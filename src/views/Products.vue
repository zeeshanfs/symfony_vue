<script setup lang="ts">
import { ref, inject, computed, onMounted } from 'vue'
import { useStore } from 'vuex'

const store = useStore();

const globalAPI: { baseURL: string; } | undefined = inject('globalAPI');
const currentPage = ref(1)
const itemsPerPage = ref(6); 

const fetchUsers = () => {
  store.dispatch('fetchProducts');
};

onMounted(() => {
  fetchUsers(); 
});

const productData = computed(() => store.getters.getProducts);
const totalproducts = computed<number>(() => productData.value?.length);

const totalPages = computed(() => {
  return Math.ceil((productData.value?.length ?? 0) / itemsPerPage.value);
});

const paginatedProducts = computed(() => {
  const startIndex = (currentPage.value - 1) * itemsPerPage.value;
  const endIndex = startIndex + itemsPerPage.value;
  return productData.value?.slice(startIndex, endIndex);
});

const previousPage = () => {
  if (currentPage.value > 1) {
    currentPage.value--;
  }
};

const nextPage = () => {
  if (currentPage.value < Math.ceil(productData.value?.length / itemsPerPage.value)) {
    currentPage.value++;
  }
};

const selectPage = (Page:number) => {
  currentPage.value = Page;
}

const selectlimit = (event: Event) => {
  const LimitInput = event.target as HTMLInputElement;
  const limit = parseFloat(LimitInput.value);
  itemsPerPage.value = limit 
}

</script>
<template>
  <h3 class="text-3xl font-semibold text-gray-700">
    Prodcuts
  </h3>
  <div class="flex flex-col mt-3 sm:flex-row">
    <div class="flex">
      <div class="relative">
        <select
          @change="selectlimit"
          class="block w-full h-full px-4 py-2 pr-8 leading-tight text-gray-700 bg-white border border-gray-400 rounded-l appearance-none focus:outline-none focus:bg-white focus:border-gray-500">
          <option value="6">6</option>
          <option value="12">12</option>
          <option value="18">18</option>
        </select>

        <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
          <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
          </svg>
        </div>
      </div>

      <div class="relative">
        <div class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
          <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
          </svg>
        </div>
      </div>
    </div>

    <div class="relative block mt-2 sm:mt-0">
      <span class="absolute inset-y-0 left-0 flex items-center pl-2">
        <svg viewBox="0 0 24 24" class="w-4 h-4 text-gray-500 fill-current">
          <path
            d="M10 4a6 6 0 100 12 6 6 0 000-12zm-8 6a8 8 0 1114.32 4.906l5.387 5.387a1 1 0 01-1.414 1.414l-5.387-5.387A8 8 0 012 10z" />
        </svg>
      </span>

      <input placeholder="Search"
        class="block w-full py-2 pl-8 pr-6 text-sm text-gray-700 placeholder-gray-400 bg-white border border-b border-gray-400 rounded-l rounded-r appearance-none sm:rounded-l-none focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none">
    </div>

    <div class="flex total_product">
      <span class="text-xs text-gray-900 xs:text-sm">Showing {{currentPage }} to {{ totalPages }} of {{ totalproducts }} Entries</span>
    </div>
  </div>

  <div class="grid grid-cols-12 gap-6">
    <div class="mt-4 mb-3 sm:col-span-6 xl:col-span-4" v-for="(item, index) in paginatedProducts" :key="index">
      <div class="mt-6 overflow-hidden bg-white rounded shadow-lg">
        <img
          class="w-full"
          :src="`${globalAPI!.baseURL}uploads/${item.image}`"
          :alt="`${item.image}`"
        >
        <div class="px-6 py-4">
          <div class="mb-2 text-xl font-bold text-gray-900">
            {{ item.name }}
          </div>
          <p class="text-base text-gray-700">
            {{ item.description }}
          </p>
        </div>
        <div class="px-6 pt-4 pb-2">
          <span
            class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full"
          >#{{ item.category }}</span>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-8">
    <div class="mt-4">
      <div class="flex px-4 py-4 overflow-x-auto bg-white rounded-md">
        <div class="flex mr-4 rounded" style="margin: 0 auto;">
          <button
            class="px-3 py-2 ml-0 leading-tight text-indigo-700 bg-white border border-r-0 border-gray-200 rounded-l hover:bg-indigo-500 hover:text-white"
            @click="previousPage" :disabled="currentPage === 1">
            Previous
          </button>

          <a v-for="(item) in totalPages" @click="selectPage(item)"
            :class="item ==  currentPage ? 'active' : ''"
            class="px-3 py-2 leading-tight text-indigo-700 bg-white border border-r-0 border-gray-200 hover:bg-indigo-500 hover:text-white">
            <span>{{item}}</span>
          </a>

          <button
            class="px-3 py-2 leading-tight text-indigo-700 bg-white border border-gray-200 rounded-r hover:bg-indigo-500 hover:text-white"
            @click="nextPage">
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.active{
  background-color: rgb(99 102 241 / var(--tw-bg-opacity)) !important;
}
.total_product{
  flex: 1;
  display: flex;
  flex-direction: column;
  margin: auto;
  text-align: right;
}
</style>