import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import KategorijaView from '../views/KategorijaView.vue'
import LekcijaView from '../views/LekcijaView.vue'
import SingleLessonView from '../views/SingleLessonView.vue'





const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/kategorija',
            name: 'kategorija',
            component: KategorijaView
        },
        {
            path: '/lekcija',
            name: 'lekcija',
            component: LekcijaView
        },
        {
            path: '/single/:id',
            name: 'single',
            component: SingleLessonView
        },







    ]
})

export default router
