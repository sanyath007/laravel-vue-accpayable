<template>
    <div class="modal-dialog text-center">
        <div class="col-sm-9 main-section">
            <div class="modal-content">
                <div class="alert alert-danger" v-if="error">
                    <p>There was an error, unable to sign in with those credentials.</p>
                </div>

                <div class="col-12 user-img">
                    <img src="http://localhost:8000/img/face.png" alt="">
                </div>

                <form autocomplete="off" @submit.prevent="login" method="post">
                    <div class="col-12 form-input">
                        <div class="form-group">
                            <input 
                                type="email" 
                                id="email" 
                                class="form-control" 
                                placeholder="user@example.com" 
                                v-model="email" required>
                        </div>

                        <div class="form-group">
                            <input 
                                type="password" 
                                id="password" 
                                class="form-control"
                                placeholder="Enter password"
                                v-model="password" required>
                        </div>

                        <button type="submit" class="btn btn-success">Login</button>
                    </div>

                    <div class="col-12 forgot">
                        <a href="">Forget Password?</a>
                    </div>
                </form>                

                <!-- <div class="col-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">Social login</div>
                        <div class="panel-body">                
                            <button class="btn btn-primary" @click="socialAuthProvider('facebook')">Login with Facebook</button>
                            <button class="btn btn-danger" @click="socialAuthProvider('google')">Login with Google</button>
                            <button class="btn btn-info" @click="socialAuthProvider('twitter')">Login with Twitter</button>
                            <button class="btn btn-warning" @click="socialAuthProvider('github')">Login with Github</button>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                email: 'sanyath007@gmail.com',
                password: '123456',
                error: false
            }
        },
        mounted() {
            console.log(this.$auth)
        },
        methods: {
            login() {
                var app = this

                this.$store.dispatch('user/login', {
                    email: app.email,
                    password: app.password
                })

                this.$router.push('/dashboard')
            },
            socialAuthProvider(provider) {
                console.log(this.$auth)
                var app = this
                this.$auth.authenticate(provider).then(res => {
                    console.log(res)
                    this.socialLogin(provider, res)
                }).catch(error => {
                    console.log(error)
                })
            }, 
            socialLogin(provider, res) {
                this.$http.post('/oauth/' + provider, res).then(res => {
                    console.log(res.data)
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    }
</script>

<style scoped>
    .main-section {
        margin: 0 auto;
        margin-top: 30px;
        padding: 0;
    }

    .modal-content {
        background-color: #434e5a;
        opacity: 0.8;
        padding: 0 18px;
        border-radius: 10px;
    }

    .user-img {
        margin-top: -60px;
        margin-bottom: 45px;
    }

    .user-img img {
        width: 120px;
        height: 120px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group input {
        height: 42px;
        border-radius: 5px;
        border: 0;
        font-size: 18px;
        letter-spacing: 2px;
        padding-left: 42px;
    }

    .form-group::before {
        position: absolute;
        font-family: 'Font Awesome\ 5 Free';
        content: "\f1fa";
        font-size: 22px;
        font-weight: 900;
        left: 28px;
        padding-top: 4px;
        color: #555e60;
    }

    .form-group:last-of-type::before {
        content: '\f023';
    }

    .form-input button {
        width: 40%;
        margin: 5px 0 25px;
    }

    .btn-success {
        background-color: #1c6288;
        font-size: 19px;
        border-radius: 5px;
        border: 1px solid #daf1ff;
        padding: 7px 14px;
    }

    .btn-success:hover {
        background-color: #13445e;
        border: 1px solid #daf1ff;
    }

    .forgot {
        padding: 5px 0 25px;
    }

    .forgot a {
        color: #daf1ff;
    }
</style>
