import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

import './assets/css/app.css'; // Importe o arquivo CSS do Tailwind

const app = createApp(App);
app.use(router);
app.mount('#app');
