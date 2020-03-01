<template>
<div class="container-fluid">
  <breadcrumb :pageTitle="'บันทึกรายการขออนุมัติหนี้'" />

  <h4>บันทึกรายการขออนุมัติหนี้</h4>
  <hr style="margin: 0; margin-bottom: 10px;">

  <!-- <b-form @submit.prevent="onSubmit($event)"> -->

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
            v-model="approve.supplier"
            v-validate="{required: true}"
            @input="clearData"
          />
          <!-- <select
            id="supplier_id"
            name="supplier_id"
            v-model="approve.supplier"
            class="form-control"
            tabindex="0"
          >
            <option value="">-- กรุณาเลือก --</option>
            <option v-for="s in suppliers" :value="s.supplier_id" :key="s.supplier_id">
              {{ s.supplier_name }}
            </option>

          </select> -->
          <span class="text-danger small" v-show="submitted && errors.has('supplier_id')">
              กรุณาเลือกเจ้าหนี้
          </span>
        </div>

      </div><!-- /.col -->

      <div class="col-md-6">

        <div class="form-group">
          <label>เลขที่รับเอกสาร :</label>
          <input
            type="text"
            id="app_recdoc_no"
            name="app_recdoc_no"
            v-model="approve.app_recdoc_no"
            :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('app_recdoc_no') }"
            v-validate="'required'"
            placeholder="ระบุเลขที่รับเอกสาร"
            tabindex="8"
          />
          <div class="invalid-feedback" v-show="submitted && errors.has('app_recdoc_no')">
              กรุณาระบุเลขที่รับเอกสาร
          </div>
        </div>

        <div class="form-group">
          <label>เลขที่ขออนุมัติ :</label>
          <input
            type="text"
            id="app_doc_no"
            name="app_doc_no"
            v-model="approve.app_doc_no"
            :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('app_doc_no') }"
            v-validate="'required'"
            placeholder="ระบุเลขที่ขออนุมัติ"
            tabindex="4"
          />
          <div class="invalid-feedback" v-show="submitted && errors.has('app_doc_no')">
              กรุณาระบุเลขที่ขออนุมัติ
          </div>
        </div>

      </div><!-- /.col -->

      <div class="col-md-6">
        
        <div class="form-group">
          <label>วันที่รับเอกสาร :</label>
          <date-picker
            id="app_recdoc_date"
            name="app_recdoc_date"
            v-model="approve.app_recdoc_date"
            :language="dpLang.th"
            :bootstrap-styling="true"
            :format="'dd/MM/yyyy'"
            v-validate="{required: true, date_format: 'dd/MM/yyyy'}"
            placeholder="เลือกวันที่รับเอกสาร"
            tabindex="5"
          />
          <span class="text-danger small" v-show="submitted && errors.has('app_recdoc_date')">
              กรุณาเลือกวันที่รับเอกสาร
          </span>
        </div>

        <div class="form-group">
          <label>วันที่ขออนุมัติ :</label>
          <date-picker
            id="app_date"
            name="app_date"
            v-model="approve.app_date"
            :language="dpLang.th"
            :bootstrap-styling="true"
            :format="'dd/MM/yyyy'"
            v-validate="{required: true, date_format: 'dd/MM/yyyy'}"
            placeholder="เลือกวันที่ขออนุมัติ"
            tabindex="1"
          />
          <span class="text-danger small" v-show="submitted && errors.has('app_date')">
              กรุณาเลือกวันที่ขออนุมัติ
          </span>
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

            <a href="#" class="btn btn-primary" role="button" @click="showSupplierDebts($event)">
              <i class="far fa-calendar-plus"></i> เพิ่ม
            </a>
            <a href="#" class="btn btn-danger" role="button" @click="removeFromApproveDebts()">
              <i class="far fa-calendar-minus"></i> ลบ
            </a>

            <div class="table-responsive">
              <table class="table table-bordered table-striped" style="font-size: 12px; margin-top: 10px;">
                  <thead>
                    <tr>
                      <th style="width: 3%; text-align: center;">#</th>
                      <th style="width: 6%; text-align: center;">รหัส</th>
                      <th style="width: 7%; text-align: center;">วันที่ลงบัญชี</th>
                      <th style="width: 15%; text-align: center;">เลขที่ใบส่งของ</th>
                      <th style="width: 8%; text-align: center;">วันที่ใบส่งของ</th>
                      <th style="text-align: left;">ประเภทหนี้</th>
                      <th style="width: 7%; text-align: center;">ยอดหนี้</th>
                      <th style="width: 7%; text-align: center;">ภาษี</th>
                      <th style="width: 7%; text-align: center;">สุทธิ</th>
                    </tr>
                  </thead>
                  <tbody v-if="approve.debts">
                    <tr v-for="debt in approve.debts" :key="debt.debt_id">
                      <td>
                        <input type="checkbox" @click="addToApproveDebtToRemove(debt)">
                      </td>
                      <td>{{ debt.debt_id }}</td>
                      <td>{{ debt.debt_date | thdate }}</td>
                      <td>{{ debt.deliver_no }}</td>
                      <td>{{ debt.deliver_date | thdate }}</td>
                      <td>{{ debt.debt_type_name }}</td>
                      <td class="text-right">{{ debt.debt_amount | currency }}</td>
                      <td class="text-right">{{ debt.debt_vat | currency }}</td>
                      <td class="text-right">{{ debt.debt_total | currency }}</td>
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
                v-model="approve.budget"
                v-validate="{required: true}"
                :class="{'form-control': true, 'is-invalid': submitted && errors.has('deliver_no')}"
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
              ({{ approve.cheque_str }})
            </span>
          </div><!-- /.col -->

          <div class="col-md-6">
            <div class="row">
              <div class="form-group col-md-6">
                <label>ฐานภาษี :</label>
                <input
                  type="text"
                  id="net_val"
                  name="net_val"
                  v-model="approve.net_val"
                  v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                  :class="{'form-control': true, 'is-invalid': submitted && errors.has('net_val')}"
                  class="text-right"
                  tabindex="1"
                />
                <div class="invalid-feedback" v-show="submitted && errors.has('net_val')">
                  {{ errors.first('net_val')}}
                </div>
              </div>
              <div class="form-group col-md-6">
                <label>ภาษีมูลค่าเพิ่ม :</label>
                <input
                  type="text"
                  id="vatamt"
                  name="vatamt"
                  v-model="approve.vatamt"
                  v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                  :class="{'form-control': true, 'is-invalid': submitted && errors.has('vatamt')}"
                  class="text-right"
                  tabindex="1"
                />
                <div class="invalid-feedback" v-show="submitted && errors.has('vatamt')">
                  {{ errors.first('vatamt')}}
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label>ส่วนลด :</label>
                <input
                  type="text"
                  id="discount"
                  name="discount"
                  v-model="approve.discount"
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
                  v-model="approve.fine"
                  v-validate="{regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                  :class="{'form-control': true, 'is-invalid': submitted && errors.has('fine')}"
                  class="text-right"
                  tabindex="1"
                />
                <div class="invalid-feedback" v-show="submitted && errors.has('budget_id')">
                  กรุณาระบุค่าปรับเป็นตัวเลข
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-md-6">
                <label>VAT (%) :</label>
                <input
                  type="text"
                  id="vatrate"
                  name="vatrate"
                  v-model="approve.vatrate"
                  v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                  :class="{'form-control': true, 'is-invalid': submitted && errors.has('vatrate')}"
                  class="text-right"
                  tabindex="1" required
                />
                <div class="invalid-feedback" v-show="submitted && errors.has('vatrate')">
                  {{ errors.first('vatrate')}}
                </div>
              </div>
              <div class="form-group col-md-6">
                <label>ภาษีหัก ณ ที่จ่าย :</label>
                <input
                  type="text"
                  id="tax_val"
                  name="tax_val"
                  v-model="approve.tax_val"
                  v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                  :class="{'form-control': true, 'is-invalid': submitted && errors.has('tax_val')}"
                  class="text-right"
                  tabindex="1"
                />
                <div class="invalid-feedback" v-show="submitted && errors.has('tax_val')">
                  {{ errors.first('tax_val')}}
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <label>ยอดสุทธิ :</label>
                <input
                  type="text"
                  id="net_total"
                  name="net_total"
                  v-model="approve.net_total"
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
                <label>ยอดจ่ายเช็ค :</label>
                <input
                  type="text"
                  id="cheque"
                  name="cheque"
                  v-model="approve.cheque"
                  v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                  :class="{'form-control': true, 'is-invalid': submitted && errors.has('cheque')}"
                  class="text-right"
                  tabindex="1"
                />
                <div class="invalid-feedback" v-show="submitted && errors.has('cheque')">
                  {{ errors.first('cheque')}}
                </div>
              </div>
            </div>

          </div><!-- /.col -->
        </div><!-- /.row -->

      </div><!-- /.tab-pane -->
    </div><!-- /.tab-content -->

    <button type="submit" class="btn btn-primary float-right" @click="onSubmit($event)" v-if="true">
      บันทึก
    </button>
    <button type="submit" class="btn btn-warning float-right" @click="onSubmit($event)" v-if="false">
      แก้ไข
    </button>
    <div class="clearfix">...</div>

  <!-- </b-form> -->

  <debt-selection
    :supplier="approve.supplier"
    :approveDebts="approve.debts"
    @selectedDebts="calculateApproveTotal"
    ref="modal"
  />
