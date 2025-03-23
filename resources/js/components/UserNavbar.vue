<template>
    <nav
        class="bg-gradient-to-r from-green-500 to-green-700 text-white p-4 shadow-lg"
    >
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <RouterLink to="/" class="text-2xl font-bold tracking-wide"
                >SnailStore</RouterLink
            >

            <!-- Search Bar -->
            <div class="flex items-center space-x-4">
                <input
                    type="text"
                    placeholder="Search products..."
                    class="px-4 py-2 rounded-full text-black bg-white focus:outline-none"
                />
                <button
                    class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-full focus:outline-none"
                >
                    Search
                </button>
            </div>

            <!-- Navigation Links & Cart -->
            <div class="space-x-3 flex items-center">
                <RouterLink
                    to="/shop"
                    class="hover:text-green-200 transition-colors"
                    >Shop</RouterLink
                >

                <RouterLink
                    v-if="isAuthenticated"
                    to="/cart"
                    class="relative hover:text-green-200 transition-colors"
                >
                    Cart
                    <!-- Cart Item Counter -->
                    <span
                        v-if="cartItemCount > 0"
                        class="absolute top-[-10px] right-[-10px] bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center"
                    >
                        {{ cartItemCount }}
                    </span>
                </RouterLink>

                <!-- If user is logged in, show name & Logout -->
                <div v-if="isAuthenticated" class="flex items-center space-x-3">
                    <span class="font-semibold">{{ user.name }}</span>
                    <button
                        @click="logout"
                        class="hover:text-red-400 transition-colors"
                    >
                        Logout
                    </button>
                </div>

                <!-- If not logged in, show Login -->
                <RouterLink
                    v-else
                    to="/login"
                    class="hover:text-green-200 transition-colors"
                >
                    Login
                </RouterLink>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, watchEffect } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

const user = ref(null);
const cartItemCount = ref(0);
const router = useRouter();

// Check if user is authenticated
const isAuthenticated = computed(() => user.value !== null);

// Fetch user's cart count from backend
const fetchCartCount = async () => {
    if (!isAuthenticated.value) return;

    try {
        const response = await axios.get(`/cart/${user.value.id}/count`);
        cartItemCount.value = response.data.count; // Adjust based on API response
    } catch (error) {
        console.error("Error fetching cart count:", error);
    }
};

// Fetch user data and cart count on mount
onMounted(() => {
    const storedUser = localStorage.getItem("user");
    if (storedUser) {
        user.value = JSON.parse(storedUser);
        fetchCartCount(); // Fetch cart count after user is loaded
    }
});

// Watch user login state and update cart count
watchEffect(() => {
    if (isAuthenticated.value) {
        fetchCartCount();
    } else {
        cartItemCount.value = 0; // Reset cart count when logged out
    }
});

// Logout function
const logout = () => {
    localStorage.removeItem("user"); // Clear user data
    user.value = null;
    cartItemCount.value = 0; // Reset cart count
    router.push("/login"); // Redirect to login page
};
</script>

<style scoped>
/* Add subtle hover and focus effects */
a:hover {
    text-decoration: underline;
}

input:focus {
    box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
    outline: none;
}

button:focus {
    box-shadow: 0 0 5px rgba(59, 130, 246, 0.5);
}
</style>
