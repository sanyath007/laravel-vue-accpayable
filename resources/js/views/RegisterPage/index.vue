<template>
  <div class="container">
    <div class="alert alert-danger" v-if="error && !success">
      <p>There was an error, unable to complete registration.</p>
    </div>

    <div class="alert alert-success" v-if="success">
      <p>
        Registration completed. You can now
        <router-link :to="{name:'login'}">sign in.</router-link>
      </p>
    </div>

    <div class="card main-section">
      <div class="card-body">
        <h1>Register</h1>

        <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">
          <div class="form-group" v-bind:class="{ 'has-error': error && errors.name }">
            <input
              type="text"
              id="name"
              class="form-control"
              v-model="name"
              placeholder="Enter name"
              required
            >
            <span class="help-block" v-if="error && errors.name">{{ errors.name }}</span>
          </div>
          <div class="form-group" v-bind:class="{ 'has-error': error && errors.email }">
            <input
              type="email"
              id="email"
              class="form-control"
              placeholder="Enter email"
              v-model="email"
              required
            >
            <span class="help-block" v-if="error && errors.email">{{ errors.email }}</span>
          </div>
          <div class="form-group" v-bind:class="{ 'has-error': error && errors.password }">
            <input
              type="password"
              id="password"
              class="form-control"
              v-model="password"
              placeholder="Enter password"
              required
            >
            <span class="help-block" v-if="error && errors.password">{{ errors.password }}</span>
          </div>
          <button type="submit" class="btn btn-success">Register</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'RegisterPage',
  data () {
    return {
      name: '',
      email: '',
      password: '',
      error: false,
      success: false
    }
  },
  mounted () {
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
  },
  methods: {
    register () {

    }
  }
}
</script>

<style scoped>
.main-section {
  margin: 0 auto;
  margin: 60px 80px;
  padding: 0;
}

.card {
  background-color: #434e5a;
  opacity: 0.8;
  padding: 0 30px;
  border-radius: 10px;
  color: #fff;
}

h1 {
  margin-bottom: 20px;
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
  font-family: "Font Awesome\ 5 Free";
  content: "\f1fa";
  font-size: 22px;
  font-weight: 900;
  left: 62px;
  padding-top: 4px;
  color: #555e60;
}

.form-group:first-of-type::before {
  content: "\f007";
}

.form-group:last-of-type::before {
  content: "\f023";
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
</style>
