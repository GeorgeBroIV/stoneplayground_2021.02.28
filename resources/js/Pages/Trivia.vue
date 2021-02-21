<!-- Tutorial for Vue Trivia: https://www.youtube.com/watch?v=4deVCNJq3qc&list=WL&index=33 -->
<template>
	<app-layout>
		<div>
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
					<b-row class="justify-content-md-center">
						<!-- Trivia Stats -->
						<b-col sm="4">
							<div class="h3">
								Developer Notes
							</div>
							<div class="mt-3 mb-1 font-bold">
								Now Operational
							</div>
							<div class="mt-2 text-gray-500">
								A cool Trivia game!
							</div>
							<div class="mt-3 font-bold">
								Soon to come
							</div>
							<div class="mt-2 text-gray-500">
								Ensure fresh questions between sessions
							</div>
							<div class="mt-2 text-gray-500">
								Trivia Stats
							</div>
							<div class="mt-2 text-gray-500">
								Persistent tab navigation where navigating between pages won't lose your current game state.
							</div>
						</b-col>

						<!-- Trivia Options / Board -->
						<b-col sm="8">

							<!-- Trivia Options -->
							<div id="triviaOptions" v-if="!triviaActive">

								<!-- START - Content from TriviaOptions.vue (commented out below) -->
								<div>
									<div class="h3 mb-3">
										Trivia Game Options
									</div>
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
											Criteria: Difficulty
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
											Criteria: Answer Type
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
											Criteria: Questions
										</div>
										<b-select v-model="selectedAmount" class="mb-3 w-auto">
											<option v-for="amount in this.amtMax">
												{{ amount }}
											</option>
										</b-select>
									</div>

									<div align="center" v-if="this.empty && !this.didloadFail" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-50">
										<div class="mb-2 h5">
											Loading... (will generate error if response not received in {{ intTimeout/1000 }} seconds)
										</div>
									</div>

									<div align="center" v-if="this.didloadFail" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-50">
										<div class="mb-2 h5">
											Sorry, unable to load your selection.
										</div>
										<div>
											Try adjusting the Criteria (e.g. less Questions)
										</div>
									</div>

									<div class="mt-3">
										<b-button v-if="(!this.triviaActive && !this.empty) || this.didloadFail" @click="startSurvey" variant="primary">
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
									:newTrivia="newTrivia"
								/>
								<div align="center" v-if="numCurrentQuestion-1 === numTotalQuestions && this.triviaActive">
									<b-button variant="primary" @click="newTrivia">
										New Trivia Game
									</b-button>
								</div>
							</div>

						</b-col>
					</b-row>
				</b-container>
			</div>
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
			questions: null,
			index: 0,
			numCorrect: 0,
			numCurrentQuestion: 1,
			numCurrentQuestionDisplay: 1,
			numTotalQuestions: 0,
			selectedIndex: 0,
			triviaActive: false,
			intTimeout: 0,
			loading: null,
			selectedCategory: 0,
			selectedDifficulty: "any",
			selectedType: "any",
			selectedAmount: 10,
			amtMax: 50,
			empty: false,
			didloadFail: false,
			bNewTrivia: false,
			strSessionToken: '',
		}
	},
	watch: {
		questions: {
			handler() {
				if(this.questions) {
					while (!this.questions.length) {
						let myVar = setTimeout(this.loading = true, this.intTimeout);
					}
					this.loading = false;
					this.loadFailed();
				}
			}
		},
		triviaActive: {
			immediate: true,
			handler() {
				this.triviaActive = this.triviaActive;
			}
		}
	},
	methods: {
		loadFailed() {
			if (this.questions.length) {
				this.empty = false
				this.triviaActive = true
				this.bNewTrivia = false
				this.strSessionToken = this.$cookies.get('PHPSESSID')
			} else {
				this.empty = true
				this.didloadFail = true
			}
		},
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
			this.bNewTrivia = true;
			this.triviaActive = false;
			this.selectedCategory = 0;
			this.selectedDifficulty = "any";
			this.selectedType = "any";
			this.selectedAmount = 10;
			this.questions = null;
			this.index = 0;
			this.numCorrect = 0;
			this.numCurrentQuestion = 1;
			this.numCurrentQuestionDisplay = 1;
			this.numTotalQuestions = 0;
			this.selectedIndex = 0;
		},
		startSurvey() {
			this.didloadFail = false;
			let urlCategory = this.selectedCategory === '0' ? '' : '&category=' + this.selectedCategory;
			let urlDifficulty = this.selectedDifficulty === 'any' ? '' : '&difficulty=' + this.selectedDifficulty;
			let urlType = this.selectedType === 'any' ? '' : '&type=' + this.selectedType;
			if (this.strSessionToken) {
				let urlSessionToken = '&token=' + this.strSessionToken;
			}
			let urlTrivia = 'https://opentdb.com/api.php?amount=' + this.selectedAmount + urlCategory + urlDifficulty + urlType; // + strSessionToken;
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
			let loaded = this.callFetch(urlTrivia);
//			if (this.questions) {
//				this.empty = false
//				this.triviaActive = true
//			} else {
//				this.empty = true
//			}
		},
		async callFetch(urlTrivia) {
			let response = Promise.resolve(fetch(urlTrivia, {method: 'get'}))
			.then(response => {
				return response.json()
			})
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