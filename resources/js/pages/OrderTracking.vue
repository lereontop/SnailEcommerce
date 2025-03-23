<template>
    <div>

      <div class="max-w-xl mx-auto p-8">
        <h2 class="text-2xl font-bold mb-6">Track Your Order</h2>
        <form @submit.prevent="trackOrder" class="space-y-6">
          <div>
            <label for="orderNumber" class="block text-lg font-semibold">Order Number</label>
            <input type="text" id="orderNumber" v-model="orderNumber" class="w-full p-2 border border-gray-300 rounded-lg" required />
          </div>
          <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-lg hover:bg-green-400">Track Order</button>
        </form>

        <div v-if="orderStatus" class="mt-6 p-4 border border-gray-300 rounded-lg bg-gray-50">
          <h3 class="font-semibold text-xl">Order Status:</h3>
          <p>{{ orderStatus }}</p>
        </div>
      </div>

    </div>
  </template>

  <script>


  export default {
    name: 'OrderTracking',
    components: { },
    data() {
      return {
        orderNumber: '',
        orderStatus: '',
      };
    },
    methods: {
      trackOrder() {
        // In a real app, you'd call an API to check the order status.
        // For now, we'll simulate it.
        if (this.orderNumber === '12345') {
          this.orderStatus = 'Your order is on its way!';
        } else {
          this.orderStatus = 'Order not found.';
        }
      }
    }
  };
  </script>
