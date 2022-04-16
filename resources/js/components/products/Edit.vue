<template>
    <div>
        <h3 class="text-center my-3">Edit Product</h3>
        <div class="row">
            <div class="col-md-4">
                <img class="img-fluid" :src="product.product_image" :alt="product.name">
            </div>
            <div class="col-md-8">
                <form @submit.prevent="updateProduct">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Description</label>
                        <textarea class="form-control" v-model="product.long_description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
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
    },
    methods: {
        updateProduct() {
            this.axios
                .patch(`http://127.0.0.1:8000/api/products/${this.$route.params.id}`, this.product)
                .then((res) => {
                    this.$router.push({ name: 'products' });
                });
        }
    }
}
</script>
