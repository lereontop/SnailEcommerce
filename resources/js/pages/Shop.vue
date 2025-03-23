<template>
    <div>
        <section class="p-8 bg-gray-50">
            <h2 class="text-3xl font-bold text-center mb-6">
                Welcome to SnailStore
            </h2>

            <p v-if="!products.length" class="text-center text-gray-500">
                Loading products...
            </p>

            <div
                v-else
                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6"
            >
                <ProductCard
                    v-for="product in products"
                    :key="product.id"
                    :product="product"
                />
            </div>
        </section>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import ProductCard from "@/components/ProductCard.vue";

export default {
    components: {
        ProductCard,
    },
    setup() {
        // Reactive data
        const products = ref([]);
        // Fetch data from Laravel backend
        const fetchProducts = async () => {
            try {
                const response = await axios.get("/products");
                products.value = response.data;
            } catch (error) {
                console.error("Error fetching products:", error);
            }
        };

        onMounted(() => {
            fetchProducts();
        });

        // Return reactive data
        return {
            products,
        };
    },
};
</script>
