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
        <label>จากวันที่ :</label>
        <date-picker
          id="searchStartDate"
          name="searchStartDate"
          v-model="searchStartDate"
          :language="dpLang.th"
          :bootstrap-styling="true"
          :format="'dd/MM/yyyy'"
          placeholder="เลือกวันที่"
        />
      </div>

      <div class="form-group col-6">
        <label>ถึงวันที่ :</label>
        <date-picker
          id="searchEndDate"
          name="searchEndDate"
          v-model="searchEndDate"
          :language="dpLang.th"
          :bootstrap-styling="true"
          :format="'dd/MM/yyyy'"
          placeholder="เลือกวันที่"
        />
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
import DatePicker from 'vuejs-datepicker'
import {en, th} from 'vuejs-datepicker/dist/locale'
import { getDate } from '../utils/date-func'

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
      showAll: true,
      dpLang: {
        en: en,
        th: th
      }
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
        startDate: this.searchStartDate ? getDate(this.searchStartDate) : 0,
        endDate: this.searchEndDate ? getDate(this.searchEndDate) : 0,
        showAll: this.showAll ? 1 : 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    },
    toggleShowAll () {
      this.showAll = event.target.checked
      this.getData()
    }
  },
}
</script>