<template>
    <div>
        <h3 class="text-center my-3">Product Detail</h3>
        <div class="row">
            <div class="col-md-4">
                <img :src="product.product_image" :alt="product.name" class="img-fluid">
            </div>
            <div class="col-md-8">
                <h3>{{ product.name }}</h3>
                <p>{{ product.short_description }}</p>
                <p>{{ product.long_description }}</p>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ViewProduct",
    data () {
        return {
            product: {}
        }
    },
    created() {
        this.axios
            .get(`http://127.0.0.1:8000/api/products/${this.$route.params.id}`)
            .then((res) => {
                this.product = res.data.product;
            });
    }
}
</script>

<style scoped>

</style>
