<template>
    <div>
      <div class="container mx-auto p-8">
        <div v-if="product" class="flex flex-col md:flex-row items-center gap-8">
          <!-- Product Image -->
          <img
            :src="`/storage/${product?.image}`"
            alt="Product Image"
            class="w-full md:w-1/2 h-96 object-cover rounded-lg shadow-lg"
          />
              <!-- Product Info -->
          <div class="md:w-1/2">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">{{product.name || "Unnamed Product" }}</h2>
            <p class="text-lg text-gray-600 mb-4">{{ product.description || "No description available." }}</p>
            <p class="text-2xl font-semibold text-green-500 mb-6">${{ product.price }}</p>
            <!-- Add to Cart -->
            <AddCartBtn :productId="product.id" />
          </div>
        </div>

        <!-- Loading Message -->
        <p v-else class="text-center text-gray-500">Loading product details...</p>
      </div>
    </div>
  </template>


<script setup>
import { ref, onMounted, computed, watch } from "vue";
import { useRoute } from "vue-router";
import AddCartBtn from "../components/AddCartBtn.vue";
import axios from "axios";

const route = useRoute();
const productId = computed(() => route.params.id); // Ensure reactivity
const product = ref(null);

// Fetch product details
const fetchProductDetails = async () => {
  try {
    if (!productId.value) return; // Prevent API call if ID is missing
    const response = await axios.get(`/products/${productId.value}`);
    product.value = response.data;
    console.log(product.value);
  } catch (error) {
    console.error("Error fetching product details:", error);
  }
};
// Watch for changes in productId (useful if navigating between products)
watch(productId, fetchProductDetails, { immediate: true });
</script>

