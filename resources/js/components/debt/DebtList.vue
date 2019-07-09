<template>
  <table class="table table-striped table-bordered">
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
      <th style="width: 8%; text-align: center;">Actions</th>
    </tr>
    <tr v-for="debt in debts" :key="debt.debt_id">
      <td style="text-align: center;">{{ 1 }}</td>
      <td style="text-align: center;">{{ debt.debt_id }}</td>
      <td style="text-align: center;">{{ debt.debt_date }}</td>
      <td style="text-align: center;">{{ debt.deliver_no }}</td>
      <td style="text-align: center;">{{ debt.deliver_date }}</td>
      <!-- <td style="text-align: left;">{{ debt.supplier_name }}</td> -->
      <td style="text-align: left;">{{ debt.debttype.debt_type_name }}</td>
      <td style="text-align: right;">{{ debt.debt_amount }}</td>
      <td style="text-align: right;">{{ debt.debt_vat }}</td>
      <td style="text-align: right;">{{ debt.debt_total }}</td>
      <td style="text-align: center;">
        <span class="label label-info" v-show="debt.debt_status!=0">
          {{ (debt.debt_status==1) ? 'ขออนุมัติ' :
          (debt.debt_status==2) ? 'ชำระเงินแล้ว' :
          (debt.debt_status==3) ? 'ยกเลิก' : 'รอดำเนินการ' }}
        </span>
      </td>
      <td style="text-align: center;">
        <!-- <a
          @click="setzero(debt.debt_id)"
          v-show="(debt.debt_status==0)"
          class="btn btn-primary btn-xs"
          title="ลดหนี้ศูนย์"
        > -->
          <i class="fa fa-credit-card"></i>
        <!-- </a> -->
        <!-- <a
          @click="edit(debt.debt_id)"
          v-show="(debt.debt_status==0)"
          class="btn btn-warning btn-xs"
          title="แก้ไขรายการ"
        > -->
          <i class="fa fa-edit"></i>
        <!-- </a> -->
        <!-- <a
          @click="delete(debt.debt_id)"
          v-show="(debt.debt_status==0)"
          class="btn btn-danger btn-xs"
          title="ลบรายการ"
        > -->
          <i class="fa fa-trash"></i>
        <!-- </a> -->
      </td>
    </tr>
  </table>
</template>

<script>
export default {
  name: "DebtList",
  props: ["debts"]
};
</script>

