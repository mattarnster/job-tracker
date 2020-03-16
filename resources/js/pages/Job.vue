<template>
  <div class="container pt-6 mx-auto">
    <router-link class="text-blue-600 underline text-xl" :to="{ name: 'jobs' }">&lt; Back to Jobs</router-link>
    <div class="flex justify-center w-full pt-4 pb-4" v-if="!job">
        <BarLoader color="#3182ce" />
    </div>
    <transition name="fade">
        <div v-if="job" class="flex flex-col lg:flex-row">
          <div class="w-full lg:w-2/3">
            <JobView :job="job" :setJobMaster="this.setJobMaster" :addComment="this.addComment" :deleteComment="this.deleteComment" :newStatusChange="this.newStatusChange" />
          </div>
          <div class="w-full mt-6 lg:w-1/3">  
            <Activity :activities="job.activities" />
          </div>
        </div>
    </transition>
  </div>
</template>

<script>
import JobView from '../components/Job/JobView'
import Activity from '../components/Job/Activity'

export default {
  name: "job",
  components: {
      JobView,
      Activity
  },
  
  data() {
    return {
      job: null,
      comment: null,
      comment_text: ''
    };
  },
  created() {
    this.fetchJob();
  },
  methods: {
    fetchJob() {
      axios
        .get("/api/jobs/" + this.$route.params.id)
        .then(response => {
          this.job = response.data;
        })
        .catch(error => {
          console.log(error.response.status);
          if (error.response.status === 401) {
            localStorage.removeItem("token");
            this.$router.push("/login");
          }
        });
    },
    addComment(id, comment_text) {
        const data = {
            comment: comment_text,
            job_id: id,
            user_id: 1
        }
        axios
            .post("/api/comment", data)
            .then(response => {
                this.fetchJob()
                this.comment_text = ""
            })
    },
    deleteComment(id) {
        const data = {
            id: id
        }
        axios
            .post("/api/comment/" + id + "/delete")
            .then(response => {
                this.fetchJob()
            })
    },
    newStatusChange(id, status) {
        const data = {
            id: id,
            status: status
        }
        axios
            .post('/api/jobs/' + id, data)
            .then(response => {
                this.fetchJob()
            })
    },
    setJobMaster(job) {
      this.fetchJob()
    }
  }
};
</script>

<style>
</style>