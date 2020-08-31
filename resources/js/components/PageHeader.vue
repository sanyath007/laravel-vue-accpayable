<template>
  <div class="page__header-container">
    <h3>{{ title }}</h3>
  
    <!--router-link-->
    <v-btn :to="linkTo" class="mx-2" fab dark color="indigo" v-if="linkTo">
      <v-icon dark>mdi-plus</v-icon>
    </v-btn>
  </div>
</template>

<script>
export default {
  name: 'PageHeader',
  props: ['title', 'link-to'],
  data () {
    return {

    }
  },
}
</script>

<style scoped>
  .page__header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 10px 5px;
  }
</style>