<template>
  <div
    class="modal fade"
    id="debtFormModal"
    ref="debtFormModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <b-form @submit.prevent="onSubmit($event)">

          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
              แบบบันทึกรายการหนี้
              <span v-if="editDebt.debt_id">[ID: {{ editDebt.debt_id }}]</span>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clearData">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <input type="hidden" id="user" name="user" value="">

              <div class="row">
                <div class="col-md-6">

                  <div class="form-group">
                    <label class="control-label">เจ้าหนี้ :</label>
                    <input
                      type="text"
                      id="supplier_name"
                      name="supplier_name"
                      v-model="debt.supplier_name"
                      class="form-control" readonly>
                    <input
                      type="hidden"
                      id="supplier_id"
                      name="supplier_id"
                      v-model="debt.supplier">
                    <span class="text-danger small" v-show="submitted && errors.has('supplier_id')">
                      กรุณาเลือกเจ้าหนี้
                    </span>
                  </div>

                  <div class="form-group">
                    <label>ประเภทหนี้ :</label>
                    <select
                      id="debt_type_id"
                      name="debt_type_id"
                      :class="{'form-control': true}"
                      v-model="debt.debt_type"
                      v-validate="{required: true}"
                    >
                      <option value="">--กรุณาเลือก--</option>
                      <option v-for="dt in debttypes" :value="dt.debt_type_id" :key="dt.debt_type_id">
                        {{ dt.debt_type_name }}
                      </option>
                    </select>
                    <span class="text-danger small" v-show="submitted && errors.has('debt_type_id')">
                      กรุณาเลือกประเภทหนี้
                    </span>
                  </div>

                  <div class="form-group">
                    <label>เลขที่รับหนังสือ :</label>
                    <input
                      type="text"
                      id="debt_doc_recno"
                      name="debt_doc_recno"
                      v-model="debt.debt_doc_recno"
                      class="form-control"
                      placeholder="ระบุเลขที่รับหนังสือ"
                      tabindex="4"
                    >
                  </div>

                  <div class="form-group">
                    <label>เลขที่หนังสือ :</label>
                    <input
                      type="text"
                      id="debt_doc_no"
                      name="debt_doc_no"
                      v-model="debt.debt_doc_no"
                      class="form-control"
                      placeholder="ระบุเลขที่หนังสือ"
                      tabindex="6"
                    >
                  </div>

                  <div class="form-group">
                    <label>เลขที่ใบส่งของ/ใบกำกับภาษี :</label>
                    <input
                      type="text"
                      id="deliver_no"
                      name="deliver_no"
                      v-model="debt.deliver_no"
                      v-validate="{required: true}"
                      :class="{'form-control': true, 'is-invalid': submitted && errors.has('deliver_no')}"
                      placeholder="ระบุเลขที่ใบส่งของ/ใบกำกับภาษี"
                      tabindex="8"
                    >
                    <div class="invalid-feedback" v-show="submitted && errors.has('deliver_no')">
                      กรุณาระบุเลขที่ใบส่งของ/ใบกำกับภาษี
                    </div>
                  </div>
                </div><!-- /.col -->

                <div class="col-md-6">
                  <div class="form-group">
                    <label>วันที่ลงบัญชี :</label>
                    <date-picker
                      id="debt_date"
                      name="debt_date"
                      v-model="debt.debt_date"
                      :language="dpLang.th"
                      :bootstrap-styling="true"
                      :format="'dd/MM/yyyy'"
                      v-validate="{required: true, date_format: 'dd/MM/yyyy'}"
                      placeholder="เลือกวันที่ลงบัญชี"
                    />
                    <span class="text-danger small" v-show="submitted && errors.has('debt_date')">
                      {{ errors.first('debt_date') }}
                    </span>
                  </div>

                  <div class="form-group">
                    <label>รายการ :</label>
                    <input
                      type="text"
                      id="debt_type_detail"
                      name="debt_type_detail"
                      v-model="debt.debt_type_detail"
                      class="form-control"
                      placeholder="ระบุรายการ"
                      tabindex="3"
                    >
                  </div>

                  <div class="form-group">
                    <label>วันที่รับหนังสือ :</label>
                    <date-picker
                      id="debt_doc_recdate"
                      name="debt_doc_recdate"
                      v-model="debt.debt_doc_recdate"
                      :language="dpLang.th"
                      :bootstrap-styling="true"
                      :format="'dd/MM/yyyy'"
                      v-validate="{required: true, date_format: 'dd/MM/yyyy'}"
                      placeholder="เลือกวันที่รับหนังสือ"
                    />
                    <span class="text-danger small" v-show="submitted && errors.has('debt_doc_recdate')">
                      {{ errors.first('debt_doc_recdate') }}
                    </span>
                  </div>

                  <div class="form-group">
                    <label>วันที่หนังสือ :</label>
                    <date-picker
                      id="debt_doc_date"
                      name="debt_doc_date"
                      v-model="debt.debt_doc_date"
                      :language="dpLang.th"
                      :bootstrap-styling="true"
                      :format="'dd/MM/yyyy'"
                      v-validate="{date_format: 'dd/MM/yyyy'}"
                      placeholder="เลือกวันที่หนังสือ"
                    />
                    <span class="text-danger small" v-show="submitted && errors.has('debt_doc_date')">
                      {{ errors.first('debt_doc_date') }}
                    </span>
                  </div>

                  <div class="form-group">
                    <label>วันที่ใบส่งของ/ใบกำกับภาษี :</label>
                    <date-picker
                      id="deliver_date"
                      name="deliver_date"
                      v-model="debt.deliver_date"
                      :language="dpLang.th"
                      :bootstrap-styling="true"
                      :format="'dd/MM/yyyy'"
                      v-validate="{required: true, date_format: 'dd/MM/yyyy'}"
                      placeholder="เลือกวันที่วันที่ใบส่งของ/ใบกำกับภาษี"
                    />
                    <span class="text-danger small" v-show="submitted && errors.has('deliver_date')">
                      {{ errors.first('deliver_date') }}
                    </span>
                  </div>
                </div><!-- /.col -->
              </div><!-- /.row -->

              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ยอดหนี้</a>
                  <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">เพิ่มเติม</a>
                </div>
              </nav>

              <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                  <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ยอดหนี้ :</label>
                      <input
                        type="text"
                        id="debt_amount"
                        name="debt_amount"
                        v-model="debt.debt_amount"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('debt_amount')}"
                        v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                        @keyup="calculateTotal"
                        tabindex="10"
                      >
                      <div class="invalid-feedback" v-show="submitted && errors.has('debt_amount')">
                        {{ errors.first('debt_amount') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label>จำนวนภาษี :</label>
                      <input
                        type="text"
                        id="debt_vat"
                        name="debt_vat"
                        v-model="debt.debt_vat"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('debt_vat')}"
                        v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                        tabindex="12"
                      >
                      <div class="invalid-feedback" v-show="submitted && errors.has('debt_vat')">
                        {{ errors.first('debt_vat') }}
                      </div>
                    </div>
                  </div><!-- /.col-md-6 -->

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>VAT(%) :</label>
                      <input
                        type="text"
                        id="debt_vatrate"
                        name="debt_vatrate"
                        v-model="debt.debt_vatrate"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('debt_vatrate')}"
                        v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/}"
                        @keyup="calculateVat();calculateTotal()"
                        tabindex="11"
                      >
                      <div class="invalid-feedback" v-show="submitted && errors.has('debt_vatrate')">
                        {{ errors.first('debt_vatrate') }}
                      </div>
                    </div>

                    <div class="form-group">
                      <label>ยอดหนี้สุทธิ :</label>
                      <input
                        type="text"
                        id="debt_total"
                        name="debt_total"
                        v-model="debt.debt_total"
                        :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('debt_total') }"
                        tabindex="13"
                        v-validate="{required: true, regex: /^[-+]?[0-9]*\.?[0-9]+$/ }"
                      >
                      <div class="invalid-feedback" v-show="submitted && errors.has('debt_total')">
                        {{ errors.first('debt_total') }}
                      </div>
                    </div>

                  </div><!-- /.col-md-6 -->
                </div>
              </div><!-- /.tab-pane -->

              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ประจำเดือน :</label>
                      <input
                        type="text"
                        id="debt_month"
                        name="debt_month"
                        v-model="debt.debt_month"
                        class="form-control"
                        placeholder="ระบุประจำเดือน"
                        tabindex="14"
                      >
                    </div>

                    <div class="form-group">
                      <label>ปีงบประมาณ (พ.ศ.) :</label>
                      <input
                        type="text"
                        id="debt_year"
                        name="debt_year"
                        v-model="debt.debt_year"
                        :class="{ 'form-control': true, 'is-invalid': submitted && errors.has('debt_year') }"
                        tabindex="16"
                        placeholder="ระบุปีงบประมาณ"
                        v-validate="{required: true, regex: /[0-9]{4}/}"
                      >
                      <div class="invalid-feedback" v-show="submitted && errors.has('debt_year')">
                        กรุณาระบุปีงบประมาณเป็นตัวเลข 4 หลัก
                      </div>
                    </div>
                  </div><!-- /.col-md-6 -->

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>วันที่รับเอกสาร :</label>
                      <date-picker
                        id="doc_receive"
                        name="doc_receive"
                        v-model="debt.doc_receive"
                        :language="dpLang.th"
                        :bootstrap-styling="true"
                        :format="'dd/MM/yyyy'"
                        v-validate="{required: true, date_format: 'dd/MM/yyyy'}"
                        placeholder="เลือกวันที่รับเอกสาร"
                      />
                      <span class="text-danger small" v-show="submitted && errors.has('doc_receive')">
                        {{ errors.first('doc_receive') }}
                      </span>
                    </div>

                    <div class="form-group">
                      <label>หมายเหตุ :</label>
                      <input
                        type="text"
                        id="debt_remark"
                        name="debt_remark"
                        v-model="debt.debt_remark"
                        class="form-control"
                        placeholder="ระบุหมายเหตุ"
                        tabindex="17"
                      >
                    </div>
                  </div><!-- /.col-md-6 -->
                </div>
              </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->

          </div><!-- /. modal-body -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" v-if="!editDebt.debt_id">บันทึก</button>
            <button type="submit" class="btn btn-warning" v-if="editDebt.debt_id">แก้ไข</button>
          </div><!-- /. modal-footer -->

        </b-form>

      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import DatePicker from 'vuejs-datepicker'
