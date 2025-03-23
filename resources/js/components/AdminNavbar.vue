<template>
    <nav class="bg-green-700 text-white p-4 shadow-lg">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <RouterLink to="/admin/dashboard" class="text-2xl font-bold"
                >Admin Panel</RouterLink
            >

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-6">
                <RouterLink to="/admin/dashboard" class="hover:text-gray-300"
                    >Dashboard</RouterLink
                >
                <RouterLink to="/admin/products" class="hover:text-gray-300"
                    >Products</RouterLink
                >
                <RouterLink to="/admin/orders" class="hover:text-gray-300"
                    >Orders</RouterLink
                >
                <RouterLink to="/admin/users" class="hover:text-gray-300"
                    >Users</RouterLink
                >
                <button @click="logout" class="hover:text-red-400">
                    Logout
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="toggleMenu" class="md:hidden">
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16m-7 6h7"
                    ></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div
            v-if="isMenuOpen"
            class="md:hidden mt-2 bg-green-600 p-4 space-y-2"
        >
            <RouterLink to="dashboard" class="block hover:text-gray-300"
                >Dashboard</RouterLink
            >
            <RouterLink to="products" class="block hover:text-gray-300"
                >Products</RouterLink
            >
            <RouterLink to="orders" class="block hover:text-gray-300"
                >Orders</RouterLink
            >
            <RouterLink to="users" class="block hover:text-gray-300"
                >Users</RouterLink
            >
            <button @click="logout" class="block hover:text-red-400">
                Logout
            </button>
        </div>
    </nav>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const isMenuOpen = ref(false);

const toggleMenu = () => {
    isMenuOpen.value = !isMenuOpen.value;
};

const logout = () => {
    localStorage.removeItem("admin");
    router.push("/login");
};
</script>

<style scoped>
a:hover {
    text-decoration: underline;
}
</style>
