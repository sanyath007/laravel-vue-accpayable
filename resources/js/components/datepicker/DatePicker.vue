<template>
  <div id="date-picker">
    <input type="text">
    <div v-show="open">

    </div>
  </div>
</template>

<script>
export default {
  name: 'DatePicker',
  data() {
    return {
      open: false,
    }
  }
}
</script>

<style scoped>
  #date-picker {
    display: inline-block;
  }
</style>