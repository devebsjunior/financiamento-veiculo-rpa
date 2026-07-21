import { buscarDadosPorCep } from './services/cepService';
import { alertService } from './services/alertService';

window.cepService = { buscar: buscarDadosPorCep };
window.alertService = alertService;


