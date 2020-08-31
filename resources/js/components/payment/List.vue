<template>
<div class="table-responsive" style="margin-top: 10px;">
  <table class="table table-striped table-bordered mb-4">
    <tr>
      <th style="width: 3%; text-align: center;">#</th>
      <th style="width: 6%; text-align: center;">รหัสรายการ</th>
      <th style="width: 8%; text-align: center;">เลขที่ บค.</th>
      <th style="width: 7%; text-align: center;">วันที่ บค.</th>
      <th style="width: 8%; text-align: center;">เลขที่เช็ค</th>
      <th style="width: 7%; text-align: center;">วันที่เช็ค</th>
      <th style="text-align: left;">สั่งจ่าย</th>
      <th style="text-align: left;">ผู้รับเช็ค</th>
      <th style="width: 7%; text-align: center;">ยอดหนี้</th>
      <th style="width: 7%; text-align: center;">ภาษี</th>
      <th style="width: 7%; text-align: center;">สุทธิ</th>
      <th style="width: 6%; text-align: center;">Actions</th>
    </tr>
    <tr v-for="(payment, index) in payments" :key="payment.debt_id">
      <td style="text-align: center;">{{ index+pager.from }}</td>
      <td style="text-align: center;">{{ payment.payment_id }}</td>
      <td style="text-align: center;">{{ payment.paid_doc_no }}</td>
      <td style="text-align: center;">{{ payment.paid_date | thdate }}</td>
      <td style="text-align: center;">{{ payment.cheque_no }}</td>
      <td style="text-align: center;">{{ payment.cheque_date | thdate }}</td>
      <td style="text-align: left;">{{ payment.pay_to }}</td>
      <td style="text-align: left;">{{ payment.cheque_receiver }}</td>
      <td style="text-align: right;">{{ payment.net_val | currency }}</td>
      <td style="text-align: right;">{{ payment.net_amt | currency }}</td>
      <td style="text-align: right;">{{ payment.total | currency }}</td>
      <td style="text-align: center;">
        <a
          @click="edit(payment.debt_id)"
          class="text-warning"
          title="แก้ไขรายการ"
        >
          <i class="fa fa-edit"></i>
        </a>
        <a
          @click="del(payment.debt_id)"
          class="text-danger"
          title="ลบรายการ"
        >
          <i class="fa fa-trash"></i>
        </a>
      </td>
    </tr>
  </table>

  <v-pagination
    v-model="pager.current_page"
    :length="pager.last_page"
    :total-visible="7"
    @input="getPayments"
  />

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

export default {
  name: 'PaymentList',
  props: ['payments'],
  data() {
    return {
      page: 1
    }
  },
  computed: {
    ...mapGetters({
      pager: 'payment/getPager'
    })
  },
  methods: {
    getPayments (page) {
      this.$store.dispatch('payment/getAll', {
        url: this.pager.path,
        page: (typeof page !== 'number') ? 1 : page
      })
    },
    edit (debtid) {

    },
    del (debtid) {

    }
  }
}
</script>

<style scoped>
table {
  font-size: 12px;
}
</style>
