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
        label="label"
        prepend-icon="event"
        readonly
        v-bind="attrs"
        v-on="on"
      />
    </template>
    <v-date-picker v-model="date" no-title @input="menu = false" scrollable locale="th" />
  </v-menu>
</template>

<script>
export default {
  name: 'DatePicker2',
  props: ['dataModel', 'label'],
  data() {
    return {
      value: '',
      date: new Date().toISOString().substr(0, 10),
      menu: false,
      modal: false
    }
  },
  watch: {
    date (val) {
      console.log(val);
      this.value = val
    }
  },
}
</script>