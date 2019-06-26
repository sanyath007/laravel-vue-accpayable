<template>
  <div class="container">
    <h1>Debt page</h1>
  </div>
</template>

<script>
  export default {
    name: 'Debt',
    data () {
      return {
        debts: []
      }
    },
    mounted() {
      this.debts = this.getDebts()
    },
    methods: {
      getDebts() {
        axios.get('/debt/list')
        .then(res => {
          console.log(res)
        })
        .catch(err => {
          console.log(err)
        })
      }
    } 
  }
</script>

