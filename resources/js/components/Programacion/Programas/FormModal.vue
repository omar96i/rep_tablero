<template>
    <!-- Modal -->
    <div class="modal fade" id="modalPrograma" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form @submit.prevent="saveProduct">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Crear un nuevo programa:</h5>
                        <button type="button" class="btn-close" @click="$parent.closeFormModal()"
                        ></button>
                    </div>
                    <div class="modal-body py-0">
                            <div class="card-body row">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Selecciona un Hecho</label>
                                    <select class="form-select" name="" v-model="programa.hecho_id" required @change="clearSelect('hecho_id')">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <option v-for="(hecho, index) in hechos" :key="index" :value="hecho.id">{{ hecho.nombre }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Selecciona una Politica</label>
                                    <select id="input-politica" class="form-select" name="" v-model="programa.politica_id" required @change="clearSelect('politica_id')">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <template v-for="(politica, index) in politicas" :key="index">
                                            <option v-if="politica.hecho_id == programa.hecho_id" :value="politica.id">{{ politica.nombre }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Selecciona una Estrategia</label>
                                    <select id="input-politica" class="form-select" name="" v-model="programa.estrategia_id">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <template v-for="(estrategia, index) in estrategias" :key="index">
                                            <option v-if="estrategia.politica_id == programa.politica_id" :value="estrategia.id">{{ estrategia.nombre }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Nombre</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="programa.nombre" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Peso (%)</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" v-model="programa.peso" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-fullname">Descripción</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" v-model="programa.descripcion" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary me-1" @click="$parent.closeFormModal()">Cerrar</button>
                        <button type="submit" class="btn btn-primary">{{ !this.programa.id ?  'Agregar' : 'Editar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['data_programa'],
    data(){
        return{
            hechos: [],
            politicas: [],
            estrategias: [],
            programa: this.data_programa
        }
    },
    created() {
        this.getHechos()
        this.getPoliticas()
        this.getEstrategias()
    },
    methods:{
        getHechos(){
            axios.get('/hechos-get').then(res=>{
                // console.log(res);
                this.hechos = res.data.hechos
            }).catch(error => {
                console.log(error);
            })
        },
        getPoliticas(){
            axios.get('/politicas-get').then(res=>{
                // console.log(res);
                this.politicas = res.data.politicas
            }).catch(error => {
                console.log(error);
            })
        },
        getEstrategias(){
            axios.get('/estrategias-get').then(res=>{
                // console.log(res);
                this.estrategias = res.data.estrategias
            }).catch(error => {
                console.log(error);
            })
        },
        saveProduct(){
            if (this.programa.id) {
                axios.put(`/programas/${this.programa.id}`, this.programa).then(res=>{
                    // console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.$parent.closeFormModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            } else {
                axios.post('/programas', this.programa).then(res=>{
                    // console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.$parent.closeFormModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            }

        },
        clearSelect(input){
            if (input == 'hecho_id') {
                this.programa.politica_id = ''
                this.programa.estrategia_id = ''
            }else if(input == 'politica_id') {
                this.programa.estrategia_id = ''
            }
        }
    }
}

</script>
