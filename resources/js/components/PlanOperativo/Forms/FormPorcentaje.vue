<template>
    <!-- datos generales -->
    <div>
        <h5>Asignacion de recursos para metas</h5>
        <form @submit.prevent="savePorcentajes()">
            <div class="row mb-2">
                <div class="col-12 px-4">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td>Inicial Total</td>
                                    <td>Definitiva Total</td>
                                    <td>Disponibilidad Total</td>
                                    <td>Registros Total</td>
                                    <td>Pagos Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ this.$parent.formatoMoneda(proyecto.total_iniciales) }}</td>
                                    <td>{{ this.$parent.formatoMoneda(proyecto.total_definitivos) }}</td>
                                    <td>{{ this.$parent.formatoMoneda(proyecto.total_disponibilidades) }}</td>
                                    <td>{{ this.$parent.formatoMoneda(proyecto.total_registros) }}</td>
                                    <td>{{ this.$parent.formatoMoneda(proyecto.total_pagos) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-primary">
                                    <td>Meta de Producto</td>
                                    <td>Asginación Definitiva</td>
                                    <td>Asignación Disponibilidad</td>
                                    <td>Asignación Registros</td>
                                    <td>Asignación Pagos</td>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- recorrer metas productos *metas -->
                                <tr v-for="(meta, index) in proyecto.productos" :key="index">
                                    <td>
                                        {{ meta.meta_producto.codigo }}
                                    </td>
                                    <td class="p-1">
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="input-porcentaje_definitivo">En %</span>
                                            <input type="text" class="form-control"
                                                :class="[{ ['is-invalid text-danger']: validarPorcentaje('porcentaje_definitivo') }, 'form-control']"
                                                v-model="meta.porcentaje_definitivo"
                                                aria-describedby="input-porcentaje_definitivo"
                                                @input="meta.valor_definitivo = ((meta.porcentaje_definitivo * proyecto.total_definitivos) / 100).toFixed(2)"
                                                required>
                                            <div class="invalid-feedback">
                                                Los valores deben ocupar el 100% disponible
                                            </div>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="input-valor_definitivo">En valor $:</span>
                                            <input type="text"
                                                :class="[{ 'text-danger': validarPorcentaje('porcentaje_definitivo') }, 'form-control ']"
                                                v-model="meta.valor_definitivo" aria-describedby="input-valor_definitivo"
                                                @input="inputDefinitivo(index)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="input-porcentaje_disponibilidad">En %</span>
                                            <input type="text" class="form-control"
                                                :class="[{ ['is-invalid text-danger']: validarPorcentaje('porcentaje_disponibilidad') }, 'form-control']"
                                                v-model="meta.porcentaje_disponibilidad"
                                                @input="meta.valor_disponibilidad = ((meta.porcentaje_disponibilidad * proyecto.total_disponibilidades) / 100).toFixed(2)"
                                                aria-describedby="input-porcentaje_disponibilidad" required>
                                            <div class="invalid-feedback">
                                                Los valores deben ocupar el 100% disponible
                                            </div>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="input-valor_disponibilidad">En valor
                                                $:</span>
                                            <input type="text"
                                                :class="[{ 'text-danger': validarPorcentaje('porcentaje_disponibilidad') }, 'form-control ']"
                                                v-model="meta.valor_disponibilidad"
                                                @input="inputDisponibilidad(index)"
                                                aria-describedby="input-valor_disponibilidad">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="input-porcentaje_registros">En %</span>
                                            <input type="text" class="form-control"
                                                :class="[{ ['is-invalid text-danger']: validarPorcentaje('porcentaje_registros') }, 'form-control']"
                                                v-model="meta.porcentaje_registros"
                                                @input="meta.valor_registros = ((meta.porcentaje_registros * proyecto.total_registros) / 100).toFixed(2)"
                                                aria-describedby="input-porcentaje_registros" required>
                                            <div class="invalid-feedback">
                                                Los valores deben ocupar el 100% disponible
                                            </div>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="input-valor_registro">En valor $:</span>
                                            <input type="text"
                                                :class="[{ 'text-danger': validarPorcentaje('porcentaje_registros') }, 'form-control ']"
                                                v-model="meta.valor_registros"
                                                @input="inputRegistros(index)"
                                                aria-describedby="input-valor_registro">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group mb-1">
                                            <span class="input-group-text" id="input-porcentaje_pagos">En %</span>
                                            <input type="text" class="form-control"
                                                :class="[{ ['is-invalid text-danger']: validarPorcentaje('porcentaje_pagos') }, 'form-control']"
                                                v-model="meta.porcentaje_pagos" aria-describedby="input-porcentaje_pagos"
                                                @input="meta.valor_pagos = ((meta.porcentaje_pagos * proyecto.total_pagos) / 100).toFixed(2)"
                                                required>
                                            <div class="invalid-feedback">
                                                Los valores deben ocupar el 100% disponible
                                            </div>
                                        </div>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text" id="input-valor_pagos">En valor $:</span>
                                            <input type="text"
                                                :class="[{ 'text-danger': validarPorcentaje('porcentaje_pagos') }, 'form-control ']"
                                                v-model="meta.valor_pagos"
                                                @input="inputPagos(index)"
                                                aria-describedby="input-valor_pagos">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="text-center my-2 mt-auto">
                <button class="btn btn-primary mx-2" type="submit">Guardar</button>
                <button class="btn btn-outline-secondary" type="button" @click="limpiarPorcentajes()"
                    required>Limpiar</button>
            </div>
        </form>
        <spinner v-if="false"></spinner>
    </div>
</template>

<script>
export default {
    props: ['proyecto_id'],
    data() {
        return {
            proyecto: {},
            btn_summit: false
        }
    },
    created() {
        this.getProyectoMetas()
    },
    methods: {
        inputDefinitivo(index){
            const meta = this.proyecto.productos[index]
            meta.porcentaje_definitivo = (this.removeFormatoMoneda(meta.valor_definitivo) * 100) / this.proyecto.total_definitivos
            meta.valor_definitivo = this.formatoMoneda(meta.valor_definitivo)
        },
        inputDisponibilidad(index){
            const meta = this.proyecto.productos[index]
            meta.porcentaje_disponibilidad = (this.removeFormatoMoneda(meta.valor_disponibilidad) * 100) / this.proyecto.total_disponibilidades;
            meta.valor_disponibilidad = this.formatoMoneda(meta.valor_disponibilidad)
        },
        inputRegistros(index){
            const meta = this.proyecto.productos[index]
            meta.porcentaje_registros = (this.removeFormatoMoneda(meta.valor_registros) * 100) / this.proyecto.total_registros;
            meta.valor_registros = this.formatoMoneda(meta.valor_registros)
        },
        inputPagos(index){
            const meta = this.proyecto.productos[index]
            meta.porcentaje_pagos = (this.removeFormatoMoneda(meta.valor_pagos) * 100) / this.proyecto.total_pagos;
            meta.valor_pagos = this.formatoMoneda(meta.valor_pagos)
        },
        removeFormatoMoneda(valor) {
            const valor_clean = valor.toString().replace(/,/g, ''); // Convertir a cadena y eliminar comas
            return parseInt(valor_clean, 10); // Convertir a entero
        },
        formatoMoneda(valor) {
            // Eliminar todos los caracteres no numéricos, excepto comas y puntos
            const valorLimpio = valor.toString().replace(/[^0-9,.]/g, '');

            // Reemplazar comas y puntos por vacío para obtener solo los dígitos
            const valorSoloDigitos = valorLimpio.replace(/[,.]/g, '');

            // Formatear el número con separadores de miles
            const valorFormateado = valorSoloDigitos.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            return valorFormateado;
        },
        validarPorcentaje(column) {
            const sumaColumn = this.proyecto.productos.reduce((acumulador, meta) => acumulador + parseFloat(meta[column]), 0);
            return sumaColumn != 100;
        },
        getProyectoMetas() {
            axios.get(`/proyectos-get-all/${this.proyecto_id}`).then(res => {
                this.proyecto = res.data.proyecto

                this.proyecto.productos.forEach(meta => {
                    meta.valor_definitivo = this.formatoMoneda(meta.valor_definitivo)
                    meta.valor_disponibilidad = this.formatoMoneda(meta.valor_disponibilidad)
                    meta.valor_registros = this.formatoMoneda(meta.valor_registros)
                    meta.valor_pagos = this.formatoMoneda(meta.valor_pagos)
                });

                let total = this.proyecto.presupuestos.reduce((acum, actual) => {
                    acum.inicial += actual.inicial;
                    acum.definitivo += actual.definitivo;
                    acum.disponibilidad += actual.disponibilidad;
                    acum.registros += actual.registros;
                    acum.pagos += actual.pagos;
                    return acum
                }, { inicial: 0, definitivo: 0, disponibilidad: 0, registros: 0, pagos: 0 })
                this.proyecto['total_iniciales'] = total.inicial
                this.proyecto['total_definitivos'] = total.definitivo
                this.proyecto['total_disponibilidades'] = total.disponibilidad
                this.proyecto['total_registros'] = total.registros
                this.proyecto['total_pagos'] = total.pagos

            }).catch(error => {
                console.log(error);
            })
        },
        limpiarPorcentajes() {
            this.proyecto.productos.forEach(meta => {
                meta.porcentaje_definitivo = 0
                meta.porcentaje_disponibilidad = 0
                meta.porcentaje_registros = 0
                meta.porcentaje_pagos = 0
                meta.valor_definitivo = 0
                meta.valor_disponibilidad = 0
                meta.valor_registros = 0
                meta.valor_pagos = 0
            });
        },
        savePorcentajes() {
            this.proyecto.productos.forEach(meta => {
                meta.valor_definitivo = this.removeFormatoMoneda(meta.valor_definitivo)
                meta.valor_disponibilidad = this.removeFormatoMoneda(meta.valor_disponibilidad)
                meta.valor_registros = this.removeFormatoMoneda(meta.valor_registros)
                meta.valor_pagos = this.removeFormatoMoneda(meta.valor_pagos)
            });
            if (!this.validarPorcentaje('porcentaje_definitivo') && !this.validarPorcentaje('porcentaje_disponibilidad') && !this.validarPorcentaje('porcentaje_registros') && !this.validarPorcentaje('porcentaje_pagos')) {
                axios.post('/save-porcentaje-metas', this.proyecto.productos).then(res => {
                    if (res.data.status) {
                        this.$swalMini('success', `${res.data.message}!`);
                        this.getProyectoMetas()
                    }
                }).catch(error => {
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                })
            } else {
                this.$swalMini('error', `Verifica todos los porcentajes`);
            }
        }
    }
}

</script>
