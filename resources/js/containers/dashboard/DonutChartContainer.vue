<template>
<div class="col-6">
  <donut-chart :data="chartData" :options="chartOptions" />
</div>
</template>

<script>
import Chart from '../../components/dashboard/Chart'

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
  components: {
    'donut-chart': Chart,
  },
  data() {
    return {
      chartOptions: options,
      chartData: {}
    }
  },
}
</script>