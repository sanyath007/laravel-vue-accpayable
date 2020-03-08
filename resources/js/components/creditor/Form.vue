<template>
  <div
    class="modal fade"
    id="creditorFormModal"
    ref="creditorFormModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <b-form @submit.prevent="onSubmit($event)">

          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">แบบบันทึกเจ้าหนี้
              <span v-if="creditor.supplier_id">[ID: {{ creditor.supplier_id }}]</span>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clearData">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <input type="hidden" id="user" name="user" value="">
            <nav>
              <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">ข้อมูลทั่วไป</a>
                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">ข้อมูลเพิ่มเติม</a>
              </div>
            </nav>

            <div class="tab-content" id="nav-tabContent">
              <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                <div class="row mt-2">
                  <div class="col-md-6">

                    <div class="form-group">
                      <label class="control-label">คำนำหน้า :</label>
                      <select
                        id="prefix_id"
                        name="prefix_id"
                        v-model="creditor.prefix"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('prefix_id')}"
                      >
                        <option value="">--กรุณาเลือก--</option>
                        <option
                          v-for="prefix in prefixes"
                          :value="prefix.prename_id"
                          :key="prefix.prename_id"
                        >
                          {{ prefix.prename_name }}
                        </option>
                      </select>
                      <span class="text-danger small" v-show="submitted && errors.has('prefix_id')">
                        กรุณาเลือกคำนำหน้า
                      </span>
                    </div>

                    <div class="form-group">
                      <label>ที่อยู่เลขที่ :</label>
                      <input
                        type="text"
                        id="supplier_address1"
                        name="supplier_address1"
                        v-model="creditor.supplier_address1"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_address1')}"
                        placeholder="ระบุชื่อเจ้าหนี้ก่อน"
                        tabindex="3"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_address1')">
                        กรุณาระบุที่อยู่เลขที่
                      </div>
                    </div>

                    <div class="form-group">
                      <label>ที่อยู่ (จ.) :</label>
                      <input
                        type="text"
                        id="supplier_address3"
                        name="supplier_address3"
                        v-model="creditor.supplier_address3"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_address3')}"
                        placeholder="ระบุที่อยู่ (จ.)"
                        tabindex="5"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_address3')">
                        กรุณาระบุที่อยู่ (จ.)
                      </div>
                    </div>

                    <div class="form-group">
                      <label>โทรศัพท์ :</label>
                      <input
                        type="text"
                        id="supplier_phone"
                        name="supplier_phone"
                        v-model="creditor.supplier_phone"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_phone')}"
                        placeholder="ระบุเบอร์โทรศัพท์"
                        tabindex="7"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_phone')">
                        กรุณาระบุเบอร์โทรศัพท์
                      </div>
                    </div>

                    <div class="form-group">
                      <label>E-mail :</label>
                      <input
                        type="text"
                        id="supplier_email"
                        name="supplier_email"
                        v-model="creditor.supplier_email"
                        v-validate="'email'"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_email')}"
                        placeholder="ระบุที่อยู่ E-mail"
                        tabindex="9"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_email')">
                        {{ errors.first('supplier_email')}}
                      </div>
                    </div>

                  </div><!-- /.col -->

                  <div class="col-md-6">
                    <div class="form-group">
                      <label>ชื่อเจ้าหนี้ :</label>
                      <input
                        id="supplier_name"
                        name="supplier_name"
                        v-model="creditor.supplier_name"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_name')}"
                        placeholder="ระบุชื่อเจ้าหนี้"
                        class="form-control"
                        tabindex="2"
                      />
                      <span class="text-danger small" v-show="submitted && errors.has('supplier_name')">
                        กรุณาระบุชื่อเจ้าหนี้ก่อน
                      </span>
                    </div>

                    <div class="form-group">
                      <label>ที่อยู่ (ต.และ อ.) :</label>
                      <input
                        type="text"
                        id="supplier_address2"
                        name="supplier_address2"
                        v-model="creditor.supplier_address2"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_address2')}"
                        placeholder="ระบุที่อยู่ (ต.และ อ.)"
                        tabindex="4"
                      />
                      <span class="text-danger small" v-show="submitted && errors.has('supplier_address2')">
                        กรุณาระบุที่อยู่ (ต.และ อ.)
                      </span>
                    </div>

                    <div class="form-group">
                      <label>รหัสไปรษณีย์ :</label>
                      <input
                        id="supplier_zipcode"
                        name="supplier_zipcode"
                        v-model="creditor.supplier_zipcode"
                        v-validate="'required|numeric|min:5'"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_zipcode')}"
                        placeholder="ระบุรหัสไปรษณีย์"
                        tabindex="6"
                      />
                      <span class="text-danger small" v-show="submitted && errors.has('supplier_zipcode')">
                        {{ errors.first('supplier_zipcode')}}
                      </span>
                    </div>

                    <div class="form-group">
                      <label>แฟกซ์ :</label>
                      <input
                        id="supplier_fax"
                        name="supplier_fax"
                        v-model="creditor.supplier_fax"
                        placeholder="ระบุแฟกซ์"
                        class="form-control"
                        tabindex="8"
                      />
                    </div>

                  </div><!-- /.col -->
                </div><!-- /.row -->
              </div><!-- /.tab-pane -->

              <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row mt-2">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>เครดิต (วัน) :</label>
                      <input
                        type="text"
                        id="supplier_credit"
                        name="supplier_credit"
                        v-model="creditor.supplier_credit"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_credit')}"
                        v-validate="'numeric'"
                        placeholder="ระบุเครดิต (วัน)"
                        tabindex="10"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_credit')">
                        {{ errors.first('supplier_credit')}}
                      </div>
                    </div>

                    <div class="form-group">
                      <label>อัตราภาษีที่หัก (%) :</label>
                      <input
                        type="text"
                        id="supplier_taxrate"
                        name="supplier_taxrate"
                        v-model="creditor.supplier_taxrate"
                        v-validate="'numeric'"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_taxrate')}"
                        placeholder="ระบุอัตราภาษีที่หัก (%)"
                        tabindex="12"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_taxrate')">
                        กรุณาระบุอัตราภาษีที่หัก (%) เป็นตัวเลขจำนวนเต็ม
                      </div>
                    </div>

                    <div class="form-group">
                      <label>ชื่อผู้ติดต่อ :</label>
                      <input
                        type="text"
                        id="supplier_agent_name"
                        name="supplier_agent_name"
                        v-model="creditor.supplier_agent_name"
                        :class="{'form-control': true}"
                        placeholder="ระบุชื่อผู้ติดต่อ"
                        tabindex="14"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_agent_name')">
                        กรุณาระบุชื่อผู้ติดต่อ
                      </div>
                    </div>

                    <div class="form-group">
                      <label>อีเมล์ผู้ติดต่อ :</label>
                      <input
                        type="text"
                        id="supplier_agent_email"
                        name="supplier_agent_email"
                        v-model="creditor.supplier_agent_email"
                        v-validate="'email'"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_agent_email')}"
                        placeholder="ระบุอีเมล์ผู้ติดต่อ"
                        tabindex="16"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_agent_email')">
                        กรุณาระบุรูปแบบอีเมล์ผู้ให้ถูกต้อง
                      </div>
                    </div>

                  </div><!-- /.col-md-6 -->

                  <div class="col-md-6">

                    <div class="form-group">
                      <label>เลขที่ประจำตัวผู้เสียภาษี :</label>
                      <input
                        type="text"
                        id="supplier_taxid"
                        name="supplier_taxid"
                        v-model="creditor.supplier_taxid"
                        v-validate="{required: true}"
                        :class="{'form-control': true, 'is-invalid': submitted && errors.has('supplier_taxid')}"
                        placeholder="ระบุเลขที่ประจำตัวผู้เสียภาษี"
                        tabindex="11"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_taxid')">
                        กรุณาระบุเลขที่ประจำตัวผู้เสียภาษีก่อน
                      </div>
                    </div>

                    <div class="form-group">
                      <label>เลขที่บัญชี :</label>
                      <input
                        id="supplier_back_acc"
                        name="supplier_back_acc"
                        v-model="creditor.supplier_back_acc"
                        placeholder="ระบุวันที่เลขที่บัญชี"
                        class="form-control"
                        tabindex="13"
                      />
                      <div class="invalid-feedback" v-show="submitted && errors.has('supplier_back_acc')">
                        กรุณาระบุเลขที่บัญชี
                      </div>
                    </div>

                    <div class="form-group">
                      <label>โทรศัพท์ผู้ติดต่อ :</label>
                      <input
                        id="supplier_agent_contact"
                        name="supplier_agent_contact"
                        v-model="creditor.supplier_agent_contact"
                        placeholder="ระบุโทรศัพท์ผู้ติดต่อ"
                        class="form-control"
                        tabindex="15"
                      />
                    </div>

                    <div class="form-group">
                      <label>หมายเหตุ :</label>
                      <textarea
                        id="supplier_note"
                        name="supplier_note"
                        v-model="creditor.supplier_note"
                        placeholder="ระบุหมายเหตุ"
                        class="form-control"
                        tabindex="17"
                      ></textarea>
                    </div>

                  </div><!-- /.col-md-6 -->

                </div><!-- /.row -->

              </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->

          </div><!-- /. modal-body -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" v-if="!creditor.supplier_id">บันทึก</button>
            <button type="submit" class="btn btn-warning" v-if="creditor.supplier_id">แก้ไข</button>
          </div><!-- /. modal-footer -->

        </b-form>

      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

