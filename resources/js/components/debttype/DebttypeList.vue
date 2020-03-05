<template>
<div class="table-responsive" style="margin-top: 10px;">
  <table class="table table-striped table-bordered">
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
</div>
</template>

<script>
export default {
  name: 'DebttypeList',
  props: ['debttypes', 'pager'],
  methods: {
    edit (debttypeId) {
      this.$store.dispatch('debttype/fetchById', debttypeId)
    },
    del (debttypeId) {
      if (confirm('คุณต้องการลบรายการ ID : ' + debttypeId + ' ใช่หรือไม่ ?')) {
        this.$http.delete('/debttypes/delete/' + debttypeId)
          .then(res => {
            console.log(res)
            this.$bvToast.toast(`ลบข้อมูลเรียบร้อย !!`, {
              title: 'Info',
              variant: 'success',
              autoHideDelay: 2000
            })

            this.$store.dispatch('debttype/fetchBySearch', { searchKey: '0', page: 1 })
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
