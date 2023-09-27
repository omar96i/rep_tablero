<template>
    <div class="col-12">
        <div class="col-12">
            <button type="button" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#modalUnidad" @click="action('insert')">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-unidad" id="tablaunidad" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(unidad, index) in unidades" :key="index">
                        <td>{{ unidad.nombre }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalUnidad" @click="action('edit',unidad.id)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(unidad.id)"><i class='bx bxs-trash' ></i></button>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <modal-unidad ref="modal_form"></modal-unidad>
    </div>
</template>
<script>
    import axios from "axios";
    import Modal from "./Modal.vue";


    export default{

        components: {
            'modal-unidad' : Modal,
        },
        data(){
            return{

                items: {},
                loading: false,
                load: false,
                unidades:{},
            }
        },
        created(){
            this.getData()

        },

        methods:{
            action(tipo,id){
                this.$refs.modal_form.setData(tipo,id)
            },
            getData(){
                axios.get('/unidad/get').then(res=>{
                    this.unidades = res.data.unidad
                    this.load=true
                    this.loading=true
                })
            },
            deleteData(id){
                // console.log(id)
                axios.get(`/unidad/delete/${id}`).then(res=>{
                    if(res.data.status){
                        this.$swalMini('success', `Unidad eliminada con exito.`);
                        this.getData()
                    }
                })
                return
            },
        },
    }

</script>
