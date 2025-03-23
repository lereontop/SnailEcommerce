<template>
    <div class="flex items-center space-x-2">
        <input
            type="number"
            v-model="quantity"
            min="1"
            class="w-16 p-2 border rounded"
        />
        <button
            class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-400"
            @click="addCart"
        >
            Add to Cart
        </button>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import { useToast } from "vue-toastification";

const props = defineProps({
    productId: Number, // Ensure it's a valid number
});

const toast = useToast();
const router = useRouter();
const quantity = ref(1); // Default quantity is 1

// Retrieve user ID from local storage or authentication state
const userId = computed(() => {
    const user = JSON.parse(localStorage.getItem("user"));
    return user ? user.id : null;
});

const addCart = async () => {
    if (!userId.value) {
        toast.warning("You need to log in first!", {
            timeout: 3000,
        });
        router.push("/login"); // Redirect to login
        return;
    }

    try {
        const response = await axios.post("/cart/add", {
            user_id: userId.value, // Include user ID
            product_id: props.productId, // Use the product ID from props
            quantity: quantity.value, // Use selected quantity
        });

        toast.success("Item added to cart!", {
            timeout: 3000,
        });

        console.log("Cart updated:", response.data);
    } catch (error) {
        console.error("Error adding to cart:", error);
        toast.error("Failed to add item to cart.");
    }
};
</script>
