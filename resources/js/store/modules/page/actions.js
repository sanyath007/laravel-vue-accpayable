import axios from "axios";

export default {
  setCurrentPage: ({ commit }, routeName) => {
    commit('SET_CURRENT_PAGE', routeName)
  },
}
