<template>
    <div>
        <table class="table table-responsive table-striped">
            <thead>
            <tr>
                <td></td>
                <td>Name</td>
                <td>Email</td>
                <td>Joined</td>
                <td>Total orders</td>
            </tr>
            </thead>
            <tbody>
            <tr @key="index" v-for="(user, index) in users">
                <td>{{index+1}}</td>
                <td v-html="user.name"></td>
                <td>{{user.email}}</td>
                <td>{{user.created_at}}</td>
                <td>{{user.orders.length}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'Users',
        data () {
            return {
                users: []
            }
        },
        beforeMount () {
            if (localStorage.getItem('lecommerce.jwt') != null) {
                this.user = JSON.parse(localStorage.getItem('lecommerce.user'))
                axios.defaults.headers.common['Content-Type'] = 'application/json'
                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('lecommerce.jwt')
            }

            axios.get('/api/users/').then(response => this.users = response.data)
        }
    }
</script>
