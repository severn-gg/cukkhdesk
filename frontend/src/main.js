import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from 'axios'

import 'bootstrap/dist/css/bootstrap.css'
import './assets/css/style.css'
import './assets/vendor/bootstrap-icons/bootstrap-icons.css'
import './assets/vendor/boxicons/css/boxicons.min.css'
import './assets/vendor/bootstrap/js/bootstrap.bundle.min.js'
// import 'bootstrap-vue/dist/bootstrap-vue.css';


axios.defaults.baseURL = 'http://localhost:8080'

createApp(App).use(router).mount('#app')
