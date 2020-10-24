<template>
    <div class="container">
      <div>
          <router-link to="/">Home</router-link>
          <router-link to="/chat">Live Chat</router-link>
          <router-link to="/order">Order A Book</router-link>

      </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
