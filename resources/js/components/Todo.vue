<template>
  <li class="todo" :class="{ completed: todo.completed }">
    <div class="view">
      <input type="checkbox" v-model="todo.completed" class="toggle">
      <label for="">{{ todo.title }}</label>
      <button @click="removeTodo(todo)">Remove</button>
    </div>
  </li>
</template>

<script>
  export default {
    name: 'Todo',
    props: ["todo"],
    methods: {
      removeTodo(todo) {
        this.$store.commit("CACHE_REMOVED", todo)
        this.$store.dispatch("DELETE_TODO", todo)
        this.$store.dispatch("GET_TODOS")
      }
    }
  }
</script>

