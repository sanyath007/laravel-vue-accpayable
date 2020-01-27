<template>
<div class="table-responsive" style="margin-top: 10px;">
  <table class="table table-striped table-bordered">
    <tr>
      <th style="width: 3%; text-align: center;">#</th>
      <th style="width: 5%; text-align: center;">รหัส</th>
      <th style="width: 20%; text-align: center;">ชื่อเจ้าหนี้</th>
      <th style="text-align: center;">ที่อยู่</th>
      <th style="width: 12%; text-align: center;">ผู้ติดต่อ</th>
      <th style="width: 12%; text-align: center;">เลขประจำตัวผู้เสียภาษี</th>
      <th style="width: 6%; text-align: center;">Actions</th>
    </tr>
    <tr v-for="(creditor, index) in creditors" :key="creditor.supplier_id">
      <td style="text-align: center;">{{ index+pager.from }}</td>
      <td style="text-align: center;">{{ creditor.supplier_id }}</td>
      <td>{{ creditor.supplier_name }}</td>
      <td>
          {{ ((creditor.supplier_address1) ? creditor.supplier_address1 : '')+ ' '
              +((creditor.supplier_address2) ? creditor.supplier_address2 : '')+ ' '
              +((creditor.supplier_address3) ? creditor.supplier_address3 : '') }}
      </td>
      <td style="text-align: center;">{{ (creditor.supplier_agent_name) ? creditor.supplier_agent_name : '' }}</td>
      <td style="text-align: center;">{{ (creditor.supplier_taxid) ? creditor.supplier_taxid : '' }}</td>
      <td style="text-align: center;">
        <a @click="edit(creditor.supplier_id)"
          class="text-warning"
          :style="{'cursor': 'pointer'}"
          data-toggle="modal"
          data-target="#creditorFormModal"
        >
          <i class="fa fa-edit"></i>
        </a>

        <a @click="del(creditor.supplier_id)" class="text-danger" :style="{'cursor': 'pointer'}">
          <i class="fa fa-trash"></i>
        </a>

      </td>
    </tr>
  </table>
</div>
</template>

<script>
export default {
  name: 'CreditorList',
  props: ['creditors', 'pager'],
  methods: {
    edit (creditorId) {
      this.$store.dispatch('creditor/fetchById', creditorId)
    },
    del (creditorId) {
      if (confirm('คุณต้องการลบรายการ ID : ' + creditorId + ' ใช่หรือไม่ ?')) {
        this.$http.delete('/creditors/delete/' + creditorId)
          .then(res => {
            console.log(res)
            this.$bvToast.toast(`ลบข้อมูลเรียบร้อย !!`, {
              title: 'Info',
              variant: 'success',
              autoHideDelay: 2000
            })

            this.$store.dispatch('creditor/fetchAllWithPagination', { searchKey: '0', page: 1 })
          })
          .catch(err => {
            console.log(err)
            this.$bvToast.toast(`พบข้อผิดพลาด "${err}"`, {
              title: 'Error',
              variant: 'danger',
              autoHideDelay: 2000
            })
          })
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
