<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <td></td>
                <td>Product</td>
                <td>Quantity</td>
                <td>Cost</td>
                <td>Delivery Address</td>
                <td>Status</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
            <tr @key="index" v-for="(order, index) in orders">
                <td>{{index+1}}</td>
                <td v-html="order.product.name"></td>
                <td>{{order.quantity}}</td>
                <td>{{order.quantity * order.product.price}}</td>
                <td>{{order.address}}</td>
                <td>{{order.status}}</td>
                <td v-if="order.status != 3">
                    <button @click="deliver(index)" class="btn btn-success">Deliver</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'Orders',
        data () {
            return {
                orders: []
            }
        },
        beforeMount () {
            if (localStorage.getItem('lecommerce.jwt') != null) {
                this.user = JSON.parse(localStorage.getItem('lecommerce.user'))
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('lecommerce.jwt')
            }

            axios.get('/api/orders/').then(response => this.orders = response.data)
        },
        methods: {
            deliver (index) {
                let order = this.orders[index]
                axios.patch(`/api/orders/${order.id}/deliver`).then(response => {
                    this.orders[index].status = 3
                    this.$forceUpdate()
                })
            }
        }
    }
</script>
