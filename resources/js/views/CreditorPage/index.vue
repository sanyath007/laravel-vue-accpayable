<template>
  <div class="container-fluid">
    <breadcrumb :pageTitle="'เจ้าหนี้'" />

    <div class="row mb-2">
      <div class="col-md-6">
        <h3>เจ้าหนี้</h3>
      </div>
      <div class="col-md-6 text-right">
        <a class="btn btn-primary" data-toggle="modal" data-target="#creditorFormModal">
          <i class="fa fa-plus"></i>
          เพิ่มรายการ
        </a>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="fo">
          <label for="">ค้นหาเจ้าหนี้ :</label>
          <input
            id="searchKey"
            name="searchKey"
            v-model="searchKey"
            @keyup="getCreditors"
            class="form-control"
            placeholder="ระบุชื่อเจ้าหนี้"
          />
        </div>
      </div>
    </div>

    <creditor-list :creditors="creditors" :pager="pager" />

    <paginate
      v-show="pager.last_page > 1"
      v-model="page"
      :page-count="pager.last_page || 1"
      :click-handler="getCreditors"
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

    <creditor-form :editCreditor="creditor" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import Breadcrumb from '../../components/Breadcrumb'
import CreditorList from '../../components/creditor/CreditorList'
import CreditorForm from '../../components/creditor/CreditorForm'

export default {
  name: 'creditor-page',
  components: {
    'creditor-list': CreditorList,
    'creditor-form': CreditorForm,
    'breadcrumb': Breadcrumb
  },
  data() {
    return {
      prefixes: [],
      searchKey: '',
      page: 1
    }
  },
  mounted() {
    this.getCreditors()
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      creditor: 'creditor/getById',
      creditors: 'creditor/getAll',
      pager: 'creditor/getPager'
    })
  },
  methods: {
    getCreditors (page) {
      this.$store.dispatch('creditor/fetchAllWithPagination', {
        searchKey: this.searchKey || 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    }
  }
}
</script>

<style scoped>

</style>
