<!-- Tutorial for Vue Trivia: https://www.youtube.com/watch?v=4deVCNJq3qc&list=WL&index=33 -->
<template>
	<app-layout>
		<div>
			<!-- Trivia Header -->
			<div align="center">
				<b-nav tabs>
					<b-nav-item disabled><b>Trivia</b></b-nav-item>
				</b-nav>
			</div>

			<!-- Trivia Content -->
			<div class="py-3">
				<b-container class="bv-example-row">
					<b-row class="justify-content-md-center">
						<!-- Trivia Stats -->
						<b-col sm="3">
							<div class="h3">
								Trivia Stats
							</div>

							<!-- Current Game Stats -->
							<div v-if="this.bTriviaActive">
								<div class="mt-3 mb-1 font-bold">
									Current Game Stats
								</div>
								<div class="mt-2 text-gray-500">
									Question {{ this.iCurrentQuestionDisplay }} of {{ this.iTotalQuestions }}
								</div>
								<div class="mt-2 text-gray-500">
									Correct Answers: {{ this.iCorrect }}
								</div>
							</div>

							<!-- Game Stats -->
							<div class="mt-3 mb-1 font-bold">
								Overall Game Stats
							</div>
							<div class="mt-2 text-gray-500">
								Games Played: {{ this.iGlobalGames }}
							</div>
							<div class="mt-2 text-gray-500">
								Questions Answered: {{ this.iGlobalQuestions }}
							</div>
							<div class="mt-2 text-gray-500">
								Correct Answers: {{ this.iGlobalCorrect }}
							</div>							<!-- Game Stats -->
							<div class="mt-3 mb-1 font-bold">
								Open Trivia Database
							</div>
							<div class="mt-2 text-gray-500">
								Trivia Categories: {{ this.iCategories }}
							</div>
							<div class="mt-2 text-gray-500">
								Verified Questions: {{ this.sTotalVerifiedQuestions }}
							</div>
						</b-col>

						<!-- Trivia Options / Board -->
						<b-col sm="5">

							<!-- Trivia Options -->
							<div id="triviaOptions" v-if="!bTriviaActive">

								<!-- START - Content from TriviaOptions.vue (commented out below) -->
								<div>
									<div class="h3 mb-3">
										Trivia Game Options
									</div>
									<div>
										Trivia Category
									</div>

									<select v-model="iSelectedCategory" class="mb-3">
										<option
											v-for="(category, index) in this.oTriviaCategories"
											:value="index">
											{{ category }}
										</option>
									</select>

									<div>
										<div>
											Criteria: Difficulty
										</div>
										<select v-model="sSelectedDifficulty" class="mb-3">
											<option
												v-for="(difficulty, index) in this.oTriviaDifficulties"
												:value="index">
												{{ difficulty }}
											</option>
										</select>
									</div>

									<div>
										<div>
											Criteria: Answer Type
										</div>
										<select v-model="sSelectedType" class="mb-3">
											<option
												v-for="(type, index) in this.oTriviaTypes"
												:value="index">
												{{ type }}
											</option>
										</select>
									</div>

									<div>
										<div>
											Criteria: Questions
										</div>
										<b-select v-model="iSelectedAmount" class="mb-3 w-auto">
											<option v-for="amount in this.iAmtMax">
												{{ amount }}
											</option>
										</b-select>
									</div>

									<div align="center" v-if="this.bLoading" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-auto">
										<div class="mb-2 h5">
											Loading...
										</div>

									</div>

									<div v-if="this.bLoadFail">
										<div align="center"class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100 w-auto">
											<div class="mb-2 h5">
												Sorry, unable to load your selection.
											</div>
											<div>
												Try adjusting the Criteria (e.g. less Questions)
											</div>
										</div>
										<div class="mt-3">
											<b-button @click="mResetVars" variant="primary">
												Reset Criteria
											</b-button>
										</div>
									</div>

										<div class="mt-3">
											<b-button v-if="(!this.bTriviaActive && !this.bEmpty) || (!this.bLoadFail && this.bEmpty)" @click="mStartSurvey" variant="primary">
												Start Trivia
											</b-button>
										</div>
								</div>
								<!-- END - Content from TriviaOptions.vue (commented out below) -->


								<!--	              <TriviaOptions
													:iTotalQuestions="iTotalQuestions"
													:oTriviaCategories="oTriviaCategories"
													:oTriviaDifficulties="oTriviaDifficulties"
													:oTriviaTypes="oTriviaTypes"
													:aQuestions="aQuestions"
													:bTriviaActive="bTriviaActive"
													:bLoading="bLoading"
												  /> -->
							</div>
							<!-- Trivia Board -->
							<div id="triviaBoard" v-if="bTriviaActive">
								<!-- Wait until server response before passing data by ensuring 'empty' is not true -->
								<TriviaContent
									v-if="this.aQuestions.length"
									:oCurrentQuestion="aQuestions[iIndex]"
									:mNext="mNext"
									:mIncrement="mIncrement"
									:iCurrentQuestion="iCurrentQuestion"
									:iTotalQuestions="iTotalQuestions"
									:mNewTrivia="mNewTrivia"
								/>
								<div align="center" v-if="iCurrentQuestion-1 === iTotalQuestions && this.bTriviaActive">
									<b-button variant="primary" @click="mNewTrivia">
										New Trivia Game
									</b-button>
								</div>
							</div>
						</b-col>

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
							<div class="mt-2 text-gray-500">
								Ensure fresh questions between sessions
							</div>
							<div class="mt-2 text-gray-500">
								Current Session Trivia Stats
							</div>
							<div class="mt-3 font-bold">
								Soon to come
							</div>
							<div class="mt-2 text-gray-500">
								Save Trivia Stats
							</div>
							<div class="mt-2 text-gray-500">
								Persistent tab navigation where navigating between pages won't lose your current game state.
							</div>
							<div class="mt-3 font-bold">
								Trivia Questions and Answers
							</div>
							<div class="mt-2 text-gray-500">
								Courtesy of <a href="https://opentdb.com/" target="_blank">Open Trivia Database</a>
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
	name: 'trivia',
	props: {
		oTriviaCategories: Object,
		oTriviaDifficulties: Object,
		oTriviaTypes: Object,
		// START - from TriviaOptions.vue
		// oTriviaCategories: Object,
		// oTriviaDifficulties: Object,
		// oTriviaTypes: Object,
//	    iTotalQuestions: Number,
//	    aQuestions: Array,
//			bTriviaActive: Boolean,
//			bLoading: Boolean,
		// END - from TriviaOptions.vue
	},
	components: {
		AppLayout,
		TriviaContent,
		Inertia
	},
	data() {
		return {
			aQuestions: [],
			bConstraints: false,
			bEmpty: false,
			bLoadFail: false,
			bLoading: false,
			bNewTrivia: false,
			bRCode4: false,
			bTriviaActive: false,
			iAmtMax: 50,
			iCategories: 0,
			iCorrect: 0,
			iCurrentQuestion: 1,
			iCurrentQuestionDisplay: 1,
			iIndex: 0,
			iGlobalCorrect: 0,
			iGlobalGames: 0,
			iGlobalQuestions: 0,
			iSelectedAmount: 10,
			iSelectedCategory: 0,
			iSelectedIndex: 0,
			iTimeout: 0,
			iTotalQuestions: 0,
			oFetch: '',
			sSelectedDifficulty: "any",
			sSelectedType: "any",
			sSessionToken: 'init',
			sTotalVerifiedQuestions: '',
			sUrlTriviaAPI: 'https://opentdb.com/api.php?amount=',
			sUrlTriviaAPIStats: 'https://opentdb.com/api_count_global.php',
			sUrlTriviaTokenReset: 'https://opentdb.com/api_token.php?command=reset&token=',
			sUrlTriviaTokenRetrieve: 'https://opentdb.com/api_token.php?command=request',
		}
	},
	methods: {
		async mGetData(url) {
			return await this.mFetchData(url)
				.then(response => {
					this.oFetch = response
				})
				.catch(({response}) => {
					this.bLoading = false;
					this.bLoadFail = true;
				})
				.finally(response => {
					this.mParseData()
				})
		},
		async mFetchData(url) {
			return await fetch(url, {method: 'get'})
				.then(response => {
					return response.json()
				})
				.catch(({response}) => {
					this.bLoading = false;
					this.bLoadFail = true;
				})
				.finally(response => {
					this.varTest = 'mFetchData';
				})
		},
		mIncrement(isCorrect) {
			if (isCorrect) {
				this.iCorrect++
				this.iGlobalCorrect++
			}
			this.iGlobalQuestions++
			this.iCurrentQuestion++
		},
		mNext() {
			this.iCurrentQuestionDisplay++
			this.iIndex++
		},
		mNumberWithCommas(int) {
			return int.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
		mNewTrivia() {
			this.iGlobalGames++
			this.mResetVars();
		},
		mParseData() {
			this.bLoading=false
			if(this.oFetch.response_code == 0) {
				if (this.oFetch.results) {
					this.aQuestions = this.oFetch.results
					if(this.aQuestions.length) {
						// Fetch yielded 'trivia questions'
						this.bEmpty = false
						this.bTriviaActive = true
						this.bNewTrivia = false
						this.iTotalQuestions = this.aQuestions.length
					}
				} else if(this.oFetch.token) {
					// Fetch yielded 'token'
					this.sSessionToken = this.oFetch.token
					this.mStartSurvey();
				}
			} else if(this.oFetch.response_code == 1)  {
				// No Trivia Results based on Criteria
				this.bEmpty = true
				this.bLoadFail = true
			} else if(this.oFetch.response_code == 3) {
				// Token not found (Retrieve (generate) a Session Token)
				this.bEmpty = true
				this.mRetrieveSessionToken()
			} else if(this.oFetch.response_code == 4) {
				// Token empty - token has returned all possible questions for the specified query (Reset token)
				// Could be no criteria matches
				this.mTestResponseCode4()
				if(this.bConstraints) {
					this.bLoadFail=true
				} else {
					this.mResetSessionToken(this.sSessionToken)
				}
			} else if(this.oFetch.overall) {
				let iVerifiedQuestions = this.oFetch.overall.total_num_of_verified_questions
				this.sTotalVerifiedQuestions = this.mNumberWithCommas(iVerifiedQuestions)
			}
		},
		mResetSessionToken(token) {
			this.mGetData(this.sUrlTriviaTokenReset + token)
		},
		mResetVars() {
			this.bNewTrivia = true;
			this.bConstraints = false;
			this.bTriviaActive = false;
			this.iSelectedCategory = 0;
			this.sSelectedDifficulty = "any";
			this.sSelectedType = "any";
			this.iSelectedAmount = 10;
			this.aQuestions = null;
			this.iIndex = 0;
			this.iCorrect = 0;
			this.iCurrentQuestion = 1;
			this.iCurrentQuestionDisplay = 1;
			this.iTotalQuestions = 0;
			this.iSelectedIndex = 0;
			this.bLoadFail = false;
			this.bEmpty = true;
			this.bLoading = false;
		},
		mRetrieveSessionToken() {
			this.mGetData(this.sUrlTriviaTokenRetrieve)
			this.sSessionToken = this.oFetch.token
		},
		mStartSurvey() {
			// Set flag variables
			this.bEmpty = true;
			this.bLoading = true;
			if(this.bLoadFail) {
				this.bLoading = false
				return
			}
			// Build URL to be fetched
			let sUrlCategory = this.iSelectedCategory === 0 ? '' : '&category=' + this.iSelectedCategory;
			let sUrlDifficulty = this.sSelectedDifficulty === 'any' ? '' : '&difficulty=' + this.sSelectedDifficulty;
			let sUrlType = this.sSelectedType === 'any' ? '' : '&type=' + this.sSelectedType;
			let sUrlTrivia = this.sUrlTriviaAPI + this.iSelectedAmount + sUrlCategory + sUrlDifficulty + sUrlType;
			if(!this.bRCode4) {
				let sUrlToken = '&token=' + this.sSessionToken;
				sUrlTrivia += sUrlToken;
			}
			// Fetch the URL
			this.mGetData(sUrlTrivia);
		},
		mTestResponseCode4() {
			this.bRCode4 = true
			this.mStartSurvey()
			this.bRCode4 = false
			if(this.oFetch.response_code == 1) {
				this.bConstraints = true
			}
		}
	},
	mounted() {
		this.mGetData(this.sUrlTriviaAPIStats)
		this.iCategories = Object.keys(this.oTriviaCategories).length
	},
	watch: {
		bTriviaActive: {
			immediate: true,
			handler() {
				this.bTriviaActive = this.bTriviaActive;
			}
		}
	},
}
</script>

<style scoped>
</style>