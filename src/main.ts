import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './assets/main.css'

import DashboardLayout from './components/admin/DashboardLayout.vue'
import EmptyLayout from './components/admin/EmptyLayout.vue'
import PageLayout from './components/PageLayout.vue'

const app = createApp(App)

app.component('DefaultLayout', DashboardLayout)
app.component('EmptyLayout', EmptyLayout)
app.component('PageLayout', PageLayout)

app.use(router)
app.mount('#app')
