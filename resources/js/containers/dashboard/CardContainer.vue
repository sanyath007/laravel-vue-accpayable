<template>
  <div class="row mt-3">

    <card :title="'เจ้าหนี้'" :data="creditors.length" />

    <card :title="'ยอดหนี้คงเหลือ'" :data="balance" />

    <card :title="'ยอดเคดิต'" :data="sumCredit" />

    <card :title="'ยอดเดบิต'" :data="sumDebit" />

  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Card from '../../components/dashboard/Card'

export default {
  name: 'CardContainer',
  components: {
    'card': Card
  },
  created() {
    this.$store.dispatch('creditor/fetchAll')
    this.$store.dispatch('debt/fetchBalance')
    this.$store.dispatch('debt/fetchSumCredit')
    this.$store.dispatch('debt/fetchSumDebit')
  },
  computed: {
    ...mapGetters({
      creditors: 'creditor/getAll',
      sumDebit: 'debt/getSumDebit',
      sumCredit: 'debt/getSumCredit',
      balance: 'debt/getBalance'
    })
  },
  data() {
    return {}
  }
}
</script>