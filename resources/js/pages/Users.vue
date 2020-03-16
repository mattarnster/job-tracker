<template>
    <div class="">
        <h1 class="text-4xl mb-12 font-bold text-center text-gray-800">Users</h1>
        <BarLoader v-if="!users" color="#3182ce" class="mx-auto" />
        <transition name="fade">
            <div v-if="users" class="container mx-auto p-4 bg-white rounded-md shadow-md">
                <div v-for="user in users" :key="user.id" class="border-b py-2 flex justify-between">
                    <p>{{ user.name }}</p>
                    <p>{{ user.email }}</p>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
import UsersList from '../components/users/UsersList'
export default {
    name: 'Users',
    components: {
        UsersList
    },
    data() {
        return {
            users: null
        }
    },
    mounted() {
        this.fetchUsers()
    },
    methods: {
        fetchUsers() {
            axios.get('/api/users')
                .catch(error => {

                })
                .then(response => {
                    this.users = response.data
                })
        }
    }
}
</script>

<style>

</style>