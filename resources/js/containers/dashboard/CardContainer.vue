<template>
  <div class="row mt-3">

    <card :title="'เจ้าหนี้'" :data="supplierCount" />

    <card :title="'ยอดหนี้คงเหลือ'" :data="balance" />

    <card :title="'ยอดเคดิต'" :data="creditSum" />

    <card :title="'ยอดเดบิต'" :data="debitSum" />

  </div>
</template>

<script>
import Card from '../../components/dashboard/Card'

export default {
  name: 'CardContainer',
  components: {
    'card': Card
  },
  data() {
    return {
      supplierCount: 933,
      debitSum: 925632795.93,
      creditSum: 55297959.03,
      balance: 8373859.21
    }
  }
}
</script>