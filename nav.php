 <!-- Nawigacja -->

 <?php include_once("branding.php"); ?>

 <nav class="navbar navbar-expand-sm navbar-light bg-white sticky-top shadow-5-stron shadow ">
     <div class="container-fluid">
         <a class="navbar-brand fa-bold" href="index.php">
             <?php echo $skrocona_nazwa_szkoly ?>
         </a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#main-navbar">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="main-navbar">
             <ul class="navbar-nav me-auto">
                 <li class="nav-item">
                     <a class="nav-link text-dark fw-bold" href="index.php">Aktualności</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link text-dark fw-bold" href="login.php">Dziennik</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link text-dark fw-bold" href="about.php">O Naszej szkole</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link text-dark fw-bold" href="contact.php">Kontakt</a>
                 </li>
             </ul>
             <a class="btn btn-primary" href="login.php">Zaloguj</a>
         </div>
     </div>
 </nav>