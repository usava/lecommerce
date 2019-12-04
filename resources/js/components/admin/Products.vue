<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <td></td>
                <td>Product</td>
                <td>Units</td>
                <td>Price</td>
                <td>Description</td>
            </tr>
            </thead>
            <tbody>
            <tr @dblclick="editingItem = product" @key="index" v-for="(product, index) in products">
                <td>{{index+1}}</td>
                <td v-html="product.name"></td>
                <td v-model="product.units">{{product.units}}</td>
                <td v-model="product.price">{{product.price}}</td>
                <td v-model="product.description">{{product.description}}</td>
            </tr>
            </tbody>
        </table>
        <modal :product="editingItem" @close="endEditing" v-show="editingItem != null"></modal>
        <modal :product="addingProduct" @close="addProduct" v-show="addingProduct != null"></modal>
        <br>
        <button @click="newProduct" class="btn btn-primary">Add New Product</button>
    </div>
</template>

<script>
    import Modal from './ProductModal'

    export default {
        name: 'products',
        data () {
            return {
                products: [],
                editingItem: null,
                addingProduct: null,
            }
        },
        components: { Modal },
        beforeMount () {
            axios.get('/api/products/').then(response => this.products = response.data)
        },
        methods: {
            newProduct () {
                this.addingProduct = {
                    name: null,
                    units: null,
                    price: null,
                    image: '',
                    description: null,
                }
            },
            endEditing (product) {
                this.editingItem = null

                // let index = this.products.indexOf(product)
                let name = product.name
                let units = product.units
                let price = product.price
                let description = product.description

                this.getToken()

                axios.put(`/api/products/${product.id}`, { name, units, price, description })
                    .then(response => this.products = response.data.products)
            },
            addProduct (product) {
                this.addingProduct = null

                let name = product.name
                let units = product.units
                let price = product.price
                let image = product.image
                let description = product.description

                this.getToken()

                axios.post('/api/products', { name, units, price, description, image })
                    .then(response => this.products = response.data.products)
            },
            getToken () {
                if (localStorage.getItem('lecommerce.jwt') != null) {
                    this.user = JSON.parse(localStorage.getItem('lecommerce.user'))
                    axios.defaults.headers.common['Content-Type'] = 'application/json'
                    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('lecommerce.jwt')
                }
            }
        }
    }
</script>
