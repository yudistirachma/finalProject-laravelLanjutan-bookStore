<template>
    <div class="container">
      <div>
        <chat-message-component/>
        <chat-form-component/>
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