import {en, th} from 'vuejs-datepicker/dist/locale'
import { getDate } from '../../utils/date-func'

// Custom validator dict
const dict = {
  custom: {
    debt_date: {
      required: 'กรุณาระบุวันที่ลงบัญชี',
      date_format: 'กรุณาระบุวันที่ลงบัญชีในรูปแบบ dd/mm/yyyy'
    },
    debt_doc_recdate: {
      required: 'กรุณาระบุวันที่รับหนังสือ',
      date_format: 'กรุณาระบุวันที่รับหนังสือในรูปแบบ dd/mm/yyyy'
    },
    debt_doc_date: {
      date_format: 'กรุณาระบุวันที่หนังสือในรูปแบบ dd/mm/yyyy'
    },
    deliver_date: {
      required: 'กรุณาระบุวันที่ใบส่งของ/ใบกำกับภาษี',
      date_format: 'กรุณาระบุวันที่ใบส่งของ/ใบกำกับภาษีในรูปแบบ dd/mm/yyyy'
    },
    doc_receive: {
      required: 'กรุณาระบุวันที่รับเอกสาร',
      date_format: 'กรุณาระบุวันที่รับเอกสารในรูปแบบ dd/mm/yyyy'
    },
    debt_amount: {
      required: 'กรุณาระบุยอดหนี้',
      regex: 'กรุณาระบุยอดหนี้เป็นตัวเลข'
    },
    debt_vatrate: {
      required: 'กรุณาระบุอัตราภาษี (%)',
      regex: 'กรุณาระบุอัตราภาษี (%) เป็นตัวเลข'
    },
    debt_vat: {
      required: 'กรุณาระบุจำนวนภาษี',
      regex: 'กรุณาระบุจำนวนภาษีเป็นตัวเลข'
    },
    debt_total: {
      required: 'กรุณาระบุยอดหนี้สุทธิ',
      regex: 'กรุณาระบุยอดหนี้สุทธิป็นตัวเลข'
    }
  }
}

