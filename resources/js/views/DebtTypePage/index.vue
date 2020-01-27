<template>
  <div class="container-fluid">
    <breadcrumb :pageTitle="'ประเภทหนี้'" />

    <div class="row mb-2">
      <div class="col-md-6">
        <h3>ประเภทหนี้</h3>
      </div>
      <div class="col-md-6 text-right">
        <a class="btn btn-primary" data-toggle="modal" data-target="#debttypeFormModal">
          <i class="fa fa-plus"></i>
          เพิ่มรายการ
        </a>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="form-group">
          <label for="">ค้นหาประเภทหนี้</label>
          <input
            id="searchKey"
            name="searchKey"
            v-model="searchKey"
            @keyup="getDebttypes"
            class="form-control"
            placeholder="ประเภทหนี้"
          />
        </div>
      </div>
    </div>

    <debttype-list :debttypes="debttypes" :pager="pager" />

    <paginate
      v-show="pager.last_page > 1"
      :page-count="pager.last_page || 1"
      :click-handler="getDebttypes"
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

    <debttype-form :editDebttype="debttype" />
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

import Breadcrumb from '../../components/Breadcrumb'
import DebttypeList from '../../components/debttype/DebttypeList'
import DebttypeForm from '../../components/debttype/DebttypeForm'

export default {
  name: 'DebttypePage',
  components: {
    'debttype-list': DebttypeList,
    'debttype-form': DebttypeForm,
    'breadcrumb': Breadcrumb
  },
  data () {
    return {
      cates: [],
      searchKey: '',
      page: 1
    }
  },
  mounted () {
    this.getDebttypes()
    this.$store.dispatch('page/setCurrentPage', this.$route.name)
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      debttype: 'debttype/getById',
      debttypes: 'debttype/getAll',
      pager: 'debttype/getPager'
    })
  },
  methods: {
    getDebttypes (page) {
      this.$store.dispatch('debttype/fetchAll', {
        searchKey: this.searchKey || 0,
        page: (typeof page !== 'number') ? 1 : page
      })
    }
  }
}
</script>

<style scoped>

</style>
