<template>
    <!-- Modal -->
    <div class="modal fade" id="modalReporte" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Nuevo reporte</h5>
                    <button type="button" class="btn-close" @click="$parent.closeModal('modalReporte', false)"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="fecha_reporte" class="form-label">Fecha del reporte</label>
                                <input v-model="reporte.fecha_reporte" type="date" class="form-control" id="fecha_reporte" required disabled>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="meta_año" class="form-label">Meta Año</label>
                                <select class="form-select" name="meta_año" id="meta_año"  v-model="reporte.meta_año">
                                    <option value="" selected disable>Selecciona...</option>
                                    <option v-for="(año, index) in 4" :key="index" :value="parseInt(meta.year) + index">{{ `Meta del año ${parseInt(meta.year) + index}` }}</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="meta_alcanzada" class="form-label">Meta Alcanzada</label>
                                <input v-model="reporte.meta_alcanzada" type="number" step=0.001 class="form-control" id="meta_alcanzada" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="actividad" class="form-label">Nueva Actividad</label>
                                <textarea class="form-control" v-model="reporte.actividad" id="actividad"></textarea>
                            </div>


                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['meta', 'data_reporte'],
    data() {
        return {
            reporte: {
                meta_producto_id: this.meta.id,
                meta_año: '',
                fecha_reporte: new Date().toISOString().split('T')[0],
                meta_alcanzada: '',
                actividad: '',
            },
        };
    },
    created() {
        if (this.data_reporte?.id) {
            this.reporte = this.data_reporte
        }
    },
    methods: {
        submitForm() {
            const fecha = new Date(`${this.reporte.fecha_reporte}T00:00:00`);
            // this.reporte.meta_año = fecha.getFullYear();
            if (this.reporte?.id) {
                axios.put(`/metas/reportes/store/${this.reporte.id}`, this.reporte)
                .then(res => {
                    // console.log(res)
                    if (res.data.status) {
                        this.$swalMini('success', `${res.data.message}`);
                    }
                })
                .catch(error => {
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                }).finally(f => {
                    this.$parent.closeModal('modalReporte', true)
                });
            } else {
                axios.post('/metas/reportes/store', this.reporte)
                .then(res => {
                    // console.log(res)
                    if (res.data.status) {
                        this.$swalMini('success', `${res.data.message}`);
                    }
                })
                .catch(error => {
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                }).finally(f => {
                    this.$parent.closeModal('modalReporte', true)
                });
            }
        },
    }
}

</script>