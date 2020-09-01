<template>
<div class="container-fluid">
  <breadcrumb :pageTitle="'บันทึกรายการตัดจ่ายหนี้'" />

  <page-header title="บันทึกรายการตัดจ่ายหนี้" />

  <hr style="margin: 0; margin-bottom: 10px;">

  <div class="row">
    <div class="col-md-12">

      <div class="form-group">
        <label>เจ้าหนี้ :</label>
        <v-select
          id="supplier_id"
          name="supplier_id"
          :options="suppliers"
          :reduce="s => s.supplier_id"
          label="supplier_name"
          v-model="payment.supplier"
          v-validate="{required: true}"
          @input="clearData"
        />
        <span class="text-danger small" v-show="submitted && errors.has('supplier_id')">
            กรุณาเลือกเจ้าหนี้
        </span>
      </div>
    </div><!-- /.col -->

    <div class="col-md-6">
      <div class="form-group">
        <label>เลขที่ บค. :</label>
        <input
          type="text"
          id="paid_doc_no"
          name="paid_doc_no"
          v-model="payment.paid_doc_no"
          :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('paid_doc_no') }"
          v-validate="'required'"
          placeholder="ระบุเลขที่ บค."
          tabindex="8"
        />
        <div class="invalid-feedback" v-show="submitted && errors.has('paid_doc_no')">
            กรุณาระบุเลขที่ บค.
        </div>
      </div>
      
      <div class="form-group">
        <label>เลขที่เช็ค :</label>
        <input
          type="text"
          id="cheque_no"
          name="cheque_no"
          v-model="payment.cheque_no"
          :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('cheque_no') }"
          v-validate="'required'"
          placeholder="ระบุเลขที่เช็ค"
          tabindex="4"
        />
        <div class="invalid-feedback" v-show="submitted && errors.has('cheque_no')">
            กรุณาระบุเลขที่เช็ค
        </div>
      </div>

      <div class="form-group">
        <label>ธนาคาร :</label>
        <select
          id="bank_acc_id"
          name="bank_acc_id"
          v-model="payment.bank_acc"
          v-validate="'required'"
          :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('bank_acc_id') }"
          tabindex="0"
        >
          <option value="">-- กรุณาเลือก --</option>
          <option v-for="b in bankaccs" :value="b.bank_acc_id" :key="b.bank_acc_id">
            {{ b.bank[0].bank_name + ' (' + b.bank_acc_no + ') ' + b.bank_acc_name }}
          </option>
        </select>
        <span class="text-danger small" v-show="submitted && errors.has('bank_acc_id')">
            กรุณาเลือกธนาคาร
        </span>
      </div>

    </div><!-- /.col -->

    <div class="col-md-6">

      <div class="form-group">
        <!--<label>วันที่ บค. :</label>-->
        <date-picker dataModel="paid_date" @inputDate="setDateFromDatePicker" label="วันที่ บค." />

        <span class="text-danger small" v-show="submitted && errors.has('paid_date')">
            {{ errors.first('paid_date')}}
        </span>
      </div>

      <div class="form-group">
        <!--<label>วันที่เช็ค :</label>-->
        <date-picker dataModel="cheque_date" @inputDate="setDateFromDatePicker" label="วันที่เช็ค" />

        <span class="text-danger small" v-show="submitted && errors.has('cheque_date')">
            {{ errors.first('cheque_date')}}
        </span>
      </div>

      <div class="form-group">
        <label>ผู้รับเช็ค :</label>
        <input
          type="text"
          id="cheque_receiver"
          name="cheque_receiver"
          v-model="payment.cheque_receiver"
          :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('cheque_receiver') }"
          v-validate="'required'"
          placeholder="ระบุผู้รับเช็ค"
          tabindex="4"
        />
        <div class="invalid-feedback" v-show="submitted && errors.has('cheque_receiver')">
            กรุณาระบุผู้รับเช็ค
        </div>
      </div>

    </div><!-- /.col -->
  </div><!-- /.row -->

  <nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
      <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">รายการหนี้</a>
    </div>
  </nav>

  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
      <div class="row m-2 mt-3">
        <div class="col-md-12">
          
          <v-btn color="primary" dark @click="showSupplierApproves($event)">
            <v-icon dark>mdi-basket-plus</v-icon>
          </v-btn>
          <v-btn color="error" dark @click="removeFromPaymentApproves()">
            <v-icon dark>mdi-delete</v-icon>
          </v-btn>

          <div class="table-responsive">
            <table class="table table-bordered table-striped" style="font-size: 12px; margin-top: 10px;">
                <thead>
                  <tr>
                    <th style="width: 3%; text-align: center;">#</th>
                    <th style="width: 6%; text-align: center;">รหัส</th>
                    <th style="width: 8%; text-align: center;">เลขที่ขออนุมัติ</th>
                    <th style="width: 8%; text-align: center;">วันที่ขออนุมัติ</th>
                    <th style="text-align: left;">สั่งจ่าย</th>
                    <th style="width: 5%; text-align: center;">จำนวนบิล</th>
                    <th style="width: 7%; text-align: center;">ฐานภาษี</th>
                    <th style="width: ุ6%; text-align: center;">VAT</th>
                    <th style="width: 7%; text-align: center;">ยอดสุทธิ</th>
                    <th style="width: 7%; text-align: center;">ภาษีหัก ณ ที่จ่าย</th>
                    <th style="width: 7%; text-align: center;">ยอดเช็ค</th>
                  </tr>
                </thead>
                <tbody v-if="payment.approves">
                  <tr v-for="approve in payment.approves" :key="approve.app_id">
                    <td>
                      <input type="checkbox" @click="addToApproveDebtToRemove(approve)">
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
          </div>

          <hr style="margin: 0; margin-bottom: 10px;">
        </div>
      </div>

      <div class="row m-2">
        <div class="col-md-6">
          <div class="form-group">
            <label>ประเภทงบประมาณ :</label>
            <select
              id="budget_id"
              name="budget_id"
              v-model="payment.budget"
              v-validate="{required: true}"
              :class="{'form-control': true, 'is-invalid': submitted && errors.has('budget_id')}"
              tabindex="2"
            >
              <option value="" selected="selected">-- กรุณาเลือก --</option>
              <option v-for="b in budgets" :value="b.budget_id" :key="b.budget_id">
                {{ b.budget_name }}
              </option>
            </select>
            <span class="text-danger small" v-show="submitted && errors.has('budget_id')">
                กรุณาเลือกประเภทงบประมาณ
            </span>
          </div>

          <span class="col-md-12" style="margin: 10px 5px; font-weight: bold;">
            ({{ payment.totalstr }})
          </span>
        </div><!-- /.col -->

        <div class="col-md-6">
          <div class="row">
            
            <div class="form-group col-md-6">
              <label>ยอดหนี้ :</label>
              <input
                type="text"
                id="net_total"
                name="net_total"
                v-model="payment.net_total"
                v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('net_total')}"
                class="text-right"
                tabindex="1"
              />
              <div class="invalid-feedback" v-show="submitted && errors.has('net_total')">
                {{ errors.first('net_total')}}
              </div>
            </div>

            <div class="form-group col-md-6">
              <label>ฐานภาษี :</label>
              <input
                type="text"
                id="net_val"
                name="net_val"
                v-model="payment.net_val"
                v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('net_val')}"
                class="text-right"
                tabindex="1"
              />
              <div class="invalid-feedback" v-show="submitted && errors.has('net_val')">
                {{ errors.first('net_val')}}
              </div>
            </div>

          </div><!-- /.row -->

          <div class="row">

            <div class="form-group col-md-6">
              <label>ส่วนลด :</label>
              <input
                type="text"
                id="discount"
                name="discount"
                v-model="payment.discount"
                v-validate="{regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('discount')}"
                class="text-right"
                tabindex="1"
              />
              <div class="invalid-feedback" v-show="submitted && errors.has('budget_id')">
                กรุณาระบุส่วนลดเป็นตัวเลข
              </div>
            </div>

            <div class="form-group col-md-6">
              <label>ค่าปรับ :</label>
              <input
                type="text"
                id="fine"
                name="fine"
                v-model="payment.fine"
                v-validate="{regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('fine')}"
                class="text-right"
                tabindex="1"
              />
              <div class="invalid-feedback" v-show="submitted && errors.has('budget_id')">
                กรุณาระบุค่าปรับเป็นตัวเลข
              </div>
            </div>

          </div><!-- /.row -->

          <div class="row">
            
            <div class="form-group col-md-6">
              <label>ภาษีหัก ณ ที่จ่าย :</label>
              <input
                type="text"
                id="net_amt"
                name="net_amt"
                v-model="payment.net_amt"
                v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('net_amt')}"
                class="text-right"
                tabindex="1"
              />
              <div class="invalid-feedback" v-show="submitted && errors.has('net_amt')">
                {{ errors.first('net_amt')}}
              </div>
            </div>

            <div class="form-group col-md-6">
              <label>ยอดจ่ายเช็ค :</label>
              <input
                type="text"
                id="total"
                name="total"
                v-model="payment.total"
                v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('total')}"
                class="text-right"
                tabindex="1"
              />
              <div class="invalid-feedback" v-show="submitted && errors.has('total')">
                {{ errors.first('total')}}
              </div>
            </div>

          </div><!-- /.row -->

        </div><!-- /.col -->
      </div><!-- /.row -->

    </div><!-- /.tab-pane -->
  </div><!-- /.tab-content -->

  <v-layout>
    <v-spacer></v-spacer>
    <v-btn align-end type="submit" color="primary" @click="onSubmit($event)" v-if="true">
      บันทึก
    </v-btn>
    <v-btn type="submit" color="warning" @click="onSubmit($event)" v-if="false">
      แก้ไข
    </v-btn>
  </v-layout>

  <approve-selection
    :supplier="payment.supplier"
    :paymentApproves="payment.approves"
    @selectedDebts="calculatePaymentTotal"
    ref="approveModal"
  />

  <div
    class="modal fade"
    id="paidConfirmModal"
    ref="paidConfirmModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
  >
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">ยืนยันการตัดจ่ายหนี้</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div><!-- /.modal-header -->

        <div class="modal-body">
          <div class="form-group">
            <label for="">ยอดจ่าย</label>
            <input
              type="text"
              name="confirm_net_total"
              id="confirm_net_total"
              v-model="confirm.net_total"
              class="form-control"
              readonly
            />
          </div>

          <div class="form-group">
            <label for="">ส่วนลด</label>
            <input
              type="text"
              name="confirm_discount"
              id="confirm_discount"
              v-model="confirm.discount"
              @keyup="calculateConfirmTotalPaid"
              class="form-control">
          </div>

          <div class="form-group">
            <label for="">จ่ายจริง</label>
            <input 
              type="text"
              name="confirm_paid"
              id="confirm_paid"
              v-model="confirm.paid"
              @keyup="calculateConfirmTotalPaid"
              class="form-control"
            />
          </div>

          <div class="form-group">
            <label for="">ยอดสุทธิ</label>
            <input
              type="text"
              name="confirm_total"
              id="confirm_total"
              v-model="confirm.total"
              class="form-control">
          </div>
        </div><!-- /. modal-body -->

        <div class="modal-footer">
          <v-btn type="submit" color="primary" @click="calculatePaidConfirm">ตกลง</v-btn>
        </div><!-- /. modal-footer -->

      </div>
    </div>
  </div><!-- /.modal container -->

