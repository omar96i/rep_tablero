<template>
    <div class="col-12">
        <div class="my-1">
            <h5>Periodo establecido: <b> {{ periodo.nombre }} </b> <br> desde: <b> {{ periodo.fecha_ini }} </b> hasta: <b> {{ periodo.fecha_fin }} </b></h5>
        </div>
        <form class="col-12 row" @submit.prevent="consultarProyectos()">
            <h5>Consultar Según jerarquía del PER:</h5>
            <div class="col">
                <label>Hecho:</label>
                <select class="form-select" name="" v-model="hecho_id" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <option v-for="(item, index) in select_hechos" :key="index" :value="item.id">{{ item.nombre }}</option>
                </select>
            </div>
            <div class="col">
                <label>Politica:</label>
                <select class="form-select" name="" v-model="politica_id" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_politicas" :key="index">
                        <option v-if="hecho_id == item.hecho_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div>
            <!-- <div class="col">
                <label>Estrategia:</label>
                <select class="form-select" name="" v-model="estrategia_id" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_estrategias" :key="index">
                        <option v-if="politica_id == item.politica_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div> -->
            <div class="col">
                <label>Programa:</label>
                <select class="form-select" name="" v-model="programa_id" required>
                    <option value="" selected disabled>Seleccionar...</option>
                    <template v-for="(item, index) in select_programas" :key="index">
                        <option v-if="politica_id == item.politica_id" :value="item.id">{{ item.nombre }}</option>
                    </template>
                </select>
            </div>
            <div class="col">
                <label>Año</label>
                <div class="input-group input-group-merge">
                    <select class="form-select" v-model="año" name="" id="" required>
                        <option value="" selected disabled>Seleccionar...</option>
                        <option v-for="(item, index) in 4" :key="index">{{ parseInt(periodo.fecha_ini.split('-')[0]) + index }}</option>
                    </select>
                </div>
            </div>
            <div class="col row align-items-end">
                <button class="btn btn-outline-primary" type="submit">Consultar</button>
            </div>
        </form>
        <div v-if="proyectos.length == 0" class="alert alert-warning text-black text-center" role="alert">
            Consulta según la jerarquía para ver proyectos
        </div>
        <template v-else>
            <div class="col-12 my-3">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0" >
                        <thead>
                            <tr class="table-primary">
                                <th rowspan="2" class="text-center">Jerarquía PER</th>
                                <th rowspan="2" class="text-center">Proyecto</th>
                                <th colspan="6" class="text-center">Codigos presupuestales</th>
                                <th rowspan="2" class="text-center">Metas Asociadas</th>
                            </tr>
                            <tr class="table-primary">
                                <th>Codigo</th>
                                <th>Inicial</th>
                                <th>Definitivo</th>
                                <th>Disponibilidad</th>
                                <th>Registros</th>
                                <th>Pagos</th>
                            </tr>
                        </thead>
                        <tbody v-for="proyecto in proyectos">
                            <tr v-if="proyecto.presupuestos.length > 0" v-for="(presupuesto, index) in proyecto.presupuestos" :key="index">
                                <td rowspan="0" v-if="index == 0">
                                    <b>Hecho regional:</b>
                                    <p>{{ proyecto.hecho.nombre }}</p>
                                    <b>Politica:</b>
                                    <p>{{ proyecto.politica.nombre}}</p>
                                    <b>Programa:</b>
                                    <p>{{ proyecto.programa.nombre}}</p>
                                </td>
                                <td rowspan="0" v-if="index == 0">{{ proyecto.nombre }}</td>
                                <td class="text-wrap" style="width: 100px;">{{presupuesto.codigo}}</td>
                                <td>{{formatoMoneda(presupuesto.inicial)}}</td>
                                <td class="p-1">
                                    {{formatoMoneda(presupuesto.definitivo)}}
                                </td>
                                <td class="p-1">
                                    {{formatoMoneda(presupuesto.disponibilidad)}}
                                </td>
                                <td class="p-1">
                                    {{formatoMoneda(presupuesto.registros)}}
                                </td>
                                <td class="p-1">
                                    {{formatoMoneda(presupuesto.pagos)}}
                                </td>
                                <td rowspan="0" v-if="index == 0">
                                    <p v-for="producto in proyecto.productos">
                                        {{ producto.meta_producto.codigo }}
                                    </p>
                                </td>
                            </tr>
                            <tr v-else>
                                <td rowspan="0">
                                    <b>Hecho regional:</b>
                                    <p>{{ proyecto.hecho.nombre }}</p>
                                    <b>Politica:</b>
                                    <p>{{ proyecto.politica.nombre}}</p>
                                    <b>Programa:</b>
                                    <p>{{ proyecto.programa.nombre}}</p>
                                </td>
                                <td rowspan="0">{{ proyecto.nombre }}</td>
                                <td class="text-wrap" style="width: 100px;">
                                    <button class="btn btn-label-secondary">Sin presupuesto</button>
                                </td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td rowspan="0">
                                    <p v-for="producto in proyecto.productos">
                                        {{ producto.meta_producto.codigo }}
                                    </p>
                                </td>
                            </tr>
                            <tr class="table-primary">
                                <td class="text-nowrap">Total presupuestos:</td>
                                <td>{{ formatoMoneda(proyecto.total_iniciales) }}</td>
                                <td>{{ formatoMoneda(proyecto.total_definitivos) }}</td>
                                <td>{{ formatoMoneda(proyecto.total_disponibilidades) }}</td>
                                <td>{{ formatoMoneda(proyecto.total_registros) }}</td>
                                <td>{{ formatoMoneda(proyecto.total_pagos) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-12 my-3">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">Totales Jerarquía PER</th>
                                <th scope="col">Definitiva Total</th>
                                <th scope="col">Disponibilidad Total</th>
                                <th scope="col">Registro Total</th>
                                <th scope="col">Pagos Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row">Total General</td>
                                <td>{{ formatoMoneda(total_general.inicial) }}</td>
                                <td>{{ formatoMoneda(total_general.definitiva) }}</td>
                                <td>{{ formatoMoneda(total_general.registro) }}</td>
                                <td>{{ formatoMoneda(total_general.pago) }}</td>
                            </tr>
                            <tr class="table-success">
                                <td scope="row">Total Hecho Regional</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="table-danger">
                                <td scope="row">Total Política</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="table-warning">
                                <td scope="row">Total Programa</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </template>
        <modal-general v-if="modal_general" :id="modal_proyecto_id" :periodo="periodo"></modal-general>
        <modal-movimientos v-if="modal_movimientos" :presupuesto_id="modal_presupuesto_id"></modal-movimientos>
        <modal-add v-if="modal_add" :presupuesto_id="modal_presupuesto_id" :column="modal_column"></modal-add>
        <spinner v-if="spinner"></spinner>
    </div>
</template>
<script>
import ModalGeneral from './Modals/ModalGeneral.vue';
import ModalMovimientos from './Modals/ModalMovimientos.vue';
import ModalAdd from './Modals/ModalAdd.vue';
export default{
    props: ['periodo'],
    components: {
        ModalGeneral,
        ModalMovimientos,
        ModalAdd
    },
    data(){
        return{
            spinner: false,
            select_hechos: [],
            select_politicas: [],
            // select_estrategias: [],
            select_programas: [],
            select_metas_productos: [],
            select_indicadores: [],

            modal_general: false,
            modal_proyecto_id: null,

            modal_movimientos: false,
            modal_nombre_proyecto: null,
            modal_presupuesto_id: null,

            modal_add: false,
            modal_column: '',

            hecho_id: '',
            politica_id: '',
            // estrategia_id: '',
            programa_id: '',
            año: (new Date).getFullYear(),

            proyectos: [],

            total_general : {
                'inicial': 0,
                'definitiva': 0,
                'disponibilidad': 0,
                'registro': 0,
                'pago': 0,
            }
        }
    },
    created(){
        this.getDataSelect()
        // this.getProyectos()
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

            // estrategias -- Modulo eliminado
            // axios.get('/estrategias-get').then(res=>{
            //     // console.log(res);
            //     this.select_estrategias = res.data.estrategias
            // }).catch(error => {
            //     console.log(error);
            // })

            // programas
            axios.get('/programas-get').then(res=>{
                // console.log(res);
                this.select_programas = res.data.programas
            }).catch(error => {
                console.log(error);
            })
        },
        consultarProyectos(){
            console.log('click');
            let consulta = {
                'hecho': this.hecho_id,
                'politica': this.politica_id,
                'programa': this.programa_id,
                'año': this.año
            };
            axios.post('/proyectos-get', consulta).then(res=>{
                this.total_general = {
                    'inicial': 0,
                    'definitiva': 0,
                    'disponibilidad': 0,
                    'registro': 0,
                    'pago': 0,
                }
                // console.log(res);
                if (res.data.status) {
                    this.proyectos = res.data.proyectos
                    // suma de los totales
                    this.proyectos.forEach(proyecto => {
                        let total = proyecto.presupuestos.reduce((acum, actual) => {
                            acum.inicial += actual.inicial;
                            acum.definitivo += actual.definitivo;
                            acum.disponibilidad += actual.disponibilidad;
                            acum.registros += actual.registros;
                            acum.pagos += actual.pagos;
                            return acum
                        }, {inicial: 0, definitivo: 0, disponibilidad: 0, registros: 0, pagos: 0})
                        proyecto['total_iniciales'] = total.inicial
                        proyecto['total_definitivos'] = total.definitivo
                        proyecto['total_disponibilidades'] = total.disponibilidad
                        proyecto['total_registros'] = total.registros
                        proyecto['total_pagos'] = total.pagos

                        this.total_general.inicial += proyecto['total_iniciales']
                        this.total_general.definitiva += proyecto['total_definitivos']
                        this.total_general.disponibilidad += proyecto['total_disponibilidades']
                        this.total_general.registro += proyecto['total_registros']
                        this.total_general.pago += proyecto['total_pagos']
                    });
                    this.spinner = false;
                }
            }).catch(error => {
                console.log(error);
            }).finally(f => {
                this.spinner = false;
            });
        },
        // getProyectos(){
        //     this.proyectos = []
        //     this.spinner = true
        //     axios.get('/proyectos-get').then(res=>{
        //         // console.log(res);
        //         if (res.data.status) {
        //             this.proyectos = res.data.proyectos
        //             // suma de los totales
        //             this.proyectos.forEach(proyecto => {
        //                 let total = proyecto.presupuestos.reduce((acum, actual) => {
        //                     acum.inicial += actual.inicial;
        //                     acum.definitivo += actual.definitivo;
        //                     acum.disponibilidad += actual.disponibilidad;
        //                     acum.registros += actual.registros;
        //                     acum.pagos += actual.pagos;
        //                     return acum
        //                 }, {inicial: 0, definitivo: 0, disponibilidad: 0, registros: 0, pagos: 0})
        //                 proyecto['total_iniciales'] = total.inicial
        //                 proyecto['total_definitivos'] = total.definitivo
        //                 proyecto['total_disponibilidades'] = total.disponibilidad
        //                 proyecto['total_registros'] = total.registros
        //                 proyecto['total_pagos'] = total.pagos
        //             });
        //             this.spinner = false;
        //         }
        //     }).catch(error => {
        //         console.log(error);
        //     }).finally(f => {
        //         this.spinner = false;
        //     });
        // },
        openModalGeneral(id){
            this.modal_general = true
            this.modal_proyecto_id = id
            setTimeout(() => {
                $('#modalProyect').modal({backdrop: 'static', keyboard: false}).modal('show')
            }, 300);
        },
        openModalMovimientos(presupuesto_id){
            this.modal_movimientos = true
            this.modal_presupuesto_id = presupuesto_id
            setTimeout(() => {
                $('#modalMovimientos').modal({backdrop: 'static', keyboard: false}).modal('show')
            }, 300);
        },
        openModalAdd(presupuesto_id, column){
            this.modal_add = true
            this.modal_column = column
            this.modal_presupuesto_id = presupuesto_id
            setTimeout(() => {
                $('#modalAdd').modal({backdrop: 'static', keyboard: false}).modal('show')
            }, 300);
        },
        closeModal(ModalId, reload = true){
            $(`#${ModalId}`).modal('hide')
            setTimeout(() => {
                this.modal_add = false
                this.modal_general = false
                this.modal_movimientos = false
                if (reload) {
                    this.consultarProyectos()
                }
            }, 300);
        },
        formatoMoneda(valor) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(valor);
        }
    },
}
</script>
