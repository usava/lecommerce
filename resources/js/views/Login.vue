<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right" for="email">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="email" required type="email"
                                           v-model="email"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right" for="password">Password</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password" required type="password"
                                           v-model="password"/>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button @click="handleSubmit" class="btn btn-primary" type="submit">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                email: '',
                password: ''
            }
        },
        methods: {
            handleSubmit (e) {
                e.preventDefault()
                if (this.password.length > 0) {
                    let email = this.email
                    let password = this.password

                    axios.post('api/login', { email, password }).then(response => {
                        let user = response.data.user
                        let is_admin = user.is_admin

                        localStorage.setItem('lecommerce.user', JSON.stringify(user))
                        localStorage.setItem('lecommerce.jwt', response.data.token)

                        if (localStorage.getItem('lecommerce.jwt') != null) {
                            this.$emit('loggedIn')
                            if (this.$route.params.nextUrl != null) {
                                this.$router.push(this.$route.params.nextUrl)
                            } else {
                                this.$router.push((is_admin == 1) ? 'admin' : 'dashboard')
                            }
                        }
                    })
                }
            }
        }
    }
</script>
