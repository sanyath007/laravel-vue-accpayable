<template>
  <div class="row">
    <div class="col-12">
      <div class="jumbotron">
        <h1>Home page</h1>

        <new-todo></new-todo>
        <todo-list></todo-list>
      </div>
    </div>
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import todoList from '../todo/TodoList'
  import newTodo from '../todo/NewTodo'
  
  export default {
    name: 'Home',
    components: {
      newTodo,
      todoList,
    },
    computed: {
      ...mapGetters({
        newTodo: "task/newTodo", 
        toRemove: "task/toRemove"
      })
    },
    mounted() {
      this.$store.dispatch('page/setCurrentPage', this.$route.name)
      
      window.Echo.channel('newTask').listen(".task-created", e => {
        this.$store.commit("ADD_TODO", e.task)
        this.newTodo.title = ''
      })

      window.Echo.channel('taskRemoved').listen(".task-removed", e => {
        this.$store.commit("DELETE_TODO", this.toRemove)
      })
    },
    methods: {

    }
  }
</script>
