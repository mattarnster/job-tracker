<template>
    <div class="flex h-screen p-12 mx-auto my-auto">
        <form class="flex-grow max-w-xs p-6 mx-auto my-auto bg-white rounded-md shadow-lg">
            <label for="email" class="block mb-2 text-sm font-bold">Email</label>
            <input type="text" name="email" class="w-full mb-2 border border-gray-500 border-solid" v-model="email">
            <label for="password" class="block mb-2 text-sm font-bold">Password</label>
            <input type="password" name="password" class="w-full mb-4 border border-gray-500 border-solid" v-model="password">
            <button type="submit" class="block w-full px-4 py-2 text-sm font-bold text-white bg-blue-400" @click="handleSubmit">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: "",
            password: ""
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length > 0) {
               axios.get('/airlock/csrf-cookie').then((response) => {
                   axios.post('/api/login', {
                       email: this.email,
                       password: this.password
                   }).then((response) => {
                       console.log(this.$route)
                       if (response.status == 200) {
                           localStorage.setItem('token', response.data.token)
                           if (this.$route.params.nextUrl != null) {
                               this.$router.push(this.$route.params.nextUrl)
                           } else {
                               this.$router.push('/jobs')
                           }
                       } else {
                           alert("Invalid email/password.")
                       }
                   })
               })
            }
        }
    }
}
</script>

<style>

</style>