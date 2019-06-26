<template>
  <div :style="containerBackgroundStyle">
    <header>
      <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <router-link :to="{name: 'home'}" class="navbar-brand">
            <img src="http://localhost:8000/img/bootstrap-solid.svg" width="30" height="30" alt="">
            Laravel&Vue App
          </router-link>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active" v-show="isLoggedIn">
                <router-link :to="{name: 'home'}" class="nav-link">หน้าหลัก</router-link>
              </li>
              <li class="nav-item dropdown" v-show="isLoggedIn">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  บันทึกรายการ
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <router-link :to="{name: 'debt'}" class="dropdown-item">รับหนี้</router-link>
                  <a class="dropdown-item" href="#">ขออนุมัติจ่าย</a>
                  <a class="dropdown-item" href="#">ตัดจ่าย</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">ขออนุมัติซื้อ</a>
                  <a class="dropdown-item" href="#">สั่งซื้อ (PO)</a>
                </div>
              </li>
              <li class="nav-item dropdown" v-show="isLoggedIn">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  ข้อมูลพื้นฐาน
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">เจ้าหนี้</a>
                  <a class="dropdown-item" href="#">ประเภทหนี้</a>
                </div>
              </li>
              <li class="nav-item dropdown" v-show="isLoggedIn">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  รายงาน
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
              <!-- <form class="form-inline">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
              </form> -->
              <li class="nav-item" v-show="!isLoggedIn">
                <router-link :to="{name: 'login'}" class="nav-link">Login</router-link>
              </li>
              <li class="nav-item" v-show="!isLoggedIn">
                <router-link :to="{name: 'register'}" class="nav-link">Register</router-link>
              </li>
              <li class="nav-item dropdown" v-show="isLoggedIn" v-if="currentUser">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  {{ currentUser.name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#" @click="logout">Logout</a>
                </div>
              </li>                 
            </ul>
          </div>
        </nav>
      </div>
    </header>

    <main>
      <section class="section-1">
        <router-view></router-view>
      </section>
    </main>

    <footer>
      <div class="container-fluid p-0">
        <div class="row text-left">
          <div class="col-md-5">
            <h1 class="text-light">About Us</h1>
            <p class="text-muted">
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita ad illo et optio quam vero alias eaque.
              Dolor.
            </p>
            <p class="pt-4 text-muted">
              Copyright &copy;2019 All rigth reserved | This template is made with by
              <span>Daily Tuition</span>
            </p>
          </div>
          <div class="col-md-5">
            <h4 class="text-light">News Letter</h4>
            <p class="text-muted">
              Stay Updated
            </p>
            <form class="form-inline">
              <div class="col pl-0">
                <div class="input-group pr-5">
                  <input type="text" class="form-control bg-dark text-white" id="inlineFormInputGroupUsername2"
                    placeholder="Email">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <i class="fas fa-arrow-right"></i>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-2">
            <h4 class="text-light">Follow Us</h4>
            <p class="text-muted">Let us be social</p>
            <div class="column">
              <i class="fab fa-facebook-f"></i>
              <i class="fab fa-instagram"></i>
              <i class="fab fa-twitter"></i>
              <i class="fab fa-youtube"></i>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  export default {
    name: 'App',
    data() {
      return {
        containerBackgroundStyle: {
          background: "url('http://localhost:8000/img/mountain.png') no-repeat center center fixed",
          backgroundSize: 'cover'
        },
      }
    },
    mounted() {
      console.log('Component mounted.')
    },
    computed: {
      ...mapGetters({ 
        isLoggedIn: 'user/isLoggedIn',
        currentUser: 'user/currentUser'
      }),
    },
    methods: {
      logout() {
        this.$store.dispatch('user/logout')
        this.$router.push('/login')
      }
    }
  }
</script>

<style scoped>
  * {
    box-sizing: border-box;
  }

  /* header,
  section {
    overflow-x: hidden;
  } */

  :root {
    --Snigle-font: "Snigle", cursive;
    --Rubik: "Rubik", cursive;
    --Patua: "Patua One", cursive;
    --Lobster: "Lobster", cursive;
    --light-black: #2e2c2caf;
    --bggradient: linear-gradient(to bottom,
        #dd2476, #ff512f);
    --light-gray: rgba(255, 255, 255, 0.2)
  }

  /********** header **********/
  /* header {
    background: #dd2476;
    background: var(--bggradient);
  } */

  /* header a {
    font-family: var(--Snigle-font);
    font-size: 0.9em;
    color: whitesmoke;
  } */

  /* header .navbar-brand {
    padding-left: 8em;
  }

  header .nav-item:last-child {
    padding-right: 10.5em;
  }

  header .nav-item {
    padding: 0.9em;
  }

  header .nav-link:hover {
    color: black;
  }

  header .row .col-md-5 {
    padding: 4.2vmin 1vmin;
  }

  header .row .col-md-7 {
    padding: 22vmin 1vmin;
    padding-bottom: 35vmin;
    font-family: var(--Rubik);
  }

  header .row .col-md-5 img {
    width: 90%;
  }

  header .container .col-md-7 h6 {
    padding: 1vmin;
    letter-spacing: 4px;
  }

  header .container .col-md-7 h1 {
    font-size: 8vmin;
    font-weight: bold;
    padding: 0.1em 0em;
  }

  header .container .col-md-7 p {
    padding: 1vmin 5vmin;
  }

  header .container .col-md-7 button {
    border-radius: 30px;
    font-weight: bold;
  } */

  /********** section-1 **********/
  .section-1 {
    padding: 20vmin 0vmin;
  }

  .section-1 .row .col-md-6 .pray img {
    opacity: 0.8;
    width: 80%;
    border-radius: 0.2em;
  }

  .section-1 .row .col-md-6:last-child {
    position: relative;
  }

  .section-1 .row .col-md-6 .panel {
    position: absolute;
    top: 7vmin;
    left: -18vmin;
    background: white;
    border-radius: 3px;
    text-align: left;
    padding: 13vmin 5vmin 20vmin 10vmin;
    box-shadow: 0px 25px 42px rgba(0, 0, 0, 0.2);
    font-family: var(--Rubik);
    z-index: 1;
  }

  .section-1 .row .col-md-6 .panel h1 {
    font-weight: bold;
    padding: 0.4em 0;
    font-size: 2em;
  }

  .section-1 .row .col-md-6 .panel p {
    font-size: 0.9em;
    color: rgba(0, 0, 0, 0.5);
  }

  /********** section-2 **********/
  /* .cover {
    width: 100%;
    height: 55vmin;
    background: url('../assets/pexels-photo-452738.jpeg');
    background-position: -24rem -19rem;
    background-size: 150%;
    position: relative;
  } */

  .cover .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
  }

  .cover .content {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    padding-top: 19vmin;
  }

  .cover .content>h1 {
    font-weight: var(--Patua);
    font-size: 6vmin;
    color: whitesmoke;
  }

  .cover .content>p {
    font-weight: var(--Rubik);
    font-size: 2vmin;
    color: #e5e5e5;
  }

  .numbers {
    margin-top: -15vmin;
  }

  .numbers .rect {
    position: relative;
    z-index: 1;
    background: white;
    width: 17rem;
    height: 12rem;
    padding-top: 3.5vmin;
    margin: 1rem;
    border-radius: 0.5em;
    box-shadow: 1px 2px 50px 0px rgba(255, 0, 0, 0.349)
  }

  .numbers .rect h1 {
    font-size: 5rem;
    color: tomato;
  }

  .numbers .rect>p {
    font-family: var(--Patua);
  }

  .purchase>h1 {
    padding-top: 15vmin;
    padding-bottom: 0.1em;
    font-family: var(--Lobster);
  }

  .purchase>p {
    color: var(--light-black);
    font-size: 3vmin;
    padding-bottom: 10vmin;
  }

  .purchase .cards .card {
    width: 22rem;
    margin: 3vmin 3vmin;
  }

  .cards div {
    padding: 0;
    margin: 0;
  }

  .cards .title {
    background: rgba(208, 241, 241, 0.199);
    padding: 1.4em 2.5em;
    font-size: 2vmin;
  }

  .card .card-text {
    padding: 2.5rem 3rem;
    color: var(--light-black);
  }

  .card-body .pricing {
    background: rgba(208, 241, 241, 0.199);
    border-top-right-radius: 170px;
    border-top-left-radius: 170px;
  }

  .card-body .pricing>h1 {
    font-size: 8vmin;
    padding: 1em 0.5em;
  }

  .card-body .pricing a {
    border-radius: 30px;
    font-weight: bold;
  }

  /********** section-3 **********/
  .section-3 {
    height: 70vmin;
    margin-top: 15vmin;
    background: var(--bggradient);
  }

  .section-3 .col-md-12>h1 {
    padding: 2em 0 0.5em 0;
    color: whitesmoke;
    font-size: 6vmin;
  }

  .section-3 .col-md-12>p {
    padding: 0 4em;
    padding-bottom: 2em;
    color: var(--light-gray);
    font-size: 3vmin;
  }

  .section-3 .desktop {
    background: white;
    display: inline-block;
    border-radius: 3em;
    padding: 2vmin 4.5vmin;
    margin: 1em;
  }

  .section-3 .desktop h3 {
    font-size: 4vmin;
  }

  .section-3 .desktop p {
    font-size: 2vmin;
  }

  /********** section-4 **********/
  .section-4 .container h1 {
    font-size: 6vmin;
    padding-top: 14vmin;
  }

  .section-4 .team {
    padding: 10vmin 4vmin;
  }

  .section-4 .card {
    width: 22em;
    margin-top: 10vmin;
  }

  .section-4 .card .card-text {
    padding: 0.5em;
  }

  .section-4 .card-body>a {
    font-size: 1.5em;
  }

  .section-4 .carousel-item {
    padding-left: 3rem;
  }

  .border-radius {
    border-radius: 340px;
    width: 60%;
  }
  /********** footer **********/
  footer {
    background: rgba(0, 0, 0, 0.815);
    overflow-x: hidden;
    padding: 14vmin 18vmin;
  }

  footer p>span {
    color: #ff512f;
  }

  footer input {
    border: none !important;
  }

  footer input::placeholder {
    color: white !important;
  }

  footer .input-group .input-group-text {
    background: linear-gradient(to bottom, #dd2476, #ff512f);
    border: none;
  }

  footer .column i {
    color: #dd2476;
  }

  /* It is Adjacent sibling combinator */

  footer .column i+i {
    padding: 0 0.5em;
  }

  .sticky {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(0, 0, 0, 0.815);
    z-index: 9999;
    transition: all 1.5s ease;
  }
</style>
