<template>
<div class="col-3">
  <div class="card text-center">
    <h5 class="card-header">{{ title }}</h5>
    <div class="card-body">
      <h5 class="card-title">{{ data | currency }}</h5>
      <a href="#">More info</a>
    </div>
  </div>
</div>
</template>

<script>
export default {
  name: 'Card',
  props: ['title', 'data'],
  mounted() {
    console.log('On mounted card.')
  },
}
</script>

