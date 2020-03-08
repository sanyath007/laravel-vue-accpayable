<template>
  <div class="card">
    <div class="card-body">
      <div class="fo">
        <label for="">{{ searchLabel }} :</label>
        <input
          id="searchKey"
          name="searchKey"
          v-model="searchKey"
          @keyup="onKeyup"
          class="form-control"
          :placeholder="inputPlaceholder"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'SearchKeyword',
  props: ['searchLabel', 'inputPlaceholder'],
  data() {
    return {
      searchKey: '',
      page: 1
    }
  },
  methods: {
    onKeyup() {
      this.$emit('handleKeyEvent', { searchKey: this.searchKey, page: this.page })
    }
  },
}
</script>