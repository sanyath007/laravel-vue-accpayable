<template>
  <div class="container-fluid">
    <breadcrumb :pageTitle="'ประเภทหนี้'" />

    <loading :active.sync="isLoading" 
      :can-cancel="true"
      :is-full-page="true"
    />

    <div class="row mb-2">
      <div class="col-md-6">
        <h3>ประเภทหนี้</h3>
      </div>
      <div class="col-md-6 text-right">
        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#debttypeFormModal">
          <i class="fa fa-plus"></i>
          เพิ่มรายการ
        </a>
      </div>
    </div>
    
    <search-keyword :searchLabel="'ค้นหาประเภทหนี้'" :inputPlaceholder="'ระบุประเภทหนี้'" @handleKeyEvent="getDebttypes" />

    <debttype-list :debttypes="debttypes" />

    <debttype-form :editDebttype="debttype" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import Breadcrumb from '../../components/Breadcrumb'
import SearchKeyword from '../../components/SearchKeyword'
import DebttypeList from '../../components/debttype/List'
import DebttypeForm from '../../components/debttype/Form'

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  name: 'DebttypePage',
  components: {
    'breadcrumb': Breadcrumb,
    'search-keyword': SearchKeyword,
    'debttype-list': DebttypeList,
    'debttype-form': DebttypeForm,
    Loading
  },
  mounted () {
    this.$store.dispatch('page/setCurrentPage', this.$route.name)

    this.getDebttypes({})
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      isLoading: 'debttype/isLoading',
      debttype: 'debttype/getById',
      debttypes: 'debttype/getAll'
    })
  },
  methods: {
    getDebttypes ({ searchKey, page }) {
      this.$store.dispatch('debttype/fetchBySearch', {
        searchKey: searchKey || 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    }
  }
}
</script>

<style scoped>

</style>
