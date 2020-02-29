<template>
  <div class="container-fluid">

    <breadcrumb :pageTitle="'Dashboard'" />
    
    <h4>Dashboard</h4>
    <hr style="margin: 0; margin-bottom: 10px;">

    <card-container />

    <div class="row mt-3">
      
      <stack-chart-container />

      <pie-chart-container />
      
    </div>

    <div class="row mt-3 mb-3">

      <column-chart-container />

    </div>

    <div class="row mt-3 mb-3">
      
      <donut-chart-container />

      <donut-chart-container />

    </div>

  </div>
</template>

<script>
  import { mapGetters } from 'vuex'

  import Breadcrumb from '../components/Breadcrumb'
  import CardContainer from '../containers/dashboard/CardContainer'
  import StackChartContainer from '../containers/dashboard/StackChartContainer'
  import PieChartContainer from '../containers/dashboard/PieChartContainer'
  import ColumnChartContainer from '../containers/dashboard/ColumnChartContainer'
  import DonutChartContainer from '../containers/dashboard/DonutChartContainer'

  export default {
    name: 'HomePage',
    components: {
      'breadcrumb': Breadcrumb,
      'card-container': CardContainer,
      'stack-chart-container': StackChartContainer,
      'pie-chart-container': PieChartContainer,
      'column-chart-container': ColumnChartContainer,
      'donut-chart-container': DonutChartContainer
    },
    data() {
      return {}
    },
    mounted() {
      this.$store.dispatch('page/setCurrentPage', this.$route.name)
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
