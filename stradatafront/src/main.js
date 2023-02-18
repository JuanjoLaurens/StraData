import { createApp } from 'vue'
import App from './App.vue'
import axios from 'axios'
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap';


const app = createApp(App)

app.config.globalProperties.$http = axios

app.mount('#app')
