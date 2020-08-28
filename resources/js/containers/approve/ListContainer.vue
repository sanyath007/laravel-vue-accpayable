<template>
  <div>
    <!-- Page Header -->
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
        <!--router-link-->
        <v-btn to="approve/form" class="mx-2" fab dark color="indigo">
          <v-icon dark>mdi-plus</v-icon>
        </v-btn>
      </div>
    </div>
    <!-- Page Header -->

    <!-- Search Box -->
    <search-box @onSearch="handleSearch" />

    <!-- Lists -->
    <approve-list :approves="approves" :approveDebts="approveDebts" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import { getDate } from '../../utils/date-func'

import Breadcrumb from '../../components/Breadcrumb'
import SearchBox from '../../components/SearchBox'
import ApproveList from '../../components/approve/List'

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  name: 'ApproveListContainer',
  components: {
    'breadcrumb': Breadcrumb,
    'search-box': SearchBox,
    'approve-list': ApproveList,
    Loading
  },
  mounted () {
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      isLoading: 'approve/isLoading',
      approve: 'approve/getById',
      approves: 'approve/getAll',
      approveDebts: 'approve/getDebts'
    })
  },methods: {
    handleSearch(searchKeys) {
      this.$store.dispatch('approve/fetchAll', {
        url: `/approves/${searchKeys.supplier}/${searchKeys.startDate}/${searchKeys.endDate}/${searchKeys.showAll}`,
        page: searchKeys.page
      })
    }
  },
}
</script>