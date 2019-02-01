<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="panel-heading">
          <button @click="initAddUser()" class="btn btn-primary btn-xs pull-right">
            + Agregar nuevo usuario
          </button>
          <hr/>
          <h2>Mis usuarios</h2>
        </div>

        <div class="panel-body">
          <table class="table">
            <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre completo</th>
              <th scope="col">Email</th>
              <th scope="col">Rol</th>
              <th scope="col">Foto</th>
              <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user, index) in users">
              <td>{{ index + 1 }}</td>
              <th scope="row">{{ user.full_name }}</th>
              <td>{{ user.email }}</td>
              <td>{{ user.id_rol }}</td>
              <td><img width="50" height="50" :src=" 'storage/images/'+user.user_photo"></td>
              <td>
                <button @click="initUpdateUser(index)" class="btn btn-success btn-xs">Editar</button>
                <button @click="deleteUser(index)" class="btn btn-danger btn-xs">Eliminar</button>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="add_task_model">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Agregar nuevo usuario</h4>
          </div>
          <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
          <div class="modal-body">

            <div class="form-group">
              <label for="full_name">Nombre Completo:</label>
              <input type="text" name="full_name" id="full_name" placeholder="Nombre completo" class="form-control"
                     v-model="user.full_name">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" placeholder="Email" class="form-control"
                     v-model="user.email">
            </div>

            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" placeholder="Password" class="form-control"
                     v-model="user.password">
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirmacion de Password:</label>
              <input type="password" id="password_confirmation" placeholder="Confirmacion de password"
                     class="form-control"
                     v-model="user.password_confirmation">
            </div>

            <div class="form-group">
              <label for="rol">Selecciona Rol:</label>
              <select class="form-control" id="rol" v-model="user.id_rol">
                <option value="1" selected>Administrador</option>
                <option value="2">Usuario</option>
                <option value="3">Vendedor</option>
              </select>
            </div>

            <div class="form-group">
              <label for="user_photo">Foto del usuario</label>
              <input type="file" class="form-control-file" id="user_photo" @change="onImageChange">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" @click="createUser" class="btn btn-primary">Guargar</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- /.Update modal -->

    <div class="modal fade" tabindex="-1" role="dialog" id="update_user_model">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Actualizar Usuario</h4>
          </div>
          <div class="modal-body">
            <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>

            <div class="form-group">
              <label for="full_name">Nombre Completo:</label>
              <input type="text" name="full_name" id="full_name" placeholder="Nombre completo" class="form-control"
                     v-model="update_user.full_name">
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" name="email" id="email" placeholder="Email" class="form-control"
                     v-model="update_user.email">
            </div>

            <div class="form-group">
              <label for="password">Password:</label>
              <input type="password" id="password" placeholder="Password" class="form-control"
                     v-model="update_user.password">
            </div>

            <div class="form-group">
              <label for="password_confirmation">Confirmacion de Password:</label>
              <input type="password" id="password_confirmation" placeholder="Confirmacion de password"
                     class="form-control"
                     v-model="user.password_confirmation">
            </div>

            <div class="form-group">
              <label for="rol">Selecciona Rol:</label>
              <select class="form-control" id="rol" v-model="update_user.id_rol">
                <option value="1" selected>Administrador</option>
                <option value="2">Usuario</option>
                <option value="3">Vendedor</option>
              </select>
            </div>

            <div class="form-group">
              <label for="user_photo">Foto del usuario</label>
              <input type="file" class="form-control-file" id="user_photo" @change="onImageChange">
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" @click="updateUser" class="btn btn-primary">Submit</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  </div>
</template>

<script>
  export default {
    /*name: "IndexUserComponent"*/
    data() {
      return {
        isLoggedIn: false,
        api_token: {},
        id_user: null,
        user: {
          full_name: '',
          email: '',
          id_rol: '',
          password: '',
          password_confirmation: '',
          user_photo: null,
        },
        errors: [],
        users: [],
        validationErrors: '',
        image: '',
        update_user: {}
      }
    },
    mounted() {
      this.api_token = localStorage.getItem('api_token')
      this.id_user = localStorage.getItem('id_user')
      this.readUsers();
    },
    methods: {
      onImageChange(e) {
        let files = e.target.files || e.dataTransfer.files;
        if (!files.length)
          return;
        this.createImage(files[0]);
      },
      createImage(file) {
        let reader = new FileReader();
        let vm = this;
        reader.onload = (e) => {
          vm.user.user_photo = e.target.result;
        };
        reader.readAsDataURL(file);
      },
      initAddUser() {
        $("#add_task_model").modal("show");
      },
      createUser() {
        console.log('creating user');
        console.log(this.user.user_photo);
        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        window.axios.defaults.headers.common['content-type'] = 'multipart/form-data';
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.api_token
        axios.post('api/users',
          this.user
        )
          .then(response => {
            this.reset();
            this.readUsers();
            this.users = response.data;
            $("#add_task_model").modal("hide");
          }).catch((err) => {
          if (err.response.status == 422) {
            this.validationErrors = err.response.data.errors;
          }
        });
      },
      readUsers() {
        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.api_token
        axios.get('api/users')
          .then(response => {
            this.users = response.data;
          });
      },
      reset() {
        this.user.full_name = '';
        this.user.email = '';
        this.user.password = '';
        this.user.password_confirmation = '';
        this.user.id_rol = '';
      },
      deleteUser(index) {
        console.log('deleting');
        console.log(index);
        axios.delete('/api/users/' + this.users[index].id)
          .then(response => {
            this.users.splice(index, 1);
            this.readUsers();
          })
          .catch(error => {
            console.log('error delete user');
            console.log(error);
          });
      },
      initUpdateUser(index) {
        this.errors = [];
        $("#update_user_model").modal("show");
        this.update_user = this.users[index];
      },
      updateUser() {
        console.log('Updating');
        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + this.api_token
        axios.put('/api/users/' + this.update_user.id,
          this.update_user
        ).then(response => {
            $("#update_user_model").modal("hide");
            this.readUsers();
          })
          .catch(error => {
            if (error.response.status == 422) {
              this.validationErrors = err.response.data.errors;
            }
          });
      }
    }
  }
</script>

<style scoped>

</style>