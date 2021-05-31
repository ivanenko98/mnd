<template>
  <order-detail :order="order" />
</template>

<script>
import OrderDetail from './components/OrderDetail';
import OrderResource from "@/api/order";
const orderResource = new OrderResource();

export default {
  name: 'EditForm',
  components: { OrderDetail },
    data() {
        return {
            order: {},
        };
    },
    created() {
        const id = this.$route.params && this.$route.params.id;
        this.getOrder(id);
    },
    methods: {
        async getOrder(id) {
            const { data } = await orderResource.get(id);
            this.order = data;
        },
    },
};
</script>

