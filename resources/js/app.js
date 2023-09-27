import { createApp } from 'vue';
window.axios = require('axios');

import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss'

import { Chart as ChartJS, CategoryScale, LinearScale, Title, Tooltip, Legend, ArcElement } from 'chart.js';
import ChartDataLabels from 'chartjs-plugin-datalabels';
ChartJS.register(Title, Tooltip, Legend, ArcElement, CategoryScale, LinearScale, ChartDataLabels);

import UserIndex from './components/Users/Index.vue';
import PeriodosIndex from './components/Periodos/Index.vue';
import DependenciasIndex from './components/Dependencias/Index.vue';
import UnidadIndex from './components/Unidades/Index.vue';
import RolesIndex from './components/Roles/Index.vue';

import HechosIndex from './components/Programacion/Hechos/Index.vue';
import PoliticasIndex from './components/Programacion/Politicas/Index.vue';
import EstrategiasIndex from './components/Programacion/Estrategias/Index.vue';
import ProgramasIndex from './components/Programacion/Programas/Index.vue';
import MetasIndex from './components/Programacion/Metas/Index.vue';
import EjecucionMetaIndex from './components/EjecucionMetas/Index.vue'
import EjecucionMetaShow from './components/EjecucionMetas/Show/Index.vue'

import PlanOperativo from './components/PlanOperativo/Index.vue';
import Spinner from './components/Spinner.vue'
import {sweetUtils} from './sweet-alert-utils';

const app = createApp({});
app.config.globalProperties.$swal = Swal;
app.config.globalProperties.$swalMini = sweetUtils;

app.component('user-index', UserIndex);
app.component('periodo-index', PeriodosIndex);
app.component('dependencia-index', DependenciasIndex);
app.component('unidad-index', UnidadIndex);
app.component('roles-index', RolesIndex);
app.component('hechos-index', HechosIndex);
app.component('politicas-index', PoliticasIndex);
app.component('estrategias-index', EstrategiasIndex);
app.component('programas-index', ProgramasIndex);
app.component('metas-index', MetasIndex);
app.component('plan-operativo-index', PlanOperativo);
app.component('ejecucion-meta-index', EjecucionMetaIndex);
app.component('ejecucion-meta-show', EjecucionMetaShow);
app.component('spinner', Spinner);
app.mount('#app');
