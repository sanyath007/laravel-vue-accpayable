<template>
<div class="table-responsive mt-2">
  <table class="table table-striped table-bordered mb-4">
    <tr>
      <th style="width: 3%; text-align: center;">#</th>
      <th style="width: 6%; text-align: center;">รหัสรายการ</th>
      <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
      <th style="width: 8%; text-align: center;">เลขที่ใบส่งของ</th>
      <th style="width: 7%; text-align: center;">วันที่ใบส่งของ</th>
      <!-- <th style="text-align: left;">เจ้าหนี้</th> -->
      <th style="text-align: left;">ประเภทหนี้</th>
      <th style="width: 7%; text-align: center;">ยอดหนี้</th>
      <th style="width: 7%; text-align: center;">ภาษี</th>
      <th style="width: 7%; text-align: center;">สุทธิ</th>
      <th style="width: 6%; text-align: center;">สถานะ</th>
      <th style="width: 8%; text-align: center;" v-show="actions">Actions</th>
    </tr>
    <tr v-for="(debt, index) in lists" :key="debt.debt_id">
      <td style="text-align: center;">{{ index+pager.from }}</td>
      <td style="text-align: center;">{{ debt.debt_id }}</td>
      <td style="text-align: center;">{{ debt.debt_date | thdate }}</td>
      <td style="text-align: center;">{{ debt.deliver_no }}</td>
      <td style="text-align: center;">{{ debt.deliver_date | thdate }}</td>
      <!-- <td style="text-align: left;">{{ debt.supplier_name }}</td> -->
      <td style="text-align: left;">{{ debt.debttype.debt_type_name }}</td>
      <td style="text-align: right;">{{ debt.debt_amount | currency }}</td>
      <td style="text-align: right;">{{ debt.debt_vat | currency }}</td>
      <td style="text-align: right;">{{ debt.debt_total | currency }}</td>
      <td style="text-align: center;">
        <span class="badge badge-primary" v-show="debt.debt_status == 0">รอดำเนินการ</span>
        <span class="badge badge-warning" v-show="debt.debt_status == 1">ขออนุมัติ</span>
        <span class="badge badge-success" v-show="debt.debt_status == 2">ชำระเงินแล้ว</span>
        <span class="badge badge-danger" v-show="debt.debt_status == 3">ยกเลิก</span>
        <span class="badge badge-dark" v-show="debt.debt_status == 4">ลดหนี้ศูนย์</span>
      </td>
      <td style="text-align: center;" v-show="actions">
        <a
          @click="setzero(debt.debt_id, debt.supplier_id)"
          v-show="(debt.debt_status==0)"
          class="text-primary"
          :style="{'cursor': 'pointer'}"
          title="ลดหนี้ศูนย์"
        >
          <i class="fa fa-credit-card"></i>
        </a>
        <a
          @click="edit(debt.debt_id)"
          v-show="(debt.debt_status==0)"
          class="text-warning"
          :style="{'cursor': 'pointer'}"
          title="แก้ไขรายการ"
          data-toggle="modal"
          data-target="#debtFormModal"
        >
          <i class="fa fa-edit"></i>
        </a>
        <a
          @click="del(debt.debt_id)"
          v-show="(debt.debt_status==0)"
          class="text-danger"
          :style="{'cursor': 'pointer'}"
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
    :click-handler="onPaginateClick"
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
  name: 'DebtList',
  props: ['lists', 'actions'],
  computed: {
    ...mapGetters({
      pager: 'debt/getPager'
    })
  },
  methods: {
    onPaginateClick(page) {
      this.$store.dispatch('debt/fetchDebts', {
        url: this.pager.path,
        page: (typeof page !== 'number') ? 1 : page
      })
    },
    setzero(debtId, supplierId) {
      if (confirm('คุณต้องการลดหนี้ศูนย์รายการ ID : ' + debtId + ' ใช่หรือไม่ ?')) {
        this.$store.dispatch('debt/setzero', debtId)

        this.$store.dispatch('debt/fetchAll', {
          url: `/debts/${supplierId}/0/0/1`,
          page: 1
        })
      }
    },
    edit(debtId) {
      this.$store.dispatch('debt/fetchById', debtId)
    },
    del(debtId) {
      if (confirm('คุณต้องการลบรายการ ID : ' + debtId + ' ใช่หรือไม่ ?')) {
        this.$store.dispatch('debt/delete', debtId)
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
