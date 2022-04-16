<template>
    <div class="products-wrapper">
        <div class="d-flex justify-content-center align-items-center">
            <h2 class="text-center my-3 me-3">Products List</h2>
            <router-link to="/products/create" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i>
            </router-link>
        </div>

        <div class="products row mb-2">
            <div v-for="product in products" :key="product.id" class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <img :src="product.product_image" :alt="product.name" class="img-fluid">
                        <p class="mt-2">{{ product.name }}</p>
                    </div>
                    <div class="card-footer">
                        <div class="btn-group d-flex" role="group" aria-label="Basic mixed styles example">
                            <router-link :to="'/products/' + product.id" class="btn btn-success">
                                <i class="bi bi-eye-fill"></i>
                            </router-link>
                            <router-link :to="'/products/edit/' + product.id" class="btn btn-info">
                                <i class="bi bi-pen-fill"></i>
                            </router-link>
                            <button @click="deleteProduct(product.id)" class="btn btn-danger">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item" :class="{ disabled: prev_page === 1 }">
                    <router-link class="page-link" :to="prev_page > 1 ? '/products?page=' + prev_page : ''" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </router-link>
                </li>
                <li class="page-item" :class="{ active: current_page === page }" v-for="page in total_pages" :key="page">
                    <router-link class="page-link" :to="'/products?page=' + page ">{{ page }}</router-link>
                </li>
                <li class="page-item" :class="{ disabled: next_page === current_page }">
                    <router-link class="page-link" :to="next_page < total_pages ? '/products?page=' + next_page : ''" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: "ProductsList",
    data() {
        return {
            products: [],
            total_pages: 1,
            current_page: this.$route.query.page || 1,
            next_page: null,
            prev_page: null,
        }
    },
    created() {
        this.loadProducts();
    },
    mounted() {
        this.current_page = this.$route.query.page || 1
    },
    methods: {
        deleteProduct(id) {
            if (confirm('Do you really want to delete product?')) {
                this.axios
                    .delete(`http://127.0.0.1:8000/api/products/${id}`)
                    .then(response => {
                        let i = this.products.map(data => data.id).indexOf(id);
                        this.products.splice(i, 1);
                        this.loadProducts();
                    });
            }
        },
        loadProducts () {
            this.axios
                .get('http://127.0.0.1:8000/api/products?page=' + this.current_page)
                .then(response => {
                    this.products = response.data.products.data;
                    this.total_pages = response.data.products.last_page;
                    this.current_page = response.data.products.current_page;
                    this.next_page = this.current_page < this.total_pages ? (this.current_page + 1) : this.current_page;
                    this.prev_page = this.current_page > 1 ? (this.current_page - 1) : this.current_page;
                });
        }
     },
    watch: {
        '$route.query.page'(toPage) {
            console.log(toPage);
            this.current_page = toPage;
            this.loadProducts();
        }
    }
}
</script>
