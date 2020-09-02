<template>
  <v-menu
    ref="menu"
    v-model="menu"
    :close-on-content-click="true"
    transition="scale-transition"
    offset-y
    min-width="290px"
  >
    <template v-slot:activator="{ on, attrs }">
      <v-text-field
        v-model="value"
        :label="label"
        prepend-icon="event"
        readonly
        v-bind="attrs"
        v-on="on"
        :rules="rules"
      />
    </template>
    <v-date-picker v-model="date" no-title @input="menu = false" scrollable locale="th" />
  </v-menu>
</template>

<script>
export default {
  name: 'DatePicker',
  props: {
    dataModel: {
      type: String
    },
    inputDate: {
      type: String
    },
    label: {
      type: String
    },
    rules: {
        type: Array,
        required: false
    }
  },
  data() {
    return {
      value: '',
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false
    }
  },
  mounted: {

  },
  watch: {
    date (val) {
      this.value = this.formatDate(val)
      this.setData(this.value)
    }
  },
  methods: {
    formatDate (date) {
      if (!date) return null

      const [year, month, day] = date.split('-')
      return `${day}/${month}/${parseInt(year)+543}`
    },
    setData (date) {
      this.$emit("inputDate", date, this.dataModel)
    }
  }
}
</script>