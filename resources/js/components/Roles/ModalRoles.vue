<template>
    <!-- Modal -->
    <div class="modal fade" id="modalRoles" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalFullTitle">{{ (tipo == 'insert') ? 'Nuevo Rol' : 'Editar Rol' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Nombre</label>
                            <div class="input-group input-group-merge" name="name">
                                <input type="text" class="form-control" v-model="roles.name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-check col-6" v-for="permission in permisos" :key="permission.id">
                                <input name="permissions" class="form-check-input" type="checkbox"
                                    v-model="selectedPermissions" :value="permission.id">
                                <label class="form-check-label" :for="permission.id">
                                    {{ permission.name }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cierrame" class="btn btn-outline-secondary"
                        data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" @click="action">{{ (tipo == 'insert') ? 'Agregar' :
                        'Editar' }}</button>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            tipo: '',
            roles: {
                name: "",
                permissions: [],
            },
            permisos: [],
            selectedPermissions: [],
        }
    },
    created() {
        this.getPermisos();
    },
    methods: {
        getPermisos() {
            axios.get(`/permisos/get-all`)
                .then(res => {
                    this.permisos = res.data.permisos;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getData(id) {
            axios.get(`/roles/getData/${id}`)
                .then(res => {
                    this.roles = res.data.roles;
                    this.selectedPermissions = this.roles.permissions.map(permission => permission.id);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        setData(tipo, id) {
            this.roles = {
                name: "",
                permissions: [],
            };
            if (tipo == 'insert') {
                this.tipo = tipo;
            }
            if (tipo == 'edit') {
                this.getData(id);
                this.tipo = tipo;
            }
        },
        action() {
            this.roles.permissions = this.selectedPermissions;
            axios.post((this.tipo == 'insert') ? '/roles/store' : `/roles/update/${this.roles.id}`, this.roles)
                .then(res => {
                    console.log(res.data);
                    if (res.data.status) {
                        this.$swalMini('success', `Permisos asignados con exito.`);
                        this.$parent.getData();
                        setTimeout(() => {
                            document.getElementById("cierrame").click();
                        }, 200);
                    }
                })
                .catch(error => {
                    this.alert('Registro', 'Error en el servidor', 'error')
                    console.log(error);
                });
        },
    },
};
</script>
  