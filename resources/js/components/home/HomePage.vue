<template>
    <div>
        <h1 class="text-4xl pt-6 text-gray-800 font-bold text-center mb-10">Welcome</h1>
        <div class="flex flex-col mx-auto w-full text-center">
            <router-link class="text-xl pb-12 underline text-blue-600" :to="{ name: 'jobs' }">View Jobs</router-link>
            <router-link class="text-xl underline text-blue-600" :to="{ name: 'users' }">View Users</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'HomePage'
};
</script>

<style>
</style>