/**
 * Serviço global para busca de CEP usando a API ViaCEP com Logs
 * @param {string} cep
 * @returns {Promise<object|null>} Dados do endereço ou null em caso de erro
 */
export async function buscarDadosPorCep(cep) {
    console.log("[cepService] Iniciando busca para o CEP:", cep);
    const limpado = cep.replace(/\D/g, '');
    console.log("[cepService] CEP higienizado:", limpado);

    if (limpado.length !== 8) {
        console.warn("[cepService] CEP inválido (tamanho incorreto):", limpado.length);
        return null;
    }

    try {
        console.log("[cepService] Fazendo fetch na API ViaCEP...");
        const response = await fetch(`https://viacep.com.br/ws/${limpado}/json/`);
        const data = await response.json();

        console.log("[cepService] Resposta bruta recebida da API:", data);

        if (data.erro) {
            console.warn("[cepService] API retornou que o CEP não existe.");
            return null;
        }

        return {
            logradouro: data.logradouro,
            bairro: data.bairro,
            cidade: data.localidade,
            uf: data.uf
        };
    } catch (e) {
        console.error('[cepService] Erro crítico na requisição do fetch:', e);
        return null;
    }
}
