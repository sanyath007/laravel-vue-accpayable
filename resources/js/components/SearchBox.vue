<template>
<v-card>
  <div class="card-body">

    <v-row>
      <v-col>
        <label for="">เจ้าหนี้ :</label>
        <v-select
          :options="suppliers"
          :reduce="s => s.supplier_id"
          label="supplier_name"
          v-model="supplierSelected"
          @input="getData"
        />
      </v-col>
    </v-row>

    <v-row class="mx-1">
      <date-picker dataModel="searchStartDate" @inputDate="setDateFromDatePicker" label="จากวันที่" />
    
      <date-picker dataModel="searchEndDate" @inputDate="setDateFromDatePicker" label="ถึงวันที่" />
    </v-row>

    <v-row class="mx-2">
      <b-form-checkbox
        id="showAll"
        name="showAll"
        v-model="showAll"
        @change="toggleShowAll"
      >
        เลือกทั้งหมด
      </b-form-checkbox>
    </v-row>

  </div><!-- /.card-body -->
</v-card>
</template>

<script>
import { mapGetters } from 'vuex'
import DatePicker from './DatePicker'
import { getDate, conv2DbDate } from '../utils/date-func'

export default {
  name: 'SerachBox',
  components: {
    'date-picker': DatePicker,
  },
  data () {
    return {
      supplierSelected: '',
      searchStartDate: 0,
      searchEndDate: 0,
      showAll: true
    }
  },
  created() {
    this.$store.dispatch('creditor/fetchAll')
    this.getData()
  },
  computed: {
    ...mapGetters({
      suppliers: 'creditor/getAll'
    })
  },
  methods: {
    getData (page) {
      this.$emit('onSearch', {
        supplier: this.supplierSelected || 0,
        startDate: this.searchStartDate ? conv2DbDate(this.searchStartDate) : 0,
        endDate: this.searchEndDate ? conv2DbDate(this.searchEndDate) : 0,
        showAll: this.showAll ? 1 : 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    },
    toggleShowAll () {
      this.showAll = event.target.checked
      this.getData()
    },
    setDateFromDatePicker: function (date, field) {
      this.[field] = date
    }
  },
}
</script>

<style scoped>

</style>