</div>
</template>

<script>
import { mapGetters } from 'vuex'
import DatePicker from 'vuejs-datepicker'
import {en, th} from 'vuejs-datepicker/dist/locale'

import Breadcrumb from '../../components/Breadcrumb'
import DebtSelectionModal from '../debt/SelectionModal'

import { ArabicNumberToText } from '../../utils/thaibath'
import { currencyFormat } from '../../utils/number-func'
import { getDate } from '../../utils/date-func'

// Custom validator dict
const dict = {
  custom: {
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

export default {
  name: 'ApproveForm',
  components: {
    'breadcrumb': Breadcrumb,
    'date-picker': DatePicker,
    'debt-selection': DebtSelectionModal
  },
  props: ['editApprove'],
  data () {
    return {
      submitted: false,
      approve: {
        supplier: '',
        app_doc_no: '',
        app_date: '',
        app_recdoc_no: '',
        app_recdoc_date: '',
        pay_to: '',
        budget: '',
        amount: '0.00',
        tax_val: '0.00',
        discount: '0.00',
        fine: '0.00',
        vatrate: '1',
        vatamt: '0.00',
        net_val: '0.00',
        net_amt: '0.00',
        net_amt_str: ' ตัวอักษร ',
        net_total: '0.00',
        net_total_str: ' ตัวอักษร ',
        cheque: '0.00',
        cheque_str: ' ตัวอักษร ',
        cr_user: '',
        chg_user: '',
        debts: []
      },
      suppliers: [],
      budgets: [],
      debts: [],
      approveDebtsToRemove: [],
      dpLang: {
        en: en,
        th: th
      }
    }
  },
  mounted () {
    this.submitted = false
    this.onInitForm()
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      currentUser: 'user/getUserProfile'
    })
  },
  methods: {
    onInitForm: function () {
      this.$http.get('/approves/add')
        .then(res => {
          console.log(res)
          this.suppliers = res.data.creditors
          this.budgets = res.data.budgets
        })
        .catch(err => {
          console.log(err)
        })
    },
    onSubmit: function (event) {
      this.submitted = true
      this.$validator.localize('en', dict)
      this.$validator.validateAll().then(valid => {
        if (valid) {
          this.approve.app_date = this.approve.app_date && getDate(this.approve.app_date)
          this.approve.app_recdoc_date = this.approve.app_recdoc_date && getDate(this.approve.app_recdoc_date)
          this.approve.pay_to = this.suppliers.filter(s => s.supplier_id === this.approve.supplier)[0].supplier_name

          this.approve.cr_user = this.currentUser.id
          this.approve.chg_user = this.currentUser.id

          if (this.editApprove && this.editApprove.app_id) {
            console.log('Edition approve')
            this.$store.dispatch('approve/update', this.approve)
          } else {
            console.log('Insertion approve')
            this.$store.dispatch('approve/store', this.approve)
          }

          /** Clear data from control */
          this.clearData()
        } else {
          this.$bvToast.toast(`คุณกรอกข้อมูลยังไม่ครบ !!`, {
            title: 'Warning',
            variant: 'warning',
            autoHideDelay: 2000
          })
        }
      })
    },
    showSupplierDebts: function (e) {      
      if (this.approve.supplier) {
        $('#debtSelectionModal').on('shown.bs.modal', this.$refs.modal.fetchDebts)
        $('#debtSelectionModal').modal()
      } else {
        this.$bvToast.toast('กรุณาเลือกเจ้าหนี้ก่อน !!', {
          title: 'Error',
          variant: 'danger',
          autoHideDelay: 2000
        })
      }
    },
    removeFromApproveDebts: function () {
      this.approveDebtsToRemove.map(r => {
        this.approve.debts = this.approve.debts.filter(ad => r.debt_id !== ad.debt_id)
      })

      this.approveDebtsToRemove = []
      this.calculateApproveTotal()
    },
    addToApproveDebtToRemove: function (debt) {
      this.approveDebtsToRemove.push(debt)
      console.log(this.approveDebtsToRemove)
    },
    calculateApproveTotal: function() {
        let vatAmt = 0.0
        let taxVal = 0.0
        let netVal = 0.0
        let netTotal = 0.0
        let cheque = 0.0
        let vatRate = $("#vatrate").val()

        this.approve.debts.map(debt => {
            vatAmt += debt.debt_vat
            netVal += debt.debt_amount
        })

        taxVal = (netVal * 1) / 100
        netTotal = netVal + vatAmt
        cheque = netTotal - taxVal

        this.approve.amount = netVal.toFixed(2) // ฐานภาษี
        this.approve.net_val = netVal.toFixed(2) // ฐานภาษี
        this.approve.vatamt = vatAmt.toFixed(2) // ภาษีมูลค่าเพิ่ม
        this.approve.tax_val = taxVal.toFixed(2) // ภาษีหัก ณ ที่จ่าย
        this.approve.net_amt = taxVal.toFixed(2) // ภาษีหัก ณ ที่จ่าย
        this.approve.net_total = netTotal.toFixed(2) // ยอดสุทธิ
        this.approve.cheque = cheque.toFixed(2) // ยอดจ่ายเช็ค

        this.approve.net_amt_str = ArabicNumberToText(taxVal.toFixed(2)) // ภาษีหัก ณ ที่จ่าย
        this.approve.net_total_str = ArabicNumberToText(netTotal.toFixed(2)) // ยอดสุทธิ
        this.approve.cheque_str = ArabicNumberToText(cheque.toFixed(2)) // ยอดจ่ายเช็ค
    },
    clearData: function () {
      this.approve = {
        supplier: this.approve.supplier,
        app_doc_no: '',
        app_date: '',
        app_recdoc_no: '',
        app_recdoc_date: '',
        pay_to: '',
        budget: '',
        amount: '0.00',
        tax_val: '0.00',
        discount: '0.00',
        fine: '0.00',
        vatrate: '1',
        vatamt: '0.00',
        net_val: '0.00',
        net_amt: '0.00',
        net_amt_str: ' ตัวอักษร ',
        net_total: '0.00',
        net_total_str: ' ตัวอักษร ',
        cheque: '0.00',
        cheque_str: ' ตัวอักษร ',
        cr_user: '',
        chg_user: '',
        debts: []
      }
    }
  }
}
</script>
