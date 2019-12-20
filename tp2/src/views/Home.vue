<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <Publicacao user="Welcome to Your Vue.js App"/>
  </div>
</template>

<script>
// @ is an alias to /src
import Publicacao from '@/components/Publicacao.vue'

export default {
  name: 'home',
  components: {
    Publicacao
  }
}
</script>
