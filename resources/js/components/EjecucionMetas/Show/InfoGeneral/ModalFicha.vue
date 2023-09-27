<template>
    <!-- Modal -->
    <div class="modal fade" id="modalFicha" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Ficha de Meta de Producto</h5>
                    <button type="button" class="btn-close" @click="$parent.closeModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="nav-align-top mb-4">
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link active border border-bottom-0 border-gray rounded" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-graficos" aria-controls="navs-graficos"
                                    aria-selected="true">Graficas de Avance Físicos y Financieros</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button type="button" class="nav-link border border-bottom-0 border-gray rounded" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-reportes" aria-controls="navs-reportes" aria-selected="false"
                                    tabindex="-1">Avances físicos, Actividades realizadas y evidencias</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-graficos" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 col-md-6 px-2">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <h5 class="card-header text-white bg-primary p-2 text-center">Avance
                                                        Físico Cuatrenio</h5>
                                                    <div class="card-body border border-secondary rounded-bottom">
                                                        <DoughnutChart />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 my-3" v-for="(reporte, index) in meta.programacion_meta"
                                                :key="index">
                                                <div class="card">
                                                    <h5 class="card-header text-white bg-primary p-2">Avance Meta {{
                                                        reporte.año }}</h5>
                                                    <div class="card-body border border-secondary rounded-bottom">
                                                        <p class="my-1"><b>Meta Programada: </b> {{ reporte.meta_programada
                                                        }}</p>
                                                        <p class="my-1"><b>Meta Alcanzada: </b> {{ reporte.meta_alcanzada }}
                                                        </p>
                                                        <div
                                                            class="d-flex justify-content-between align-items-center gap-3">
                                                            <div class="progress w-100" style="height:10px;">
                                                                <div :class="reporte.porcentaje_avance < 50 ? 'bg-danger' : reporte.porcentaje_avance > 50 ? 'bg-success' : 'bg-warning', 'progress-bar'"
                                                                    role="progressbar"
                                                                    :style="{ width: reporte.porcentaje_avance + '%' }"
                                                                    :aria-valuenow="reporte.porcentaje_avance"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                            <small class="fw-medium">{{ reporte.porcentaje_avance
                                                            }}%</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 px-2">
                                        <div class="col-12">
                                            <div class="card">
                                                <h5 class="card-header text-white bg-primary p-2 text-center">Avance
                                                    Financiero</h5>
                                                <div class="card-body border border-secondary rounded-bottom">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="navs-reportes" role="tabpanel">
                                <div class="row">
                                    <div class="col-12 col-md-6 overflow-auto" style="max-height: 400px;">
                                        <h5><b>Meta alcanzada a la fecha:</b> </h5>
                                        <h5><b>Fecha de ultimo ingreso de informacion:</b> </h5>
                                        <div class="card">
                                            <h5 class="card-header text-white bg-primary p-2 text-center">Actividades
                                                realizadas</h5>
                                            <div class="card-body border border-secondary rounded-bottom px-0">
                                                <ul class="list-group">
                                                    <li type="button" v-for="(reporte, index) in meta.reportes" :key="index"
                                                        class="list-group-item" aria-current="true"
                                                        @click="getEvidencias(reporte.id)">
                                                        <p><b>Fecha de reporte:</b> {{ reporte.fecha_reporte }}</p>
                                                        {{ reporte.actividad }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div v-if="alert" class="alert alert-primary" role="alert">
                                            <i class='bx bx-info-circle'></i> Da clic en la actividad para ver las evidencias
                                        </div>
                                        <div class="nav-align-top mb-4">
                                            <ul class="nav nav-pills" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button type="button" class="nav-link border border-bottom-0 border-gray rounded active" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#navs-documentos"
                                                        aria-controls="navs-documentos"
                                                        aria-selected="true">Documentos</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button type="button" class="nav-link border border-bottom-0 border-gray rounded" role="tab"
                                                        data-bs-toggle="tab" data-bs-target="#navs-fotos"
                                                        aria-controls="navs-fotos" aria-selected="true">Fotos</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button type="button" class="nav-link border border-bottom-0 border-gray rounded" role="tab" data-bs-toggle="tab"
                                                        data-bs-target="#navs-videos" aria-controls="navs-videos"
                                                        aria-selected="false" tabindex="-1">Videos</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane fade show active overflow-scroll" id="navs-documentos" role="tabpanel">
                                                    <div class="row" style="max-height: 300px;">
                                                        <template v-for="(evidencia, index) in evidencias" :key="index">
                                                            <div class="col-6" v-if="evidencia.tipo === 'documento'">
                                                                <iframe :src="`/storage/documentos/${evidencia.route_name}`" class="pdf-iframe" frameborder="0"></iframe>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="navs-fotos" role="tabpanel">
                                                    <div class="overflow-auto row" style="max-height: 300px;">
                                                        <template v-for="(evidencia, index) in evidencias" :key="index">
                                                            <div class="col-6 mb-2" v-if="evidencia.tipo == 'imagen'">
                                                                <img :src="`/storage/imagenes/${evidencia.route_name}`" alt="Imagen" class="img-fluid">
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="navs-videos" role="tabpanel">
                                                    <div class="overflow-auto row" style="max-height: 300px;">
                                                        <template v-for="(evidencia, index) in evidencias" :key="index">
                                                            <div class="col-6" v-if="evidencia.tipo === 'video'">
                                                                <video :src="`/storage/videos/${evidencia.route_name}`" class="video-responsive" controls frameborder="0"></video>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import DoughnutChart from './charts/MediaDona.vue';

export default {
    props: ['meta'],
    components: {
        DoughnutChart,
    },
    data() {
        return {
            evidencias: [],
            alert: true
        };
    },
    created() {

    },
    methods: {
        getEvidencias(id) {
            this.alert = false
            axios.get(`/metas/evidencias/${id}`)
                .then(res => {
                    this.evidencias = res.data.evidencias
                })
                .catch(error => {
                    console.log(error);
                })
        },
    }
}

</script>

<style>
.video-responsive {
  max-width: 100% !important;
  height: auto !important;
}
.pdf-iframe {
  width: 100%;
  height: 100%; /* Establece la altura deseada para el iframe del PDF */
}
</style>