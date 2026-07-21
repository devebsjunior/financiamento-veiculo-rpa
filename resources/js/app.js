import Swal from 'sweetalert2';
import { alertService } from './alertService';
import { buscarDadosPorCep } from './cepService';

window.cepService = { buscar: buscarDadosPorCep };
window.Swal = Swal;
window.alertService = alertService;
