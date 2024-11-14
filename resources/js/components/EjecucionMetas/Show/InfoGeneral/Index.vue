<template>
    <div class="row row-bordered border-bottom-0">
        <div class="col-12 col-md-6 px-4">
            <div class="mb-2">
                <h5 class="my-0">Nombre de la meta:</h5>
                <p>{{ meta.nombre }}</p>
            </div>
            <div class="mb-2">
                <h5 class="my-0">Indicador de Producto:</h5>
                <p>{{ meta.indicador_meta }}</p>
            </div>
            <div class="mb-2">
                <h5 class="my-0">Tipo de Indicador:</h5>
                <p>{{ meta.indicador.nombre }}</p>
            </div>
            <div class="mb-2 row">
                <div class="col-6 d-flex">
                    <h5 class="my-0 me-1">Linea base:</h5>
                    <p>{{ meta.linea_base }}</p>
                </div>
                <div class="col-6 d-flex">
                    <h5 class="my-0 me-1">Meta de Cuaternio:</h5>
                    <p>{{ meta.meta_cuatrienio }}</p>
                </div>
            </div>
            <div class="mb-2">
                <!-- lista de proyectos relacionados -->
                <h5 class="my-0">Proyectos:</h5>
                <p v-for="(proyecto, index) in meta.proyectos" :key="index">{{ proyecto.proyecto.nombre }}</p>
            </div>
        </div>
        <div class="col-12 col-md-6 px-4">
            <div class="table-responsive">
                <div class="d-flex justify-content-between mb-2">
                    <h5 class="my-auto">Programacion de la meta:</h5>
                    <!-- <button class="btn btn-primary btn-sm" @click="changeProgramacion()">Editar</button> -->
                </div>
                <table v-if="!form_programacion" class="table table-bordered table-periodo" width="100%" cellspacing="0" >
                    <thead>
                        <tr class="table-primary">
                            <th>Año</th>
                            <th>Meta Programada</th>
                            <th>Meta Alcanzada</th>
                            <th>Porcentaje de ejecución</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in meta.programacion_meta" :key="index">
                            <td>{{ item.year }}</td>
                            <td>{{ item.meta_programada }}</td>
                            <td>{{ item.meta_alcanzada }}</td>
                            <td>{{ item.porcentaje_avance }} %</td>
                        </tr>
                        <tr>
                            <td>Acumulado</td>
                            <td>{{(acum_meta.meta_programada > 0) ? '1' : '0'}}</td>
                            <td>{{acum_meta.meta_alcanzada}}</td>
                            <td>{{acum_meta.porcentaje_avance_general}} %</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center my-3">
                <button class="btn btn-primary" @click="openFicha()">Ver ficha de la meta</button>
            </div>
        </div>
        <modal-ficha v-if="modal_ficha" :meta="meta" :acum_meta="acum_meta.porcentaje_avance_general" :state="state"></modal-ficha>
    </div>
</template>
<script>
import ModalFicha from './ModalFicha.vue'
export default {
    props: ['meta', 'state'],
    components:{
        ModalFicha
    },
    data() {
        return {
            form_programacion: false,
            acumulado_metas: 0,
            acumulado_porcentaje: 0,
            modal_ficha: false,
            acum_meta: {
                meta_programada: '',
                meta_alcanzada: '',
                porcentaje_avance_general: '',
            }
        }
    },
    created() {
        this.calcularAcumulado()
    },
    methods: {
        openFicha(){
            this.modal_ficha = true
            setTimeout(() => {
                $('#modalFicha').modal({backdrop: 'static', keyboard: false}).modal('show')
            }, 300);
        },
        closeModal(){
            $('#modalFicha').modal('hide')
            setTimeout(() => {
                this.modal_ficha = false
            }, 300);
        },
        calcularAcumulado(){
            if (this.meta.indicador_id == 1) {
                let valoresMetaProgramada = this.meta.programacion_meta.map(objeto => objeto.meta_programada);
                let maximoMetaProgramada = Math.max(...valoresMetaProgramada);
                this.acum_meta.meta_programada = maximoMetaProgramada;
            }else{
                this.acum_meta.meta_programada = this.meta.programacion_meta.reduce((acumulador, objeto) => acumulador + objeto.meta_programada, 0);
            }
            this.acum_meta.meta_alcanzada = this.meta.programacion_meta.reduce((acumulador, objeto) => acumulador + objeto.meta_alcanzada, 0);
            this.acum_meta.porcentaje_avance_general = this.meta.programacion_meta[0].porcentaje_avance_general;
        },

        // changeProgramacion(){
        //     this.form_programacion ? this.form_programacion = false : this.form_programacion = true
        //     this.calcularAcumulado()
        // },

        // saveMeta(){
        //     axios.put(`/metas-productos/${this.meta.id}`, this.meta).then(res=>{
        //         console.log(res)
        //         if (res.data.status) {
        //              this.$swalMini('success', `${res.data.message}`)
        //              this.changeProgramacion()
        //         }
        //     }).catch(error=>{
        //         console.log(error.response)
        //     })
        // },

    },
}
</script>
