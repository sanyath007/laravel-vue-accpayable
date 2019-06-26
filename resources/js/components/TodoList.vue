<template>
  <ul>
    <todo v-for="todo in todos" :todo="todo" :key="todo.id" />
  </ul>
</template>

<script>
  import { mapGetters } from 'vuex'
  import todo from './Todo'

  export default {
    name: 'TodoList',
    components: {
      todo
    },
    mounted() {
      this.$store.dispatch("task/GET_TODOS")
    },
    computed: {
      ...mapGetters({
        todos: "task/todos"
      })
    }
  }
</script>

