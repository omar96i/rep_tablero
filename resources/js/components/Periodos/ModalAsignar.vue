<template>
    <!-- Modal -->
    <div class="modal fade" id="modalAsignacion" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Asignar usuarios al periodo: <b>{{ periodo.nombre}}</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    ></button>
                </div>
                    <div class="modal-body">
                        <form @submit.prevent="action" class="row">
                            <div class="mb-3">
                                <label class="form-label" for="input-user_id">Selecciona un usuario</label>
                                <select id="input-user_id" class="form-select" v-model="data.user_id" required>
                                    <option value="" selected disabled>Asignar un usuario...</option>
                                    <option v-for="(user, index) in users" :key="index" :value="user.id">{{`${user.nombre} ${user.apellido}`}}</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" id="cierrame" class="btn btn-outline-secondary mx-2" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Asignar Usuario</button>
                            </div>
                        </form>
                        <hr class="my-3">
                        <div class="table-responsive">
                            <h5>Usuarios asignados:</h5>
                            <table class="table table-bordered table-periodo" id="tablaperiodo" width="100%" cellspacing="0" >
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(user, index) in periodo.users" :key="index">
                                        <td>{{ `${user.user.nombre} ${user.user.apellido}` }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(user.id)"><i class='bx bxs-trash' ></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                users: [],
                data : {
                    user_id : '',
                    tipo_acceso : ''
                },
                periodo : {}
            }
        },
        created() {
            this.getUsers()
        },
        methods:{
            getUsers(){
                axios.get('/user/get').then(res=>{
                    this.users = res.data.user
                })
            },
            setData(periodo){
                this.periodo = periodo
            },
            deleteData(id){
                axios.get(`/periodo/delete/asignacion/${id}`).then(res=>{
                    if (res.data.status) {
                        this.periodo = res.data.periodo
                        this.$swalMini('success', `Usuario des-asignado con exito`);
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            },
            action(){
                let request = {
                    periodo_id : this.periodo.id,
                    user_id : this.data.user_id,
                    tipo_acceso : this.data.tipo_acceso
                }
                axios.post('/periodo/asignar', request).then(res=>{
                    if (res.data.status) {
                        this.periodo = res.data.periodo
                        this.data = {
                            user_id : '',
                            tipo_acceso : ''
                        }
                        this.$parent.getData()
                        setTimeout(()=>{
                            this.$swalMini('success', `Usuario asignado con exito`);
                            document.getElementById("cierrame").click()
                        },200)
                    }else{
                        this.$swalMini('info', `${res.data.message}`);
                    }
                }).catch(res=>{
                    console.log(res.response)
                })
            }
        }
}

</script>
