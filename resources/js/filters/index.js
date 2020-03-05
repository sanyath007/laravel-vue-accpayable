import Vue from 'vue';

Vue.filter('currency', function (value) {
  return parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
})

Vue.filter('thdate', function (date) {
  if (!date) return;
  let arr = date.split('-')
  return arr[2] + '/' + arr[1] + '/' + (parseInt(arr[0]) + 543)
})
