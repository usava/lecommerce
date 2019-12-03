<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right" for="name">Name</label>
                                <div class="col-md-6">
                                    <input autofocus class="form-control" id="name" required type="text"
                                           v-model="name"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right" for="email">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="email" required type="email" v-model="email"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right" for="password">Password</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password" required type="email" v-model="password"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label text-md-right" for="password-confirm">Confirm
                                    Password</label>
                                <div class="col-md-6">
                                    <input class="form-control" id="password-confirm" required type="email"
                                           v-model="password_confirmation"/>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button @click="handleSubmit" class="btn btn-primary" type="submit">Register
                                    </button>
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
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            }
        },
        methods: {
            handleSubmit (e) {
                e.preventDefault()
                if (this.password.length !== this.password_confirmation || this.password.length == 0) {
                    this.password = ''
                    this.password_confirmation = ''
                    return alert('Passwords do not match')
                }

                let name = this.name
                let email = this.email
                let password = this.password
                let c_password = this.password_confirmation

                axios.post('api/register', { name, email, password, c_password }).then(response => {
                    let data = response.data

                    localStorage.setItem('lecommerce.user', JSON.stringify(data.user))
                    localStorage.setItem('lecommerce.jwt', data.token)

                    if (localStorage.getItem('lecommerce.jwt') != null) {
                        this.$emit('loggedIn')
                        let nextUrl = this.$route.params.nextUrl
                        this.$router.push((nextUrl != null ? nextUrl : '/'))
                    }
                })
            }
        }
    }
</script>
