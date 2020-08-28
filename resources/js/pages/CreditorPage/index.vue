<template>
  <div class="container-fluid">
    <breadcrumb :pageTitle="'เจ้าหนี้'" />

    <loading :active.sync="isLoading" 
      :can-cancel="true"
      :is-full-page="true"
    />
    
    <div class="row mb-2">
      <div class="col-md-6">
        <h3>เจ้าหนี้</h3>
      </div>
      <div class="col-md-6 text-right">
        <v-btn class="mx-2" fab dark color="indigo" data-toggle="modal" data-target="#creditorFormModal">
          <v-icon dark>mdi-plus</v-icon>
        </v-btn>
      </div>
    </div>

    <search-keyword :searchLabel="'ค้นหาเจ้าหนี้'" :inputPlaceholder="'ระบุชื่อเจ้าหนี้'" @handleKeyEvent="getCreditors" />

    <creditor-list :creditors="creditors" @handlePageClick="getCreditors" />

    <creditor-form :editCreditor="creditor" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import Breadcrumb from '../../components/Breadcrumb'
import SearchKeyword from '../../components/SearchKeyword'
import CreditorList from '../../components/creditor/List'
import CreditorForm from '../../components/creditor/Form'

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  name: 'creditor-page',
  components: {
    'breadcrumb': Breadcrumb,
    'search-keyword': SearchKeyword,
    'creditor-list': CreditorList,
    'creditor-form': CreditorForm,
    Loading
  },
  mounted() {
    this.getCreditors({})
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      isLoading: 'creditor/isLoading',
      creditor: 'creditor/getById',
      creditors: 'creditor/getAll',
    })
  },
  methods: {
    getCreditors ({ searchKey, page }) {
      this.$store.dispatch('creditor/fetchAllWithPagination', {
        searchKey: searchKey || 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    }
  }
}
</script>

<style scoped>

</style>
