<template>
    <div>
      <!-- <Navbar /> -->
      <section class="p-8 bg-gray-50">
        <h2 class="text-3xl font-bold text-center mb-6">Shop Our Products</h2>

        <!-- Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <ProductCard v-for="product in paginatedProducts" :key="product.id" :product="product" />
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-8">
          <button
            @click="changePage(page - 1)"
            :disabled="page === 1"
            class="px-4 py-2 mx-2 bg-green-500 text-white rounded-full hover:bg-green-400 disabled:opacity-50"
          >
            Previous
          </button>
          <span class="text-lg font-semibold">Page {{ page }} of {{ totalPages }}</span>
          <button
            @click="changePage(page + 1)"
            :disabled="page === totalPages"
            class="px-4 py-2 mx-2 bg-green-500 text-white rounded-full hover:bg-green-400 disabled:opacity-50"
          >
            Next
          </button>
        </div>
      </section>
      <!-- <Footer /> -->
    </div>
  </template>

<script setup>
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import ProductCard from "@/components/ProductCard.vue";

// Reactive state
const products = ref([]);
const productsPerPage = ref(4);
const page = ref(1);

// Fetch products from Laravel backend
const fetchProducts = async () => {
    try {
        const response = await axios.get("/products");
        products.value = response.data; // Assign fetched data to products
    } catch (error) {
        console.error("Error fetching products:", error);
    }
};

// Computed properties
const totalPages = computed(() => Math.ceil(products.value.length / productsPerPage.value));

const paginatedProducts = computed(() => {
    const start = (page.value - 1) * productsPerPage.value;
    return products.value.slice(start, start + productsPerPage.value);
});

// Change page function
const changePage = (newPage) => {
    if (newPage > 0 && newPage <= totalPages.value) {
        page.value = newPage;
    }
};

// Fetch products when the component mounts
onMounted(fetchProducts);
</script>
