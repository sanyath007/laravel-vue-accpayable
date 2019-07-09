<template>
  <div class="container">
    <h1>Debt page</h1>
    <select v-model="supplierSelected" @change="getDebts($event)" class="form-control">
      <option :value="supplier.supplier_id" v-for="supplier in suppliers" :key="supplier.supplier_id">
        {{supplier.supplier_name}}
      </option>
    </select>

    <debt-list :debts="debts" />
  </div>
</template>

<script>
import DebtList from "./DebtList";

export default {
  name: "Debt",
  components: {
    'debt-list': DebtList,
  },
  data() {
    return {
      debts: [],
      suppliers: [],
      supplierSelected: '',
    };
  },
  mounted() {
    this.debts = this.onInit();
  },
  methods: {
    onInit() {
      axios
        .get("/debt/list")
        .then(res => {
          console.log(res);
          this.suppliers = res.data.suppliers
        })
        .catch(err => {
          console.log(err);
        });
    },
    getDebts(event) {
      console.log('debt/rpt/' +this.supplierSelected+ '/0/0/1')
      axios
        .get('debt/rpt/' +this.supplierSelected+ '/0/0/1')
        .then(res => {
          console.log(res);
          this.debts = res.data.debts.data
        })
        .catch(err => {
          console.log(err);
        });
    }
  }
};
</script>

