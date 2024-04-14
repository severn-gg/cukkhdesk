<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    
  </div>
</template>

<script>
import axios from "axios"
export default {
  name: 'HelloWorld',
  props: {
    msg: String
  },
  data(){
    return {
      username:'',
      password:''
    }
  },
  methods:{
    async login() {
      try {
        const response = await axios.post('/api/login', {
          username: this.username,
          password: this.password
        });

        // Check if response status is true
        if (response.data.status === true) {
          // Redirect to another route
          this.$router.push('/dashboard'); // Example: redirect to '/dashboard'
        } else {
          // Handle unsuccessful login (optional)
          console.error('Login failed:', response.data.message);
        }
      } catch (error) {
        // Handle error here
        console.error('Error during login:', error);
      }
    },
    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  h3 {
    margin: 40px 0 0;
  }
  ul {
    list-style-type: none;
    padding: 0;
  }
  li {
    display: inline-block;
    margin: 0 10px;
  }
  a {
    color: #42b983;
  }
</style>
