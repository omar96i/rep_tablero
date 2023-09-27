<template>
    <div class="col-12 text-center">
    </div>
    <div class="col-12">
        <div class="col-12">
            <button type="button" class="btn btn-info m-1" data-bs-toggle="modal" data-bs-target="#modalPermisos" @click="action('insert')">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-permisos" id="tablapermisos" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th>Nombre</th>
                        <th>Guard_name</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <!-- <th></th> -->
                        <th>Nombre</th>
                        <th>Guard_name</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr v-for="(permiso, index) in permisos" :key="index">
                        <td>{{ permiso.name }}</td>
                        <td>{{ permiso.guard_name }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm" data-bs-toggle="modal" data-bs-target="#modalPermisos" @click="action('edit',permiso.id)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(permiso.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <modal-permisos ref="modal_form_permission"></modal-permisos>
    </div>
</template>
<script>
    import axios from "axios";
    import ModalPermisos from "./ModalPermisos.vue";


    export default{

        components: {
            'modal-permisos' : ModalPermisos,
        },
        data(){
            return{

                items: {},
                loading: false,
                load: false,
                permisos:[],
            }
        },
        created(){
            this.getData()

        },

        methods:{
            action(tipo,id){
                this.$refs.modal_form_permission.setData(tipo,id)
            },
            getData(){
                axios.get('/permisos/get').then(res=>{
                    this.permisos = res.data.permisos
                    this.load=true
                    this.loading=true
                })
            },
            deleteData(id){
                axios.get(`/permisos/delete/${id}`).then(res=>{
                    if(res.data.status){
                        this.getData()
                    }
                })
            },


        },
    }

</script>
