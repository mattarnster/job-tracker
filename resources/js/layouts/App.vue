<template>
    <div class="">
        <router-link class="pl-6 block pt-4 text-xl underline text-blue-600" :to="{ name: 'home' }">Menu</router-link>
        <router-view></router-view>
    </div>
</template>
<script>
    export default {}
</script>