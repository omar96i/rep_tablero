<template>
    <div class="col-12">
        <div class="col-12">
            <h5>Periodo establecido: <b> {{ periodo.nombre }} </b> <br> desde: <b> {{ periodo.fecha_ini }} </b> hasta: <b> {{ periodo.fecha_fin }} </b></h5>
            <button type="button" class="btn btn-info my-2" @click="openFormModal('insert', null)">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-periodo" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <!-- <th>Periodo</th> -->
                        <th>Hecho</th>
                        <th>Politica</th>
                        <th>Programa</th>
                        <th>Código meta</th>
                        <th>Nombre meta</th>
                        <th>Indicador meta</th>
                        <th>Tipo de indicador</th>
                        <th>Peso de meta(%)</th>
                        <th>Línea base</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(meta, index) in metas" :key="index">
                        <!-- <td>{{ hecho.periodo }}</td> -->
                        <td>{{ meta.hecho?.nombre }}</td>
                        <td>{{ meta.politica?.nombre }}</td>
                        <td>{{ meta.programa?.nombre }}</td>
                        <td>{{ meta.codigo }}</td>
                        <td>{{ meta.nombre }}</td>
                        <td>{{ meta.indicador.nombre }}</td>
                        <!-- <td>{{ meta.indicador }}</td> -->
                        <td>{{ meta.indicador_id }}</td>
                        <td>{{ meta.peso }}</td>
                        <td>{{ meta.linea_base }}</td>
                        <td class="text-center d-flex">
                            <button type="button" class="btn btn-info btn-circle btn-sm me-1" @click="openFormModal('edit', meta)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(meta.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form-modal v-if="form_modal" :data_meta="this.data_meta"></form-modal>
    </div>
</template>
<script>
import FormModal from './FormModal.vue'
export default{
    props: ['periodo'],
    components: {
        FormModal
    },
    data(){
        return{
            metas: [],
            data_meta: {},
            form_modal: false,
        }
    },
    created(){
        this.getData()
        if (!this.periodo) {
            this.$swal.fire({
                icon: 'error',
                title: 'Sin periodo activo',
                text: 'Por favor, active o asigne un período antes de añadir hechos.',
                showConfirmButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = '/periodo';
                }
            })
        }
    },
    methods:{
        openFormModal(tipo, data){
            this.form_modal = false
            if (tipo == 'insert') {
                this.data_meta = {
                    id: '',
                    periodo_id: this.periodo.id,
                    hecho_id: '',
                    politica_id: '',
                    estrategia_id: '',
                    programa_id: '',
                    indicador_id: '',
                    user_id: '',
                    codigo: '',
                    nombre: '',
                    indicador_meta: '',
                    siglas_indicador: '',
                    peso: '',
                    linea_base: '',
                    year: (new Date).getFullYear(),
                    meta_year_1: '',
                    meta_year_2: '',
                    meta_year_3: '',
                    meta_year_4: '',
                    meta_cuatrienio: '',
                    recurso_year_1: '',
                    recurso_year_2: '',
                    recurso_year_3: '',
                    recurso_year_4: '',
                    recurso_cuatrienio: '',
                }
            } else {
                this.data_meta = data
            }
            this.form_modal = true
            setTimeout(() => {
                $('#modalMeta').modal('show')
            }, 300);
        },
        closeFormModal(){
            $('#modalMeta').modal('hide')
            setTimeout(() => {
                this.form_modal = false
                this.getData()
            }, 300);
        },
        getData(){
            axios.get('/metas/get').then(res=>{
                console.log(res);
                this.metas = res.data.metas
            }).catch(error => {
                console.log(error);
            })
        },
        deleteData(id){
            axios.delete(`/metas/${id}`).then(res=>{
                if(res.data.status){
                     this.$swalMini('success', `${res.data.message}.`)
                    this.getData()
                }
            }).catch(error => {
                console.log(error.response);
            })
        },
    },
}
</script>
