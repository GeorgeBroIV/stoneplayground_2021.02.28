<template>
  <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    <div class="question-box-container">
      <div id="divCategory"
           class="text-2xl mb-3">
	      Category: {{ oCurrentQuestion.category }}
      </div>
      <b-jumbotron class="rounded-xl shadow-2xl -ml-5 mr-5 pl-4">
		<div id="divQuestion">
	        <div class="text-lg mb-3 mt-2 p-3 bg-yellow-50 bg-opacity-50 rounded-xl shadow-2xl" v-html="this.oCurrentQuestion.question">
	          {{ this.oCurrentQuestion.question }}
	        </div>
		</div>
		<div id="divAnswerList">
			<b-list-group>
			  <b-list-group-item
			      v-for="(answer, index) in aAnswers"
			      v-html="answer"
			      :key="index"
			      @click="mSelectAnswer(index)"
			      :class="sAnswerClass(index)"
			      :disabled="bAnswered"
			  >
			    {{ answer }}
			  </b-list-group-item>
			</b-list-group>
	      </div>
		<div id="divStatusMessage">
			<div id='statusSubmit' align="center" v-if="!bAnswered && iSelectedIndex === null" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100">
			  Select an answer.
			</div>
			<div id='statusNext' align="center" v-if="bAnswered && iSelectedIndex === iCorrectIndex" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100">
			  Correct!
			</div>
			<div id='statusNewGame' align="center" v-if="bAnswered && iSelectedIndex !== iCorrectIndex" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100">
			  Wrong guess.
			</div>
		</div>
        <div id="divFormButtons"
             align="center"
             v-if="iCurrentQuestion-1 !== iTotalQuestions">
          <b-button id="btnSubmitAnswer"
              v-if="!bAnswered && iSelectedIndex !== null"
              variant="primary"
              @click="mSubmitAnswer"
          >
            Submit
          </b-button>
          <b-button id="btnNextQuestion"
	          v-if="bAnswered"
              @click="mNext"
              variant="success"
              href="#"
          >
            Next
          </b-button>
        </div>
      </b-jumbotron>
    </div>
  </div>
</template>

<script>
  export default {
  	name: 'TriviaContent',
    props: {
		iCurrentQuestion: Number,
	    iTotalQuestions: Number,
        oCurrentQuestion: Object,
	    mIncrement: Function,
        mNext: Function,
    },
    data() {
      return {
        iSelectedIndex: null,
        iCorrectIndex: null,
        mShuffledAnswers: [],
        bAnswered: false,
      }
    },
    computed: {
      aAnswers() {
        let aAnswers = [...this.oCurrentQuestion.incorrect_answers];
        aAnswers.push(this.oCurrentQuestion.correct_answer)
        return aAnswers
      }
    },
    watch: {
      oCurrentQuestion: {
        immediate: true,
        handler() {
          this.iSelectedIndex = null
          this.bAnswered = false
          this.mShuffleAnswers()
        }
      },
    },
    methods: {
      mSelectAnswer(index) {
        this.iSelectedIndex = index
      },
      mSubmitAnswer() {
        let bIsCorrect = false
        if (this.iSelectedIndex === this.iCorrectIndex) {
          bIsCorrect = true
        }
        this.bAnswered = true
        this.mIncrement(bIsCorrect)
      },
      mShuffleAnswers() {
        let aAnswers = [...this.oCurrentQuestion.incorrect_answers, this.oCurrentQuestion.correct_answer]
        this.mShuffledAnswers = _.shuffle(aAnswers)
        this.iCorrectIndex = this.mShuffledAnswers.indexOf(this.oCurrentQuestion.correct_answer)
      },
      sAnswerClass(index) {
        let sAnswerClass = ''
        if (!this.bAnswered && this.iSelectedIndex === index) {
          sAnswerClass = 'selected'
        } else if (this.bAnswered && this.iCorrectIndex === index) {
          sAnswerClass = 'correct'
        } else if (
            this.bAnswered
            && this.iSelectedIndex === index
            && this.iCorrectIndex !== index) {
          sAnswerClass = 'incorrect'
        }
        return sAnswerClass
      }
    }
  }
</script>

<style scoped>
	.list-group {
	  margin-bottom: 15px;
	}
	.list-group-item:hover {
	  background-color: lightgray;
	  cursor: pointer;
	}
	.selected {
	  background-color: lightblue;
	}
	.correct {
	  background-color: lightgreen;
	  color: black;
	}
	.incorrect {
	  background-color: #F19E9C ;
	  color: black;
	}
	.jumbotron {
	  padding-top: 15px;
	  padding-bottom: 15px;
	  margin-bottom: 10px;
		background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
	}
	.btn {
	  margin: 0 15px;
	  cursor: auto;
	}
	.question-box-container {
	  margin: 0 -30px;
	}
</style>