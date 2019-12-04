<template>
    <div>
        <div class="container-fluid hero-section d-flex align-content-center justify-content-center flex-wrap ml-auto">
            <h2 class="title">Admin Dashboard</h2>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <ul style="list-style-type:none">
                        <li class="active">
                            <button @click="setComponent('main')" class="btn">Dashboard</button>
                        </li>
                        <li>
                            <button @click="setComponent('orders')" class="btn">Orders</button>
                            <button @click="setComponent('products')" class="btn">Products</button>
                            <button @click="setComponent('users')" class="btn">Users</button>
                        </li>
                    </ul>
                </div>
                <div class="col-md-9">
                    <component :is="activeComponent"></component>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Main from '../components/admin/Main'
    import Users from '../components/admin/Users'
    import Products from '../components/admin/Products'
    import Orders from '../components/admin/Orders'

    export default {
        data () {
            return {
                user: null,
                activeComponent: null
            }
        },
        components: {
            Main, Users, Products, Orders
        },
        beforeMount () {
            this.setComponent(this.$route.params.page)
            this.user = JSON.parse(localStorage.getItem('lecommerce.user'))
            axios.defaults.headers.common['Content-Type'] = 'application/json'
            axios.defaults.headers.common['Authentication'] = 'Bearer ' + localStorage.getItem('lecommerce.jwt')
        },
        methods: {
            setComponent (value) {
                switch (value) {
                    case 'users':
                        this.activeComponent = Users
                        this.$router.push({ name: 'admin-pages', params: { page: 'users' } })
                        break
                    case 'orders':
                        this.activeComponent = Orders
                        this.$router.push({ name: 'admin-pages', params: { page: 'orders' } })
                        break
                    case 'products':
                        this.activeComponent = Products
                        this.$router.push({ name: 'admin-pages', params: { page: 'products' } })
                        break
                    default:
                        this.activeComponent = Main
                        this.$router.push({ name: 'admin' })
                }
            }
        }

    }
</script>

<style scoped>
    .hero-section {
        height: 20vh;
        background: #ababab;
        align-items: center;
        margin-bottom: 20px;
        margin-top: -20px;
    }

    .title {
        font-size: 60px;
        color: #ffffff;
    }
</style>
