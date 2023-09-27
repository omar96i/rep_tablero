<template>
    <!-- Modal -->
    <div class="modal fade" id="modalDependencia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" v-if="!loading_data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Formulario de registro</h5>
                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    ></button>
                </div>
                    <div class="modal-body">
                        <div class="card-body row">
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Nombre</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="dependencia.nombre" >
                                    </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Descripcion</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" v-model="dependencia.descripcion" >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Informacion de la Dependencia</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" v-model="dependencia.info_dependencia" >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Mision</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" v-model="dependencia.mision" >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Vision</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" v-model="dependencia.vision" >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Organigrama</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" v-model="dependencia.organigrama" >
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="modal-footer" v-if="!loading">
                    <button type="button" id="cierrame" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Close
                    </button>
                    <button type="submit" class="btn btn-primary" @click="action">{{ (tipo == 'insert') ?  'Agregar' : 'Editar' }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    import axios from 'axios';
    export default {

        props:['id', 'tipo'],

        data(){
            return{
                dependencia:{
                    nombre:"",
                    descripcion:"",
                    info_dependencia:"",
                    mision:"",
                    vision:"",
                    organigrama:""
                },
                data:{},
                ruta: '',
                tipo: 'insert',
                loading: false,
                loading_data : false,
            }
        },
        methods:{
            getData(id){
                axios.get(`/dependencia/getData/${id}`).then(res=>{
                    this.dependencia = res.data.dependencia;
                    console.log("Datos Dependencia", this.dependencia)
                    this.loading_data = false
                }).catch(res=>{
                    console.log(res.response)
                })
            },
            setData(tipo, id){
                console.log(tipo + ' ' + id)
                if(tipo == 'insert'){
                    this.loading_data = true
                    this.resetData()
                    this.tipo = tipo

                }
                if(tipo == 'edit'){
                    this.loading_data = true
                    this.getData(id)
                    this.tipo = tipo
                }
            },
            resetData(){
                this.data = {}
                setTimeout(()=>{
                    this.loading_data = false
                },200)
            },
            action(){
                this.loading = true
                axios.post((this.tipo == 'insert') ? '/dependencia/store' : `/dependencia/update/${this.dependencia.id}`,this.dependencia).then(res=>{
                    this.loading = false
                    console.log(res.data)
                    if(res.data.status){
                        this.$swalMini('success', `Dependencia ${this.tipo=='insert' ? 'creada' : 'actualizada'} con exito.`);
                    }
                    this.$parent.getData()
                    setTimeout(()=>{
                        document.getElementById("cierrame").click()
                    },200)
                }).catch(res=>{
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                    console.log(res.response)
                    this.loading = false
                })
            }
        }


}

</script>
