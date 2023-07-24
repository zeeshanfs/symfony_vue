<script setup lang="ts">
import { ref, inject } from 'vue'

const products = ref([
  { id: 1, name: '', image: '', price: null, category: null }
]);

const globalAPI: { baseURL: string; } | undefined = inject('globalAPI');
if (!globalAPI) {
  throw new Error('globalAPI is not provided.');
}

fetch(`${globalAPI.baseURL}api/products`)
    .then(response => response.json())
    .then(data => products.value = data);

  const open = ref(false)
</script>
<template>
   <h3 class="text-3xl font-semibold text-gray-700">
      Prodcuts
    </h3>
  <div class="grid grid-cols-12 gap-6">
    <div class="mt-4 mb-3 sm:col-span-6 xl:col-span-4" v-for="(item, index) in products" :key="index">
      <div class="max-w-sm mt-6 overflow-hidden bg-white rounded shadow-lg">
        <img
          class="w-full"
          :src="`${globalAPI.baseURL}uploads/${item.image}`"
          :alt="`${item.image}`"
        >
        <div class="px-6 py-4">
          <div class="mb-2 text-xl font-bold text-gray-900">
            {{ item.name }}
          </div>
          <p class="text-base text-gray-700">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit.
            Voluptatibus quia, nulla! Maiores et perferendis eaque,
            exercitationem praesentium nihil.
          </p>
        </div>
        <div class="px-6 pt-4 pb-2">
          <span
            class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full"
          >#photography</span>
          <span
            class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full"
          >#travel</span>
          <span
            class="inline-block px-3 py-1 mb-2 mr-2 text-sm font-semibold text-gray-700 bg-gray-200 rounded-full"
          >#winter</span>
        </div>
      </div>
    </div>
    <hr>
  </div>
</template>
<style>

</style>