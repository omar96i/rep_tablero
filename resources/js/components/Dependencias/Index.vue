<template>
    <div class="col-12">
        <div class="col-12">
            <button type="button" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#modalDependencia" @click="action('insert')">
                Nuevo registro
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-dependencia" id="tabladependencia" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Informacion de Dependencia</th>
                        <th>Mision</th>
                        <th>Vision</th>
                        <th>Organigrama</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(dependencia, index) in dependencias" :key="index">
                        <td>{{ dependencia.nombre }}</td>
                        <td>{{ dependencia.descripcion }}</td>
                        <td>{{ dependencia.info_dependencia }}</td>
                        <td>{{ dependencia.mision }}</td>
                        <td>{{ dependencia.vision }}</td>
                        <td>{{ dependencia.organigrama }}</td>
                        <td class="d-flex text-center">
                            <button type="button" class="btn btn-info btn-circle btn-sm mx-1" data-bs-toggle="modal" data-bs-target="#modalDependencia" @click="action('edit',dependencia.id)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(dependencia.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <modal-dependencia ref="modal_form"></modal-dependencia>
    </div>
</template>
<script>
    import Modal from "./Modal.vue";
    export default{

        components: {
            'modal-dependencia' : Modal,
        },
        data(){
            return{

                items: {},
                loading: false,
                load: false,
                dependencias:{},
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
                axios.get('/dependencia/get').then(res=>{
                    this.dependencias = res.data.dependencia
                    this.load=true
                    this.loading=true
                })
            },
            deleteData(id){
                // console.log(id)
                axios.get(`/dependencia/delete/${id}`).then(res=>{
                    if(res.data.status){
                        this.$swalMini('success', `Dependencia eliminada con exito.`);
                        this.getData()
                    }
                })
                return
            },
        }
    }

</script>
