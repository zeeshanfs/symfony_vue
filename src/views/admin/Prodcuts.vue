<script setup lang="ts">
import { ref, inject } from 'vue'
import Modal from './Modal.vue';

const products = ref([
  { 
    id: 1, 
    name: '', 
    image: '', 
    price: null, 
    category: null,
    description: '' 
  }
]);

const globalAPI: { baseURL: string; } | undefined = inject('globalAPI')
const valueModal = ref(false)
const prodcutId = ref()

function openModal(id: number){
  prodcutId.value = id
  valueModal.value = !valueModal.value;
}

function getData_prodcuts(){
  fetch(`${globalAPI!.baseURL}api/products`)
    .then(response => response.json())
    .then(data => products.value = data);
}
getData_prodcuts()

</script>

<template>
  <div>
    <h3 class="text-3xl font-medium text-gray-700">
      Prodcuts
    </h3>
    
    <div class="mt-4 dashboard ">
      <div class="flex flex-wrap -mx-6">
        <div class="w-full px-6 mt-6 xl:mt-0">
          <div
            class="flex items-center px-5 py-6 bg-white rounded-md shadow-sm"
          >
            <div class="p-3 bg-pink-600 bg-opacity-75 rounded-full">
              <svg
                class="w-8 h-8 text-white"
                viewBox="0 0 28 28"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6.99998 11.2H21L22.4 23.8H5.59998L6.99998 11.2Z"
                  fill="currentColor"
                  stroke="currentColor"
                  stroke-width="2"
                  stroke-linejoin="round"
                />
                <path
                  d="M9.79999 8.4C9.79999 6.08041 11.6804 4.2 14 4.2C16.3196 4.2 18.2 6.08041 18.2 8.4V12.6C18.2 14.9197 16.3196 16.8 14 16.8C11.6804 16.8 9.79999 14.9197 9.79999 12.6V8.4Z"
                  stroke="currentColor"
                  stroke-width="2"
                />
              </svg>
            </div>

            <div class="mx-5">
              <h4 class="text-2xl font-semibold text-gray-700">
                {{ products.length }}
              </h4>
              <div class="text-gray-500">
                Total Products
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <Modal :props="{ openModal: valueModal, prodcutId: prodcutId }" />
      </div>
    </div>

    <div class="mt-8" />

    <div class="flex flex-col mt-8">
      <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
        <div
          class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg"
        >
          <table class="min-w-full">
            <thead>
              <tr>
                <th
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                >
                  Name
                </th>
                <th
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                >
                  Image
                </th>
                <th
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                >
                  Price
                </th>
                <th
                  class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50"
                >
                  Category
                </th>
                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50" />
              </tr>
            </thead>

            <tbody class="bg-white">
              <tr v-for="(item, index) in products" :key="index">

                <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                  <div class="text-sm leading-5 text-gray-900">
                    {{ item.name }}
                  </div>
                </td>

                <td class="px-6 py-4 border-b border-gray-200 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-12">
                      <img
                        class="w-12 h-12"
                        :src="`${globalAPI!.baseURL}uploads/${item.image}`"
                        :alt="`${item.image}`"
                      >
                    </div>
                  </div>
                </td>
                <td
                  class="px-6 py-4 border-b border-gray-200 whitespace-nowrap"
                >
                  <span
                    class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full"
                  >{{ item.price }}</span>
                </td>

                <td
                  class="px-6 py-4 text-sm leading-5 text-gray-500 border-b border-gray-200 whitespace-nowrap"
                >
                  {{ item.category }}
                </td>
                <td
                  class="px-6 py-4 text-sm font-medium leading-5 text-right border-b border-gray-200 whitespace-nowrap"
                >
                  <a href="#" @click="openModal(item.id)" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
.dashboard {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
</style>
