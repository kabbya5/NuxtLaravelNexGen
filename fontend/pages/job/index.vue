<template> 
    <div>
      <div class="api-data text-black"> 
        {{ apiData }}
      </div>
  
      <div class="container mx-auto p-4">
        <ul>
          <button @click="dispatch1"> Show message after 40 seconds! <span class="text-blue-600"> Click Now </span>  </button>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios'; // Assuming $axios is not globally injected
  
  const apiData = ref(null);
  
  const dispatch1 = async () => {
    axios.get('http://127.0.0.1:8000/api/job-1').then(res =>{
        apiData.value = res;
    })
  };
  </script>