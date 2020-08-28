<template>
  <v-breadcrumbs :items="items">
    <template v-slot:item="{ item }">
      <v-breadcrumbs-item
        :href="item.href"
        :disabled="item.disabled"
      >
        {{ item.text }}
      </v-breadcrumbs-item>
    </template>
  </v-breadcrumbs>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  name: 'Breadcrumb',
  props: ['pageTitle'],
  data () {
    return {
      items: [
        {
          text: 'Home',
          disabled: false,
          href: 'breadcrumbs_dashboard',
        },
      ]
    }
  },
  mounted () {
    this.items.push({
      text: this.pageTitle,
      disabled: true,
      href: 'breadcrumbs_dashboard',
    })
  },
  computed: {
    ...mapGetters({
      currentPage: 'page/getCurrentPage'
    })
  }
}
</script>
