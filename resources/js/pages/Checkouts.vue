<template>
    <div>
        <h1>Checkout</h1>
        <button @click="placeOrder">Place Order</button>
    </div>
</template>

<script>
import axios from "axios";
export default {
    methods: {
        async placeOrder() {
            const res = await axios.post("/api/checkout");
            alert("Order placed!");
            this.$router.push("/payment/" + res.data.order_id);
        },
    },
};
</script>
