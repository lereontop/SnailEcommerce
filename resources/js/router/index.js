import { createRouter, createWebHistory } from "vue-router";
import UserLayout from "@/layouts/UserLayout.vue";
import AdminLayout from "@/layouts/AdminLayout.vue";


import Shop from '@/pages/Shop.vue';
import ProductDetails from '@/pages/ProductDetails.vue';
import Cart from '@/pages/Cart.vue';
import Checkout from '@/pages/Checkout.vue';
import OrderTracking from '@/pages/OrderTracking.vue';
import Login from '@/pages/Login.vue';
import Register from '@/pages/Register.vue';
import AddProduct from '../Admin/AddProduct.vue';
import ViewProducts from '../Admin/ViewProducts.vue';
import Home from '../pages/Home.vue';



const routes = [
    {
        path: "/",
        component: UserLayout,
        children: [
            { path: '', component: Home },
            { path: 'shop', component: Shop },
            { path: 'product/:id', name: 'ProductDetails', component: ProductDetails, props: true },
            { path: 'cart', component: Cart },
            { path: 'checkout', component: Checkout },
            { path: 'track-order', component: OrderTracking },


        ],
    },
    { path: '/login', component: Login },
    { path: '/register', component: Register },

    {
        path: "/admin",
        component: AdminLayout,
        children: [

            { path: 'add-product', component: AddProduct },
            { path: 'products', component: ViewProducts },

        ],
        meta: { requiresAdmin: true },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard to Protect Admin Routes
router.beforeEach((to, from, next) => {
    const user = JSON.parse(localStorage.getItem("user"));

    if (to.meta.requiresAdmin && (!user || user.role !== "admin")) {
        next("/"); // Redirect non-admins to homepage
    } else {
        next();
    }
});

export default router;
