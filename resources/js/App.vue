<template>
  <div>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
        <router-link class="navbar-brand" to="/">Home</router-link>
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link to="/create" class="nav-link">Create User</router-link>
          </li>
          <li class="nav-item">
            <router-link to="/users" class="nav-link">Users</router-link>
          </li>
          <li class="nav-item" v-if="!this.isLoggedIn">
            <router-link to="/login" class="nav-link">Login</router-link>
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
        isLoggedIn : true,
        name : null
      }
    },
    mounted(){
      console.log('App mounted');
    }
  }
</script>