<template>
    <div class="col-12">
        <div class="my-1">
            <h5>Periodo establecido: <b> {{ periodo.nombre }} </b> <br> desde: <b> {{ periodo.fecha_ini }} </b> hasta: <b> {{ periodo.fecha_fin }} </b></h5>
        </div>
        <form @submit.prevent="getData()" class="col-12 row">
            <div class="col">
                <label>Hecho:</label>
                <select class="form-select" name="" v-model="consulta.hecho_id" @change="clearSelect('hecho_id')" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <option v-for="(item, index) in select_hechos" :key="index" :value="item.id">{{ item.nombre }}</option>
                </select>
            </div>
            <div class="col">
                <label>Politica:</label>
                <select class="form-select" name="" v-model="consulta.politica_id" @change="clearSelect('politica_id')" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_politicas" :key="index">
                        <option v-if="consulta.hecho_id == item.hecho_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div>
            <div class="col">
                <label>Estrategia:</label>
                <select class="form-select" name="" v-model="consulta.estrategia_id" @change="clearSelect('estrategia_id')">
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_estrategias" :key="index">
                        <option v-if="consulta.politica_id == item.politica_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div>
            <div class="col">
                <label>Programa:</label>
                <select class="form-select" name="" v-model="consulta.programa_id" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_programas" :key="index">
                        <option v-if="consulta.politica_id == item.politica_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div>
            <div class="col row align-items-end">
                <button class="btn btn-outline-primary" type="submit">Consultar</button>
            </div>
        </form>
        <div class="col-12 my-3">
            <div class="table-responsive">
                <table class="table table-bordered table-periodo" width="100%" cellspacing="0" >
                    <thead class="table-primary">
                        <tr>
                            <th>Código meta</th>
                            <th>Nombre de la meta</th>
                            <th>Opción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(meta, index) in metas" :key="index">
                            <td>{{ meta.codigo }}</td>
                            <td>{{ meta.nombre }}</td>
                            <td class="text-center align-middle">
                                <button type="button" class="btn btn-primary btn-sm text-nowrap" @click="showMeta(meta.id)">Gestionar meta</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <spinner v-if="spinner"></spinner>
    </div>
</template>
<script>
export default{
    props: ['periodo'],
    data(){
        return{
            spinner: false,
            select_hechos: [],
            select_politicas: [],
            select_estrategias: [],
            select_programas: [],

            consulta: {
                hecho_id: '',
                politica_id: '',
                estrategia_id: '',
                programa_id: '',
            },

            metas: [],
        }
    },
    created(){
        this.getDataSelect()
    },
    methods:{
        getDataSelect(){
            // hechos
            axios.get('/hechos-get').then(res=>{
                // console.log(res);
                this.select_hechos = res.data.hechos
            }).catch(error => {
                console.log(error);
            })

            // politicas
            axios.get('/politicas-get').then(res=>{
                // console.log(res);
                this.select_politicas = res.data.politicas
            }).catch(error => {
                console.log(error);
            })

            // estrategias
            axios.get('/estrategias-get').then(res=>{
                // console.log(res);
                this.select_estrategias = res.data.estrategias
            }).catch(error => {
                console.log(error);
            })

            // programas
            axios.get('/programas-get').then(res=>{
                // console.log(res);
                this.select_programas = res.data.programas
            }).catch(error => {
                console.log(error);
            })
        },
        getData(){
            axios.post('/metas/getAll', this.consulta).then(res=>{
                this.metas = res.data.metas
            }).catch(error => {
                console.log(error);
            })
        },
        showMeta(id){
            window.location = `/metas/reportes/${id}`
        },
        clearSelect(input){
            if (input == 'hecho_id') {
                this.consulta.politica_id = ''
                this.consulta.estrategia_id = ''
                this.consulta.programa_id = ''
            }else if(input == 'politica_id') {
                this.consulta.estrategia_id = ''
                this.consulta.programa_id = ''
            }else if(input == 'estrategia_id'){
                this.consulta.programa_id = ''
            }
        }
    },
}
</script>
