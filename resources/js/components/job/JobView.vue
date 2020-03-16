<template>
  <div>
    <CustomerModal v-if="customer_modal_open" :customer="job.customer" :closeCustomerModal="closeCustomerModal"/>
    <NotifyCustomerModal v-if="notify_customer_modal_open" :setJob="setJobInternal" :job="job" :closeNotifyCustomerModal="closeNotifyCustomerModal" />
    <h1 class="pt-6 mx-auto text-4xl font-bold text-center text-gray-800">{{ job.name }}</h1>
    <h2 class="pt-2 mx-auto mb-6 text-2xl font-semibold text-center text-gray-600">{{ job.customer.name }} - {{ job.customer.company }}</h2>
    <div class="w-full p-6 text-gray-800 bg-white rounded-md shadow-md">
      <span :class="getJobStatusColor(job.status) + ' inline-block w-auto rounded-full mb-4 text-sm px-4 font-bold'">{{ job.status }}</span>
      <div class="flex">
        <p class="mr-4 text-lg text-gray-600">Created: {{ job.created_at | moment('from', 'now') }}</p>
        <p class="mr-4 text-lg text-gray-600">Updated: {{ job.updated_at | moment('from', 'now') }}</p>
      </div>
      <div class="flex mt-4 mb-4">
          <select v-on:change="newStatusChangeInternal()" v-model="new_status" class="p-2 text-lg font-semibold text-white bg-blue-400 border border-gray-400 border-solid rounded-md">
              <option>Select new status</option>
              <option v-for="status in statuses" :key="status.key" :value="status.key">
                  {{ status.value }}
              </option>
          </select>
      </div>
      <div class="flex mt-4 mb-4">
        <button v-on:click="customer_modal_open = true" class="px-4 py-2 mr-4 font-semibold text-gray-600 border border-gray-400 border-solid rounded-md cursor-pointer">View customer info</button>
        <button v-on:click="notify_customer_modal_open = true" class="px-4 py-2 mr-6 font-semibold text-gray-600 border border-gray-400 border-solid rounded-md cursor-pointer" v-if="job.status==='Ready for pickup'">Notify customer</button>
      </div>
      <p class="mt-6 text-lg font-semibold leading-5">Job information:</p>
      <div class="p-4 mt-2 mb-2 border border-gray-300 border-solid rounded-sm">
        <p>{{ job.specification }}</p>
      </div>
      <div class="mt-6">
        <p class="mb-2 text-lg font-semibold leading-5 text-gray-800">Comments</p>
        <div v-for="comment in job.comments" :key="comment.id">
          <div class="p-6 mb-2 bg-blue-300 rounded-sm">
            <p class="font-bold text-blue-800">{{ comment.comment }}</p>
            <p class="text-right text-blue-800">
              {{ comment.created_at | moment('from', 'now') }} |
              <span class="font-semibold text-blue-800 underline cursor-pointer" v-on:click="deleteCommentInternal(comment.id)">Delete</span>
            </p>
          </div>
        </div>
        <div class="p2">
          <form v-on:submit.prevent="addCommentInternal()">
            <textarea
              v-model="comment_text"
              class="w-full p-2 mt-4 mb-4 border border-gray-500 border-solid rounded-sm"
              placeholder="Write a new comment"
            />
            <button class="w-full p-2 font-bold text-white bg-blue-600 rounded-md">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import CustomerModal from './CustomerModal'
import NotifyCustomerModal from './NotifyCustomerModal'
export default {
  name: 'JobView',
  props: ["job", "addComment", "deleteComment", "newStatusChange", "setJobMaster"],
  components: {
    CustomerModal,
    NotifyCustomerModal,
  },
  data() {
      return {
        comment_text: '',
        customer_modal_open: false,
        notify_customer_modal_open: false,
        statuses: [
            {
                key:"received",
                value: "Received"
            },
            {
                key:"in-progress",
                value: "In progress"
            },
            {
                key:"waiting-customer",
                value: "Waiting on customer"
            },
            {
                key:"waiting-supplier",
                value: "Waiting on supplier"
            },
            {
                key:"ready-for-pickup",
                value: "Ready for pickup"
            },
            {
              key:"complete",
              value: "Complete"
            }
        ],
        new_status: 'Select new status'
      }
  },
  methods: {
    setJobInternal(job) {
      console.log('setJobInternal JobView')
      this.setJobMaster(job)
    },
    deleteCommentInternal(id) {
        this.deleteComment(id)
    },
    getJobStatusColor: function(status) {
      switch (status) {
        case "Received":
          return "bg-gray-400 text-gray-700";
        case "In progress":
          return "bg-blue-200 text-blue-700";
        case "Waiting on customer":
          return "bg-red-200 text-red-700";
        case "Waiting on supplier":
          return "bg-red-200 text-red-700";
        case "Ready for pickup":
          return "bg-green-200 text-green-700";
        case "Complete":
          return "bg-green-200 text-green-700"
        default:
          break;
      }
    },
    addCommentInternal() {
        this.addComment(this.job.id, this.comment_text)
        this.comment_text = ""
    },
    newStatusChangeInternal() {
        if (this.new_status == "Select new status") return false
        this.newStatusChange(this.job.id, this.new_status)
    },
    closeCustomerModal() {
      this.customer_modal_open = false
    },
    closeNotifyCustomerModal() {
      this.notify_customer_modal_open = false
    }
  }
};
</script>

<style>
</style>