<template>
<div class="col-6">
  <stack-chart :data="chartData" :options="chartOptions" />
</div>
</template>

<script>
import Chart from '../../components/dashboard/Chart'


var options = {
  chart: {
    type: 'bar'
  },
  title: {
    text: 'Stacked bar chart'
  },
  xAxis: {
    categories: ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
  },
  yAxis: {
    min: 0,
    title: {
      text: 'Total fruit consumption'
    }
  },
  legend: {
    reversed: true
  },
  plotOptions: {
    series: {
      stacking: 'normal'
    }
  },
  series: [{
    name: 'John',
    data: [5, 3, 4, 7, 2]
  }, {
    name: 'Jane',
    data: [2, 2, 3, 2, 1]
  }, {
    name: 'Joe',
    data: [3, 4, 4, 2, 5]
  }]
}

export default {
  components: {
    'stack-chart': Chart
  },
  data() {
    return {
      chartOptions: options,
      chartData: {}
    }
  },
}
</script>