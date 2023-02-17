

  <!-- question modal -->
  <div class="modal fade" id="questionUpdateModal" tabindex="-1" aria-labelledby="questionUpdateModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="rting-form" class="needs-validation">
          <div class="modal-body p-0">
            <div class="card m-0">
              <div class="card-body">
                <h5 class="card-title">Post a new Question!</h5>
                  <div class="col-sm-12 col-md-12 align-items-center justify-content-center">
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-card-heading"></i></span>
                      <input type="text" id="question"  name="question" placeholder="question title" class="form-control" required>
                    <div class="invalid-feedback">Please enter question title.</div>
                  </div>
                  <div class="mt-2 col-sm-12 col-md-12 align-items-center justify-content-center">
                    <div class="input-group has-validation">
                      <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-patch-question-fill"></i></span>
                      <textarea type="text" id="description"  name="description" class="form-control" required> question description </textarea>
                    <div class="invalid-feedback">Please enter question description.</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="question-update-btn"  type="submit" class="btn btn-primary">Post</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- end question modal -->








 <!-- bootstrap cdns -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/js/main.js"></script>
  </body>
</body>
</html>