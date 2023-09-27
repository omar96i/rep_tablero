<template>
    <!-- Modal -->
    <div class="modal fade" id="modalProyect" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">{{ proyecto_id ? 'Editar ' : 'Crear un nuevo ' }} proyecto</h5>
                    <button type="button" class="btn-close" @click="$parent.closeModal('modalProyect')"
                    ></button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-pills mb-3 d-flex" id="pills-tab" role="tablist">
                        <li class="nav-item d-flex" role="presentation">
                            <button class="nav-link active" id="form_1_tab" data-bs-toggle="tab" data-bs-target="#form_1" type="button" role="tab" aria-controls="form_1" aria-selected="true">Datos Generales</button>
                        </li>
                        <li class="nav-item d-flex" role="presentation" v-if="proyecto_id">
                            <button class="nav-link" id="form_2_tab" data-bs-toggle="tab" data-bs-target="#form_2" type="button" role="tab" aria-controls="form_2" aria-selected="false">Metas Asociadas</button>
                        </li>
                        <li class="nav-item d-flex" role="presentation" v-if="proyecto_id">
                            <button class="nav-link" id="form_3_tab" data-bs-toggle="tab" data-bs-target="#form_3" type="button" role="tab" aria-controls="form_3" aria-selected="false">Presupuestos</button>
                        </li>
                        <li class="nav-item d-flex" role="presentation" v-if="proyecto_id">
                            <button class="nav-link" id="form_4_tab" data-bs-toggle="tab" data-bs-target="#form_4" type="button" role="tab" aria-controls="form_4" aria-selected="false">Asignación de recursos</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="nav-tabContent">

                        <!-- datos generales -->
                        <div class="tab-pane fade show active" id="form_1" role="tabpanel" aria-labelledby="form_1_tab">
                            <form-proyecto :proyecto_id="proyecto_id" :periodo_year="parseInt(periodo.fecha_ini.split('-')[0])" @set-id="setIdProyecto"></form-proyecto>
                        </div>

                        <!-- metas y preupuestos, se podria dividir en 2 el tab -->
                        <div v-if="proyecto_id" class="tab-pane fade" id="form_2" role="tabpanel" aria-labelledby="form_2_tab">
                            <form-metas-de-productos :proyecto_id="proyecto_id"></form-metas-de-productos>
                        </div>

                        <!-- metas y preupuestos, se podria dividir en 2 el tab -->
                        <div v-if="proyecto_id" class="tab-pane fade" id="form_3" role="tabpanel" aria-labelledby="form_3_tab">
                            <form-presupuestos :proyecto_id="proyecto_id"></form-presupuestos>
                        </div>

                        <!-- Asignación de recursos para metas -->
                        <div v-if="proyecto_id" class="tab-pane fade" id="form_4" role="tabpanel" aria-labelledby="form_4_tab">
                            <form-porcentaje :proyecto_id="proyecto_id"></form-porcentaje>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary me-1" @click="$parent.closeModal('modalProyect')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormProyecto from '../Forms/FormProyecto.vue'
import FormMetasDeProductos from '../Forms/FormMetasDeProductos.vue'
import FormPresupuestos from '../Forms/FormPresupuestos.vue'
import FormPorcentaje from '../Forms/FormPorcentaje.vue'
export default {
    components:{
        FormProyecto,
        FormMetasDeProductos,
        FormPresupuestos,
        FormPorcentaje
    },
    props: ['id', 'periodo'],
    data(){
        return{
            proyecto_id: this.id,
            select_hechos: [],
            select_politicas: [],
            select_programas: [],
            select_metas_productos: [],
            select_indicadores: [],

            proyecto: {
                hecho_id: '',
                politica_id: '',
                programa_id: '',
                periodo_id: this.periodo.id,
                vigencia: '',
                nombre: '',
            },
        }
    },
    methods:{
        setIdProyecto(new_id){
            this.proyecto_id = new_id
        },
        formatoMoneda(valor) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(valor);
        }
    }
}

</script>
