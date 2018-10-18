<template>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card">

                        <div class="card-body">
                            <form>

                                <ul class="list-group alert alert-danger" v-if="errors.length > 0">
                                    <li class="list-group-item" v-for="error in errors" :key="errors.indexOf(error)">
                                        {{ error }}
                                    </li>
                                </ul>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control required autofocus" v-model="email" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" required v-model="password" >
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="remember" >

                                            <label class="form-check-label" for="remember">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="button" class="btn btn-primary" @click="attemptLogin()" :disabled="!isValidLoginForm">
                                            Login
                                        </button>

                                        <a class="btn btn-link" href="">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        data() {
            return {
                email : '',
                password : '',
                remember : true,
                loading : false,
                errors : []
            }
        },

        methods : {
             emailIsValid() {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email))
                {
                    return (true)
                } else {
                    return (false)
                }
            },

            attemptLogin() {
                 this.errors = [];
                 this.loading = true;

                 axios.post('/login', {
                     email : this.email,
                     password : this.password,
                     remember : this.remember
                 }).then(resp => {
                     location.reload()
                 }).catch(error => {
                     this.loading = false;

                     if (error.response.status == 422) {
                         this.errors.push("We couldn\'t verify your account details.")
                     } else {
                         this.errors.push("Something went wrong, please refresh and try again.")
                     }
                 })
            }

        },

        computed : {
            isValidLoginForm() {
                return this.emailIsValid() && this.password && !this.loading
            }
        }
    }
</script>
