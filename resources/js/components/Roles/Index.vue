<template>
    <!-- <div class="col-12">
        <div class="col-12">
            <button class="btn btn-primary m-1" :class="{'active' :loadTable}" @click="selectType('permisos')">Permisos</button>
            <button class="btn btn-primary" :class="{'active' :loadTableRoles }" @click="selectType('roles')">Roles</button>
        </div>
    </div> -->
    <!-- <div class="col-12" v-if="type == 'permisos'">
        <table-permisos-vue></table-permisos-vue>
    </div> -->
    <div class="col-12">
        <table-roles-vue></table-roles-vue>
    </div>


</template>
<script>
    import TableRolesVue from './TableRoles.vue'
    // import TablePermisosVue from './TablePermisos.vue'

    export default{
        components: {
            // TablePermisosVue,
            TableRolesVue
        },
        data(){
            return{
                file : '',
                items : [],
                loading : false,
                type : 'permisos',
                id : '',
            }
        },
        methods:{
            action(tipo,id = false){
                if(tipo == 'delete'){
                    this.deleteData(id)
                    return

                }
                console.log(this.$refs.modal_form)
                this.$refs.modal_form.setData(tipo, id)
            },

            selectType(type){
                this.type = type
            },

        }
    }

</script>
