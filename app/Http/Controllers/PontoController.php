<?php

namespace App\Http\Controllers;

use App\Events\PontoRegistradoEvent;
use App\Services\PontoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use OpenApi\Attributes as OA;

class PontoController extends Controller
{
  protected PontoService $pontoService;

  public function __construct(PontoService $pontoService)
  {
    $this->pontoService = $pontoService;
  }

  #[OA\Get(
    path: "/api/ponto/admin/listar",
    summary: "Listar todos os pontos (Admin)",
    description: "Retorna a lista paginada dos registros de ponto de todos os usuários.",
    tags: ["Marcação de Ponto"],
    security: [["bearerAuth" => []]]
  )]
  #[OA\Response(response: 200, description: "Lista de pontos retornada com sucesso")]
  public function index(Request $request): JsonResponse
  {
    $perPage = (int) $request->input('per_page', 15);
    $pontos = $this->pontoService->listarTodos($perPage);

    return response()->json($pontos, 200, [], JSON_UNESCAPED_UNICODE);
  }

  #[OA\Put(
    path: "/api/ponto/admin/{id}",
    summary: "Editar um ponto existente (Admin)",
    description: "Permite que o administrador altere a lista de horários ou a observação de um registro.",
    tags: ["Marcação de Ponto"],
    security: [["bearerAuth" => []]]
  )]
  #[OA\Parameter(
    name: "id",
    in: "path",
    required: true,
    description: "ID do registro de ponto",
    schema: new OA\Schema(type: "string")
  )]
  #[OA\RequestBody(
    required: true,
    content: new OA\JsonContent(
      properties: [
        new OA\Property(
          property: "horarios",
          type: "array",
          items: new OA\Items(type: "string", example: "08:00:00")
        ),
        new OA\Property(property: "observacao", type: "string", example: "Horário corrigido pelo RH")
      ]
    )
  )]
  #[OA\Response(response: 200, description: "Ponto atualizado com sucesso")]
  #[OA\Response(response: 404, description: "Registro de ponto não encontrado")]
  public function update(Request $request, string $id): JsonResponse
  {
    $dadosValidados = $request->validate([
      'horarios' => 'nullable|array',
      'horarios.*' => 'string|date_format:H:i:s',
      'observacao' => 'nullable|string'
    ]);

    $pontoAtualizado = $this->pontoService->atualizarPonto($id, $dadosValidados);

    return response()->json([
      'mensagem' => 'Registro de ponto atualizado com sucesso!',
      'ponto' => $pontoAtualizado
    ], 200, [], JSON_UNESCAPED_UNICODE);
  }

  #[OA\Delete(
    path: "/api/ponto/admin/{id}",
    summary: "Apagar um registro de ponto (Admin)",
    description: "Remove um registro de ponto batido incorretamente.",
    tags: ["Marcação de Ponto"],
    security: [["bearerAuth" => []]]
  )]
  #[OA\Parameter(
    name: "id",
    in: "path",
    required: true,
    description: "ID do registro de ponto a ser removido",
    schema: new OA\Schema(type: "string")
  )]
  #[OA\Response(response: 200, description: "Ponto removido com sucesso")]
  #[OA\Response(response: 404, description: "Registro de ponto não encontrado")]
  public function destroy(string $id): JsonResponse
  {
    $this->pontoService->deletarPonto($id);

    return response()->json([
      'mensagem' => 'Registro de ponto removido com sucesso!'
    ], 200, [], JSON_UNESCAPED_UNICODE);
  }

  #[OA\Post(
    path: "/api/ponto/marcar",
    summary: "Bater o ponto do usuário autenticado",
    description: "Registra um novo horário de entrada/saída para o usuário logado no dia atual.",
    tags: ["Marcação de Ponto"],
    security: [["bearerAuth" => []]]
  )]
  #[OA\RequestBody(
    required: false,
    content: new OA\JsonContent(
      properties: [
        new OA\Property(property: "observacao", type: "string", example: "Trabalho remoto")
      ]
    )
  )]
  #[OA\Response(
    response: 200,
    description: "Ponto registrado com sucesso"
  )]
  #[OA\Response(
    response: 401,
    description: "Não autorizado"
  )]
  public function baterPonto(Request $request): JsonResponse
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $userId = $user->id;
    $observacao = $request->input('observacao');
    $resultado = $this->pontoService->registrarPonto($userId, $observacao);
    $payload = [
      'usuario_id'    => $user->id,
      'usuario_nome'  => $user->name,
      'usuario_email' => $user->email,
      'observacao'    => $observacao,
      'data_hora'     => now()->toDateTimeString(),
      'registro'      => $resultado,
    ];
    event(new PontoRegistradoEvent($payload));
    return response()->json($resultado, 200, [], JSON_UNESCAPED_UNICODE);
  }

  #[OA\Get(
    path: "/api/ponto/espelho/{anoMes}",
    summary: "Consultar espelho de ponto mensal",
    description: "Retorna o histórico de batidas e horas acumuladas no mês.",
    tags: ["Marcação de Ponto"],
    security: [["bearerAuth" => []]]
  )]
  #[OA\Parameter(
    name: "anoMes",
    in: "path",
    required: true,
    description: "Ano e mês de referência no formato YYYY-MM",
    schema: new OA\Schema(type: "string", example: "2026-08")
  )]
  #[OA\Response(
    response: 200,
    description: "Espelho de ponto retornado com sucesso"
  )]
  #[OA\Response(
    response: 401,
    description: "Não autorizado"
  )]
  public function espelhoMes(string $anoMes): JsonResponse
  {
    /** @var \App\Models\User $user */
    $user = Auth::user();
    $userId = $user->id;

    $resultado = $this->pontoService->obterEspelhoMes($userId, $anoMes);

    return response()->json($resultado, 200);
  }

  #[OA\Delete(
    path: "/api/ponto/admin/{id}/horario/{index}",
    summary: "Remover um horário específico do ponto (Admin)",
    description: "Remove um horário do array de batidas com base no seu índice de posição (0, 1, 2...).",
    tags: ["Marcação de Ponto"],
    security: [["bearerAuth" => []]]
  )]
  #[OA\Parameter(
    name: "id",
    in: "path",
    required: true,
    description: "ID do registro de ponto",
    schema: new OA\Schema(type: "string")
  )]
  #[OA\Parameter(
    name: "index",
    in: "path",
    required: true,
    description: "Índice do horário no array (ex: 0 para a primeira batida)",
    schema: new OA\Schema(type: "integer", example: 0)
  )]
  #[OA\Response(
    response: 200,
    description: "Horário removido do registro com sucesso"
  )]
  #[OA\Response(
    response: 404,
    description: "Registro de ponto não encontrado"
  )]
  public function destroyHorario(string $id, int $index): JsonResponse
  {
    $ponto = $this->pontoService->removerHorarioEspecifico($id, $index);

    return response()->json([
      'mensagem' => 'Horário removido com sucesso!',
      'ponto' => $ponto
    ], 200, [], JSON_UNESCAPED_UNICODE);
  }
}
