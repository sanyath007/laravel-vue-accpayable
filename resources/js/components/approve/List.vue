<template>
<div class="table-responsive" style="margin-top: 10px;">
  <table class="table table-striped table-bordered mb-4">
    <tr>
      <th style="width: 3%; text-align: center;">#</th>
      <th style="width: 5%; text-align: center;">รหัส</th>
      <th style="width: 8%; text-align: center;">เลขที่ขออนุมัติ</th>
      <th style="width: 8%; text-align: center;">วันที่ขออนุมัติ</th>
      <th style="text-align: left;">สั่งจ่าย</th>
      <th style="width: 5%; text-align: center;">จำนวนบิล</th>
      <th style="width: 7%; text-align: center;">ฐานภาษี</th>
      <th style="width: ุ6%; text-align: center;">VAT</th>
      <th style="width: 7%; text-align: center;">ยอดสุทธิ</th>
      <th style="width: 7%; text-align: center;">ภาษีหัก ณ ที่จ่าย</th>
      <th style="width: 7%; text-align: center;">ยอดเช็ค</th>
      <th style="width: 5%; text-align: center;">สถานะ</th>
      <th style="width: 5%; text-align: center;">Actions</th>
    </tr>
    <tr v-for="(approve, index) in approves" :key="approve.app_id">
      <td style="text-align: center;">{{ index+pager.from }}</td>
      <td style="text-align: center;">{{ approve.app_id }}</td>
      <td style="text-align: center;">{{ approve.app_doc_no }}</td>
      <td style="text-align: center;">{{ approve.app_date | thdate }}</td>
      <td style="text-align: left;">{{ approve.pay_to }}</td>
      <td style="text-align: center;">
        <a href=""><h5><span class="badge badge-primary">
          {{ approveDebts[approve.app_id].length }}
        </span></h5></a>
      </td>
      <td style="text-align: right;">{{ approve.net_val | currency }}</td>
      <td style="text-align: right;">{{ approve.vatamt | currency }}</td>
      <td style="text-align: right;">{{ approve.net_total | currency }}</td>
      <td style="text-align: right;">{{ approve.tax_val | currency }}</td>
      <td style="text-align: right;">{{ approve.cheque | currency }}</td>
      <td style="text-align: center;">
        <span class="text-default" v-show="approve.app_stat == 0">รอดำเนินการ</span>
        <span class="text-info" v-show="approve.app_stat == 1">ขออนุมัติ</span>
        <span class="text-success" v-show="approve.app_stat == 2">ชำระเงินแล้ว</span>
        <span class="text-danger" v-show="approve.app_stat == 3">ยกเลิก</span>
      </td>
      <td style="text-align: center;">
        <a
          @click="edit(approve.app_id)"
          v-show="(approve.app_stat==0)"
          class="text-warning"
          :style="{'cursor': 'pointer'}"
          title="แก้ไขรายการ"
        >
          <i class="fa fa-edit"></i>
        </a>
        <a
          @click="cancel(approve.app_id, approveDebts[approve.app_id])"
          v-show="(approve.app_stat==0)"
          class="text-danger"
          :style="{'cursor': 'pointer'}"
          title="ยกเลิกรายการ"
        >
          <i class="fas fa-calendar-times"></i>
        </a>
      </td>
    </tr>
  </table>
  
  <paginate
    v-show="pager.last_page > 1"
    :page-count="pager.last_page || 1"
    :click-handler="getApproves"
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
  name: 'ApproveList',
  props: ['approves', 'approveDebts'],
  computed: {
    ...mapGetters({
      pager: 'approve/getPager'
    })
  },
  methods: {
    getApproves (page) {
      this.$store.dispatch('approve/fetchAll', {
        url: this.pager.path,
        page: (typeof page !== 'number') ? 1 : page
      })
    },
    edit (approveId) {
      this.$store.dispatch('approve/fetchById', approveId)
    },
    cancel (approveId, approveDebts) {
      const data = { approveId, approveDebts }

      if (confirm('คุณต้องการยกเลิกรายการ ID: ' + approveId + ' ใช่หรือไม่ ?')) {
        this.$http.post('/approves/cancel', data)
          .then(res => {
            console.log(res)
            this.$bvToast.toast(`ยกเลิกข้อมูลเรียบร้อย !!`, {
              title: 'Info',
              variant: 'success',
              autoHideDelay: 2000
            })

            this.$store.dispatch('approve/fetchAll', {
              supplierId: 0,
              startDate: 0,
              endDate: 0,
              showAll: 1,
              page: 1
            })
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
  font-size: 14px;
}
</style>
