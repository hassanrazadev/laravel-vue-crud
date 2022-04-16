import ProductsList from './components/products/List.vue';
import CreateProduct from './components/products/Create.vue';
import EditProduct from './components/products/Edit.vue';
import ViewProduct from './components/products/View'
import Home from './components/Home'

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },{
        name: 'products',
        path: '/products',
        component: ProductsList
    },
    {
        name: 'create-product',
        path: '/products/create',
        component: CreateProduct
    },
    {
        name: 'view-product',
        path: '/products/:id',
        component: ViewProduct
    },
    {
        name: 'edit-product',
        path: '/products/edit/:id',
        component: EditProduct
    }
];
