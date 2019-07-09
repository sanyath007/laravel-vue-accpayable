<template>
  <div :style="containerBackgroundStyle">
    <header-section :is-logged-in="isLoggedIn" :current-user="currentUser" />

    <main>
      <section class="section-1">
        <router-view></router-view>
      </section>
    </main>

    <footer-section />
  </div>
</template>

<script>
  import { mapGetters } from 'vuex'
  import Header from './Header'
  import Footer from './Footer'

  export default {
    name: 'App',
    components: {
      'header-section': Header,
      'footer-section': Footer,
    },
    data() {
      return {

      }
    },
    mounted() {
      console.log('Component mounted.')
      console.log(this.currentPage)
    },
    computed: {
      ...mapGetters({ 
        isLoggedIn: 'user/isLoggedIn',
        currentUser: 'user/currentUser',
        currentPage: 'page/currentPage',
      }),
      containerBackgroundStyle: function() {
        let bg = (this.currentPage === 'login' || this.currentPage === 'register')
                    ? "url('http://localhost:8000/img/mountain.png') no-repeat center center fixed"
                    : 'white'

        return {
          background: bg,
          backgroundSize: 'cover'
        }
      }
    },
    methods: {
      
    }
  }
</script>

<style scoped>
  * {
    box-sizing: border-box;
  }

  /* header,
  section {
    overflow-x: hidden;
  } */

  :root {
    --Snigle-font: "Snigle", cursive;
    --Rubik: "Rubik", cursive;
    --Patua: "Patua One", cursive;
    --Lobster: "Lobster", cursive;
    --light-black: #2e2c2caf;
    --bggradient: linear-gradient(to bottom,
        #dd2476, #ff512f);
    --light-gray: rgba(255, 255, 255, 0.2)
  }

  /********** section-1 **********/
  .section-1 {
    padding: 20vmin 0vmin;
  }

  .section-1 .row .col-md-6 .pray img {
    opacity: 0.8;
    width: 80%;
    border-radius: 0.2em;
  }

  .section-1 .row .col-md-6:last-child {
    position: relative;
  }

  .section-1 .row .col-md-6 .panel {
    position: absolute;
    top: 7vmin;
    left: -18vmin;
    background: white;
    border-radius: 3px;
    text-align: left;
    padding: 13vmin 5vmin 20vmin 10vmin;
    box-shadow: 0px 25px 42px rgba(0, 0, 0, 0.2);
    font-family: var(--Rubik);
    z-index: 1;
  }

  .section-1 .row .col-md-6 .panel h1 {
    font-weight: bold;
    padding: 0.4em 0;
    font-size: 2em;
  }

  .section-1 .row .col-md-6 .panel p {
    font-size: 0.9em;
    color: rgba(0, 0, 0, 0.5);
  }

  /********** section-2 **********/
  /* .cover {
    width: 100%;
    height: 55vmin;
    background: url('../assets/pexels-photo-452738.jpeg');
    background-position: -24rem -19rem;
    background-size: 150%;
    position: relative;
  } */

  .cover .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
  }

  .cover .content {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    padding-top: 19vmin;
  }

  .cover .content>h1 {
    font-weight: var(--Patua);
    font-size: 6vmin;
    color: whitesmoke;
  }

  .cover .content>p {
    font-weight: var(--Rubik);
    font-size: 2vmin;
    color: #e5e5e5;
  }

  .numbers {
    margin-top: -15vmin;
  }

  .numbers .rect {
    position: relative;
    z-index: 1;
    background: white;
    width: 17rem;
    height: 12rem;
    padding-top: 3.5vmin;
    margin: 1rem;
    border-radius: 0.5em;
    box-shadow: 1px 2px 50px 0px rgba(255, 0, 0, 0.349)
  }

  .numbers .rect h1 {
    font-size: 5rem;
    color: tomato;
  }

  .numbers .rect>p {
    font-family: var(--Patua);
  }

  .purchase>h1 {
    padding-top: 15vmin;
    padding-bottom: 0.1em;
    font-family: var(--Lobster);
  }

  .purchase>p {
    color: var(--light-black);
    font-size: 3vmin;
    padding-bottom: 10vmin;
  }

  .purchase .cards .card {
    width: 22rem;
    margin: 3vmin 3vmin;
  }

  .cards div {
    padding: 0;
    margin: 0;
  }

  .cards .title {
    background: rgba(208, 241, 241, 0.199);
    padding: 1.4em 2.5em;
    font-size: 2vmin;
  }

  .card .card-text {
    padding: 2.5rem 3rem;
    color: var(--light-black);
  }

  .card-body .pricing {
    background: rgba(208, 241, 241, 0.199);
    border-top-right-radius: 170px;
    border-top-left-radius: 170px;
  }

  .card-body .pricing>h1 {
    font-size: 8vmin;
    padding: 1em 0.5em;
  }

  .card-body .pricing a {
    border-radius: 30px;
    font-weight: bold;
  }

  /********** section-3 **********/
  .section-3 {
    height: 70vmin;
    margin-top: 15vmin;
    background: var(--bggradient);
  }

  .section-3 .col-md-12>h1 {
    padding: 2em 0 0.5em 0;
    color: whitesmoke;
    font-size: 6vmin;
  }

  .section-3 .col-md-12>p {
    padding: 0 4em;
    padding-bottom: 2em;
    color: var(--light-gray);
    font-size: 3vmin;
  }

  .section-3 .desktop {
    background: white;
    display: inline-block;
    border-radius: 3em;
    padding: 2vmin 4.5vmin;
    margin: 1em;
  }

  .section-3 .desktop h3 {
    font-size: 4vmin;
  }

  .section-3 .desktop p {
    font-size: 2vmin;
  }

  /********** section-4 **********/
  .section-4 .container h1 {
    font-size: 6vmin;
    padding-top: 14vmin;
  }

  .section-4 .team {
    padding: 10vmin 4vmin;
  }

  .section-4 .card {
    width: 22em;
    margin-top: 10vmin;
  }

  .section-4 .card .card-text {
    padding: 0.5em;
  }

  .section-4 .card-body>a {
    font-size: 1.5em;
  }

  .section-4 .carousel-item {
    padding-left: 3rem;
  }

  .border-radius {
    border-radius: 340px;
    width: 60%;
  }
</style>
