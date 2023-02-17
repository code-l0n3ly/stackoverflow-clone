<?php
    include "includes/header.php";
?>
    <!-- main section -->
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column mt-5 align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-5">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>
                  <!-- form -->
                  <form class="row g-3 needs-validation" novalidate>
                    
                    <div class="col-12">
                      <label for="name" class="form-label">Username</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-file-earmark-person-fill"></i></span>
                        <input type="text" name="name" class="form-control" id="name" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope-fill"></i></span>
                        <input type="text" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-key-fill"></i></span>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">Please enter your password!</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <button id="register-btn" class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">I already have account? <a href="login.php">Login</a></p>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main>
  <!-- end main section -->
  <script>
    $("#register-btn").click(function(event) {
        event.preventDefault();
        const name = $("#name").val();
        const email = $("#email").val();
        const password = $("#password").val();
        if(name == "" || email == "" || password == "") {
            swal("Error!", "Please fillup all information!", "error");
        }else if(!validateEmail(email)){
          swal("Error!", "Please enter valid email!", "error");
        }else if(!validatePassword(password)){
          swal("Error!", "Password should grater than 8 char!", "error");
        }else {
            $.ajax({
                url: "http://localhost/stackoverflow/api/register-user.php",
                method: "POST",
                data: {
                    name: name,
                    email: email,
                    password: password
                },
                success: function(data) {
                    if(data.status) {
                        swal("Successfull!", data.message, "success");
                        setTimeout(function() {
                            window.location.replace('http://localhost/stackoverflow/login.php');
                        },2500);
                    }else {
                        swal("Error!", data.message, "error");
                    }
                }
            });
        }
    });

    function validatePassword(password) {
      if(password.length > 8) {
        return true;
      }
      return false;
    }

    function validateEmail(email) {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return (true)
      }
      return (false);
    }

  </script>
<?php
    include "includes/footer.php";
?>  