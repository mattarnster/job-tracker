<template>
  
</template>

<script>
export default {
    name: 'logout',
    mounted() {
        localStorage.removeItem('token')
        this.$router.push('/login')
    },
    methods: {
        
    }
}
</script>

<style>

</style>