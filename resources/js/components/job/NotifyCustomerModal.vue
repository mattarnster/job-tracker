<template>
  <div
    class="fixed inset-x-0 bottom-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center"
  >
    <div class="fixed inset-0 transition-opacity">
      <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
    </div>

    <div
      class="overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:max-w-lg sm:w-full"
    >
    <div v-if="submitting" class="fixed inset-0 transition-opacity">
      <div class="absolute inset-0 flex mx-auto my-auto bg-gray-500 opacity-75 ">
        <GridLoader class="m-auto" color="#3182ce" />
      </div>
    </div>
      <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="w-full mt-3 text-center sm:mt-0 sm:text-left">
            <h3 class="text-lg font-medium leading-6 text-gray-900">Send a notification to: {{ job.customer.name }}</h3>
            <input v-model="sms" type="checkbox" class="mt-4" value="sms" id="sms" name="sms" />
            <label for="sms" class="pr-4">SMS</label>
            <input v-model="email" type="checkbox" value="email" id="email" name="email" />
            <label for="email">Email</label>
            <textarea v-model="notification_text" rows="8" placeholder="Notification text..." class="w-full p-2 mt-4 border border-gray-400 border-solid rounded-md"/>
            <div v-if="submitted" class="p-2 mt-6 font-semibold text-center text-white bg-green-500 rounded-sm">
              <p>Notification sent! Closing in 3 seconds...</p>
            </div>
            <div v-if="failed" class="p-2 mt-6 font-semibold text-center text-white bg-red-500 rounded-sm">
              <p>{{ this.failed_msg }}</p>
            </div>
          </div>
        </div>
      </div>
      <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
        <span class="flex w-full mt-3 rounded-md shadow-sm sm:mt-0 sm:w-auto">
          <button
            v-on:click="sendNotification()"
            type="button"
            class="justify-center inline-block w-full px-4 py-2 mr-2 text-base font-medium leading-6 text-white transition duration-150 ease-in-out bg-white bg-blue-600 border border-gray-300 rounded-md shadow-sm focus:outline-none hover:text-gray-200 focus:border-blue-300 focus:shadow-outline sm:text-sm sm:leading-5"
          >Send</button>
          <button
            v-on:click="closeNotifyCustomerModalInternal()"
            type="button"
            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline sm:text-sm sm:leading-5"
          >Close</button>
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "NotifyCustomerModal",
  props: ["job", "closeNotifyCustomerModal", "setJob"],
  data() {
    return {
      submitting: false,
      submitted: false,
      failed: false,
      failed_msg: '',
      email: false,
      sms: false,
      notification_text: 'Hi ' + (this.job.customer.name.split(' ').length > 1 ? this.job.customer.name.split(' ')[0] : this.job.customer.name) + ','
    }
  },
  methods: {
    closeNotifyCustomerModalInternal() {
      this.closeNotifyCustomerModal();
    },
    sendNotification() {
      if (!this.email && !this.sms) {
        this.failed = true
        this.failed_msg = 'Please select a notification method'
        return
      } else {
        this.failed = false
        this.failed_msg = ''
      }
      
      this.submitting = true
      
      const data = {
        email: this.email,
        sms: this.sms,
        notification_text: this.notification_text
      }

      axios
        .post('/api/jobs/'+this.job.id+'/notification', data)
        .catch(error => {
          this.failed = true
          this.failed_msg = error
          this.submitting = false
        })
        .then(response => {
          this.submitted = true
          this.submitting = false

          this.setJob(response)

          setTimeout(this.closeNotifyCustomerModalInternal, 3000)
        })
    }
  }
};
</script>

<style>
</style>