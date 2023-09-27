<template>
    <div class="col-12">
        <div class="col-12">
            <h5>Periodo establecido: <b> {{ periodo.nombre }} </b> <br> desde: <b> {{ periodo.fecha_ini }} </b> hasta: <b> {{ periodo.fecha_fin }} </b></h5>
            <button type="button" class="btn btn-info my-3" @click="openFormModal('insert', null)">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-periodo" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th>Hecho</th>
                        <th>Nombre</th>
                        <th>Peso(%)</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(politica, index) in politicas" :key="index">
                        <td>{{ politica.hecho.nombre }}</td>
                        <td>{{ politica.nombre }}</td>
                        <td>{{ politica.peso }}</td>
                        <td>{{ politica.descripcion }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm me-1" @click="openFormModal('edit', politica)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(politica.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form-modal v-if="form_modal" :data_politica="this.data_politica"></form-modal>
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
            politicas: [],
            data_politica: {},
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
                console.log('entro');
                this.data_politica = {
                    id: '',
                    periodo_id: this.periodo.id,
                    hecho_id: '',
                    nombre: '',
                    peso: '',
                    descripcion: ''
                }
            } else {
                this.data_politica = data
            }
            this.form_modal = true
            setTimeout(() => {
                $('#modalPolitica').modal('show')
            }, 300);
        },
        closeFormModal(){
            $('#modalPolitica').modal('hide')
            setTimeout(() => {
                this.form_modal = false
                this.getData()
            }, 300);
        },
        getData(){
            axios.get('/politicas-get').then(res=>{
                console.log(res);
                this.politicas = res.data.politicas
            }).catch(error => {
                console.log(error);
            })
        },
        deleteData(id){
            axios.delete(`/politicas/${id}`).then(res=>{
                if(res.data.status){
                    this.$swalMini('success', `${res.data.message}.`)
                    this.getData()
                }
            }).catch(error => {
                console.log(error);
            })
        },
    },
}
</script>
