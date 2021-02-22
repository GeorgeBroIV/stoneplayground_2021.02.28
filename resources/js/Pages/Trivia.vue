<!-- Tutorial for Vue Trivia: https://www.youtube.com/watch?v=4deVCNJq3qc&list=WL&index=33 -->
<template>
	<app-layout>
		<div id="divAppNotLoaded" v-if="this.setVisibility == 'hidden'">
			<TriviaLoading />
		</div>
		<div id="divApp" :style="{ visibility: this.setVisibility }">
			<TriviaHeader/>
			<div class="py-3">
				<b-container class="bv-example-row">
					<b-row class="justify-content-md-center">
						<b-col sm="3">
							<div id="divTriviaStats">
								<TriviaStats
									:bTriviaActive="bTriviaActive"
									:iCorrect="iCorrect"
									:iCurrentQuestionDisplay="iCurrentQuestionDisplay"
									:iGlobalCorrect="iGlobalCorrect"
									:iGlobalGames="iGlobalGames"
									:iGlobalQuestions="iGlobalQuestions"
									:iTotalQuestions="iTotalQuestions"
									:mGetData="mGetData"
									:oTriviaCategories="oTriviaCategories"
									:sTotalVerifiedQuestions="sTotalVerifiedQuestions"
								/>
							</div>
						</b-col>
						<b-col sm="5" class="pl-3">
							<div id="divTriviaOptions" v-if="!bTriviaActive">
								<TriviaOptions
									:bError="bError"
									:bLoadFail="bLoadFail"
									:bLoading="bLoading"
									:iAmtMax="iAmtMax"
									:iSelectedAmount="iSelectedAmount"
									:iSelectedCategory="iSelectedCategory"
									:mResetVars="mResetVars"
									:oTriviaCategories="oTriviaCategories"
									:oTriviaDifficulties="oTriviaDifficulties"
									:oTriviaTypes="oTriviaTypes"
									:sSelectedDifficulty="sSelectedDifficulty"
									:sSelectedType="sSelectedType"
								/>
							</div>
							<div id="divTriviaBoard" v-if="bTriviaActive">
								<TriviaContent
									v-if="this.aQuestions.length"
									:oCurrentQuestion="aQuestions[iIndex]"
									:mNext="mNext"
									:mIncrement="mIncrement"
									:iCurrentQuestion="iCurrentQuestion"
									:iTotalQuestions="iTotalQuestions"
									:mGetData="mGetData"
									:mNewTrivia="mNewTrivia"
								/>
							</div>
							<div id="divButtons">
								<div class="mt-3">
									<b-button v-if="(!this.bTriviaActive && !this.bEmpty) || (!this.bLoadFail && this.bEmpty)" @click="mStartSurvey" variant="primary">
										Start Trivia
									</b-button>
								</div>
								<div align="center" v-if="iCurrentQuestion-1 === iTotalQuestions && this.bTriviaActive">
									<b-button variant="primary" @click="mNewTrivia">
										New Trivia Game
									</b-button>
								</div>
							</div>
						</b-col>
						<b-col sm="4">
							<div id="divTriviaDeveloperNotes">
								<TriviaDeveloperNotes/>
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
	import TriviaContent from "@/Pages/Components/Trivia/TriviaContent";
	import TriviaDeveloperNotes from "@/Pages/Components/Trivia/TriviaDeveloperNotes"
	import TriviaHeader from "@/Pages/Components/Trivia/TriviaHeader"
	import TriviaLoading from "@/Pages/Components/Trivia/TriviaLoading"
	import TriviaOptions from "@/Pages/Components/Trivia/TriviaOptions";
	import TriviaStats from "@/Pages/Components/Trivia/TriviaStats";

	export default {
		name: 'trivia',
		props: {
			oTriviaCategories: Object,
			oTriviaDifficulties: Object,
			oTriviaTypes: Object,
		},
		components: {
			AppLayout,
			TriviaContent,
			TriviaDeveloperNotes,
			TriviaHeader,
			TriviaLoading,
			TriviaOptions,
			TriviaStats,
		},
		data() {
			return {
				aQuestions: [],
				bConstraints: false,
				bEmpty: false,
				bError: false,
				bLoadFail: false,
				bLoading: false,
				bNewTrivia: false,
				bRCode4: false,
				bTriviaActive: false,
				iAmtMax: 50,
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
				setVisibility: 'hidden',
				sUrlTriviaAPI: 'https://opentdb.com/api.php?amount=',
				sUrlTriviaTokenReset: 'https://opentdb.com/api_token.php?command=reset&token=',
				sUrlTriviaTokenRetrieve: 'https://opentdb.com/api_token.php?command=request',
varTest:'',
			}
		},
		methods: {
			async mFetchData(url) {
				return await fetch(url, {method: 'get'})
					.then(response => {
						return response.json()
					})
					.catch(({response}) => {
						this.bLoading = false;
						this.bError = true;
					})
					.finally(response => {
						this.varTest = 'mFetchData';
					})
			},
			async mGetData(url) {
				return await this.mFetchData(url)
					.then(response => {
						this.oFetch = response
					})
					.catch(({response}) => {
						this.bLoading = false;
						this.bError = true;
					})
					.finally(response => {
						this.mParseData()
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
			mNewTrivia() {
				this.iGlobalGames++
				this.mResetVars();
			},
			mNumberWithCommas(int) {
				return int.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			},
			mParseData() {
				if(this.oFetch.response_code == 0) {
					if (this.oFetch.results) {
						this.aQuestions = this.oFetch.results
						if(this.aQuestions.length) {
							// Fetch yielded 'trivia questions'
							this.bEmpty = false
							this.bLoading = false
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
					this.bLoadFail = true
				} else if(this.oFetch.response_code == 3) {
					// Token not found (Retrieve (generate) a Session Token)
					this.mRetrieveSessionToken()
				} else if(this.oFetch.response_code == 4) {
					// Token empty - token has returned all possible questions for the specified query (Reset token)
					this.mTestResponseCode4()
					// Due be no criteria matches (same as response_code 1 - bug in API)
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
				this.aQuestions = null;
				this.bConstraints = false;
				this.bEmpty = true;
				this.bError = false;
				this.bLoadFail = false;
				this.bLoading = false;
				this.bNewTrivia = true;
				this.bTriviaActive = false;
				this.iCorrect = 0;
				this.iCurrentQuestion = 1;
				this.iCurrentQuestionDisplay = 1;
				this.iIndex = 0;
				this.iSelectedAmount = 10;
				this.iSelectedCategory = 0;
				this.iTotalQuestions = 0;
				this.sSelectedDifficulty = "any";
				this.sSelectedType = "any";
			},
			mRetrieveSessionToken() {
				this.mGetData(this.sUrlTriviaTokenRetrieve)
				this.sSessionToken = this.oFetch.token
			},
			mStartSurvey() {
				// Set flag variables
				this.bEmpty = true;
				this.bLoading = true;
				// If bLoadFail, exit this method
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
		beforeUpdate() {
			this.setVisibility = 'visible'
		},
		watch: {
			setVisibility: {
				immediate: true,
				handler() {
					this.setVisibility = this.setVisibility;
				}
			},
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