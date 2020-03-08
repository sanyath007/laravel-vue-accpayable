<template>
<div class="table-responsive" style="margin-top: 10px;">
  <table class="table table-striped table-bordered mb-3">
    <tr>
      <th style="width: 3%; text-align: center;">#</th>
      <th style="width: 10%; text-align: center;">รหัส</th>
      <th style="text-align: center;">ชื่อ</th>
      <th style="width: 25%; text-align: center;">ประเภท</th>
      <th style="width: 6%; text-align: center;">Actions</th>
    </tr>
    <tr v-for="(debttype, index) in debttypes" :key="debttype.debt_type_id">
      <td style="text-align: center;">{{ index+pager.from }}</td>
      <td style="text-align: center;">{{ debttype.debt_type_id }}</td>
      <td style="text-align: left;">{{ debttype.debt_type_name }}</td>
      <td style="text-align: center;">{{ debttype.debt_cate_name }}</td>
      <td style="text-align: center;">
        <a
          @click="edit(debttype.debt_type_id)"
          class="text-warning"
          title="แก้ไขรายการ"
          data-toggle="modal"
          data-target="#debttypeFormModal"
        >
          <i class="fa fa-edit"></i>
        </a>

        <a
          @click="del(debttype.debt_type_id)"
          class="text-danger"
          title="ลบรายการ"
        >
          <i class="fa fa-trash"></i>
        </a>
      </td>
    </tr>
  </table>

  <paginate
    v-show="pager.last_page > 1"
    :page-count="pager.last_page || 1"
    :click-handler="onPageClick"
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

export default {
  name: 'DebttypeList',
  props: ['debttypes'],
  computed: {
    ...mapGetters({
      pager: 'debttype/getPager'
    })
  },
  methods: {
    onPageClick(page) {
      let pattern = /[^\/]+$/      
      let searchKey = (this.pager.path).match(pattern);

      this.$store.dispatch('debttype/fetchBySearch', { searchKey, page })
    },
    edit(debttypeId) {
      this.$store.dispatch('debttype/fetchById', debttypeId)
    },
    del(debttypeId) {
      if (confirm('คุณต้องการลบรายการ ID : ' + debttypeId + ' ใช่หรือไม่ ?')) {
        this.$store.dispatch('debttype/delete', debttypeId)
      }
    }
  }
}
</script>

<style scoped>
table {
  font-size: 12px;
}
</style>
