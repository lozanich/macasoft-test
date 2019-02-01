<template>
  <div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card card-default">
      <div class="card-header">Login</div>
      <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
      <div class="card-body">
        <form autocomplete="off" @submit.prevent="login" method="post">
          <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
            <div class="col-md-6">
              <input id="email" type="email" class="form-control" v-model="user.email"  autofocus>
            </div>
          </div>

          <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
              <input id="password" type="password" class="form-control" v-model="user.password" >
            </div>
          </div>

          <div class="form-group row mb-0">
            <div class="col-md-8 offset-md-4">
              <button type="submit" class="btn btn-primary">
                Login
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
  export default {
    data(){
      return {
        user: {
          email:null,
          password:null,
          message:false,
          logged:false
        },
        messages: [],
        validationErrors: ''
      }
    },
    methods: {
      login(){
        var isLoggedIn = $("meta[name=login-status]").attr('content');
        console.log('logged');
        console.log(isLoggedIn);
        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        axios.post('api/auth/login', this.user)
          .then((res) => {
            console.log(res);
            let access_token = res.data.token;
            console.log(access_token);
            localStorage.setItem('token', access_token);
            this.$router.push('/');
          })
          .catch((err) => {
            if (err.response.status == 422){
              this.validationErrors = err.response.data.errors;
            }
          });
      }
    }
  }
</script>

<style scoped>

</style>