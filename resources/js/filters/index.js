import Vue from 'vue';

Vue.filter('currency', function (value) {
  return parseFloat(value).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',')
})

Vue.filter('thdate', function (date) {
  if (!date) return;
  let [year, month, day] = date.split('-')
  return day + '/' + month + '/' + (parseInt(year) + 543)
})
