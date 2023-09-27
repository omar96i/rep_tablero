<template>
    <!-- Modal -->
    <div class="modal fade" id="modalEvidencias" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">Evidencias del reporte: </h5>
                    <button type="button" class="btn-close" @click="$parent.closeModal('modalEvidencias', false)"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12 mt-3">
                        <ul class="nav nav-pills mb-3 d-flex justify-content-around" role="tablist"
                            @change="handleTipoChange">
                            <li class="nav-item mx-1">
                                <button type="button" class="btn btn-outline-primary"
                                    :class="{ 'active': formData.tipo == 'documento' }"
                                    @click="formData.tipo = 'documento'">Documentos</button>
                            </li>
                            <li class="nav-item mx-1">
                                <button type="button" class="btn btn-outline-primary"
                                    :class="{ 'active': formData.tipo == 'imagen' }"
                                    @click="formData.tipo = 'imagen'">Fotos</button>
                            </li>
                            <li class="nav-item mx-1">
                                <button type="button" class="btn btn-outline-primary"
                                    :class="{ 'active': formData.tipo == 'video' }"
                                    @click="formData.tipo = 'video'">Videos</button>
                            </li>
                        </ul>

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h5>Subir Archivos</h5>
                            <form @submit.prevent="submitForm" enctype="multipart/form-data" class="row">
                                <div class="col-6 mb-3">
                                    <label for="tipo" class="form-label">Tipo de Archivo:</label>
                                    <select v-model="formData.tipo" class="form-select" id="tipo" required disabled>
                                        <option value="imagen">Imagen</option>
                                        <option value="documento">Documento</option>
                                        <option value="video">Video</option>
                                    </select>
                                </div>

                                <div class="col-6 mb-3">
                                    <div class="">
                                        <label class="form-label" for="archivos">Cargar evidencia:</label>
                                        <input type="file" id="archivos" class="form-control" multiple
                                            :accept="tipoArchivo()" @change="handleFileChange">
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Añadir</button>
                                </div>
                            </form>
                        </div>
                        <hr class="my-3">
                        <div class="col-12">
                            <h5>Archivos cargados</h5>
                            <ul class="list-group">
                                <template v-for="(evidencia, index) in evidencias" :key="index">
                                    <button v-if="evidencia.tipo == formData.tipo" class="list-group-item d-flex align-items-center justify-content-between">
                                        <div @click="descargar(evidencia.id)">
                                            <i :class="evidencia.tipo == 'documento' ? 'bx bx-file-blank me-2' : evidencia.tipo == 'imagen' ? 'bx bx-images me-2' : 'bx bxs-videos me-2'"></i>
                                            {{ evidencia.route_name }}
                                        </div>
                                        <div>
                                            <button class="btn btn-danger btn-sm" type="button"
                                                @click="deleteEvidencia(evidencia.id)"><i
                                                    class='bx bx-x-circle'></i></button>
                                        </div>
                                    </button>
                                </template>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['reporte_id'],
    data() {
        return {
            formData: {
                reporte_id: this.reporte_id,
                tipo: 'documento',
                archivos: [],
            },
            evidencias: [],
        };
    },
    created() {
        this.getEvidencias()
    },
    methods: {
        getEvidencias() {
            axios.get(`/metas/evidencias/${this.reporte_id}`)
                .then(res => {
                    this.evidencias = res.data.evidencias
                })
                .catch(error => {
                    console.log(error);
                })
        },
        submitForm() {
            const formData = new FormData();

            formData.append('reporte_id', this.formData.reporte_id);
            formData.append('tipo', this.formData.tipo);
            for (let i = 0; i < this.formData.archivos.length; i++) {
                formData.append('archivos[]', this.formData.archivos[i]);
            }

            axios.post('/metas/evidencias', formData)
                .then(res => {
                    if (res.data.status) {
                        this.$swalMini('success', `${res.data.message}`);
                        this.getEvidencias()
                    }
                })
                .catch(error => {
                    console.log(error.response)
                    this.$swalMini('error', `Se ha producido un error al realizar la acción.`);
                })
        },

        handleFileChange(event) {
            this.formData.archivos = event.target.files;
        },

        tipoArchivo() {
            if (this.formData.tipo === 'imagen') {
                return 'image/*';
            } else if (this.formData.tipo === 'documento') {
                return '.pdf';
            } else if (this.formData.tipo === 'video') {
                return 'video/*';
            }
        },

        deleteEvidencia(evidencia_id) {
            axios.delete(`/metas/evidencias/${evidencia_id}`).then(res => {
                console.log(res)
                if (res.data.status) {
                    this.$swalMini('success', `${res.data.message}.`)
                    this.getEvidencias()
                }
            }).catch(error => {
                console.log(error.response)
            })
        },

        descargar(id) {
            window.location.href = `/metas/evidencias/download/${id}`;
        }
    }
}

</script>