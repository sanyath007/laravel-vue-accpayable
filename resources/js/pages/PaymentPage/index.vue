<template>
  <div class="container-fluid">
    <breadcrumb :pageTitle="'รายการตัดจ่ายหนี้'" />

    <div class="row mb-2">
      <div class="col-md-6">
        <h3>รายการตัดจ่ายหนี้</h3>
      </div>
      <div class="col-md-6 text-right">
        <router-link :to="{name: 'payment-form'}" class="btn btn-primary">เพิ่มรายการ</router-link>
      </div>
    </div>

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
              @input="getPayments"
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

    <payment-list :payments="payments" :pager="pager" />

    <paginate
      v-show="pager.last_page > 1"
      :page-count="pager.last_page || 1"
      :click-handler="getPayments"
      :prev-text="'Prev'"
      :next-text="'Next'"
      :container-class="'pagination'"
      :page-class="'page-item'"
      :page-link-class="'page-link'"
      :prev-class="'page-item'"
      :prev-link-class="'page-link'"
      :next-class="'page-item'"
      :next-link-class="'page-link'"
      :first-last-button="true"
      :hide-prev-next="true"
    />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import DatePicker from 'vuejs-datepicker'
import {en, th} from 'vuejs-datepicker/dist/locale'

import Breadcrumb from '../../components/Breadcrumb'
import PaymentList from '../../components/payment/List'
import PaymentForm from '../../components/payment/Form'

export default {
  name: 'PaymentPage',
  components: {
    'breadcrumb': Breadcrumb,
    'payment-list': PaymentList,
    'payment-form': PaymentForm,
    'date-picker': DatePicker
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
  mounted () {
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
    this.$store.dispatch('creditor/fetchAll')
    this.getPayments()
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      payment: 'payment/getById',
      payments: 'payment/getAll',
      pager: 'payment/getPager',
      suppliers: 'creditor/getAll'
    })
  },
  methods: {
    toggleShowAll () {
      this.showAll = event.target.checked
      this.getPayments()
    },
    getPayments (page) {
      this.$store.dispatch('payment/getAll', {
        supplierId: (this.supplierSelected) ? this.supplierSelected : 0,
        startDate: (this.searchStartDate) ? this.searchStartDate : 0,
        endDate: (this.searchEndDate) ? this.searchEndDate : 0,
        showAll: (this.showAll) ? 1 : 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    }    
  }
}
</script>

<style scoped>

</style>
