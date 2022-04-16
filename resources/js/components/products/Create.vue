<template>
    <div>
        <h3 class="text-center my-3">Create Product</h3>
        <div class="row">
            <div class="col-md-4">
                <img class="img-fluid product-image" :src="image_preview" :alt="product.name" @click="selectImage" >
            </div>
            <div class="col-md-8">
                <form @submit.prevent="addProduct">
                    <div class="form-group mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="product.name">
                    </div>
                    <div class="form-group mb-3">
                        <label>Description (short)</label>
                        <textarea class="form-control" v-model="product.short_description"></textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label>Description (long)</label>
                        <textarea class="form-control" v-model="product.long_description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Product Image</label>
                        <input type="file" ref="product_image" class="form-control" @input="pickFile" >
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            product: {},
            image_preview: 'https://via.placeholder.com/640X480'
        }
    },
    methods: {
        addProduct () {
            let formData = new FormData();
            formData.append('name', this.product.name);
            formData.append('short_description', this.product.short_description);
            formData.append('long_description', this.product.long_description);
            formData.append('product_image', this.product.product_image);
            this.axios
                .post('http://127.0.0.1:8000/api/products', formData)
                .then(response => (
                    this.$router.push({ name: 'products' })
                ))
                .catch(err => console.log(err))
                .finally(() => this.loading = false)
        },
        selectImage () {
            this.$refs.product_image.click();
        },
        pickFile () {
            let input = this.$refs.product_image
            let file = input.files
            if (file && file[0]) {
                let reader = new FileReader
                reader.onload = e => {
                    this.image_preview = e.target.result
                }
                reader.readAsDataURL(file[0])
                this.$emit('input', file[0])
                this.product.product_image =  file[0];
            }
        }
    }
}
</script>

<style scoped>
.product-image:hover { cursor: pointer }
</style>
