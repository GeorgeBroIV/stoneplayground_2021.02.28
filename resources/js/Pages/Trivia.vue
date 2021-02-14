<!-- Tutorial for Vue Trivia: https://www.youtube.com/watch?v=4deVCNJq3qc&list=WL&index=33 -->
<template>
	<app-layout>

    <!-- Trivia Header -->
    <div align="center">
      <b-nav tabs>
        <b-nav-item disabled><b>Trivia</b></b-nav-item>
        <b-nav-item disabled>Correct answers: {{ numCorrect }}/{{ numTotal }} out of {{ this.questions.length }} questions.</b-nav-item>
      </b-nav>
    </div>

    <!-- Trivia Content -->
    <div>
	    <b-container class="bv-example-row">
	      <b-row>
	        <b-col sm="6" offset="3">
            <!-- Wait until server response before passing data by ensuring questions.length is not zero -->
	          <TriviaContent
                v-if="questions.length"
                :currentQuestion="questions[index]"
                :next="next"
                :increment="increment"
                :numTotal="numTotal"
                :questions="questions.length"
            />
	        </b-col>
	      </b-row>
	    </b-container>
    </div>

	</app-layout>
</template>

<script>
  import AppLayout from "@/Layouts/AppLayout";
  import TriviaContent from "@/Pages/Components/TriviaContent";

  export default {
    components: {
	    AppLayout,
      TriviaContent
    },
    data() {
      return {
        questions: [],
        index: 0,
        numCorrect: 0,
        numTotal: 0
      }
    },
    methods: {
      next() {
        this.index++
      },
      increment(isCorrect) {
        if (isCorrect) {
          this.numCorrect++
        }
        this.numTotal++
      }
    },
    mounted: function() {
      fetch('https://opentdb.com/api.php?amount=10&category=27&difficulty=easy&type=multiple', {
        method: 'get'
      })
      .then(response => {
        return response.json()
      })
      .then(jsonData => {
        this.questions = jsonData.results
      })
    }
  }
</script>

<style scoped>

</style>