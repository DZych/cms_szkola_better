<?php session_start();
      if((isset($_SESSION['zalogowany'])) && $_SESSION['zalogowany']==true){
      header("location:dashboard/index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
</head>

<body style="display: flex;
  flex-direction: column;
  min-height: 100vh;">
    <?php include_once("nav.php") ?>


   <div class="container" style="flex: 1;">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto ">
        <div class="card border-0 shadow rounded-3 my-5" >  
          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Witaj, tutaj możesz się zalogować</h5>
            <form action="scripts/php/zaloguj.php" method="post">
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email">
                <label for="floatingInput">Adres email</label>
              </div>
              <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="haslo">
                <label for="floatingPassword">Hasło</label>
              </div>
              <div class="d-grid">
                <button class="btn btn-primary btn-login text-uppercase fw-bold p-3 m-2" type="submit">Zaloguj się</button>
              </div>
            </form>
          </div>
        </div>
        <?php if(isset($_SESSION['error'])) echo $_SESSION['error']; unset($_SESSION['error']);?>
      </div>
    </div>
  </div>
  <
  
    <?php include_once("footer.php") ?>
</body>

</html>