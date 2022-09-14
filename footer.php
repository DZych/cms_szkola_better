<?php include_once("branding.php"); ?>

<footer class="bg-primary text-white text-center text-lg-start mt-4">
  <!-- Grid container -->
  <div class="container p-4">
    <!--Grid row-->
    <div class="row">
      <!--Grid column-->
      <div class="col-lg-6 col-md-12 mb-4 mb-md-0">
        <h5 class="text-uppercase"><?php echo $skrocona_nazwa_szkoly ?></h5>

        <p>
        <?php echo $adres_szkoly ?>
        </p>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Email</h5>

        <ul class="list-unstyled mb-0">
          <li>
          <?php echo $pierwszy_mail ?>
          </li>
          <li>
          <?php echo $drugi_mail ?>
          </li>
        </ul>
      </div>
      <!--Grid column-->

      <!--Grid column-->
      <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
        <h5 class="text-uppercase">Telefon</h5>

        <ul class="list-unstyled mb-0">
          <li>
          <?php echo $pierwszy_numer_tel ?>
          </li>
          <li>
          <?php echo $drugi_numer_tel ?>
          </li>
        </ul>
      </div>
      <!--Grid column-->
    </div>
    <!--Grid row-->
  </div>
  <!-- Grid container -->

  <!-- Copyright -->
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
    © 2020 Copyright:
    <a class="text-white" href="index.php"><?php echo $skrocona_nazwa_szkoly ?></a>
  </div>
  <!-- Copyright -->
</footer>