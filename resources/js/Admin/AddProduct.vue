<template>
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">
            Add New Product
        </h2>

        <form @submit.prevent="submitProduct">
            <!-- Name -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-1"
                    >Product Name</label
                >
                <input
                    v-model="product.name"
                    type="text"
                    class="w-full p-2 border rounded"
                    required
                />
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-1"
                    >Description</label
                >
                <textarea
                    v-model="product.description"
                    class="w-full p-2 border rounded"
                    required
                ></textarea>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-1"
                    >Price ($)</label
                >
                <input
                    v-model="product.price"
                    type="number"
                    step="0.01"
                    class="w-full p-2 border rounded"
                    required
                />
            </div>

            <!-- Stock -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-1">Stock</label>
                <input
                    v-model="product.stock"
                    type="number"
                    class="w-full p-2 border rounded"
                    required
                />
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-1"
                    >Product Image</label
                >
                <input
                    type="file"
                    @change="handleFileUpload"
                    class="w-full p-2 border rounded"
                />
            </div>

            <!-- Submit Button -->
            <button
                type="submit"
                class="w-full bg-green-500 text-white py-2 rounded hover:bg-green-400 disabled:opacity-50"
                :disabled="loading"
            >
                {{ loading ? "Adding..." : "Add Product" }}
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
import axios from "axios";

const router = useRouter();
const toast = useToast();

const product = ref({
    name: "",
    description: "",
    price: "",
    stock: "",
    image: null,
});

const loading = ref(false);

const handleFileUpload = (event) => {
    product.value.image = event.target.files[0];
};

const submitProduct = async () => {
    loading.value = true;
    try {
        const formData = new FormData();
        formData.append("name", product.value.name);
        formData.append("description", product.value.description);
        formData.append("price", product.value.price);
        formData.append("stock", product.value.stock);
        if (product.value.image) {
            formData.append("image", product.value.image);
        }

        await axios.post("/farmer/products", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });

        toast.success("Product added successfully!", { timeout: 3000 });
        router.push("products"); // Redirect after success
    } catch (error) {
        toast.error("Failed to add product. Please try again.", {
            timeout: 3000,
        });
        console.error("Error:", error);
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped>
input,
textarea {
    border: 1px solid #ccc;
    transition: border 0.3s;
}
input:focus,
textarea:focus {
    border-color: #38a169;
    outline: none;
}
</style>
