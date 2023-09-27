<template>
    <!-- Modal -->
    <div class="modal fade" id="modalPeriodo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" v-if="!loading_data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">{{ periodo.id ? 'Editar' : 'Crear nuevo' }} periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="action" class="row">
                        <div class="mb-3">
                            <label class="form-label" for="input-name">Nombre</label>
                            <div class="input-group input-group-merge">
                                <input id="input-name" type="text" class="form-control" v-model="periodo.nombre" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="input-fecha_ini">Fecha Inicial</label>
                            <div class="input-group input-group-merge">
                                <input id="input-fecha_ini" type="date" class="form-control" v-model="periodo.fecha_ini" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="input-fecha_fin">Fecha Final</label>
                            <div class="input-group input-group-merge">
                                <input id="input-fecha_fin" type="date" class="form-control" v-model="periodo.fecha_fin" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="input-estado">Estado</label>
                            <select id="input-estado" class="form-select" v-model="periodo.estado" required>
                                <option value="" selected disabled>Seleccionar un estado...</option>
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end" v-if="!loading">
                            <button type="button" id="cierrame" class="btn btn-outline-secondary mx-2" data-bs-dismiss="modal">cerrar</button>
                            <button type="submit" class="btn btn-primary">{{ (tipo == 'insert') ?  'Agregar' : 'Editar' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                periodo:{
                    nombre:"",
                    fecha_ini:"",
                    fecha_fin:"",
                    estado:""
                },
                tipo: '',
                loading: false,
                loading_data : false,
                ruta:''
            }
        },
        methods:{
            getData(id){
                axios.get(`/periodo/getData/${id}`).then(res=>{
                    this.periodo = res.data.periodo;
                    console.log("Datos Usuario", this.periodo)
                    this.loading_data = false
                }).catch(res=>{
                    console.log(res.response)
                })
            },
            setData(tipo, id){
                if(tipo == 'insert'){
                    this.loading_data = true
                    console.log(tipo)
                    this.resetData()
                    this.tipo = tipo

                }
                if(tipo == 'edit'){
                    this.loading_data = true
                    console.log(tipo)
                    this.getData(id)
                    this.tipo = tipo
                }
            },
            resetData(){
                this.periodo = {
                    nombre:"",
                    fecha_ini:"",
                    fecha_fin:"",
                    estado:""
                },
                setTimeout(()=>{
                    this.loading_data = false
                },200)
            },
            action(){
                if (this.periodo.estado == 'activo' && this.tipo == 'insert') {
                    this.$swal.fire({
                        title: 'Cuidado!',
                        text: 'Cuando se crea un nuevo período ACTIVO, el período anterior se cambia automáticamente a INACTIVO.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#696cff',
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.savePeriodo()
                        }
                    })
                }else{
                    this.savePeriodo()
                }
            },
            savePeriodo(){
                axios.post((this.tipo == 'insert') ? '/periodo/store' : `/periodo/update/${this.periodo.id}`,this.periodo).then(res=>{
                    this.loading = false
                    this.$parent.getData()
                    setTimeout(()=>{
                        this.$swalMini('success', `Periodo ${this.tipo == 'insert' ? 'creado' : 'actualizado'} con exito`);
                        document.getElementById("cierrame").click()
                    },200)
                }).catch(res=>{
                    console.log(res.response)
                    this.loading = false
                })
            }
        }
}

</script>
