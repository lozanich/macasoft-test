<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
        <router-link class="navbar-brand" to="/">Home</router-link>
        <ul class="navbar-nav">
         <li class="nav-item">
            <router-link to="/users" class="nav-link" v-if="this.isLoggedIn">Users</router-link>
          </li>
          <li class="nav-item" v-if="!this.isLoggedIn">
            <router-link to="/login" class="nav-link">Login</router-link>
          </li>
          <li class="nav-item" v-if="this.isLoggedIn">
            <a href="#" @click.prevent="logout" class="nav-link">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    <br />
    <div>
      <transition name="fade">
        <router-view></router-view>
      </transition>
    </div>
  </div>
</template>

<style scoped>
  .fade-enter-active, .fade-leave-active {
    transition: opacity .5s
  }
  .fade-enter, .fade-leave-active {
    opacity: 0
  }
</style>

<script>

  export default{
    data(){
      return {
        isLoggedIn : false,
        name : null,
        api_token: {},
        id_user: null
      }
    },
    mounted(){
      this.isLoggedIn = localStorage.getItem('logged')
      this.api_token  = localStorage.getItem('api_token')
      this.id_user    = localStorage.getItem('id_user')
    },
    methods: {
      logout() {

        var token = document.head.querySelector('meta[name="csrf-token"]');
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
        axios.defaults.headers.common['Authorization'] = 'Bearer '+ this.api_token
        axios.post('api/auth/logout', [this.id_user])
        .then((res) => {
          this.isLoggedIn = false
          localStorage.setItem('logged', 'false');
          this.$router.push('/login');
        })
        .catch((err) => {
          console.log('error')
          console.log(err)
        });
      }
    }
  }
</script>