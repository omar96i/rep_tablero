<template>
    <!-- Modal -->
    <div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">{{ column.toUpperCase() }}</h5>
                    <button type="button" class="btn-close" @click="$parent.closeModal('modalAdd', false)"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="saveColumn()" class="col">
                        <div class="mb-2">
                            <b>Nombre del proyecto:</b>
                            <p>{{ presupuesto.proyecto?.nombre }}</p>
                        </div>
                        <div class="mb-2">
                            <div class="mb-2">
                                <b>Codigo presupuestal:</b>
                                <p>{{  presupuesto.codigo }}</p>
                            </div>
                        </div>
                        <div class="mb-2">
                            <b>Ultima Actualización:</b>
                            <p>{{  presupuesto[`${column}`] == 0 ? 'No ejecutado' : 'Ejecutado' }}</p>
                        </div>
                        <div class="mb-2" v-if="column == 'disponibilidad'">
                            <b>Presupuesto definitivo $:</b>
                            <p>{{  this.$parent.formatoMoneda(presupuesto.definitivo) }}</p>
                        </div>
                        <div class="mb-2" v-if="column == 'registros'">
                            <b>Presupuesto disponible $:</b>
                            <p>{{  this.$parent.formatoMoneda(presupuesto.disponibilidad) }}</p>
                        </div>
                        <div class="mb-2" v-if="column == 'pagos'">
                            <b>Presupuesto registrado $:</b>
                            <p>{{ this.$parent.formatoMoneda(presupuesto.registros) }}</p>
                        </div>
                        <div class="mb-2">
                            <b>Ultima ejecución $:</b>
                            <p>{{  this.$parent.formatoMoneda(ult_ejecutado) }}</p>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <label for="input_valor" class="col-sm-4 col-form-label"><b>Valor {{ column }}$:</b></label>
                            <div class="col-sm-8">
                            <input type="number" class="form-control" id="input_valor" @input="inputFormatoMoneda" v-model="presupuesto[`${column}`]">
                            </div>
                        </div>
                        <div class="text-center my-2 mt-auto">
                            <button class="btn btn-primary" type="submit">
                                Guardar
                            </button>
                        </div>
                    </form>
                </div>
                <!-- <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-secondary me-1"
                        @click="$parent.closeModal('modalAdd')">Cerrar</button>
                </div> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['presupuesto_id', 'column'],
    data() {
        return {
            presupuesto: {},
            ult_ejecutado: 0,
        }
    },
    created() {
        this.getPresupuesto()
    },
    methods: {
        inputFormatoMoneda(event){
            const valor = event.target.value;
            this.FormatoMoneda(valor)
        },
        FormatoMoneda(valor) {
            // Eliminar todos los caracteres no numéricos, excepto comas y puntos
            const valorLimpio = valor.replace(/[^0-9,.]/g, '');

            // Reemplazar comas y puntos por vacío para obtener solo los dígitos
            const valorSoloDigitos = valorLimpio.replace(/[,.]/g, '');

            // Formatear el número con separadores de miles
            const valorFormateado = valorSoloDigitos.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            this.presupuesto[`${column}`] = valorFormateado;
        },
        removeFormatoMoneda(valor) {
            const valor_clean = valor.replace(/,/g, ''); // Eliminar comas
            this.presupuesto[`${column}`] = parseInt(valor_clean); // Convertir a entero
        },
        getPresupuesto(){
            axios.get(`/get-presupuesto/${this.presupuesto_id}`).then(res => {
                console.log(res.data);
                if (res.data.status) {
                    this.presupuesto = res.data.presupuesto
                    this.ult_ejecutado = this.presupuesto[`${this.column}`]
                }
            }).catch(error => {
                console.log(error.response)
            })
        },
        saveColumn(){
            let val_max = 0
            if (this.column == 'disponibilidad') {
                val_max = this.presupuesto.definitivo
            }else if(this.column == 'registros'){
                val_max = this.presupuesto.disponibilidad
            }else if(this.column == 'pagos'){
                val_max = this.presupuesto.registros
            }
            if (this.presupuesto[`${this.column}`] > val_max) {
                this.$swalMini('error', `El valor de ${this.column}  supera ${val_max}!`);
            }else{
                removeFormatoMoneda(this.presupuesto[`${this.column}`])
                axios.put(`/proyecto-presupuestos/${this.presupuesto.id}`, this.presupuesto).then(res=>{
                    console.log(res)
                    if (res.data.status) {
                        this.$swalMini('success', `${this.column} actualizada con exito!`);
                        this.$parent.closeModal('modalAdd')
                    }
                }).catch(error=>{
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                })
            }
        }
    }
}

</script>
