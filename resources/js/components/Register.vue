<template>
    <div class="container">
        <div class="alert alert-danger" v-if="error && !success">
            <p>There was an error, unable to complete registration.</p>
        </div>

        <div class="alert alert-success" v-if="success">
            <p>Registration completed. You can now <router-link :to="{name:'login'}">sign in.</router-link></p>
        </div>
        <div class="card">
            <div class="card-body">
                <h1>Register</h1>

                <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
                    <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
                        <label for="name">Name</label>
                        <input 
                            type="text" 
                            id="name" 
                            class="form-control" 
                            v-model="name" 
                            placeholder="Enter name"
                            required>
                        <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" class="form-control" 
                            placeholder="Enter email" 
                            v-model="email" required>
                        <span class="help-block" v-if="error && errors.email">{{ errors.email }}</span>
                    </div>
                    <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            class="form-control" 
                            v-model="password"
                            placeholder="Enter password"
                            required>
                        <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Register</button>
                </form>

        </div>
    </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                name: '',
                email: '',
                password: '',
                error: false,
                errors: {},
                success: false
            }
        },
        methods: {
            register() {
                console.log(this.$auth)
                var app = this
                
                this.$auth.register({
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password
                    },
                    success: function() {
                        app.success = true
                    },
                    error: function(res) {
                        app.error = true
                        app.errors = res.reponse.data.errors
                    },
                    redirect: null
                })
            }
        }
    }
</script>
