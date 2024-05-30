import { createRouter, createWebHistory } from 'vue-router';
import EquipmentForm from '../components/EquipmentForm.vue';
import EquipmentSearch from '../components/EquipmentSearch.vue';

const routes = [
  { path: '/', component: EquipmentSearch },
  { path: '/create', component: EquipmentForm }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
