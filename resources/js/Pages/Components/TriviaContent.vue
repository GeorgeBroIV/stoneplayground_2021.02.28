<template>
  <div class="max-w-6xl pt-3 mx-auto sm:px-6 lg:px-8">
    <div class="question-box-container">
      <p>Category: {{ currentQuestion.category }}</p>
      <b-jumbotron>

        <!-- Question -->
        <template slot="lead" v-html="currentQuestion.question">
          <div v-html="currentQuestion.question">
          {{ currentQuestion.question }}
          </div>
        </template>

        <!-- List of Answers (use v-html to suppress escaping of special characters -->
        <b-list-group>
          <b-list-group-item
              v-for="(answer, index) in answers"
              v-html="answer"
              :key="index"
              @click="selectAnswer(index)"
              :class="answerClass(index)"
              :disabled="answered"
          >
            {{ answer }}
          </b-list-group-item>
        </b-list-group>

        <!-- Form Buttons -->
        <div align="center" v-if="numTotal !== questions">
          <b-button
              variant="primary"
              @click="submitAnswer"
              :disabled="selectedIndex === null || answered"
          >
            Submit
          </b-button>
          <b-button
              @click="next"
              variant="success"
              href="#"
              :disabled="!answered"
          >
            Next
          </b-button>
        </div>
        <div align="center" v-if="numTotal === questions">
          <b-button variant="primary" :href="route('trivia')" :active="route().current('trivia')">
            Try another Trivia game
          </b-button>
        </div>

      </b-jumbotron>
      <div id='status' align="center" v-if="!answered" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100">
        Select an answer and click 'Submit'.
      </div>
      <div id='status' align="center" v-if="answered && selectedIndex === correctIndex" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100">
        Correct!  Click 'Next' for the next question.
      </div>
      <div id='status' align="center" v-if="answered && selectedIndex !== correctIndex" class="mt-0 mb-3 py-2 text-gray-700 bg-blue-100">
        Wrong guess, click 'Next' for the next question.
      </div>


    </div>
  </div>
</template>

<script>
import JetNavLink from '@/Jetstream/NavLink'

  export default {
    components: {
      JetNavLink
    },
    props: {
      currentQuestion: Object,
      next: Function,
      increment: Function,
      numTotal: Number,
      questions: Number

    },
    data() {
      return {
        selectedIndex: null,
        correctIndex: null,
        shuffledAnswers: [],
        answered: false,
      }
    },
    computed: {
      answers() {
        let answers = [...this.currentQuestion.incorrect_answers];
        answers.push(this.currentQuestion.correct_answer)
        return answers
      }
    },
    watch: {
      currentQuestion: {
        immediate: true,
        handler() {
          this.selectedIndex = null
          this.answered = false
          this.shuffleAnswers()
        }
      }
    },
    methods: {
      selectAnswer(index) {
        this.selectedIndex = index
      },
      submitAnswer() {
        let isCorrect = false
        if (this.selectedIndex === this.correctIndex) {
          isCorrect = true
        }
        this.answered = true

        this.increment(isCorrect)
      },
      shuffleAnswers() {
        let answers = [...this.currentQuestion.incorrect_answers, this.currentQuestion.correct_answer]
        this.shuffledAnswers = _.shuffle(answers)
        this.correctIndex = this.shuffledAnswers.indexOf(this.currentQuestion.correct_answer)
      },
      answerClass(index) {
        let answerClass = ''
        if (!this.answered && this.selectedIndex === index) {
          answerClass = 'selected'
        } else if (this.answered && this.correctIndex === index) {
          answerClass = 'correct'
        } else if (
            this.answered
            && this.selectedIndex === index
            && this.correctIndex !== index) {
          answerClass = 'incorrect'
        }
        return answerClass
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
}
.btn {
  margin: 0 15px;
  cursor: auto;
}
.question-box-container {
  margin: 0 -30px;
}
</style>