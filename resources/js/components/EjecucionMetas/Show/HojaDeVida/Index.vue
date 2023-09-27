<template>
    <div>
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
            <div class="row col-12">
                <h5>Datos generales:</h5>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="codigo" class="form-label">Código:</label>
                        <input :value="meta.codigo" type="text" class="form-control" id="codigo" disabled>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input :value="meta.nombre" type="text" class="form-control" id="nombre" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="codigo" class="form-label">Indicador:</label>
                        <input :value="meta.indicador_meta" type="text" class="form-control" id="indicador" disabled>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="siglas" class="form-label">Siglas indicador:</label>
                        <input :value="meta.siglas_indicador" type="text" class="form-control" id="siglas" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="linea_base" class="form-label">Linea base:</label>
                        <input v-model="hoja_vida.linea_base" type="text" class="form-control" id="linea_base" disabled>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="mb-3">
                            <label for="periocidad" class="form-label">Periocidad:</label>
                            <input v-model="hoja_vida.periocidad" type="text" class="form-control" id="periocidad">
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="fuente" class="form-label">Fuente:</label>
                        <input v-model="hoja_vida.fuente" type="text" class="form-control" id="fuente">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="periodo_fuente" class="form-label">Perido de Fuente:</label>
                        <input v-model="hoja_vida.periodo_fuente" type="text" class="form-control" id="periodo_fuente">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="definiciones" class="form-label">Definiciones:</label>
                        <textarea rows="3" v-model="hoja_vida.definiciones" type="text" class="form-control"
                            id="definiciones"></textarea>
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="valoracion" class="form-label">Valoracion:</label>
                        <textarea rows="3" v-model="hoja_vida.valoracion" type="text" class="form-control"
                            id="valoracion"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="localizacion" class="form-label">Localizacion:</label>
                        <input v-model="hoja_vida.localizacion" type="text" class="form-control" id="localizacion">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="poblacion" class="form-label">Poblacion:</label>
                        <input v-model="hoja_vida.poblacion" type="text" class="form-control" id="poblacion">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="medicion" class="form-label">Medicion:</label>
                        <input v-model="hoja_vida.medicion" type="text" class="form-control" id="medicion">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="unidad_de_medida" class="form-label">Unidad de medida:</label>
                        <select class="form-select" name="unidad_de_medida" id="unidad_de_medida"
                            v-model="hoja_vida.unidad_medida">
                            <option value="" selected disabled>Selecciona..</option>
                            <option v-for="(u_medida, index) in select_unidad_medida" :key="index" :value="u_medida.nombre">
                                {{ u_medida.nombre }}</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6">
                        <label for="formula" class="form-label">Formula:</label>
                        <input v-model="hoja_vida.formula" type="text" class="form-control" id="formula">
                    </div>
                    <div class="col-12 col-sm-6">
                        <label for="variables" class="form-label">Variables:</label>
                        <input v-model="hoja_vida.variables" type="text" class="form-control" id="variables">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="observaciones" class="form-label">Observaciones:</label>
                        <textarea rows="3" v-model="hoja_vida.observaciones" type="text" class="form-control"
                            id="observaciones"></textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Guardar hoja de vida</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    props: ['meta'],
    data() {
        return {
            hoja_vida: {
                meta_producto_id: this.meta.id,
                linea_base: this.meta.linea_base,
                periocidad: '',
                fuente: '',
                periodo_fuente: '',
                localizacion: '',
                poblacion: '',
                definiciones: '',
                valoracion: '',
                medicion: '',
                unidad_medida: '',
                formula: '',
                variables: '',
                observaciones: '',
            },
            select_unidad_medida: [],
        };
    },
    created() {
        console.log(this.meta);
        if(this.meta.hoja_de_vida){
            this.hoja_vida = this.meta.hoja_de_vida
        }
        this.getData()
    },
    methods: {
        getData() {
            axios.get('/unidad/get').then(res => {
                this.select_unidad_medida = res.data.unidad
            })
        },
        submitForm() {
            if (this.hoja_vida.id) {
                axios.put(`/metas/hoja-vida/${this.hoja_vida.id}`, this.hoja_vida)
                .then(res => {
                    console.log(res)
                    if (res.data.status) {
                        this.$swalMini('success', `${res.data.message}`);
                    }
                })
                .catch(error => {
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                })
            } else {
                axios.post('/metas/hoja-vida', this.hoja_vida)
                .then(res => {
                    console.log(res)
                    if (res.data.status) {
                        this.$swalMini('success', `${res.data.message}`);
                        this.hoja_vida = res.data.hoja_vida
                    }
                })
                .catch(error => {
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                })
            }
        }
    }
};
</script>
