import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import ContactForm from '../components/ContactForm.vue';
import ReservationForm from '../components/ReservationForm.vue';

const routes = [
  { path: '/', component: Home },
  { path: '/contacts', component: ContactForm },
  { path: '/reservations', component: ReservationForm },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
