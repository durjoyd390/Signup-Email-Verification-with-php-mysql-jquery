<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sign Up</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

<section class="vh-100" style="background-color: #eee;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-11">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

              <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>

               <form class="mx-1 mx-md-4">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="fullname">Your Name</label>
                      <input type="text" id="fullname" class="form-control" placeholder="Enter Your Full Name..." />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="email">Your Email</label>
                      <input type="email" id="email" class="form-control" placeholder="Enter Your E-mail..." />
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                    <label class="form-label" for="password">Password</label>
                      <input type="password" id="password" class="form-control" placeholder="Enter Your Password..."/>
                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="button" class="btn btn-primary btn-lg" name="submit" id="submit">Register</button>
                  </div>
                </form>

<div id="re"></div>

              </div>

              <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">
                <img src="img/draw1.webp"
                  class="img-fluid" alt="Sample image">
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<script>
  $(document).ready(function () {
    $('#submit').click(function (e) {
      e.preventDefault();

       $('#submit[name="submit"]').html('<i style="font-size:20px;" class="fas fa-cog fa-spin">');
        setTimeout(function(){
            $('#submit[name="submit"]').text('Sign Up');
        }, 1300);

      var fullname = $('#fullname').val();
      var email = $('#email').val();
      var password = $('#password').val();
      $.ajax
        ({
          type: "POST",
          url: "reg.php",
          data: { "fullname": fullname, "email": email, "password": password},
          success: function (data) {
          if (data != 'ok') {
           $('#re').html(data);
            }else{
     window.location='verification.php';
            }
         

          }
        });
    });
  });
</script>
</body>
</html>