<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <router-link :to="{name: 'home'}" class="navbar-brand">
      <img src="http://accpayable.com/img/bootstrap-solid.svg" width="30" height="30" alt="">
      AccPayable System
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
        <li class="nav-item dropdown" v-show="isLoggedIn && currentUser.is_admin === 1">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            ข้อมูลพื้นฐาน
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <router-link :to="{name: 'creditor'}" class="dropdown-item">เจ้าหนี้</router-link>
            <router-link :to="{name: 'debttype'}" class="dropdown-item">ประเภทหนี้</router-link>
            <router-link :to="{name: 'debttype'}" class="dropdown-item">บัญชีธนาคาร</router-link>
          </div>
        </li>

        <li class="nav-item dropdown" v-show="isLoggedIn">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            บันทึกรายการ
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <router-link to="debt" class="dropdown-item">รับหนี้</router-link>
            <router-link to="approve" class="dropdown-item">ขออนุมัติจ่าย</router-link>
            <router-link to="payment" class="dropdown-item">ตัดจ่าย</router-link>
            <!-- <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">ขออนุมัติซื้อ</a>
            <a class="dropdown-item" href="#">สั่งซื้อ (PO)</a> -->
          </div>
        </li>

        <li class="nav-item dropdown" v-show="isLoggedIn">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            บัญชี
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">แยกประเภทเจ้าหนี้</a>
            <a class="dropdown-item" href="#">แยกประเภทหนี้</a>
            <a class="dropdown-item" href="#">ยอดหนี้ค้างจ่าย</a>
            <a class="dropdown-item" href="#">เจ้าหนี้จ่ายชำระหนี้</a>
          </div>
        </li>

        <li class="nav-item dropdown" v-show="isLoggedIn">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            รายงาน
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#">ยอดหนี้รายเจ้าหนี้</a>
            <a class="dropdown-item" href="#">ยอดหนี้รายประเภทหนี้</a>
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
            <i class="fas fa-user-circle"></i>
            {{ currentUser.name }}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="#" @click="logout">Logout</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'header-section',
  props: ['isLoggedIn', 'currentUser'],
  methods: {
    logout () {
      this.$store.dispatch('user/logout')
    }
  }
}
</script>

<style scoped>

</style>
