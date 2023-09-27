<template>
    <!-- metas de productos -->
    <div class="row">
        <div class="col-12">
            <h5>Metas Asociadas:</h5>
            <form @submit.prevent="saveMetaDeProductos()" class="row">
                <div class="col-12 col-md-6">
                    <label>Dependencia:</label>
                    <select class="form-select"  v-model="form_meta_producto.dependencia_id" required>
                        <option value="" selected disabled>Seleccionar...</option>
                        <option v-for="dependencia in select_dependencias" :value="dependencia.id">{{dependencia.nombre}}</option>
                    </select>
                </div>
                <div class="col-12 col-md-6">
                    <label>Indicadores de Producto:</label>
                    <select class="form-select"  v-model="form_meta_producto.meta_producto_id" required>
                        <option value="" selected disabled>Seleccionar...</option>
                        <option v-for="meta in select_metas_productos" :value="meta.id">{{meta.codigo}}</option>
                    </select>
                </div>
                <div class="text-center my-3">
                    <button class="btn btn-primary" type="submit">Añadir Meta de producto</button>
                </div>
            </form>
        </div>
        <div class="col-12 table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="table-primary">
                        <th>Meta de producto</th>
                        <th>Quitar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="meta in lista_metas_productos">
                        <td>{{ meta.meta_producto.codigo }}</td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm" type="button" @click="deleteMetaDeProductos(meta.id)"><i class='bx bx-x'></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <spinner v-if="false"></spinner>
    </div>
</template>

<script>
export default {
    props: ['proyecto_id'],
    data(){
        return{
            select_metas_productos: [],
            select_dependencias: [],
            lista_metas_productos: [],
            form_meta_producto: {
                proyecto_id: '',
                dependencia_id: '',
                meta_producto_id: ''
            },
        }
    },
    created() {
        this.getDataSelect()
        if (this.proyecto_id) {
            this.getProyectoMetas()
        }
    },
    methods:{
        resetForm(){
            this.form_meta_producto = {
                proyecto_id: '',
                meta_producto_id: '',
                indicador_id: ''
            }
        },
        getDataSelect(){
            axios.get('metas/get').then(res => {
                // console.log(res.data);
                this.select_metas_productos = res.data.metas
            }).catch(error => {
                console.log(error);
            })

            axios.get('/dependencia/get').then(res => {
                // console.log(res.data);
                this.select_dependencias = res.data.dependencia
            }).catch(error => {
                console.log(error);
            })
        },
        getProyectoMetas(){
            axios.get(`/proyectos-get-all/${this.proyecto_id}`).then(res => {
                // console.log(res)
                this.lista_metas_productos = res.data.proyecto.productos
            }).catch(error => {
                console.log(error);
            })
        },
        saveMetaDeProductos(){
            if (this.proyecto_id) {
                this.form_meta_producto.proyecto_id = this.proyecto_id
                axios.post('/proyectos-productos', this.form_meta_producto).then(res=>{
                    // console.log(res)
                    if (res.data.status) {
                         this.$swalMini('success', `${res.data.message}.`)
                        this.getProyectoMetas()
                        this.resetForm()
                    }
                }).catch(error=>{
                    console.log(error.response)
                })
            }else{
                alert('proyecto sin crear')
            }
        },
        deleteMetaDeProductos(id){
            axios.delete(`/proyectos-productos/${id}`).then(res=>{
                console.log(res)
                if (res.data.status) {
                     this.$swalMini('success', `${res.data.message}.`)
                    this.getProyectoMetas()
                }
            }).catch(error=>{
                console.log(error.response)
            })
        },
    }
}

</script>
