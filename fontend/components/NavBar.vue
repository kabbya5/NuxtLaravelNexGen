<template>
  <div class="px-4 py-2 shdow-md">
    <div class="flex justify-between items-center">
      <NuxtLink to="/" class="text-black text-3xl font-md shadow transion duration-300 hover:text-green-800">Home</NuxtLink>
      <NuxtLink :to="{ name: 'job' }" class="text-black text-2xl transition duration-300 font-md hover:text-green-800">Jobs</NuxtLink>
    </div>
  </div>
</template>
