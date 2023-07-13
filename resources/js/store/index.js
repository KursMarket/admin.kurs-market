import {createStore} from 'vuex';
export default createStore({
   state: {
       categories: []
   },
   mutations: {
       SAVE_CATEGORY_IDS(state, payload) {
           state.categories.map((c, i) => {
               if (c.index === payload.index) {
                   state.categories.splice(i, 1)
               }
           });
           state.categories.push(payload);
       },
       REMOVE_CATEGORY_ID(state, payload) {
           state.categories = state.categories.filter(c => c.index !== payload.index);
       }
   },
   actions: {
       saveCategory({ commit }, payload) {
           commit('SAVE_CATEGORY_IDS', payload)
       },
       removeCategory({ commit }, payload) {
           commit('REMOVE_CATEGORY_ID', payload)
       }
   },
   getters: {
       getStateCategories(state) {
           return state.categories
       },
       getStateCategoriesLength(state) {
           return state.categories.length;
       }
   },
   modules: {}
});
