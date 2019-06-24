<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <new-todo></new-todo>
        <todo-list></todo-list>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import todoList from './TodoList'
  import newTodo from './NewTodo'

  export default {
    name: 'App',
    props: [],
    components: {
      newTodo,
      todoList,
    },
    computed: {
      ...mapGetters(["newTodo", "toRemove"])
    },
    mounted() {
      console.log('Component mounted.')
      window.Echo.channel('newTask').listen(".task-created", e => {
        this.$store.commit("ADD_TODO", e.task)
        this.newTodo.title = ''
      })

      window.Echo.channel('taskRemoved').listen(".task-removed", e => {
        this.$store.commit("DELETE_TODO", this.toRemove)
      })
    }
  }
</script>
