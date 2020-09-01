<template>
<div
  class="modal fade"
  id="approveSelectionModal"
  ref="approveSelectionModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="myModalLabel"
>
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">รายการขออนุมัติ</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- /.modal-header -->

      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th style="width: 5%; text-align: center;">เลือก</th>
                <th style="width: 5%; text-align: center;">รหัส</th>
                <th style="width: 8%; text-align: center;">เลขที่ขออนุมัติ</th>
                <th style="width: 8%; text-align: center;">วันที่ขออนุมัติ</th>
                <th style="text-align: left;">สั่งจ่าย</th>
                <th style="width: 5%; text-align: center;">จำนวนบิล</th>
                <th style="width: 7%; text-align: center;">ฐานภาษี</th>
                <th style="width: 5%; text-align: center;">VAT</th>
                <th style="width: 7%; text-align: center;">ยอดสุทธิ</th>
                <th style="width: 7%; text-align: center;">ภาษีหัก ณ ที่จ่าย</th>
                <th style="width: 7%; text-align: center;">ยอดเช็ค</th>
              </tr>
            </thead>
            <tbody v-if="approves">
              <tr v-for="approve in approves" :key="approve.app_id">
                <td class="text-center">
                  <input type="checkbox" @click="addToPaymentApproves(approve)" />
                </td>
                <td style="text-align: center;">{{ approve.app_id }}</td>
                <td style="text-align: center;">{{ approve.app_doc_no }}</td>
                <td style="text-align: center;">{{ approve.app_date | thdate }}</td>
                <td style="text-align: left;">{{ approve.pay_to }}</td>
                <td style="text-align: center;">
                  <a href=""><h5><span class="badge badge-primary">
                    {{ approve.app_detail.length }}
                  </span></h5></a>
                </td>
                <td style="text-align: right;">{{ approve.net_val | currency }}</td>
                <td style="text-align: right;">{{ approve.vatamt | currency }}</td>
                <td style="text-align: right;">{{ approve.net_total | currency }}</td>
                <td style="text-align: right;">{{ approve.tax_val | currency }}</td>
                <td style="text-align: right;">{{ approve.cheque | currency }}</td>
              </tr>
            </tbody>
          </table>
        </div><!-- /.table-responsive -->

        <v-pagination
          v-model="page"
          :length="pager.last_page"
          :total-visible="7"
          @input="fetchApproves"
        />
      </div><!-- /. modal-body -->

      <div class="modal-footer">
        <v-btn type="submit" color="primary" @click="onSelected">ตกลง</v-btn>
      </div><!-- /. modal-footer -->

    </div>
  </div>
</div>
</template>

<script>
export default {
  name: 'ApproveSelectionModal',
  props: ['supplier', 'paymentApproves'],
  data () {
    return {
      selectedDebts: [],
      approves: [],
      debts: [],
      pager: {},
      page: 1,
    }
  },
  updated () {
    console.log('Component has been updated!')
  },
  destroyed () {
    console.log('Component has been destroyed!')
  },
  methods: {
    fetchApproves: function (page) {
      console.log('/approves/' + this.supplier + '/list?page=' + page)
      this.$http.get('/approves/' + this.supplier + '/list?page=' + page)
        .then(res => {
          console.log(res)
          this.approves = res.data.approvements.data
          this.pager = res.data.approvements
        })
        .catch(err => {
          console.log(err)
        })
    },
    addToPaymentApproves: function (approve) {
      if (event.target.value === 'on') {
        this.paymentApproves.push(approve)

        this.removeSelectedApprove(this.approves, approve.app_id)
      } else {
        console.log('this is not checked')
      }
    },
    removeSelectedApprove: function (data, compared) {
      let removeIndex = data.findIndex(d => d.app_id === compared)
      data.splice(removeIndex, 1)
    },
    onSelected: function () {
      // Submit selection to and calculate approvement total.
      this.$emit('selectedDebts')

      // Close modal.
      $(this.$refs.approveSelectionModal).modal('hide')
    }
  }
}
</script>
