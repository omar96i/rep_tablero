<template>
    <div class="col-12 text-center">
    </div>
    <div class="col-12">
        <div class="table-responsive">
            <button type="button" class="btn btn-info my-3" data-bs-toggle="modal" data-bs-target="#modalRoles" @click="action('insert')">
                Nuevo registro
            </button>
            <table class="table table-bordered table-roles" id="tablaroles" width="100%" cellspacing="0" >
                <thead>
                    <tr>
                        <!-- <th></th> -->
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(rol, index) in roles" :key="index">
                        <td>{{ rol.name }}</td>
                        <td class="text-center d-flex">
                            <button type="button" class="btn btn-info btn-circle btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalRoles" @click="action('edit',rol.id)"><i class='bx bxs-edit' ></i></button>
                            <button class="btn btn-danger btn-circle btn-sm"  @click="deleteData(rol.id)"><i class='bx bxs-trash' ></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <modal-roles ref="modal_form"></modal-roles>
    </div>
</template>
<script>
import ModalRoles from "./ModalRoles.vue";
export default{
    components: {
        'modal-roles' : ModalRoles,
    },
    data(){
        return{

            items: {},
            loading: false,
            load: false,
            roles:{},
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
            axios.get('/roles/get').then(res=>{
                this.roles = res.data.roles
                this.load=true
                this.loading=true
            })
        },
        deleteData(id){
            axios.get(`/roles/delete/${id}`).then(res=>{
                if(res.data.status){
                    this.getData()
                }
            })
        },
    },
}
</script>
