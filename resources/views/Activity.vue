<template>
    <div class="p-4 mt-6">
        <div v-for="a in activities" 
             :key="a.id"
             class="">
             <div class="pl-12 border-l-2 border-gray-400 border-solid">
                <div class="flex pt-4 pb-4 align-center">
                    <svg class="w-8 h-8 text-gray-600 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M1 5l9 5-9 5V5zm9 0l9 5-9 5V5z"/></svg>
                    <p class="pt-1 pl-12" v-if="a.type=='status_change'">Status changed from {{ a.from }} to {{ a.to }} <span class="text-gray-600">{{ a.created_at | moment('from', 'now') }}</span></p>
                    <p class="pt-1 pl-12" v-if="a.type=='notification'">{{a.to}} notification sent <span class="text-gray-600">{{ a.created_at | moment('from', 'now') }}</span></p>
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