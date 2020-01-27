<template>
  <div class="container-fluid">

    <breadcrumb :pageTitle="'Dashboard'" />
    
    <h4>Dashboard</h4>
    <hr style="margin: 0; margin-bottom: 10px;">

    <div class="row mt-3">
      <div class="col-3">
        <card :title="'เจ้าหนี้'" :data="'933'" />
      </div>

      <div class="col-3">
        <card :title="'ยอดหนี้คงเหลือ'" :data="'925,632,795.93'" />
      </div>

      <div class="col-3">
        <card :title="'ยอดเคดิต'" :data="'55,297,959.03'" />
      </div>

      <div class="col-3">
        <card :title="'ยอดเดบิต'" :data="'8,373,859.21'" />
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-6">
        <stack-chart :data="stackData" />
      </div>

      <div class="col-6">
        <pie-chart :data="pieData" />
      </div>
    </div>

    <div class="row mt-3 mb-3">
      <div class="col-6">
        <column-chart />
      </div>

      <div class="col-3">
        <circle-donut-chart :data="donutData1" />
      </div>

      <div class="col-3">
        <circle-donut-chart :data="donutData2" />
      </div>
    </div>

  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  import Breadcrumb from '../components/Breadcrumb'
  import Card from '../components/dashboard/Card'
  import StackChart from '../components/dashboard/StackChart'
  import PieChart from '../components/dashboard/PieChart'
  import ColumnChart from '../components/dashboard/ColumnChart'
  import CircleDonutChart from '../components/dashboard/CircleDonutChart'

  export default {
    name: 'HomePage',
    components: {
      'breadcrumb': Breadcrumb,
      'card': Card,
      'stack-chart': StackChart,
      'pie-chart': PieChart,
      'column-chart': ColumnChart,
      'circle-donut-chart': CircleDonutChart
    },
    data () {
      return {
        stackData: {},
        pieData: {},
        donutData1: {},
        donutData2: {}
      }
    },
    mounted() {
      this.$store.dispatch('page/setCurrentPage', this.$route.name)
      this.renderStackChart()
      this.renderPieChart()
    },
    methods: {
      renderStackChart () {
        console.log('On render stack chart')
      },
      renderPieChart () {
        console.log('On render pie chart')
      }
    }
  }
</script>
