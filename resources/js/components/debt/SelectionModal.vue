<template>
<div
  class="modal fade"
  id="debtSelectionModal"
  ref="debtSelectionModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="myModalLabel"
>
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">รายการหนี้</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div><!-- /.modal-header -->

      <div class="modal-body">

        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="font-size: 12px;">
            <thead>
              <tr>
                <th style="width: 5%; text-align: center;">#</th>
                <th style="width: 10%; text-align: center;">รหัส</th>
                <th style="width: 10%; text-align: center;">วันที่ลงบัญชี</th>
                <th style="width: 10%; text-align: center;">เลขที่ใบส่งของ</th>
                <!-- <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th> -->
                <th style="text-align: left;">ประเภทหนี้</th>
                <th style="width: 10%; text-align: center;">ยอดหนี้</th>
                <th style="width: 10%; text-align: center;">ภาษี</th>
                <th style="width: 10%; text-align: center;">สุทธิ</th>
                <!-- <th style="width: 6%; text-align: center;">สถานะ</th> -->
              </tr>
            </thead>
            <tbody v-if="debts">
              <tr v-for="debt in debts" :key="debt.debt_id">
                <td class="text-center">
                  <input type="checkbox" @click="addToApproveDebts(debt)" />
                </td>
                <td>{{ debt.debt_id }}</td>
                <td>{{ debt.debt_date | thdate }}</td>
                <td>{{ debt.deliver_no }}</td>
                <!-- <td>{{ debt.deliver_date }}</td> -->
                <td>{{ debt.debttype.debt_type_name }}</td>
                <td class="text-right">{{ debt.debt_amount | currency }}</td>
                <td class="text-right">{{ debt.debt_vat | currency }}</td>
                <td class="text-right">{{ debt.debt_total | currency }}</td>
                <!-- <td>{{ debt.debt_status }}</td> -->
              </tr>
            </tbody>
          </table>
        </div><!-- /.table-responsive -->

        <paginate
          v-show="pager.last_page > 1"
          :page-count="pager.last_page || 1"
          :click-handler="fetchDebts"
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

      </div><!-- /. modal-body -->

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" @click="onSelected">ตกลง</button>
      </div><!-- /. modal-footer -->

    </div>
  </div>
</div>
</template>

<script>
export default {
  name: 'DebtSelectionModal',
  props: ['supplier', 'approveDebts'],
  data () {
    return {
      selectedDebts: [],
      debts: [],
      pager: {}
    }
  },
  updated () {
    console.log('Component has been updated!')
  },
  destroyed () {
    console.log('Component has been destroyed!')
  },
  methods: {
    fetchDebts: function (page) {
      this.$http.get('/debts/' + this.supplier + '/list?page=' + page)
        .then(res => {
          console.log(res)

          if (this.approveDebts.length > 0) {
            this.approveDebts.map(ad => {
              this.removeSelectedDebt(res.data.debts.data, ad.debt_id)
            })

            this.debts = res.data.debts.data
          } else {
            this.debts = res.data.debts.data
          }

          this.pager = res.data.debts
        })
        .catch(err => {
          console.log(err)
        })
    },
    addToApproveDebts: function (debt) {
      if (event.target.value === 'on') {
        this.approveDebts.push(debt)

        this.removeSelectedDebt(this.debts, debt.debt_id)
      } else {
        console.log('this is not checked')
      }
    },
    removeSelectedDebt: function (data, compared) {
      let removeIndex = data.findIndex(d => d.debt_id === compared)
      data.splice(removeIndex, 1)
    },
    onSelected: function () {
      // Submit selection to and calculate approvement total.
      this.$emit('selectedDebts')

      // Close modal.
      $(this.$refs.debtSelectionModal).modal('hide')
    }
  }
}
</script>
