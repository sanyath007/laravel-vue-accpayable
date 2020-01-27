<template>
  <div class="container-fluid">
    <breadcrumb :pageTitle="'รายการขออนุมัติหนี้'" />

    <loading :active.sync="isLoading" 
      :can-cancel="true"
      :is-full-page="true"
    />

    <div class="row mb-2">
      <div class="col-md-6">
        <h3>รายการขออนุมัติจ่ายหนี้</h3>
      </div>
      <div class="col-md-6 text-right">
        <router-link :to="{name: 'approve-form'}" class="btn btn-primary">เพิ่มรายการ</router-link>
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
              @input="getApproves"
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

    <approve-list :approves="approves" :approveDebts="approveDebts" />

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import DatePicker from 'vuejs-datepicker'
import {en, th} from 'vuejs-datepicker/dist/locale'
// import moment from 'moment'
import { getDate } from '../../utils/date-func'

import Breadcrumb from '../../components/Breadcrumb'
import ApproveList from '../../components/approve/List'

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  name: 'ApprovePage',
  components: {
    'breadcrumb': Breadcrumb,
    'approve-list': ApproveList,
    'date-picker': DatePicker,
    Loading
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
    this.getApproves()
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      isLoading: 'approve/isLoading',
      approve: 'approve/getById',
      approves: 'approve/getAll',
      approveDebts: 'approve/getDebts',
      suppliers: 'creditor/getAll'
    })
  },
  methods: {
    getApproves (page) {
      this.$store.dispatch('approve/fetchAll', {
        url: `/approves/${this.supplierSelected || 0}/${getDate(this.searchStartDate)}/${getDate(this.searchEndDate)}/${this.showAll ? 1 : 0}`,
        page: (typeof page !== 'number') ? 1 : page
      })
    },
    toggleShowAll () {
      this.showAll = event.target.checked
      this.getApproves()
    }
  }
}
</script>

<style scoped>

</style>
