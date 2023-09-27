<template>
    <!-- Modal -->
    <div class="modal fade" id="modalUnidad" tabindex="-1" aria-hidden="true">
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
                                        <input type="text" class="form-control" v-model="unidad.nombre" >
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
    export default {
        data(){
            return{
                data:{},
                unidad:{
                    nombre:""

                },
                tipo: '',
                loading: false,
                loading_data : false,
                ruta:''
            }
        },
        methods:{
            getData(id){
                axios.get(`/unidad/getData/${id}`).then(res=>{

                    this.unidad = res.data.unidad;
                    console.log("Datos Usuario", this.unidad)
                    this.loading_data = false
                }).catch(res=>{

                    console.log(res.response)
                })
            },

            setData(tipo, id){
                console.log(tipo + ' ' + id)
                if(tipo == 'insert'){
                    this.loading_data = true
                    // console.log(tipo)
                    this.resetData()
                    this.tipo = tipo

                }
                if(tipo == 'edit'){
                    this.loading_data = true
                    // console.log(tipo)
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
                axios.post((this.tipo == 'insert') ? '/unidad/store' : `/unidad/update/${this.unidad.id}`,this.unidad).then(res=>{
                    this.loading = false
                    // console.log(res.data)
                    if(res.data.status){
                        this.$swalMini('success', `Unidad ${this.tipo=='insert' ? 'creada' : 'actualizada'} con exito.`);
                        this.$parent.getData()
                    }
                    setTimeout(()=>{
                        document.getElementById("cierrame").click()
                    },200)

                }).catch(res=>{
                    this.alert('Registro', 'Error en el servidor', 'error')
                    console.log(res.response)
                    this.loading = false
                })
            }
        }
}

</script>
