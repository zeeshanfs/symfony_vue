import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/main.css'
import store from './store'

import DashboardLayout from './components/admin/DashboardLayout.vue'
import EmptyLayout from './components/admin/EmptyLayout.vue'
import PageLayout from './components/PageLayout.vue'

const app = createApp(App)

app.component('DefaultLayout', DashboardLayout)
app.component('EmptyLayout', EmptyLayout)
app.component('PageLayout', PageLayout)

// Set the global API variable
const globalAPI = {
    baseURL: 'http://localhost:8000/'
};
  
// Provide the globalAPI to all components
app.provide('globalAPI', globalAPI);

app.use(router)
app.use(store)

app.mount('#app')
