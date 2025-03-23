<template>
    <div
        class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md"
    >
        <!-- Handle missing image with a fallback -->
        <RouterLink
            :to="{ name: 'ProductDetails', params: { id: product.id } }"
        >
            <img
                :src="`storage/${product?.image} ` || defaultImage"
                alt="Product Image"
                class="w-full h-64 object-cover"
            />
        </RouterLink>
        <div class="p-4">
            <h3 class="text-lg font-semibold">
                <RouterLink
                    :to="{ name: 'ProductDetails', params: { id: product.id } }"
                    class="text-blue-600 hover:underline"
                >
                    {{ product?.name || "Unnamed Product" }}
                </RouterLink>
            </h3>

            <p class="text-gray-500">
                {{
                    product?.description.substring(0, 100) + "..." ||
                    "No description available."
                }}
            </p>
            <p class="font-bold text-lg text-green-500">
                #{{ formattedPrice }}
            </p>
            <AddCartBtn :productId="product.id" />
        </div>
    </div>
</template>

<script setup>
import { defineProps, computed } from "vue";
import AddCartBtn from "./AddCartBtn.vue";
import { RouterLink } from "vue-router";

// Define Props
const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

// Default Image for Missing Product Images
const defaultImage = "https://via.placeholder.com/300x200?text=No+Image";

// Computed Property for Price Formatting
const formattedPrice = computed(() => {
    return props.product?.price
        ? Number(props.product.price).toFixed(2)
        : "0.00";
});
</script>
