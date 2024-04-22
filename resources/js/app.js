require('./bootstrap')

import { createApp } from 'vue'
import router from './router'
import axios from 'axios'

axios.defaults.headers = {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
    'Authorization': 'Bearer 3|UfCJ0RQ6iekOOnfUDeEO3K9D9qkwE6tcFrspZTKJ'
}
axios.defaults.baseURL = 'http://127.0.0.1:8000/api/';

const app = createApp({})

app.use(router)

app.mount('#app')
