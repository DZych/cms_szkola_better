<!DOCTYPE html>
<html lang="en">

<?php include_once("branding.php"); ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <title><?php echo $pelna_nazwa_szkoly ?></title>
</head>

<body>
  
   <?php include_once("nav.php"); ?>

    <header class="masthead d-flex align-items-center">
        <div class="p-5 text-white lh-sm" >
            <p class="fs-1 fw-bold "><?php echo $pelna_nazwa_szkoly ?></p>
            <p class="fs-3">Miejsce w którym czujesz się bezpiecznie</p>
        </div>
    </header>

    <!-- Ostatnio opublikowane posty -->

    <?php
    include_once("scripts/php/get_Last_Posts.php");
    ?>
      

    <!-- /.container -->

    <!-- stopka  -->
    <?php
    include_once("footer.php");
    ?>

</body>

</html>