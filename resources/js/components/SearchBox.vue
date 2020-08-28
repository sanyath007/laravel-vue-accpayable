<template>
<div class="card">
  <div class="card-body">

    <div class="row">
      <div class="form-group col-12">
        <label for="">เจ้าหนี้ :</label>
        <v-select
          :options="suppliers"
          :reduce="s => s.supplier_id"
          label="supplier_name"
          v-model="supplierSelected"
          @input="getData"
        />
      </div>
    </div>

    <div class="row">
      <div class="form-group col-6">
        <date-picker dataModel="searchStartDate" @inputDate="setDateFromDatePicker" label="จากวันที่" />
      </div>

      <div class="form-group col-6">
        <date-picker dataModel="searchEndDate" @inputDate="setDateFromDatePicker" label="ถึงวันที่" />
      </div>
    </div>

    <b-form-checkbox
      id="showAll"
      name="showAll"
      v-model="showAll"
      @change="toggleShowAll"
    >
      เลือกทั้งหมด
    </b-form-checkbox>

  </div><!-- /.card-body -->
</div><!-- /.card -->
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