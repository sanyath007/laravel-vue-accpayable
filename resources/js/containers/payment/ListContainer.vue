<template>
  <div>
    <!-- Page Header -->
    <breadcrumb :pageTitle="'รายการตัดจ่ายหนี้'" />
    
    <loading :active.sync="isLoading" 
      :can-cancel="true"
      :is-full-page="true"
    />

    <page-header title="รายการตัดจ่ายหนี้" link-to="payment/form" />
    <!-- Page Header -->

    <!-- Search Box -->
    <search-box @onSearch="handleSearch" />

    <payment-list :payments="payments" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Breadcrumb from '../../components/Breadcrumb'
import SearchBox from '../../components/SearchBox'
import PaymentList from '../../components/payment/List'
import PageHeader from '../../components/PageHeader'
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  name: 'PaymentPage',
  components: {
    'breadcrumb': Breadcrumb,
    'page-header': PageHeader,
    'payment-list': PaymentList,
    'search-box': SearchBox,
    Loading
  },
  data () {
    return {

    }
  },
  mounted () {
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
    this.$store.dispatch('creditor/fetchAll')
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      isLoading: 'payment/isLoading',
      payment: 'payment/getById',
      payments: 'payment/getAll',
      pager: 'payment/getPager',
      suppliers: 'creditor/getAll',
    })
  },
  methods: {
    handleSearch(searchKeys) {
      console.log(searchKeys)
      this.$store.dispatch('payment/getAll', {
        url: `/payments/${searchKeys.supplier}/${searchKeys.startDate}/${searchKeys.endDate}/${searchKeys.showAll}`,
        page: searchKeys.page
      })
    }
  }
}
</script>

<style scoped>

</style>
