<template>
    <div class="pl-4">
        <p class="text-lg font-semibold text-gray-800">Job Timeline</p>
        <div v-for="a in activities" 
             :key="a.id"
             class="">
             <div class="">
                <div class="flex items-center content-center pt-4 pb-4">
                    <!-- <svg v-if="a.type=='status_change'" class="text-gray-600 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 5l9 5-9 5V5zm9 0l9 5-9 5V5z"/></svg>
                    <svg v-if="a.type=='notification'" class="text-gray-600 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M10 15l-4 4v-4H2a2 2 0 0 1-2-2V3c0-1.1.9-2 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-8zM5 7v2h2V7H5zm4 0v2h2V7H9zm4 0v2h2V7h-2z"/></svg> -->
                    <p class="pt-1 text-sm" v-if="a.type=='status_change'">Status changed from {{ a.from }} to {{ a.to }} <br/><span class="text-gray-600">{{ a.created_at | moment('from', 'now') }}</span></p>
                    <p class="pt-1 text-sm" v-if="a.type=='notification'">{{a.to}} notification sent <br/><span class="text-gray-600">{{ a.created_at | moment('from', 'now') }}</span></p>
                </div>
            </div>
        </div>

                
        
    </div>
</template>

<script>
export default {
    name: 'activity',
    props: ['activities'],
    data() {
        return {
            a: ''
        }
    }
}
</script>

<style>

</style>