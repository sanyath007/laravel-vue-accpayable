<template>
  <div
    class="modal fade"
    id="debttypeFormModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="myModalLabel"
  >
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <b-form @submit.prevent="onSubmit($event)">

          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">
              แบบบันทึกรายการประเภทหนี้
              <span v-if="editDebttype.debt_type_id">[ID: {{editDebttype.debt_type_id}}]</span>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clearData">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <input type="hidden" id="user" name="user" value="">

              <div class="row">
                <div class="col-md-12">

                  <div class="form-group">
                    <label class="control-label">ประเภทหนี้ :</label>
                    <input
                      id="debt_type_name"
                      name="debt_type_name"
                      v-model="debttype.debt_type_name"
                      v-validate="{required: true}"
                      :class="{'form-control': true, 'is-invalid': submitted && errors.has('debt_type_name')}"
                    />
                    <span class="text-danger small" v-show="submitted && errors.has('debt_type_name')">
                      กรุณาระบุประเภทหนี้
                    </span>
                  </div>

                  <div class="form-group">
                    <label>ประเภท :</label>
                    <select
                      id="debt_cate_id"
                      name="debt_cate_id"
                      v-model="debttype.debt_cate"
                      v-validate="{required: true}"
                      :class="{'form-control': true, 'is-invalid': submitted && errors.has('debt_cate_id')}"
                    >
                      <option value="">--กรุณาเลือก--</option>
                      <option v-for="cate in cates" :key="cate.debt_cate_id" :value="cate.debt_cate_id">
                        {{ cate.debt_cate_name }}
                      </option>
                    </select>
                    <span class="text-danger small" v-show="submitted && errors.has('debt_cate_id')">
                      กรุณาเลือกประเภท
                    </span>
                  </div>

                </div><!-- /.col -->
              </div><!-- /.row -->

          </div><!-- /. modal-body -->

          <div class="modal-footer">
            <button type="submit" class="btn btn-primary" v-if="!editDebttype.debt_type_id">บันทึก</button>
            <button type="submit" class="btn btn-warning" v-if="editDebttype.debt_type_id">แก้ไข</button>
          </div><!-- /. modal-footer -->

        </b-form>

      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'DebttypeForm',
  props: ['editDebttype'],
  data () {
    return {
      cates: [],
      debttype: {
        debt_type_name: '',
        debt_cate: '',
        debt_cate_name: '',
        debt_type_status: '1'
      },
      submitted: false
    }
  },
  mounted () {
    this.submitted = false
    this.onInitForm()
  },
  computed: {
    ...mapGetters({
      token: 'user/getToken'
    })
  },
  watch: {
    editDebttype: function () {
      this.debttype = {
        debt_type_id: this.editDebttype.debt_type_id,
        debt_type_name: this.editDebttype.debt_type_name,
        debt_cate: this.editDebttype.debt_cate_id,
        debt_cate_name: this.editDebttype.debt_cate_name,
        debt_type_status: this.editDebttype.debt_type_status
      }
    }
  },
  methods: {
    onInitForm () {
      this.$http.get('/debttypes/add')
        .then(res => {
          console.log(res.data)
          this.cates = res.data.cates
        })
        .catch(err => {
          console.log(err)
        })
    },
    onSubmit: function (event) {
      this.submitted = true

      if (this.editDebttype.debt_type_id) {
        console.log('This edition data')
      } else {
        console.log('This insertion data')
      }

      this.$validator.validateAll().then(valid => {
        if (valid) {
          if (this.editDebttype.debt_type_id) {
            this.updateData()
          } else {
            this.storeData()
          }

          $(this.$refs.debttypeFormModal).modal('hide')
        } else {
          this.$bvToast.toast(`คุณกรอกข้อมูลยังไม่ครบ !!`, {
            title: 'Warning',
            variant: 'warning',
            autoHideDelay: 2000
          })
        }
      })
    },
    storeData: function () {
      this.$http.post('/debttypes/store', this.debttype)
        .then(res => {
          console.log(res)

          this.$bvToast.toast(`Successful !!`, {
            title: 'Info',
            variant: 'success',
            autoHideDelay: 2000
          })

          this.$store.dispatch('creditor/fetchAll', { searchKey: '0', page: 1 })
        })
        .catch(err => {
          console.log(err)

          this.$bvToast.toast(`Error ${err}`, {
            title: 'Error',
            variant: 'danger',
            autoHideDelay: 2000
          })
        })

      this.clearData() // Clear data from control
    },
    updateData: function () {
      this.$http.put('/debttypes/update', this.debttype)
        .then(res => {
          console.log(res)

          this.$bvToast.toast(`Successful !!`, {
            title: 'Info',
            variant: 'success',
            autoHideDelay: 2000
          })

          this.$store.dispatch('creditor/fetchAll', { searchKey: '0', page: 1 })
        })
        .catch(err => {
          console.log(err)

          this.$bvToast.toast(`Error ${err}`, {
            title: 'Error',
            variant: 'danger',
            autoHideDelay: 2000
          })
        })

      this.clearData() // Clear data from control
    },
    clearData: function () {
      this.debttype = {
        debt_type_name: '',
        debt_cate: '',
        debt_cate_name: '',
        debt_type_status: ''
      }

      this.$store.commit('debttype/CLEAR_DEBTTYPE', {})
    }
  }
}
</script>
