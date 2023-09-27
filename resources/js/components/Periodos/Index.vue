<template>
    <div class="col-12">
        <button type="button" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#modalPeriodo" @click="action('insert')">
            Crear nuevo Periodo
        </button>
        <div class="table-responsive">
            <table class="table table-bordered table-periodo" id="tablaperiodo" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Final</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(periodo, index) in periodos" :key="index">
                        <td>{{ periodo.nombre }}</td>
                        <td>{{ periodo.fecha_ini }}</td>
                        <td>{{ periodo.fecha_fin }}</td>
                        <td>{{ periodo.estado }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalPeriodo" @click="action('edit',periodo.id)"><i class='bx bxs-edit' ></i></button>
                            <button type="button" class="btn btn-info btn-circle btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalAsignacion" @click="openAsignarModal(periodo)">Asignar</button>
                            <button class="btn btn-danger btn-circle btn-sm mx-1"  @click="deleteData(periodo)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <modal-periodo ref="modal_form"></modal-periodo>
        <modal-asignar ref="modal_asignar"></modal-asignar>
    </div>
</template>
<script>
    import ModalPeriodo from "./Modal.vue";
    import ModalAsignar from "./ModalAsignar.vue"
    export default{
        components: {
            ModalPeriodo,
            ModalAsignar
        },
        data(){
            return{
                users : [],
                items: {},
                loading: false,
                load: false,
                periodos:{},
            }
        },
        created(){
            this.getData()
        },
        methods:{
            action(tipo,id){
                this.$refs.modal_form.setData(tipo,id)
            },
            openAsignarModal(periodo){
                this.$refs.modal_asignar.setData(periodo)
            },
            getData(){
                axios.get('/periodo/get').then(res=>{
                    this.periodos = res.data.periodo
                    this.load=true
                    this.loading=true
                })
            },
            deleteData(periodo){
                this.$swal.fire({
                    title: `Seguro de eliminar el periodo ${periodo.nombre}`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.get(`/periodo/delete/${periodo.id}`).then(res=>{
                            if(res.data.status){
                                this.getData()
                                this.$swalMini('success', 'Periodo eliminado con exito');
                            }
                        })
                    }
                })
            },
        },
    }

</script>
