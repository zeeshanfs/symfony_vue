<script setup lang="ts">
import { ref, inject, watch, computed, onMounted } from 'vue'
import axios from 'axios'
import { useStore } from 'vuex'

const store = useStore();

interface Product {
  name: string
  category: string
  price: string,
  description: string
}

const product = ref<Product>({
  name: '',
  category: '',
  price: '',
  description: ''
})

let fileData: File | null = null;
let DescData = '';

const open = ref(false)
const props = defineProps(['props'])
const isRequired = ref(true);

watch(
  () => props.props.openModal,
  value => {
    open.value = !open.value
    getData_prodcut(props.props.prodcutId)
  },
);

function openModal(){
  isRequired.value = false;
  open.value = !open.value
  product.value = {
    name: "",
    category: "",
    price: "",
    description: "",
  }
}

const fetchCategories = () => {
  store.dispatch('fetchCategories');
};

onMounted(() => {
  fetchCategories(); 
})

const globalAPI: { baseURL: string; } | undefined = inject('globalAPI');
const Category_list = computed(() => store.getters.getCategories);


function getData_prodcut(id: number){
  isRequired.value = false;
  fetch(`${globalAPI!.baseURL}api/products/${id}`)
    .then(response => response.json())
    .then(data => product.value = data);
}

function submit() {
  const dataToSend = new FormData();
  if(product.value.name == "" || product.value.category == "" || product.value.price == ""){
    isRequired.value = true;
    return false;
  }
  open.value = !open.value
  dataToSend.append('name',  product.value.name );
  dataToSend.append('category',  product.value.category );
  dataToSend.append('price',  product.value.price );
  dataToSend.append('description', DescData);
  dataToSend.append('image', fileData!);

  axios.post(`${globalAPI!.baseURL}api/products`, dataToSend,{
    headers: {
      'Content-Type': 'multipart/form-data',
    }
  })
}

function uploadFile(event: Event) { 
    const fileInput = event.target as HTMLInputElement;
    const files = fileInput.files;
    if (files && files.length > 0) { 
      fileData = files[0]
    } 
}

function updateMessage(event: Event) {
    const DescInput = event.target as HTMLInputElement;
    DescData = DescInput.value; 
}

</script>
<template>
  <div>
    <button
      class="px-6 py-3 mt-3 font-medium tracking-wide text-white bg-indigo-600 rounded-md hover:bg-indigo-500 focus:outline-none"
      @click="openModal"
    >
      Add Product
    </button>

    <div
      :class="`modal ${
        !open && 'opacity-0 pointer-events-none'
      } z-50 fixed w-full h-full top-0 left-0 flex items-center justify-center`"
    >
      <div
        class="absolute w-full h-full bg-gray-900 opacity-50 modal-overlay"
        @click="open = false"
      />

      <div
        class="z-50 w-11/12 mx-auto overflow-y-auto bg-white rounded shadow-lg modal-container lg:max-w-lg"
      >
        <!-- Add margin if you want to see some of the overlay behind the modal -->
        <div class="px-6 py-4 text-left modal-content">
          <!-- Title -->
          <div class="flex items-center justify-between pb-3">
            <p class="text-2xl font-bold">
              Add Product
            </p>
            <div class="z-50 cursor-pointer modal-close" @click="open = false">
              <svg
                class="text-black fill-current"
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
              >
                <path
                  d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                />
              </svg>
            </div>
          </div>

          <!-- Body -->
          <div class="bg-white rounded-md">
            <form @submit.prevent="">
              <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                  <label class="text-gray-700" for="productName">Name</label>
                  <input
                    :required="isRequired" 
                    v-model="product.name"
                    class="w-full mt-2 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    type="text"
                  >
                </div>
                <div>
                  <label class="text-gray-700" for="productImg">Image</label>
                  <input
                    :required="isRequired" 
                    type="file" 
                    @change="uploadFile"
                    ref="fileInput"
                    accept="image/*"
                    class="w-full mt-2 border-gray-200 focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                  >
                </div>
                
                <div>
                  <label class="text-gray-700" for="productCategory">Category</label>
                  <select
                    :required="isRequired" 
                    v-model="product.category"
                    class="w-full mt-2 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                  >
                <option>Select Category</option>
                <option v-for="item in Category_list" :value="item.id" >{{item.name}}</option>
                </select>
                </div>

                <div>
                  <label class="text-gray-700" for="productPrice">Price</label>
                  <input
                    :required="isRequired" 
                    v-model="product.price"
                    class="w-full mt-2 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500"
                    type="number"
                  >
                </div>
              </div>

              <div class="mt-4">
                  <label class="text-gray-700" for="productCategory">Description</label>
                  <textarea
                    @input="updateMessage"
                    class="w-full h-40 mt-2 border-gray-200 rounded-md focus:border-indigo-600 focus:ring focus:ring-opacity-40 focus:ring-indigo-500" 
                    rows="4" 
                    cols="50"
                    :value="product.description"
                    >
                  </textarea>
              </div>

              <div class="flex justify-end mt-4">
                <button
                  class="p-3 px-6 py-3 mr-2 text-indigo-500 bg-transparent rounded-lg hover:bg-gray-100 hover:text-indigo-400 focus:outline-none"
                  @click="open = false"
                >
                  Close
                </button>
                <button
                  @click="submit"
                  class="px-4 py-2 text-gray-200 bg-gray-800 rounded-md hover:bg-gray-700 focus:outline-none focus:bg-gray-700"
                >
                  Save
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>