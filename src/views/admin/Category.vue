<script setup lang="ts">
import { ref, inject } from 'vue'
import axios from 'axios'

interface Category {
  name: string
}

const category = ref<Category>({
  name: ''
})

const Category_list = ref([
  { id: 1, name: '' }
]);

const globalAPI: { baseURL: string; } | undefined = inject('globalAPI');
if (!globalAPI) {
  throw new Error('globalAPI is not provided.');
}

fetch(`${globalAPI.baseURL}api/category`)
    .then(response => response.json())
    .then(data => Category_list.value = data);

function submit() {
  if (!globalAPI) {
    throw new Error('globalAPI is not provided.');
  } 
  const dataToSend = JSON.parse(JSON.stringify(category.value))
  axios.post(`${globalAPI.baseURL}api/category`, dataToSend);
    try {
      console.log('Data Submitted: ', dataToSend);
      } catch (error) {
        console.error('Error making POST request:', error);
      }
}
</script>

<template>
  <h3 class="text-3xl font-semibold text-gray-700">
     Add Category
    </h3>
  <div class="grid grid-cols-12 gap-6">
    
    <div class="mt-4 mb-3 sm:col-span-6 xl:col-span-4">
      <div class="mt-4">
        <div
          class="w-full max-w-sm overflow-hidden bg-white border rounded-md shadow-md"
        >
          <form @submit.prevent="submit">
            <div
              class="flex items-center justify-between px-5 py-3 text-gray-700 border-b"
            >
              <h3 class="text-sm">
                Add Category
              </h3>
              <button>
                <svg
                  class="w-4 h-4"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>

            <div class="px-5 py-6 text-gray-700 bg-gray-200 border-b">
              <label class="text-xs">Name</label>

              <div class="relative mt-2 rounded-md shadow-sm">
                <span
                  class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-600"
                >
                  <svg
                    class="w-6 h-6"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"
                    />
                  </svg>
                </span>

                <input
                  v-model="category.name"
                  type="text"
                  class="w-full px-12 py-2 border-transparent rounded-md appearance-none focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                >
              </div>
            </div>

            <div class="flex items-center justify-between px-5 py-3">
              <button
                class="px-3 py-1 text-sm text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 focus:outline-none"
              >
                Cancel
              </button>
              <button
                class="px-3 py-1 text-sm text-white bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none"
              >
                Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="mt-4 mb-3 sm:col-span-6 xl:col-span-8">
      <div class="mt-6">
        <div class="my-6 overflow-hidden bg-white rounded-md shadow">
          <table class="w-full text-left border-collapse">
            <thead class="border-b">
              <tr>
                <th
                  class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800"
                >
                  ID
                </th>
                <th
                  class="px-5 py-3 text-sm font-medium text-gray-100 uppercase bg-indigo-800"
                >
                  Name
                </th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(item, index) in Category_list"
                :key="index"
              >
                <td class="px-6 py-4 text-lg text-gray-700 border-b">
                  {{ item.id }}
                </td>
                <td class="px-6 py-4 text-gray-500 border-b">
                  {{ item.name }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</template>
