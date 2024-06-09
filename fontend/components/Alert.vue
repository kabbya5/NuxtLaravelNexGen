<template> 
    <!-- <div class="p-2">
        <div :class="alert.bg" class="px-6 py-3 text-white text-lg font-md"> 
           <p> {{ alert.message }} </p>
            
        </div>
    </div> -->
</template>

<script setup>
    const alert = ref({
        message : 'The email send successfully',
        type: 'success',
        bg:'bg-green-800',
    });
</script>

<style>

</style>