</div>
</template>

<script>
import { mapGetters } from 'vuex'
import DatePicker from '../DatePicker'

import Breadcrumb from '../../components/Breadcrumb'
import PageHeader from '../../components/PageHeader'
import ApproveSelectionModal from '../approve/SelectionModal'

import { ArabicNumberToText } from '../../utils/thaibath'
import { currencyFormat } from '../../utils/number-func'
import { getDate } from '../../utils/date-func'

export default {
  name: 'ApproveForm',
  components: {
    'breadcrumb': Breadcrumb,
    'page-header': PageHeader,
    'date-picker': DatePicker,
    'approve-selection': ApproveSelectionModal
  },
  props: ['editApprove'],
  data () {
    return {
      submitted: false,
      payment: {
        paid_date: '',
        supplier: '',
        paid_doc_no: '',
        cheque_no: '',
        cheque_date: '',
        bank_acc: '',
        pay_to: '',
        cheque_receiver: '',
        remark: '',
        budget: '',
        tax_type: '',
        net_total: 0.00,
        net_val: 0.00,
        net_amt: 0.00,
        fine: 0.00,
        discount: 0.00,
        remain: 0.00,
        paid_amt: 0.00,
        total: 0.00,
        totalstr: ' ตัวอักษร ',
        cr_userid: '',
        chg_userid: '',
        approves: []
      },
      confirm: {
        net_total: 0.00,
        paid: 0.00,
        discount: 0.00,
        total: 0.00
      },
      suppliers: [],
      budgets: [],
      bankaccs: [],
      paymentApprovesToRemove: [],
    }
  },
  created() {
    console.log('Component has been created!');
  },
  mounted() {
    this.submitted = false
    this.onInitForm()
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      currentUser: 'user/getCurrentUser'
    })
  },
  methods: {
    onInitForm: function () {
      this.$http.get('/payments/add')
        .then(res => {
          console.log(res)
          this.suppliers = res.data.creditors
          this.budgets = res.data.budgets
          this.bankaccs = res.data.bankaccs
        })
        .catch(err => {
          console.log(err)
        })
    },
    onSubmit: function (event) {
      this.submitted = true
      const dict = {
        custom: {
          paid_date: {
            required: 'กรุณาระบุวันที่ บค.',
            date_format: 'กรุณาระบุวันที่ บค. ในรูปแบบ dd/mm/yyyy'
          },
          cheque_date: {
            required: 'กรุณาระบุวันที่เช็ค',
            date_format: 'กรุณาระบุวันที่เช็คในรูปแบบ dd/mm/yyyy'
          },
          net_val: {
            required: 'กรุณาระบุฐานภาษี',
            regex: 'กรุณาระบุฐานภาษีเป็นตัวเลข'
          },
          vatrate: {
            required: 'กรุณาระบุอัตราภาษี (%)',
            regex: 'กรุณาระบุอัตราภาษี (%) เป็นตัวเลข'
          },
          vatamt: {
            required: 'กรุณาระบุจำนวนภาษี',
            regex: 'กรุณาระบุจำนวนภาษีเป็นตัวเลข'
          },
          tax_val: {
            required: 'กรุณาระบุภาษีหัก ณ ที่จ่าย',
            regex: 'กรุณาระบุภาษีหัก ณ ที่จ่ายป็นตัวเลข'
          },
          net_total: {
            required: 'กรุณาระบุยอดหนี้สุทธิ',
            regex: 'กรุณาระบุยอดหนี้สุทธิป็นตัวเลข'
          },
          cheque: {
            required: 'กรุณาระบุยอดจ่ายเช็ค',
            regex: 'กรุณาระบุยอดจ่ายเช็คป็นตัวเลข'
          }
        }
      }

      if (this.editApprove && this.editApprove.app_id) {
        console.log('Edition approve')
      } else {
        console.log('Insertion approve')
      }

      this.$validator.localize('en', dict)
      this.$validator.validateAll().then(valid => {
        console.log(this.$validator.errors)

        if (valid) {
          if (this.editApprove && this.editApprove.app_id) {
            this.updateData()
          } else {
            this.calculatePaidConfirm()
          }

          // this.$store.dispatch('approve/fetchAll', {
          //   supplierId: 0,
          //   startDate: 0,
          //   endDate: 0,
          //   showAll: 1,
          //   page: 1
          // })

          // this.clearData() // Clear data from control
        } else {
          this.$bvToast.toast(`คุณกรอกข้อมูลยังไม่ครบ !!`, {
            title: 'Warning',
            variant: 'warning',
            autoHideDelay: 2000
          })
        }
      })
    },
    calculateConfirmTotalPaid () {
      this.confirm.total = parseFloat(this.confirm.paid).toFixed(2)
    },
    calculatePaidConfirm () {
      this.confirm.net_total = parseFloat(this.payment.net_total).toFixed(2)
      this.payment.remain = parseFloat((this.confirm.net_total - this.confirm.discount) - this.confirm.paid).toFixed(2)
      this.payment.paid_amt = parseFloat(this.confirm.paid).toFixed(2)
      this.payment.total = parseFloat(this.confirm.total).toFixed(2)
      this.payment.total_str = ArabicNumberToText(parseFloat(this.confirm.total).toFixed(2)) // ยอดสุทธิ

      $(this.$refs.paidConfirmModal).modal()
      
      if (this.confirm.paid > 0.00) {
        console.log('It is paid !!')
        $(this.$refs.paidConfirmModal).modal('hide')

        this.storeData()
      } else {
        this.$bvToast.toast(`กรุณากรอกขจำนวนที่จ่ายจริงก่อน !!`, {
          title: 'Warning',
          variant: 'warning',
          autoHideDelay: 2000
        })
      }
    },
    storeData: function () {
      this.payment.paid_date = this.payment.paid_date && getDate(this.payment.paid_date)
      this.payment.cheque_date = this.payment.cheque_date && getDate(this.payment.cheque_date)
      this.payment.pay_to = this.suppliers.filter(s => s.supplier_id === this.payment.supplier)[0].supplier_name
      // this.payment.cheque_receiver = this.suppliers.filter(s => s.supplier_id === this.payment.supplier)[0].supplier_name

      this.payment.cr_userid = this.currentUser
      this.payment.chg_userid = this.currentUser
      console.log(this.payment)

      this.$http.post('/payments/store', this.payment)
        .then(res => {
          console.log(res)

          this.$bvToast.toast(`บันทึกข้อมูลเรียบร้อยแล้ว !!`, {
            title: 'Info',
            variant: 'success',
            autoHideDelay: 2000
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
    },
    updateData: function () {
      this.payment.paid_date = this.payment.paid_date && getDate(this.payment.paid_date)
      this.payment.cheque_date = this.payment.cheque_date && getDate(this.payment.cheque_date)
      this.payment.pay_to = this.suppliers.filter(s => s.supplier_id === this.payment.supplier)[0].supplier_name
      // this.payment.cheque_receiver = this.suppliers.filter(s => s.supplier_id === this.payment.supplier)[0].supplier_name

      this.payment.cr_userid = this.currentUser
      this.payment.chg_userid = this.currentUser
      console.log(this.payment)

      this.$http.put('/payments/update', this.payment)
        .then(res => {
          console.log(res)

          this.$bvToast.toast(`บันทึกข้อมูลเรียบร้อยแล้ว !!`, {
            title: 'Info',
            variant: 'success',
            autoHideDelay: 2000
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
    },
    showSupplierApproves: function (e) {      
      if (this.payment.supplier) {
        $('#approveSelectionModal').on('shown.bs.modal', this.$refs.approveModal.fetchApproves)
        $('#approveSelectionModal').modal()
      } else {
        this.$bvToast.toast('กรุณาเลือกเจ้าหนี้ก่อน !!', {
          title: 'Error',
          variant: 'danger',
          autoHideDelay: 2000
        })
      }
    },
    removeFromPaymentApproves: function () {
      this.paymentApprovesToRemove.map(r => {
        this.payment.approves = this.payment.approves.filter(ad => r.debt_id !== ad.debt_id)
      })

      this.paymentApprovesToRemove = []
      this.calculatePaymentTotal()
    },
    addToApproveDebtToRemove: function (approve) {
      this.paymentApprovesToRemove.push(approve)
      console.log(this.paymentApprovesToRemove)
    },
    calculatePaymentTotal: function() {
        let taxVal = 0.0
        let netVal = 0.0
        let netTotal = 0.0

        this.payment.approves.map(app => {
            netTotal += app.net_total // ยอดหนี้
            netVal += app.amount // ฐานภาษี
        })

        taxVal = (netVal * 1) / 100 // ภาษีหัก ณ ที่จ่าย

        this.payment.net_total = netTotal.toFixed(2) // ยอดหนี้
        this.payment.net_val = netVal.toFixed(2) // ฐานภาษี
        this.payment.net_amt = taxVal.toFixed(2) // ภาษีหัก ณ ที่จ่าย

        this.payment.total = netTotal.toFixed(2) // ยอดสุทธิ
        this.payment.totalstr = ArabicNumberToText(netTotal.toFixed(2)) // ยอดสุทธิ
    },
    clearData: function () {
      this.payment = {
        paid_date: '',
        supplier: this.payment.supplier,
        paid_doc_no: '',
        cheque_no: '',
        cheque_date: '',
        bank_acc: '',
        pay_to: '',
        cheque_receiver: '',
        remark: '',
        budget: '',
        tax_type: '',
        net_total: 0.00,
        net_val: 0.00,
        net_amt: 0.00,
        fine: 0.00,
        discount: 0.00,
        remain: 0.00,
        paid_amt: 0.00,
        total: 0.00,
        totalstr: ' ตัวอักษร ',
        cr_userid: '',
        chg_userid: '',
        approves: []
      }

      this.confirm = {
        net_total: 0.00,
        paid: 0.00,
        discount: 0.00,
        total: 0.00
      }
    },
    setDateFromDatePicker: function (date, field) {
      this.payment[field] = date
    }
  }
}
</script>
