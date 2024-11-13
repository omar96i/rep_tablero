<template>
    <div class="col-12">
        <div class="my-1">
            <h5>Periodo establecido: <b> {{ periodo.nombre }} </b> <br> desde: <b> {{ periodo.fecha_ini }} </b> hasta:
                <b> {{ periodo.fecha_fin }} </b>
            </h5>
        </div>
        <form @submit.prevent="getData()" class="col-12 row">
            <div class="col">
                <label>Hecho:</label>
                <select class="form-select" name="" v-model="consulta.hecho_id" @change="clearSelect('hecho_id')"
                    required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <option v-for="(item, index) in select_hechos" :key="index" :value="item.id">{{ item.nombre }}
                    </option>
                </select>
            </div>
            <div class="col">
                <label>Politica:</label>
                <select class="form-select" name="" v-model="consulta.politica_id" @change="clearSelect('politica_id')"
                    required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_politicas" :key="index">
                        <option v-if="consulta.hecho_id == item.hecho_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div>
            <!-- <div class="col">
                <label>Estrategia:</label>
                <select class="form-select" name="" v-model="consulta.estrategia_id" @change="clearSelect('estrategia_id')">
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_estrategias" :key="index">
                        <option v-if="consulta.politica_id == item.politica_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div> -->
            <div class="col">
                <label>Programa:</label>
                <select class="form-select" name="" v-model="consulta.programa_id" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_programas" :key="index">
                        <option v-if="consulta.politica_id == item.politica_id" :value="item.id">{{ item.nombre }}
                        </option>
                    </template>
                </select>
            </div>
            <div class="col row align-items-end">
                <button class="btn btn-outline-primary" type="submit">Consultar</button>
            </div>
        </form>
        <hr>
        <div class="col-12 my-3">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3 mb-3" v-for="(meta, index) in metas" :key="index">
                    <button type="button" class="btn w-100"
                        :style="{ backgroundColor: getButtonColor(meta.average), color: '#fff' }"
                        @click="showMeta(meta.id)">
                        {{ meta.codigo }}
                    </button>
                </div>
            </div>
        </div>
        <spinner v-if="spinner"></spinner>
    </div>
</template>
<script>
export default {
    props: ['periodo'],
    data() {
        return {
            spinner: false,
            select_hechos: [],
            select_politicas: [],
            // select_estrategias: [],
            select_programas: [],

            consulta: {
                hecho_id: '',
                politica_id: '',
                // estrategia_id: '',
                programa_id: '',
            },

            metas: [],
        }
    },
    created() {
        this.getDataSelect()
    },
    methods: {
        getDataSelect() {
            // hechos
            axios.get('/hechos-get').then(res => {
                // console.log(res);
                this.select_hechos = res.data.hechos
            }).catch(error => {
                console.log(error);
            })

            // politicas
            axios.get('/politicas-get').then(res => {
                // console.log(res);
                this.select_politicas = res.data.politicas
            }).catch(error => {
                console.log(error);
            })

            // // estrategias
            // axios.get('/estrategias-get').then(res=>{
            //     // console.log(res);
            //     this.select_estrategias = res.data.estrategias
            // }).catch(error => {
            //     console.log(error);
            // })

            // programas
            axios.get('/programas-get').then(res => {
                // console.log(res);
                this.select_programas = res.data.programas
            }).catch(error => {
                console.log(error);
            })
        },
        getData() {
            axios.post('/public/ejecucion', this.consulta).then(res => {
                this.metas = res.data.metas.map(meta => {
                    meta.average = meta.programacion_meta[0].porcentaje_avance_general
                    return meta;
                });
            }).catch(error => {
                console.log(error);
            });
        },
        getButtonColor(average) {
            if (average <= 25) {
                return '#c00000'; // Rojo oscuro
            } else if (average > 25 && average <= 50) {
                return '#ffc000'; // Naranja
            } else if (average > 50 && average <= 75) {
                return '#ffff00'; // Amarillo
            } else if (average > 75 && average < 100) {
                return '#00b050'; // Verde
            } else if (average === 100) {
                return '#4472c4'; // Azul
            }
            return '#000000'; // Color por defecto (negro)
        },
        showMeta(id) {
            window.location = `/public/ejecucion/show/${id}`
        },
        clearSelect(input) {
            if (input == 'hecho_id') {
                this.consulta.politica_id = ''
                this.consulta.programa_id = ''
            } else if (input == 'politica_id') {
                this.consulta.programa_id = ''
            }
        },
        calcularAcumulado() {
            if (this.meta.indicador_id == 1) {
                let valoresMetaProgramada = this.meta.programacion_meta.map(objeto => objeto.meta_programada);
                let maximoMetaProgramada = Math.max(...valoresMetaProgramada);
                this.acum_meta.meta_programada = maximoMetaProgramada;
            } else {
                this.acum_meta.meta_programada = this.meta.programacion_meta.reduce((acumulador, objeto) => acumulador + objeto.meta_programada, 0);
            }
            this.acum_meta.meta_alcanzada = this.meta.programacion_meta.reduce((acumulador, objeto) => acumulador + objeto.meta_alcanzada, 0);
            this.acum_meta.porcentaje_avance_general = this.meta.programacion_meta[0].porcentaje_avance_general;
        },
    },
}
</script>
