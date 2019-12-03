<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <router-link :to="{name: 'home'}" class="navbar-brand">L`ecommerce</router-link>
                <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"
                        class="navbar-toggler" data-target="#navbarSuppordtedContent"
                        data-toggle="collapse" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auth"></ul>
                    <ul class="mavbar-nav ml-auto">
                        <router-link :to="{ name: 'login' }" class="nav-link" v-if="!isLoggedIn">Login</router-link>
                        <router-link :to="{ name: 'register' }" class="nav-link" v-if="!isLoggedIn">Register
                        </router-link>
                        <span v-if="isLoggedIn">
                            <router-link :to="{ name: 'userboard' }" class="nav-link"
                                         v-if="user_type == 0">Hi, {{name}}</router-link>
                            <router-link :to="{ name: 'admin' }" class="nav-link"
                                         v-if="user_type == 1">Hi, {{name}}</router-link>
                        </span>
                        <li @click="logout" class="nav-link" v-if="isLoggedIn">Logout</li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <router-view @loggedIn="change"></router-view>
        </main>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                name: null,
                user_type: 0,
                isLoggedIn: localStorage.getItem('lecommerce.jwt') != null
            }
        },
        mounted () {
            this.setDefaults()
        },
        methods: {
            setDefaults () {
                if (this.isLoggedIn) {
                    let user = JSON.parse(localStorage.getItem('lecommece.user'))
                    this.name = user.name
                    this.user_type = user.is_admin
                }
            },
            change () {
                this.isLoggedIn = localStorage.getItem('lecommerce.jwt') != null
                this.setDefaults()
            },
            logout () {
                localStorage.removeItem('lecommerce.jwt')
                localStorage.removeItem('lecommerce.user')
                this.change()
                this.$router.push('/')
            }
        }
    }
</script>
