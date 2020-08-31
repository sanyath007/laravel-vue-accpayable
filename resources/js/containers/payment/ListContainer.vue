<template>
  <div>
    <!-- Page Header -->
    <breadcrumb :pageTitle="'รายการตัดจ่ายหนี้'" />
    
    <loading :active.sync="isLoading" 
      :can-cancel="true"
      :is-full-page="true"
    />

    <div style="display: flex; justify-content: space-between; align-items: center; margin: 10px 5px;">
      <h3>รายการตัดจ่ายหนี้</h3>
    
      <!--router-link-->
      <v-btn to="payment/form" class="mx-2" fab dark color="indigo">
        <v-icon dark>mdi-plus</v-icon>
      </v-btn>
    </div>
    <!-- Page Header -->

    <!-- Search Box -->
    <search-box @onSearch="handleSearch" />

    <!--<payment-list :payments="payments" :pager="pager" />-->

    <!--<paginate
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
    />-->
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Breadcrumb from '../../components/Breadcrumb'
import SearchBox from '../../components/SearchBox'
import PaymentList from '../../components/payment/List'
import PaymentForm from '../../components/payment/Form'
// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  name: 'PaymentPage',
  components: {
    'breadcrumb': Breadcrumb,
    'payment-list': PaymentList,
    'payment-form': PaymentForm,
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
      payment: 'payment/getById',
      payments: 'payment/getAll',
      pager: 'payment/getPager',
      suppliers: 'creditor/getAll',
      isLoading: 'approve/isLoading',
    })
  },
  methods: {
    handleSearch(searchKeys) {
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
