<template>
    <div class="col-12">
        <div class="col-12">
            <button type="button" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#modalUser" @click="action(null)">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-user" id="tablauser" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>E-Mail</th>
                        <th>Documento</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users" :key="index">
                        <td>{{ user.nombre }}</td>
                        <td>{{ user.apellido }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.documento }}</td>
                        <td >{{ user.usuario }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#modalUser" @click="action(user)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteUser(user.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <modal-user ref="modal_form"></modal-user>
    </div>
</template>
<script>
    import axios from "axios";
    import Modal from "./Modal.vue";
    export default{

        components: {
            'modal-user' : Modal,
        },
        data(){
            return{
                loading: false,
                users: []
            }
        },
        created(){
            this.getUsers()
        },
        methods:{
            action(data_user){
                this.$refs.modal_form.setData(data_user)
            },
            getUsers(){
                axios.get('/user/get').then(res=>{
                    this.users = res.data.user
                    this.load=true
                    this.loading=true
                })
            },
            deleteUser(id){
                axios.get(`/user/delete/${id}`).then(res=>{
                    if(res.data.status){
                        this.getUsers()
                    }
                })
            },
        },
    }

</script>
