
<template>
    <div>
      <!-- <Navbar /> -->
      <div class="max-w-4xl mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6">Checkout</h2>
        <form @submit.prevent="submitOrder" class="space-y-6">
          <div class="space-y-4">
            <label for="name" class="block text-lg font-semibold">Full Name</label>
            <input type="text" id="name" v-model="form.name" class="w-full p-2 border border-gray-300 rounded-lg" required />
          </div>
          <div class="space-y-4">
            <label for="email" class="block text-lg font-semibold">Email</label>
            <input type="email" id="email" v-model="form.email" class="w-full p-2 border border-gray-300 rounded-lg" required />
          </div>
          <div class="space-y-4">
            <label for="address" class="block text-lg font-semibold">Address</label>
            <textarea id="address" v-model="form.address" class="w-full p-2 border border-gray-300 rounded-lg" required></textarea>
          </div>
          <div class="flex justify-between">
            <p class="text-lg font-semibold">Total: ${{ totalPrice }}</p>
            <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-400">Place Order</button>
          </div>
        </form>
      </div>
      <!-- <Footer /> -->
    </div>
  </template>

  <script>


  export default {
    name: 'Checkout',
    components: { },
    data() {
      return {
        form: {
          name: '',
          email: '',
          address: '',
        },
        cartItems: [
          { id: 1, product: { name: 'Product 1', price: 20 }, quantity: 2 },
          { id: 2, product: { name: 'Product 2', price: 30 }, quantity: 1 },
        ]
      };
    },
    computed: {
      totalPrice() {
        return this.cartItems.reduce((total, item) => total + item.product.price * item.quantity, 0);
      }
    },

  };
  </script>
