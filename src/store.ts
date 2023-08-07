import { createStore } from 'vuex'
import {  inject } from 'vue'

const store = createStore({
  state: {
    products: [],
    categories: [],
  },
  mutations: {
    SET_PRODUCTS(state, products) {
      state.products = products;
    },
    SET_CATEGORIES(state, categories) {
      state.categories = categories;
    },
  },
  actions: {
    async fetchProducts({ commit }) {
      const globalAPI: { baseURL: string; } | undefined = inject('globalAPI');
        try {
          const response = await fetch(`${globalAPI!.baseURL}api/products`);
          const data = await response.json();
          commit('SET_PRODUCTS', data);
        } catch (error) {
          console.error('Error fetching users:', error);
        }
    },
    async fetchCategories({ commit }) {
      const globalAPI: { baseURL: string; } | undefined = inject('globalAPI');
        try {
          const response = await fetch(`${globalAPI!.baseURL}api/category`);
          const data = await response.json();
          commit('SET_CATEGORIES', data);
        } catch (error) {
          console.error('Error fetching users:', error);
        }
    },
  },
  getters: {
    getProducts: state => {
      return state.products;
    },
    getCategories: state => {
      return state.categories;
    },
  },
});

export default store;
