<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <img :alt="product.name" :src="product.image">
                <h2 class="title" v-html="product.name"></h2>
                <p class="small-text text-muted fload-left">$ {{ product.price }}</p>
                <p class="small-text fload-right">Available Units: {{ product.units }}</p>

                <hr>
                <label class="row">
                    <span class="col-md-2 float-left">Quantity: </span>
                    <input :max="product.units" @change="checkoutUnits" class="col-md-2 float-left" min="1"
                           name="units" type="number" v-model="quantity"
                    />
                </label>
            </div>

            <div>
                <div v-if="!isLoggedIn">
                    <h2>You need to login to continue</h2>
                    <button @click="login" class="col-md-4 btn btn-primary float-left">Login</button>
                    <button @click="register" class="col-md-4 btn btn-primary float-right">Register</button>
                </div>
                <div v-if="isLoggedIn">
                    <div class="row">
                        <label class="col-md-3 col-form-label" for="address">Delivery Address</label>
                        <div class="col-md-9">
                            <input class="form-control" id="address" required type="text" v-model="address">
                        </div>
                    </div>

                    <button @click="placeOrder" class="col-md-4 btn btn-sm-vtn-success float-right" v-if="isLoggedIn">
                        Continue
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['pid'],
        data () {
            return {
                address: '',
                quantity: 1,
                isLoggedIn: null,
                product: []
            }
        },
        mounted () {
            this.isLoggedIn = localStorage.getItem('lecommerce.jwt') != null
        },
        beforeMount () {
            let url = `/api/products/${this.pid}`
            axios.get(url).then(response => this.product = response.data)

            if (localStorage.getItem('lecommerce.jwt') != null) {
                this.user = JSON.parse(localStorage.getItem('lecommerce.user'))
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('lecommerce.jwt')
            }
        },
        methods: {
            login () {
                this.$router.push({ name: 'login', params: { nextUrl: this.$route.fullPath } })
            },
            register () {
                this.$router.push({ name: 'register', params: { nextUrl: this.$route.fullPath } })
            },
            placeOrder (e) {
                e.preventDefault()

                let address = this.address
                let product_id = this.product.id
                let quantity = this.quantity

                axios.post('api/orders/', { address, quantity, product_id })
                    .then(response => this.$router.push('/confirmation'))
            },
            checkoutUnits () {
                if (this.quantity > this.product.units) {
                    this.quantity = this.product.units
                }
            }
        }
    }
</script>

<style scoped>
    .small-text {
        font-size: 18px;
    }

    .order-box {
        border: 1px solid #cccccc;
        padding: 10px 15px;
    }

    .title {
        font-size: 36px;
    }
</style>
