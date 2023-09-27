<template>
    <div class="col-12">
        <div class="mt-2">
            <h5>Periodo establecido: <b> {{ periodo.nombre }} </b> <br> desde: <b> {{ periodo.fecha_ini }} </b> hasta: <b> {{ periodo.fecha_fin }} </b></h5>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-info my-3" @click="openFormModal('insert', null)">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-periodo" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Peso(%)</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(hecho, index) in hechos" :key="index">
                        <td>{{ hecho.nombre }}</td>
                        <td>{{ hecho.peso }}</td>
                        <td>{{ hecho.descripcion }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm me-1" @click="openFormModal('edit', hecho)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(hecho.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form-modal v-if="form_modal" :data_hecho="this.data_hecho"></form-modal>
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
            hechos: [],
            data_hecho: {},
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
                this.data_hecho = {
                    id: '',
                    periodo_id: this.periodo.id,
                    nombre: '',
                    peso: '',
                    descripcion: ''
                }
            } else {
                this.data_hecho = data
            }
            this.form_modal = true
            setTimeout(() => {
                $('#modalHecho').modal('show')
            }, 300);
        },
        closeFormModal(){
            $('#modalHecho').modal('hide')
            setTimeout(() => {
                this.form_modal = false
                this.getData()
            }, 300);
        },
        getData(){
            axios.get('/hechos-get').then(res=>{
                console.log(res);
                this.hechos = res.data.hechos
            }).catch(error => {
                console.log(error);
            })
        },
        deleteData(id){
            axios.delete(`/hechos/${id}`).then(res=>{
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
