<template>
  <footer>
    <div class="container-fluid p-0">
      <div class="row text-left">
        <div class="col-md-5">
          <h1 class="text-light">About Us</h1>
          <p class="text-muted">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Expedita ad illo et optio quam vero alias eaque.
            Dolor.
          </p>
          <p class="pt-4 text-muted">
            Copyright &copy;2019 All rigth reserved | This template is made with by
            <span>Daily Tuition</span>
          </p>
        </div>
        <div class="col-md-5">
          <h4 class="text-light">News Letter</h4>
          <p class="text-muted">
            Stay Updated
          </p>
          <form class="form-inline">
            <div class="col pl-0">
              <div class="input-group pr-5">
                <input type="text" class="form-control bg-dark text-white" id="inlineFormInputGroupUsername2"
                  placeholder="Email">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    <i class="fas fa-arrow-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="col-md-2">
          <h4 class="text-light">Follow Us</h4>
          <p class="text-muted">Let us be social</p>
          <div class="column">
            <i class="fab fa-facebook-f"></i>
            <i class="fab fa-instagram"></i>
            <i class="fab fa-twitter"></i>
            <i class="fab fa-youtube"></i>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'footer-section'
}
</script>

<style scoped>
/********** footer **********/
footer {
  background: rgba(0, 0, 0, 0.815);
  overflow-x: hidden;
  padding: 6vmin 18vmin;
}

footer p>span {
  color: #ff512f;
}

footer input {
  border: none !important;
}

footer input::placeholder {
  color: white !important;
}

footer .input-group .input-group-text {
  background: linear-gradient(to bottom, #dd2476, #ff512f);
  border: none;
}

footer .column i {
  color: #dd2476;
}

/* It is Adjacent sibling combinator */

footer .column i+i {
  padding: 0 0.5em;
}

.sticky {
  position: fixed;
  top: 0;
  width: 100%;
  background: rgba(0, 0, 0, 0.815);
  z-index: 9999;
  transition: all 1.5s ease;
}
</style>
