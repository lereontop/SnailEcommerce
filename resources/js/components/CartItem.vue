<template>
    <div
        class="flex items-center justify-between py-4 border-b border-gray-200"
    >
        <img
            :src="`/storage/${item.product.image}`"
            alt="Product Image"
            class="w-20 h-20 object-cover"
        />
        <div class="flex-1 mx-4">
            <p class="font-semibold">{{ item.product.name }}</p>
            <p class="text-sm text-gray-500">Quantity: {{ item.quantity }}</p>
        </div>
        <p class="font-bold text-lg">
            ${{ item.product.price * item.quantity }}
        </p>
    </div>
</template>

<script>
export default {
    name: "CartItem",
    props: {
        item: Object,
    },
};
</script>
