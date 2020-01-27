<template>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="#">Home</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page" v-if="pageTitle">{{ pageTitle }}</li>
  </ol>
</nav>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Breadcrumb',
  props: ['pageTitle'],
  mounted () {
    console.log(this.currentPage)
  },
  computed: {
    ...mapGetters({
      currentPage: 'page/getCurrentPage'
    })
  }
}
</script>
