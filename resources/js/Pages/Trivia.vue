<!-- Tutorial for Vue Trivia: https://www.youtube.com/watch?v=4deVCNJq3qc&list=WL&index=33 -->
<template>
	<app-layout>
<!-- Trivia Header -->
    <div align="center">
      <b-nav tabs>
        <b-nav-item disabled><b>Trivia</b></b-nav-item>
      <b-nav-item v-if="this.triviaActive" disabled class="align-middle">Question {{ numCurrentQuestionDisplay }} of {{ this.numTotalQuestions }}.  Correct answers: {{ numCorrect }}.</b-nav-item>
      </b-nav>
    </div>

<!-- Trivia Content -->
    <div class="py-3">
	    <b-container class="bv-example-row">
	      <b-row>
<!-- Trivia Stats -->
	          <b-col align-self="center" sm="3">
	            Placeholder for Trivia Stats and Save options.
	          </b-col>

<!-- Column Separator -->
	          <b-col sm="1">
	          </b-col>

<!-- Trivia Options / Board -->
	          <b-col sm="8">
  <!-- Trivia Options -->
	            <div id="triviaOptions" v-if="!triviaActive">

<!-- START - Content from TriviaOptions.vue (commented out below) -->
		            <div>
			            <div>
				            Trivia Category
			            </div>
			            <select v-model="selectedCategory" class="mb-3">
				            <option
					            v-for="(category, index) in this.triviaCategories"
					            :value="index">
					            {{ category }}
				            </option>
			            </select>

			            <div>
				            <div>
					            Difficulty
				            </div>
				            <select v-model="selectedDifficulty" class="mb-3">
					            <option
						            v-for="(difficulty, index) in this.triviaDifficulties"
						            :value="index">
						            {{ difficulty }}
					            </option>
				            </select>
			            </div>

			            <div>
				            <div>
					            Answer Type
				            </div>
				            <select v-model="selectedType" class="mb-3">
					            <option
						            v-for="(type, index) in this.triviaTypes"
						            :value="index">
						            {{ type }}
					            </option>
				            </select>
			            </div>

			            <div>
				            <div>
					            Questions
				            </div>
				            <b-select v-model="selectedAmount" class="mb-3 w-auto">
					            <option v-for="amount in this.amtMax">
						            {{ amount }}
					            </option>
				            </b-select>
			            </div>

			            <div class="mt-3">
				            <b-button @click="startSurvey" variant="primary">
					            Start Trivia
				            </b-button>
			            </div>
		            </div>
<!-- END - Content from TriviaOptions.vue (commented out below) -->


<!--	              <TriviaOptions
	                :numTotalQuestions="numTotalQuestions"
	                :triviaCategories="triviaCategories"
	                :triviaDifficulties="triviaDifficulties"
	                :triviaTypes="triviaTypes"
	                :questions="questions"
	                :triviaActive="triviaActive"
	                :loading="loading"
	              /> -->
	            </div>
  <!-- Trivia Board -->
	            <div id="triviaBoard" v-if="triviaActive">
	              <!-- Wait until server response before passing data by ensuring questions.length is not zero -->
	              <TriviaContent
	                  v-if="questions.length"
	                  :currentQuestion="questions[index]"
	                  :next="next"
	                  :increment="increment"
	                  :numCurrentQuestion="numCurrentQuestion"
	                  :numTotalQuestions="numTotalQuestions"
	                  :triviaActive="triviaActive"
	                  :newTrivia="newTrivia"
	              />
	              <div align="center" v-if="numCurrentQuestion-1 === numTotalQuestions">
	                <b-button variant="primary" @click="newTrivia">
	                  New Trivia Game
	                </b-button>
	              </div>
	            </div>

	          </b-col>
	      </b-row>
	    </b-container>

    </div>

	</app-layout>
</template>

<script>

  import AppLayout from "@/Layouts/AppLayout";
//  import TriviaOptions from "@/Pages/Components/TriviaOptions";
  import TriviaContent from "@/Pages/Components/TriviaContent";
	import Inertia from '@inertiajs/inertia';  // from TriviaOptions.vue

  export default {
    props: {
      triviaCategories: Object,
      triviaDifficulties: Object,
      triviaTypes: Object,
	    // START - from TriviaOptions.vue
	   // triviaCategories: Object,
	   // triviaDifficulties: Object,
	   // triviaTypes: Object,
//	    numTotalQuestions: Number,
//	    questions: Array,
//			triviaActive: Boolean,
//			loading: Boolean,
	    // END - from TriviaOptions.vue
    },
    components: {
      AppLayout,
      TriviaContent,
	    Inertia
    },
    data() {
      return {
        questions: [],
        index: 0,
        numCorrect: 0,
        numCurrentQuestion: 1,
        numCurrentQuestionDisplay: 1,
        numTotalQuestions: 0,
        selectedIndex: 0,
        triviaActive: false,
        loading: null,
	      selectedCategory: 0,
	      selectedDifficulty: "any",
	      selectedType: "any",
	      selectedAmount: 10,
	      amtMax: 50,
      }
    },
    methods: {
      next() {
        this.numCurrentQuestionDisplay++
        this.index++
      },
      increment(isCorrect) {
        if (isCorrect) {
          this.numCorrect++
        }
        this.numCurrentQuestion++
      },
	    newTrivia() {
		    this.selectedCategory = 0;
		    this.selectedDifficulty = "any";
		    this.selectedType = "any";
		    this.selectedAmount = 10;
		    this.questions = [];
			this.index = 0;
			this.numCorrect = 0;
			this.numCurrentQuestion = 1;
			this.numCurrentQuestionDisplay = 1;
			this.numTotalQuestions = 0;
			this.selectedIndex = 0;
		    this.startSurvey();
	    },
	    startSurvey() {
		    let urlCategory = this.selectedCategory === '0' ? '' : '&category=' + this.selectedCategory;
		    let urlDifficulty = this.selectedDifficulty === 'any' ? '' : '&difficulty=' + this.selectedDifficulty;
		    let urlType = this.selectedType === 'any' ? '' : '&type=' + this.selectedType;
		    let urlTrivia = 'https://opentdb.com/api.php?amount=' + this.selectedAmount + urlCategory + urlDifficulty + urlType;
//				this.loading = true;
//		    this.$inertia.get(urlTrivia)
//			    .then(response => {
//				    return response.json()
//			    })
//			    .then(jsonData => {
//				    this.questions = jsonData.results
//				    this.numTotalQuestions = jsonData.results.length
//						this.loading = false
//			    });
		        let loaded=this.callFetch(urlTrivia);
				this.triviaActive = !this.triviaActive
	    },
			    async callFetch(urlTrivia) {
			      let response = await Promise.resolve(fetch(urlTrivia, {method: 'get'}))
			      .then(response => {return response.json()})
			      .then(jsonData => {
			        this.questions = jsonData.results
			        this.numTotalQuestions = jsonData.results.length
			      })
			    }
    }
  }
</script>

<style scoped>

</style>