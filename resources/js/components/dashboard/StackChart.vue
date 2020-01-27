<template>
  <div id="chart-container"></div>
</template>

<script>
import Highcharts from 'highcharts'

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
  name: 'StackChart',
  components: {
    Highcharts
  },
  props: ['data'],
  data () {
    return {
      target: null,
      options: options
    }
  },
  mounted () {
    this.createChart()
    console.log('On mounted chart')
  },
  // beforeDestroy () {
  //   this.target.destroy();
  // },
  methods: {
    createChart (some_data) {
      this.target = Highcharts.chart(this.$el, this.options);
    }
  }
}
</script>

