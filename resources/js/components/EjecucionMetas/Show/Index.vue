<template>
    <div class="col-12">
        <div class="my-1">
            <h5><b>Codigo de meta:</b> {{ meta.codigo }}</h5>
        </div>
        <div class="nav-align-top">
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-info-general" aria-controls="navs-info-general" aria-selected="true" @click="changeView()">Información general de la meta</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-crear-evidencia" aria-controls="navs-crear-evidencia" aria-selected="false" @click="changeView()">Crear un nuevo reporte de avance de la meta</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-hoja-vida" aria-controls="navs-hoja-vida" aria-selected="false" @click="changeView()">Hoja de vida</button>
                </li>
            </ul>
            <div class="tab-content shadow-lg">
                <div class="tab-pane fade show active" id="navs-info-general" role="tabpanel">
                    <!-- componente de informacion general -->
                    <info-general :meta="data_meta"></info-general>

                </div>
                <div class="tab-pane fade" id="navs-crear-evidencia" role="tabpanel">
                    <!-- componente formulario reportes -->
                    <reportes :meta="data_meta"></reportes>
                </div>
                <div class="tab-pane fade" id="navs-hoja-vida" role="tabpanel">
                    <!-- componente formulario hojas de vida -->
                    <hoja-vida :meta="data_meta"></hoja-vida>
                </div>
            </div>
        </div>
        <spinner v-if="spinner"></spinner>
    </div>
</template>
<script>
import InfoGeneral from './InfoGeneral/Index.vue'
import Reportes from './Reportes/Index.vue'
import HojaVida from './HojaDeVida/Index.vue'
export default {
    props: ['meta'],
    components: {
        InfoGeneral,
        Reportes,
        HojaVida
    },
    data() {
        return {
            spinner: false,
            data_meta: this.meta
        }
    },
    methods: {
        changeView(){
            // recargar meta
            axios.get(`/metas/reportes/getData/${this.meta.id}`).then(res=>{
                // console.log(res);
                this.data_meta = res.data.meta
            }).catch(error => {
                console.log(error);
            })
        }
    },
}
</script>
