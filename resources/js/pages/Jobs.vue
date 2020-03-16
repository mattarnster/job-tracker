<template>
    <div class="flex flex-row">
        <div class="w-full">
            <h1 class="pt-4 mb-12 text-4xl font-bold text-center text-gray-800 mb">Good {{ this.greeting }}, Matt!</h1>
            <!-- <h3 class="pt-4 mb-6 text-xl font-bold text-center text-gray-800">Here are your current jobs:</h3> -->
            
            <div>
                <input type="text" v-model="search" placeholder="Search..." class="block w-3/4 p-4 mx-auto mb-4 text-lg" />
            </div>

            <ul class="flex flex-col w-3/4 pb-4 mx-auto md:border-b lg:flex-row">
                <li class="mr-1 -mb-px">
                    <a v-bind:class="getActiveFilterClass('')" v-on:click="status=''" class="inline-block py-2 font-semibold lg:px-4" href="#">All</a>
                </li>
                <li class="mr-1 -mb-px">
                    <a v-bind:class="getActiveFilterClass('Received')" v-on:click="status='Received'" class="inline-block py-2 font-semibold lg:px-4" href="#">Received</a>
                </li>
                <li class="mr-1">
                    <a v-bind:class="getActiveFilterClass('In progress')" v-on:click="status='In progress'" class="inline-block py-2 font-semibold lg:px-4" href="#">In progress</a>
                </li>
                <li class="mr-1">
                    <a v-bind:class="getActiveFilterClass('Waiting on customer')" v-on:click="status='Waiting on customer'" class="inline-block py-2 font-semibold lg:px-4" href="#">Waiting on Customer</a>
                </li>
                <li class="mr-1">
                    <a v-bind:class="getActiveFilterClass('Waiting on supplier')" v-on:click="status='Waiting on supplier'" class="inline-block py-2 font-semibold lg:px-4" href="#">Waiting on Supplier</a>
                </li>
                <li class="mr-1">
                    <a v-bind:class="getActiveFilterClass('Ready for pickup')" v-on:click="status='Ready for pickup'" class="inline-block py-2 font-semibold lg:px-4" href="#">Ready</a>
                </li>
                <li class="mr-1">
                    <a v-bind:class="getActiveFilterClass('Complete')" v-on:click="status='Complete'" class="inline-block py-2 font-semibold lg:px-4" href="#">Complete</a>
                </li>
            </ul>

            <div class="flex justify-center w-full pt-4 pb-4" v-if="!jobs">
                <BarLoader />
            </div>
            
            <transition name="fade">
                <div v-if="jobs">
                    
                    <div v-for="job in filteredJobs" v-on:click='navigateToJob(job.id)' :key="job.id" :class="getJobStatusBorderColor(job.status) + ' flex justify-between w-3/4 p-4 mx-auto mb-4 bg-white rounded-md shadow-md cursor-pointer'">
                        <div class="w-full">
                            <div class="flex justify-between w-full">
                                <div class="ml-2">
                                    <p class="mr-6 text-lg font-bold text-gray-800">{{ job.name }}</p>
                                </div>
                                <span :class="getJobStatusColor(job.status) + ' rounded-full px-4 text-xs pt-1 font-bold'">{{ job.status }}</span>
                            </div>
                            <div class="ml-2">
                                <p class="text-gray-600">{{ job.customer.company }}</p>
                            </div>
                        </div>
                    </div>
                    <p v-if="!filteredJobs.length" class="w-3/4 mx-auto mt-4 text-lg text-center">No jobs match your search/filters</p>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            jobs: null,
            search: '',
            status: ''
        }
    },
    computed: {
        greeting: function () {
            let d = new Date()
            let h = d.getHours()
            if (h < 12) {
                return "morning"
            } else if (h >= 12 && h < 18) {
                return "afternoon"
            } else if (h >= 18) {
                return "evening"
            } 
        },
        filteredJobs: function() {
            var self = this
            return this.jobs.filter(function(job){
                var nameCheck = job.name.toLowerCase().indexOf(self.search.toLowerCase()) >= 0
                var statusCheck = (self.status !== "" ? (job.status === self.status) : true)
                return (nameCheck && statusCheck)
            })
        }
    },
    methods: {
        getJobs() {
            axios.get('/api/jobs')
            .then((response) => {
                this.jobs = response.data
                console.log(jobs)
            })
            .catch((error) => {
                console.log(error.message)
                if (error.status === 401 || error.message === "Request failed with status code 401") {
                    localStorage.removeItem('token')
                    this.$router.push("/login")
                }
            })
        },
        getJobStatusColor: function(status) {
            switch (status) {
                case "Received": return "bg-gray-200 text-gray-700"
                case "In progress": return "bg-blue-200 text-blue-700"
                case "Waiting on customer": return "bg-red-200 text-red-700"
                case "Waiting on supplier": return "bg-red-200 text-red-700"
                case "Ready for pickup": return "bg-green-200 text-green-700"
                case "Complete": return "bg-green-200 text-green-700"
                default:
                    break;
            }
        },
        getJobStatusBorderColor: function(status) {
            switch(status) {
                case "Received": return "border-gray-500 border-l-8 border-solid"
                case "In progress": return "border-blue-500 border-l-8 border-solid"
                case "Waiting on customer": return "border-red-500 border-l-8 border-solid"
                case "Waiting on supplier": return "border-red-500 border-l-8 border-solid" 
                case "Ready for pickup": return "border-green-500 border-l-8 border-solid"
                case "Complete": return "border-green-500 border-l-8 border-solid"
            }
        },
        getJobStatusCount: function(status) {
            if (!status) {
                return this.jobs.length
            }
            return this.jobs.filter((v)=>{
                return v.status === status
            }).length
        },
        getActiveFilterClass: function(status) {
            if (status === this.status) return 'text-white bg-blue-400 px-6'
            return 'text-blue-400 hover:text-blue-800'
        },
        navigateToJob: function(id) {
            this.$router.push('/jobs/' + id)
        }
    },
    created() {
        this.getJobs()
    }
}
</script>

<style>

</style>