export default {
  name: 'DebtForm',
  components: {
    'date-picker': DatePicker
  },
  props: ['editDebt', 'supplierSelected'],
  data () {
    return {
      submitted: false,
      debt: {
        debt_date: '',
        debt_doc_no: '',
        debt_doc_date: '',
        debt_doc_recno: '',
        debt_doc_recdate: '',
        deliver_no: '',
        deliver_date: '',
        debt_type: '',
        debt_type_detail: '',
        supplier: '',
        supplier_name: '',
        debt_amount: 0.0,
        debt_vatrate: 7,
        debt_vat: 0.0,
        debt_total: 0.0,
        debt_month: '',
        debt_year: '',
        doc_receive: '',
        debt_remark: ''
      },
      dpLang: {
        en: en,
        th: th
      }
    }
  },
  created() {
    this.$store.dispatch('creditor/fetchAll')
    this.$store.dispatch('debttype/fetchAll')

    if(this.isEdition) {
      this.$store.dispatch('debt/fetchById', this.editId)
    }
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      currentUser: 'user/getUserProfile',
      suppliers: 'creditor/getAll',
      debttypes: 'debttype/getAll',
    })
  },
  watch: {
    editDebt: function () {
      this.debt = {
        debt_id: this.editDebt.debt_id,
        debt_date: this.editDebt.debt_date && new Date(this.editDebt.debt_date),
        debt_doc_no: this.editDebt.debt_doc_no,
        debt_doc_date: this.editDebt.debt_doc_date && new Date(this.editDebt.debt_doc_date),
        debt_doc_recno: this.editDebt.debt_doc_recno,
        debt_doc_recdate: this.editDebt.debt_doc_recdate && new Date(this.editDebt.debt_doc_recdate),
        deliver_no: this.editDebt.deliver_no,
        deliver_date: this.editDebt.deliver_date && new Date(this.editDebt.deliver_date),
        debt_type: this.editDebt.debt_type_id,
        debt_type_detail: this.editDebt.debt_type_detail,
        supplier: this.editDebt.supplier_id,
        supplier_name: this.editDebt.supplier_name,
        debt_amount: this.editDebt.debt_amount,
        debt_vatrate: this.editDebt.debt_vatrate,
        debt_vat: this.editDebt.debt_vat,
        debt_total: this.editDebt.debt_total,
        debt_month: this.editDebt.debt_month,
        debt_year: this.editDebt.debt_year,
        doc_receive: this.editDebt.doc_receive && new Date(this.editDebt.doc_receive),
        debt_remark: this.editDebt.debt_remark
      }
    },
    supplierSelected: function () {
      this.debt.supplier = this.supplierSelected.supplier_id
      this.debt.supplier_name = this.supplierSelected.supplier_name
    }
  },
  methods: {
    onSubmit: function (event) {
      this.submitted = true

      this.$validator.localize('en', dict)
      this.$validator.validateAll().then(valid => {
        if (valid) {
          this.debt.debt_date = this.debt.debt_date && getDate(this.debt.debt_date)
          this.debt.debt_doc_date = this.debt.debt_doc_date && getDate(this.debt.debt_doc_date)
          this.debt.debt_doc_recdate = this.debt.debt_doc_recdate && getDate(this.debt.debt_doc_recdate)
          this.debt.deliver_date = this.debt.deliver_date && getDate(this.debt.deliver_date)
          this.debt.doc_receive = this.debt.doc_receive && getDate(this.debt.doc_receive)

          this.debt.debt_creby = this.currentUser
          this.debt.debt_userid = this.currentUser
          console.log(this.debt)

          if (this.editDebt.debt_id) {
            console.log('Edition debt')
            this.$store.dispatch('debt/update', this.debt)
          } else {
            console.log('Insertion debt')
            this.$store.dispatch('debt/store', this.debt)
          }

          $(this.$refs.debtFormModal).modal('hide')

          this.$store.dispatch('debt/fetchAll', {
            supplierId: this.debt.supplier,
            startDate: 0,
            endDate: 0,
            showAll: 1,
            page: 1
          })

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
    clearData: function () {
      this.debt = {
        debt_date: '',
        debt_doc_no: '',
        debt_doc_date: '',
        debt_doc_recno: '',
        debt_doc_recdate: '',
        deliver_no: '',
        deliver_date: '',
        debt_type: '',
        debt_type_detail: '',
        supplier: '',
        supplier_name: '',
        debt_amount: 0.0,
        debt_vatrate: 7,
        debt_vat: 0.0,
        debt_total: 0.0,
        debt_month: '',
        debt_year: '',
        doc_receive: '',
        debt_remark: ''
      }

      this.$store.commit('debt/CLEAR_DEBT', {})
    },
    calculateTotal: function () {
      this.debt.debt_total = (parseFloat(this.debt.debt_amount) + parseFloat(this.debt.debt_vat)).toFixed(2)
    },
    calculateVat: function () {
      this.debt.debt_vat = ((parseFloat(this.debt.debt_amount) * parseFloat(this.debt.debt_vatrate)) / 100).toFixed(2)
    }
  }
}
</script>
