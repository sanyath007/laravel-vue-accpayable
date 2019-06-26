import actions from './actions'
import getters from './getters'
import mutations from './mutations'

const state = {
  todos: [], 
  toRemove: null,
  newTodo: {
    title: '',
    completed: false,
  }
}

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};