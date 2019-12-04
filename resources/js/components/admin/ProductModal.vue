<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
            <div class="modal-container">
                <div class="modal-header">
                    <slot name="header" v-html="data.name"></slot>
                </div>
                <div class="modal-body">
                    <slot name="body">
                        <div>
                            <label for="name">Name: </label>
                            <input id="name" type="text" v-model="data.name">
                        </div>
                        <div>
                            <label for="units">Units: </label>
                            <input id="units" type="text" v-model="data.units">
                        </div>
                        <div>
                            <label for="price">Price: </label>
                            <input id="price" type="text" v-model="data.price"></div>
                        <div>
                            <textarea placeholder="Description" rows="4" style="width:86%"
                                      v-model="data.description"></textarea>
                        </div>
                        <div>
                            <img :src="data.image" v-show="data.image != null">
                            <input @change="attachFile" id="file" type="file">
                        </div>
                    </slot>
                </div>
                <div class="modal-footer">
                    <slot name="footer">
                        <button @click="uploadFile" class="modal-default-button">Finish</button>
                    </slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],
        data () {
            return {
                attachment: null
            }
        },
        computed: {
            data: function () {
                if (this.product != null) {
                    return this.product
                }

                return {
                    name: '',
                    units: '',
                    price: '',
                    description: '',
                    image: false,
                }
            }
        },
        methods: {
            attachFile (e) {
                this.attachment = e.target.files[0]
            },
            uploadFile (e) {
                if (this.attachment != null) {
                    this.getToken()

                    let formData = new FormData()
                    formData.append('image', this.attachment)
                    let headers = { 'Content-Type': 'multipart/form-data' }
                    axios.post('/api/upload-file', formData, { headers }).then(response => {
                        this.product.image = response.data
                        this.$emit('close', this.product)
                    })
                } else {
                    this.$emit('close', this.product)
                }
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

<style scoped>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 500px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-body input {
        width: 70%;
    }

    .modal-body label {
        width: 15%;
    }

    .modal-default-button {
        float: right;
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>
