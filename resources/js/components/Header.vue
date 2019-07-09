<template>
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
</template>

<script>
  export default {
    name: 'header-section',
    props: ['isLoggedIn', 'currentUser'],
    methods: {
      logout() {
        this.$store.dispatch('user/logout')
        this.$router.push('/login')
      }
    }
  }
</script>

<style scoped>
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
</style>
