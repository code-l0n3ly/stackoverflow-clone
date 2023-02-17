<?php
    include "includes/header.php";
    if($isLogin) {
      echo "<script>window.location.replace('http://localhost/stackoverflow/')</script>";
    }

    $url = 'http://localhost/stackoverflow/api/login-user.php';

    if(isset($_POST['email'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $data = array(
            'email' => $email,
            'password' => $password,
        );
    
        $data = get_request_withcontext($url, $data);
        
        if(!empty($data->status)) {
            echo '<script>swal("Error", "'.$data->message.'" , "error")</script>';
        }else {
            $_SESSION['user'] = $data;
            print_r($_SESSION['user']);
            echo '<script>swal("Successfull", "Login successfull!" , "success")</script>';
            echo "<script>setTimeout(function(){window.location.replace('http://localhost/stackoverflow/')},2000)</script>";
        }
    }
    
?>

    <!-- main section -->
  <main>
    <div class="container">
      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
              <div class="card mb-5">

                <div class="card-body ">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>
                  <!-- form -->
                  <form action="" method="post" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend"><i class="bi bi-envelope-fill"></i></span>
                        <input type="text" name="email" id="email" class="form-control" required>
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
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="register.php">Create an account</a></p>
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
<?php
    include "includes/footer.php";
?>

