<template>
  <div></div>
</template>

<script>
import Highcharts from 'highcharts'

export default {
  name: 'Chart',
  components: {
    Highcharts
  },
  props: ['options', 'data'],
  data () {
    return {
      target: null,
    }
  },
  mounted () {
    this.createChart()
    console.log('On mounted column chart')
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

