<template>
    <!-- Modal -->
    <div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" v-if="!loading_data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">{{ user?.id ? 'Editar' : 'Crear Nuevo'}} Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-0">
                    <div class="card-body">
                        <form @submit.prevent="action" class="row">
                            <h5>Datos Personales:</h5>
                            <div class="mb-3 col col-md-6">
                                <label class="form-label" for="input-name">Nombre</label>
                                <input id="input-name" type="text" class="form-control" v-model="user.nombre" required>
                                <div class="input-group input-group-merge">
                                </div>
                            </div>
                            <div class="mb-3 col col-md-6">
                                <label class="form-label" for="input-lastname">Apellido</label>
                                <div class="input-group input-group-merge">
                                    <input id="input-lastname" type="text" class="form-control" v-model="user.apellido">
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label" for="input-email">E-Mail</label>
                                <div class="input-group input-group-merge">
                                    <input id="input-email" type="email" class="form-control" v-model="user.email" required>
                                </div>
                            </div>
                            <div class="col col-md-6">
                                <label class="form-label" for="input-documento">Documento</label>
                                <div class="input-group input-group-merge">
                                    <input id="input-documento" type="text" class="form-control" v-model="user.documento">
                                </div>
                            </div>

                            <hr class="col my-5">

                            <h5>Datos de ingreso:</h5>
                            <div class="mb-3">
                                <label class="form-label" for="input-user">Usuario</label>
                                <div class="input-group input-group-merge">
                                    <input id="input-user" type="text" class="form-control" v-model="user.usuario" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="input-password">{{ user?.id ? 'Actualizar' : ''}} Contraseña</label>
                                <div class="input-group input-group-merge">
                                    <input id="input-password" type="text" class="form-control" v-model="user.password" required placeholder="Cambia o ingresa la contraseña anterior">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="select-rol">Tipo De Acceso</label>
                                <select id="select-rol" class="form-select" v-model="user.rol" required>
                                    <option value="" selected disabled>--Selecciona--</option>
                                    <option v-for="(rol, index) in roles" :key="index" :value="rol.id">{{ rol.name }}</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end" v-if="!loading">
                                <button type="button" id="cierrame" class="btn btn-outline-secondary mx-1" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">{{ (tipo == 'insert') ?  'Agregar' : 'Editar' }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        data(){
            return{
                user:{
                    nombre:"",
                    apellido:"",
                    email:"",
                    documento:"",
                    usuario:"",
                    password:"",
                    rol:""
                },
                tipo: '',
                loading: false,
                loading_data : false,
                roles: []
            }
        },
        created() {
            this.getRoles()
        },
        methods:{
            getData(id){
                axios.get(`/user/getData/${id}`).then(res=>{
                    this.user = res.data.user;
                    console.log("Datos Usuario", this.user)
                    this.loading_data = false
                }).catch(res=>{
                    console.log(res.response)
                })
            },
            getRoles(){
                axios.get('/roles/get').then(res=>{
                    this.roles = res.data.roles
                })
            },
            setData(data){
                this.resetData()
                this.loading_data = true
                if(data){
                    this.user = data
                    this.user.password = ''
                    this.user.rol = data.roles[0].id
                    this.tipo = 'edit'
                }else{
                    this.tipo = 'insert'
                }
            },
            resetData(){
                this.user = {
                    nombre:"",
                    apellido:"",
                    email:"",
                    documento:"",
                    usuario:"",
                    password:"",
                    rol:""
                },
                setTimeout(()=>{
                    this.loading_data = false
                },200)
            },
            action(){
                console.log(this.user)
                axios.post((this.tipo == 'insert') ? '/user/store' : `/user/update/${this.user.id}`,this.user).then(res=>{
                    this.loading = false
                    console.log(res.data)
                    if(res.data.status){
                        // this.alert('Registro', (this.tipo=='insert') ? 'Agregado' : 'Actualizado', 'success')
                        this.$swalMini('success', `Guardado con exito.`)
                        this.$parent.getUsers()
                    }
                    setTimeout(()=>{
                        document.getElementById("cierrame").click()
                    },200)
                }).catch(res=>{
                    console.log(res.response)
                    this.$swalMini('error', `Error en el servidor`)
                    this.loading = false
                })
            }
        }
}

</script>
