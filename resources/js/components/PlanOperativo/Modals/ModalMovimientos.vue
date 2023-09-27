<template>
    <!-- Modal -->
    <div class="modal fade" id="modalMovimientos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Movimientos Financieros</h5>
                    <button type="button" class="btn-close" @click="$parent.closeModal('modalMovimientos')"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="row mt-2">
                            <form @submit.prevent="saveMovimiento()" class="col-12 col-md-5 border-2 border-end">
                                <div class="mb-2">
                                    <b>Nombre del proyecto:</b>
                                    <p>{{ presupuesto.proyecto?.nombre }}</p>
                                </div>
                                <div class="mb-2">
                                    <b>Codigo presupuestal:</b>
                                    <p>{{ presupuesto.codigo }}</p>
                                </div>
                                <div class="mb-2">
                                    <label>Movimiento financiero:</label>
                                    <select class="form-select" v-model="form_movimiento.tipo_movimiento">
                                        <option value="">---Seleccionar---</option>
                                        <option value="adicion">Adición</option>
                                        <option value="reduccion">Reduccion</option>
                                        <option value="creditos">Créditos</option>
                                        <option value="contracreditos">Contracréditos</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label>Valor a ingresar $:</label>
                                    <input class="form-control" type="number" v-model="form_movimiento.valor">
                                    <!--poner formato moneda -->
                                </div>
                                <div class="mb-2">
                                    <label>Acta de aprovacion:</label>
                                    <input class="form-control" type="text" v-model="form_movimiento.acta_aprovacion">
                                </div>
                                <div class="text-center my-2 mt-auto">
                                    <button class="btn btn-primary" type="submit">Guardar movimiento</button>
                                </div>
                            </form>
                            <div class="col-12 col-md-7 table-responsive">
                                <b>Desglose ingreso de movimientos financieros:</b>
                                <table class="table table table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>Tipo Movimiento</th>
                                            <th>Valor</th>
                                            <th>Total</th>
                                            <th>Fecha</th>
                                            <th>Acta de Aprobación</th>
                                            <th>Opción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(movimiento, index) in presupuesto.movimiento_financieros" :key="index">
                                            <td>{{ movimiento.tipo_movimiento }}</td>
                                            <td>{{ this.$parent.formatoMoneda(movimiento.valor) }}</td>
                                            <td>{{ this.$parent.formatoMoneda(movimiento.total) }}</td>
                                            <td>{{ (new Date(movimiento.created_at)).toLocaleString() }}</td>
                                            <td>{{ movimiento.acta_aprovacion }}</td>
                                            <td class="text-center d-flex">
                                                <button class="btn btn-danger btn-sm"
                                                    :disabled="movimiento.tipo_movimiento == 'inicial'"
                                                    @click="deleteMovimiento(movimiento.id)">
                                                    <i class='bx bxs-trash'></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <spinner v-if="false"></spinner>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary me-1"
                        @click="$parent.closeModal('modalMovimientos')">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['presupuesto_id'],
    data() {
        return {
            presupuesto: {},
            form_movimiento: {
                tipo_movimiento: '',
                valor: '',
                acta_aprovacion: '',
            }
        }
    },
    created() {
        this.getPresupuesto()
    },
    methods: {
        getPresupuesto() {
            axios.get(`/get-presupuesto/${this.presupuesto_id}`).then(res => {
                console.log(res.data);
                if (res.data.status) {
                    this.presupuesto = res.data.presupuesto
                }
            }).catch(error => {
                console.log(error.response)
            })
        },
        saveMovimiento() {
            this.form_movimiento.proyecto_presupuesto_id = this.presupuesto_id
            axios.post('/proyectos-movimientos', this.form_movimiento).then(res => {
                if (res.data.status) {
                    this.$swalMini('success', `${res.data.message}`);
                    this.getPresupuesto()
                    this.resetForm()
                }
            }).catch(error => {
                console.log(error.response)
            })
        },
        deleteMovimiento(id) {
            axios.delete(`/proyectos-movimientos/${id}`).then(res => {
                console.log(res)
                if (res.data.status) {
                    this.$swalMini('success', `${res.data.message}`);
                    this.getPresupuesto()
                }
            }).catch(error => {
                this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                console.log(error.response)
            })
        },
        resetForm() {
            this.form_movimiento = {
                tipo_movimiento: '',
                valor: '',
                acta_aprovacion: '',
            }
        },
    }
}

</script>
