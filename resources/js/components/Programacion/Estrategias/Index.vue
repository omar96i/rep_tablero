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
                        <th>Politica</th>
                        <th>Nombre</th>
                        <th>Peso(%)</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(estrategia, index) in estrategias" :key="index">
                        <td>{{ estrategia.hecho.nombre }}</td>
                        <td>{{ estrategia.politica.nombre }}</td>
                        <td>{{ estrategia.nombre }}</td>
                        <td>{{ estrategia.peso }}</td>
                        <td>{{ estrategia.descripcion }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm me-1" @click="openFormModal('edit', estrategia)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(estrategia.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <form-modal v-if="form_modal" :data_estrategia="this.data_estrategia"></form-modal>
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
            estrategias: [],
            data_estrategia: {},
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
                this.data_estrategia = {
                    id: '',
                    hecho_id: '',
                    periodo_id: this.periodo.id,
                    politica_id: '',
                    nombre: '',
                    peso: '',
                    descripcion: ''
                }
            } else {
                this.data_estrategia = data
            }
            this.form_modal = true
            setTimeout(() => {
                $('#modalEstrategia').modal('show')
            }, 300);
        },
        closeFormModal(){
            $('#modalEstrategia').modal('hide')
            setTimeout(() => {
                this.form_modal = false
                this.getData()
            }, 300);
        },
        getData(){
            axios.get('/estrategias-get').then(res=>{
                console.log(res);
                this.estrategias = res.data.estrategias
            }).catch(error => {
                console.log(error);
            })
        },
        deleteData(id){
            axios.delete(`/estrategias/${id}`).then(res=>{
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
