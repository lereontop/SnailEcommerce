<template>
    <div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-md rounded-lg">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Product List</h2>
        <router-link to="add-product">
          <button class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            + Add Product
          </button>
        </router-link>
      </div>

      <!-- Product Table -->
      <div v-if="products.length > 0" class="overflow-x-auto">
        <table class="w-full border-collapse border border-gray-300">
          <thead>
            <tr class="bg-green-500 text-white">
              <th class="p-3 border">Image</th>
              <th class="p-3 border">Name</th>
              <th class="p-3 border">Price</th>
              <th class="p-3 border">Stock</th>
              <th class="p-3 border">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products" :key="product.id" class="text-center">
              <td class="p-3 border">
                <img :src="`/storage/${product.image}`" alt="Product" class="w-16 h-16 object-cover rounded" />
              </td>
              <td class="p-3 border">{{ product.name }}</td>
              <td class="p-3 border">${{ product.price }}</td>
              <td class="p-3 border">{{ product.stock }}</td>
              <td class="p-3 border space-x-2">
                <button @click="editProduct(product)" class="bg-blue-500 text-white px-3 py-1 rounded">Edit</button>
                <button @click="deleteProduct(product.id)" class="bg-red-500 text-white px-3 py-1 rounded">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <p v-else class="text-center text-gray-500">No products found.</p>

      <!-- Edit Product Modal -->
      <div v-if="showEditModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">
          <h3 class="text-lg font-bold mb-4">Edit Product</h3>

          <form @submit.prevent="updateProduct">
            <div class="mb-3">
              <label class="block text-gray-700 font-bold mb-1">Name</label>
              <input v-model="editForm.name" type="text" class="w-full p-2 border rounded" required />
            </div>

            <div class="mb-3">
              <label class="block text-gray-700 font-bold mb-1">Price ($)</label>
              <input v-model="editForm.price" type="number" step="0.01" class="w-full p-2 border rounded" required />
            </div>

            <div class="mb-3">
              <label class="block text-gray-700 font-bold mb-1">Stock</label>
              <input v-model="editForm.stock" type="number" class="w-full p-2 border rounded" required />
            </div>

            <div class="flex justify-end space-x-2 mt-4">
              <button type="button" @click="showEditModal = false" class="bg-gray-500 text-white px-4 py-2 rounded">
                Cancel
              </button>
              <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Update</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from "vue";
  import axios from "axios";
  import { useToast } from "vue-toastification";

  const toast = useToast();
  const products = ref([]);
  const showEditModal = ref(false);
  const editForm = ref({
    id: null,
    name: "",
    price: "",
    stock: "",
  });

  // Fetch Products
  const fetchProducts = async () => {
    try {
      const response = await axios.get("/farmer/products");
          products.value = response.data;
    } catch (error) {
      toast.error("Failed to load products.");
      console.error(error);
    }
  };

  // Open Edit Modal
  const editProduct = (product) => {
    editForm.value = { ...product };
    showEditModal.value = true;
  };

  // Update Product
  const updateProduct = async () => {
    try {
      await axios.put(`/farmer/products/${editForm.value.id}`, editForm.value);
      toast.success("Product updated successfully.");
      showEditModal.value = false;
      fetchProducts(); // Refresh product list
    } catch (error) {
      toast.error("Failed to update product.");
      console.error(error);
    }
  };

  // Delete Product
  const deleteProduct = async (id) => {
    if (!confirm("Are you sure you want to delete this product?")) return;

    try {
      await axios.delete(`/farmer/products/${id}`);
      toast.success("Product deleted successfully.");
      products.value = products.value.filter((p) => p.id !== id);
    } catch (error) {
      toast.error("Failed to delete product.");
      console.error(error);
    }
  };

  // Load products on mount
  onMounted(fetchProducts);
  </script>

  <style scoped>
  button:hover {
    opacity: 0.8;
  }
  </style>
