<template>
    <!-- Modal -->
    <div class="modal fade" id="modalHecho" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="saveProduct">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Crear un nuevo Hecho:</h5>
                        <button type="button" class="btn-close" @click="$parent.closeFormModal()"
                        ></button>
                    </div>
                    <div class="modal-body py-0">
                            <div class="card-body row">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Nombre</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="hecho.nombre" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Peso (%)</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" v-model="hecho.peso" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Descripción</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="hecho.descripcion" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary me-1" @click="$parent.closeFormModal()">Cerrar</button>
                        <button type="submit" class="btn btn-primary">{{ !this.hecho.id ?  'Agregar' : 'Editar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['data_hecho'],
    data(){
        return{
            hecho: this.data_hecho,
        }
    },
    methods:{
        saveProduct(){
            if (this.hecho.id) {
                axios.put(`/hechos/${this.hecho.id}`, this.hecho).then(res=>{
                    console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.$parent.closeFormModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            } else {
                axios.post('/hechos', this.hecho).then(res=>{
                    console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.$parent.closeFormModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            }

        }
    }
}

</script>
