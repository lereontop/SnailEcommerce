<template>
    <div class="max-w-4xl mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6">Your Cart</h2>

        <div v-if="cartItems.length > 0">
            <div v-for="item in cartItems" :key="item.id">
                <CartItem :item="item" />
            </div>

            <!-- Cart Summary -->
            <div class="flex justify-between mt-6">
                <p class="font-semibold">Total: ${{ totalPrice }}</p>
                <RouterLink to="/checkout" >
                    <button
                        class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-400"
                    >
                        Proceed to Checkout
                    </button>
                </RouterLink>
            </div>
        </div>

        <div v-else class="text-center text-gray-500">
            <p>Your cart is empty.</p>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import CartItem from "@/components/CartItem.vue";

// Store cart items
const cartItems = ref([]);

// Retrieve user ID from local storage (adjust based on authentication method)
const userId = computed(() => {
    const user = JSON.parse(localStorage.getItem("user"));
    return user ? user.id : null;
});

// Fetch user's cart from backend
const fetchCart = async () => {
    if (!userId.value) {
        console.error("User not logged in");
        return;
    }

    try {
        const response = await axios.get(`/cart`);
        cartItems.value = response.data; // Adjust based on API response structure
    } catch (error) {
        console.error("Error fetching cart:", error);
    }
};
// removeFromCart(id) {
//             await axios.delete(`/cart/remove/${id}`);
//             this.cart = this.cart.filter((item) => item.id !== id);
       // },
// Compute total price
const totalPrice = computed(() =>
    cartItems.value.reduce(
        (total, item) => total + item.product.price * item.quantity,
        0
    )
);

// Fetch cart on component mount
onMounted(fetchCart);
</script>

<style scoped></style>
