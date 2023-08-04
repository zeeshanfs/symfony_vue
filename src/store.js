import { createStore } from 'vuex'
import {  inject } from 'vue'

const store = createStore({
  state: {
    prodcuts: [],
  },
  mutations: {
    SET_PRODUCTS(state, products) {
        state.products = products;
      },
  },
  actions: {
    async fetchProducts({ commit }) {
      const globalAPI= inject('globalAPI');
        try {
          const response = await fetch(`${globalAPI.baseURL}api/products`);
          const data = await response.json();
          commit('SET_PRODUCTS', data);
        } catch (error) {
          console.error('Error fetching users:', error);
        }
      },
  },
  getters: {
    getProducts: state => {
      return state.products;
    },
  },
});

export default store;
