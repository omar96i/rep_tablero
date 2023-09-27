<template>
    <!-- Modal -->
    <div class="modal fade" id="modalMeta" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <form @submit.prevent="saveProduct">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalFullTitle">Crear una nueva Meta:</h5>
                        <button type="button" class="btn-close" @click="$parent.closeFormModal()"
                        ></button>
                    </div>
                    <div class="modal-body py-0">
                            <div class="card-body row">
                                <div class="mb-3">
                                    <label class="form-label" for="input-hecho_id">Selecciona un Hecho</label>
                                    <select class="form-select" id="input-hecho_id" v-model="meta.hecho_id" required @change="clearSelect('hecho_id')">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <option v-for="(hecho, index) in hechos" :key="index" :value="hecho.id">{{ hecho.nombre }}</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-politica_id">Selecciona una Politica</label>
                                    <select class="form-select" id="input-politica_id" v-model="meta.politica_id" required @change="clearSelect('politica_id')">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <template v-for="(politica, index) in politicas" :key="index">
                                            <option v-if="politica.hecho_id == meta.hecho_id" :value="politica.id">{{ politica.nombre }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-estrategia_id">Selecciona una Estrategia</label>
                                    <select class="form-select" id="input-estrategia_id" v-model="meta.estrategia_id" @change="clearSelect('estrategia_id')">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <template v-for="(estrategia, index) in estrategias" :key="index">
                                            <option v-if="estrategia.politica_id == meta.politica_id" :value="estrategia.id">{{ estrategia.nombre }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-programa_id">Selecciona un Programa</label>
                                    <select id="input-programa_id" class="form-select" v-model="meta.programa_id">
                                        <option value="" selected disabled>Seleccionar...</option>
                                        <template v-for="(programa, index) in programas" :key="index">
                                            <option v-if="programa.estrategia_id == meta.estrategia_id" :value="programa.id">{{ programa.nombre }}</option>
                                        </template>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-codigo">Código de meta</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="input-codigo" v-model="meta.codigo" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-meta">Nombre de meta</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="input-meta" v-model="meta.nombre" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-idicador_meta">Indicador de meta</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="input-idicador_meta" v-model="meta.indicador_meta" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-idicador_meta">Siglas del Indicador</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="input-idicador_meta" v-model="meta.siglas_indicador" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-peso">Peso (%)</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" id="input-peso" v-model="meta.peso" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-indicador">Selecciona tipo de indicador</label>
                                    <select class="form-select" id="input-indicador" v-model="meta.indicador_id" required>
                                        <option value="">--Seleccionar indicador--</option>
                                        <option v-for="(indicador, index) in indicadores" :key="index" :value="indicador.id">{{ indicador.nombre }}</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-linea">Línea base</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="input-linea" v-model="meta.linea_base" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-año">Año</label>
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" v-model="meta.year" name="" id="">
                                            <option value="" selected disabled>Seleccionar...</option>
                                            <option v-for="year in Array.from({length: 70}, (v, i) => i + (2099 - 80))" :value="year">{{ year }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-meta_cuatrienio">Meta cuatrienio</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" class="form-control" id="input-meta_cuatrienio" v-model="meta.meta_cuatrienio" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-meta_year_1">Meta año 1</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" step=0.01 class="form-control" id="input-meta_year_1" v-model="meta.meta_year_1" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-meta_year_2">Meta año 2</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" step=0.01 class="form-control" id="input-meta_year_2" v-model="meta.meta_year_2" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-meta_year_3">Meta año 3</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" step=0.01 class="form-control" id="input-meta_year_3" v-model="meta.meta_year_3" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-meta_year_4">Meta año 4</label>
                                    <div class="input-group input-group-merge">
                                        <input type="number" step=0.01 class="form-control" id="input-meta_year_4" v-model="meta.meta_year_4" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="input-recurso_cuatrienio">Recursos cuatrienio</label>
                                    <div class="input-group input-group-merge">
                                        <input type="text" class="form-control" id="input-recurso_cuatrienio" v-model="meta.recurso_cuatrienio" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-recurso_year_1">Recurso año 1</label>
                                    <div class="input-group input-group-merge">
                                        <input type="year" class="form-control" id="input-recurso_year_1" v-model="meta.recurso_year_1" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-recurso_year_2">Recurso año 2</label>
                                    <div class="input-group input-group-merge">
                                        <input type="year" class="form-control" id="input-recurso_year_2" v-model="meta.recurso_year_2" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-recurso_year_3">Recurso año 3</label>
                                    <div class="input-group input-group-merge">
                                        <input type="year" class="form-control" id="input-recurso_year_3" v-model="meta.recurso_year_3" required>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <label class="form-label" for="input-recurso_year_4">Recurso año 4</label>
                                    <div class="input-group input-group-merge">
                                        <input type="year" class="form-control" id="input-recurso_year_4" v-model="meta.recurso_year_4" required>
                                    </div>
                                </div>
                                <div class=" mb-3">
                                    <label class="form-label" for="input-gerente">Gerente de meta</label>
                                    <div class="input-group input-group-merge">
                                        <select class="form-select" v-model="meta.user_id" id="input-gerente" required>
                                            <option value="1">Ejemplo de Gerente</option>
                                            <option v-for="(gerente, index) in gerentes" :key="index" :value="meta.id">{{ meta.nombre }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary me-1" @click="$parent.closeFormModal()">Cerrar</button>
                        <button type="submit" class="btn btn-primary">{{ !this.meta.id ?  'Agregar' : 'Editar' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props:['data_meta'],
    data(){
        return{
            hechos: [],
            politicas: [],
            estrategias: [],
            programas: [],
            indicadores: [],
            gerentes: [],
            meta: this.data_meta
        }
    },
    created() {
        this.getDataSelect()
    },
    methods:{
        getDataSelect(){
            axios.get('/hechos-get').then(res=>{
                this.hechos = res.data.hechos
            }).catch(error => {
                console.log(error);
            })

            axios.get('/politicas-get').then(res=>{
                console.log(res);
                this.politicas = res.data.politicas
            }).catch(error => {
                console.log(error);
            })

            axios.get('/estrategias-get').then(res=>{
                console.log(res);
                this.estrategias = res.data.estrategias
            }).catch(error => {
                console.log(error);
            })

            axios.get('/programas-get').then(res=>{
                this.programas = res.data.programas
            }).catch(error => {
                console.log(error);
            })

            axios.get('/metas/indicadores').then(res=>{
                console.log(res);
                this.indicadores = res.data.indicadores
            }).catch(error => {
                console.log(error);
            })
        },
        saveProduct(){
            if (this.meta.id) {
                console.log(this.meta);
                axios.put(`/metas/${this.meta.id}`, this.meta).then(res=>{
                    console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.$parent.closeFormModal()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            } else {
                axios.post('/metas', this.meta).then(res=>{
                    console.log(res)
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
                this.meta.politica_id = ''
                this.meta.estrategia_id = ''
                this.meta.programa_id = ''
            }else if(input == 'politica_id') {
                this.meta.estrategia_id = ''
                this.meta.programa_id = ''
            }else if(input == 'estrategia_id'){
                this.meta.programa_id = ''
            }
        }
    }
}

</script>
