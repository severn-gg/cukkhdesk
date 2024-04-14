<template>
  <div class="about">
    <Register msg="Daftarkan diri anda"/>
  </div>
</template>

<script>
// @ is an alias to /src
import Register from '@/components/Register.vue'

export default {
  name: 'RegisterView',
  components: {
    Register
  }
}
</script>