const dict = {
  custom: {
    supplier_email: {
      required: 'กรุณาระบุที่อยู่ E-mail ก่อน',
      email: 'กรุณาระบุรูปแบบอีเมล์ให้ถูกต้อง'
    },
    supplier_zipcode: {
      required: 'กรุณาระบุรหัสไปรษณีย์',
      numeric: 'กรุณาระบุรหัสไปรษณีย์เป็นตัวเลข',
      min: 'รหัสไปรษณีย์เป็นตัวเลข 5 หลัก'
    },
    supplier_credit: {
      required: 'กรุณาระบุเครดิต (วัน) ก่อน',
      numeric: 'กรุณาระบุเครดิต (วัน) เป็นตัวเลขจำนวนเต็ม'
    }
  }
}

export default {
  name: 'CreditorForm',
  props: ['editCreditor'],
  data () {
    return {
      submitted: false,
      creditor: {
        prefix: '',
        supplier_name: '',
        supplier_address1: '',
        supplier_address2: '',
        supplier_address3: '',
        supplier_zipcode: '',
        supplier_phone: '',
        supplier_fax: '',
        supplier_email: '',
        supplier_taxid: '',
        supplier_back_acc: '',
        supplier_note: '',
        supplier_credit: '',
        supplier_taxrate: '',
        supplier_agent_name: '',
        supplier_agent_email: '',
        supplier_agent_contact: ''
      }
    }
  },
  mounted () {
    this.submitted = false
    
    this.$store.dispatch('creditor/fetchPrefixes')
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken',
      prefixes: 'creditor/getPrefixes'
    })
  },
  watch: {
    editCreditor: function (newVal, oldVal) {
      this.creditor = {
        supplier_id: newVal.supplier_id,
        prefix: newVal.prename_id || '',
        supplier_name: newVal.supplier_name,
        supplier_address1: newVal.supplier_address1,
        supplier_address2: newVal.supplier_address2,
        supplier_address3: newVal.supplier_address3,
        supplier_zipcode: newVal.supplier_zipcode,
        supplier_phone: newVal.supplier_phone,
        supplier_fax: newVal.supplier_fax,
        supplier_email: newVal.supplier_email,
        supplier_taxid: newVal.supplier_taxid,
        supplier_back_acc: newVal.supplier_back_acc,
        supplier_note: newVal.supplier_note,
        supplier_credit: newVal.supplier_credit,
        supplier_taxrate: newVal.supplier_taxrate,
        supplier_agent_name: newVal.supplier_agent_name,
        supplier_agent_email: newVal.supplier_agent_email,
        supplier_agent_contact: newVal.supplier_agent_contact
      }
    }
  },
  methods: {
    onSubmit: function (event) {
      this.submitted = true

      this.$validator.localize('en', dict)
      this.$validator.validateAll().then(valid => {
        if (valid) {
          if (this.editCreditor.supplier_id) {
            console.log('This edition data')
            this.$store.dispatch('creditor/update', this.creditor)
          } else {
            console.log('This insertion data')
            this.$store.dispatch('creditor/store', this.creditor)
          }

          // this.$store.dispatch('creditor/fetchAllWithPagination', { searchKey: '0', page: 1 })
        
          /** Clear data from control */
          this.clearData()

          $(this.$refs.creditorFormModal).modal('hide')
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
      this.$validator.reset()

      this.creditor = {
        prefix: '',
        supplier_name: '',
        supplier_address1: '',
        supplier_address2: '',
        supplier_address3: '',
        supplier_zipcode: '',
        supplier_phone: '',
        supplier_fax: '',
        supplier_email: '',
        supplier_taxid: '',
        supplier_back_acc: '',
        supplier_note: '',
        supplier_credit: '',
        supplier_taxrate: '',
        supplier_agent_name: '',
        supplier_agent_email: '',
        supplier_agent_contact: ''
      }

      this.$store.commit('creditor/CLEAR_CREDITOR', {})
    }
  }
}
</script>
