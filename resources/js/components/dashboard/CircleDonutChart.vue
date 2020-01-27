<template>
  <div id="chart-container"></div>
</template>

<script>
import Highcharts from 'highcharts'

var options = {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'Browser<br>shares<br>2017',
        align: 'center',
        verticalAlign: 'middle',
        y: 40
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '75%'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Browser share',
        innerSize: '50%',
        data: [
            ['Chrome', 58.9],
            ['Firefox', 13.29],
            ['Internet Explorer', 13],
            ['Edge', 3.78],
            ['Safari', 3.42],
            {
                name: 'Other',
                y: 7.61,
                dataLabels: {
                    enabled: false
                }
            }
        ]
    }]
}

export default {
  name: 'CircleDonutChart',
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

