<template>
    <!-- Modal -->
    <div class="modal fade" id="modalEstrategia" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="saveProduct">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Crear un nuevo Estrategia:</h5>
                        <button type="button" class="btn-close" @click="$parent.closeFormModal()"
                        ></button>
                    </div>
                    <div class="modal-body py-0">
                            <div class="card-body row">
                                <div class="mb-3">
                                    <label class="form-label" for="input-hecho">Selecciona un Hecho</label>
                                    <select id="input-hecho" class="form-select" name="" v-model="estrategia.hecho_id" required>
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <option v-for="(hecho, index) in hechos" :key="index" :value="hecho.id">{{ hecho.nombre }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-politica">Selecciona una Politica</label>
                                    <select id="input-politica" class="form-select" name="" v-model="estrategia.politica_id" required>
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <template v-for="(politica, index) in politicas" :key="index">
                                            <option v-if="politica.hecho_id == estrategia.hecho_id" :value="politica.id">{{ politica.nombre }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-nombre">Nombre</label>
                                    <div id="input-nombre" class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="estrategia.nombre" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-peso">Peso (%)</label>
                                    <div id="input-peso" class="input-group input-group-merge">
                                        <input type="number" class="form-control" v-model="estrategia.peso" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-descripcion">Descripción</label>
                                    <div id="input-descripcion" class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="estrategia.descripcion" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" @click="$parent.closeFormModal()">Cerrar</button>
                        <button type="submit" class="btn btn-primary">{{ !this.estrategia.id ?  'Agregar' : 'Editar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['data_estrategia'],
    data(){
        return{
            hechos: [],
            politicas: [],
            estrategia: this.data_estrategia
        }
    },
    created() {
        this.getPerido()
        this.getHechos()
        this.getPoliticas()
    },
    methods:{
        getPerido(){
            this.estrategia.periodo_id = 1
        },
        getHechos(){
            axios.get('/hechos-get').then(res=>{
                console.log(res);
                this.hechos = res.data.hechos
            }).catch(error => {
                console.log(error);
            })
        },
        getPoliticas(){
            axios.get('/politicas-get').then(res=>{
                console.log(res);
                this.politicas = res.data.politicas
            }).catch(error => {
                console.log(error);
            })
        },
        saveProduct(){
            if (this.estrategia.id) {
                axios.put(`/estrategias/${this.estrategia.id}`, this.estrategia).then(res=>{
                    console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.$parent.closeFormModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            } else {
                axios.post('/estrategias', this.estrategia).then(res=>{
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
