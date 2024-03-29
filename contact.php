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
    <link href="css/contact.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="//static.rmt.pl/cache.ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="scripts/contact.js"></script>
    <title><?php echo $pelna_nazwa_szkoly ?></title>
</head>

<body>

    <?php include_once("nav.php"); ?>

    <header class="masthead d-flex align-items-center">
        <div class="p-5 text-white lh-sm">
            <p class="fs-1 fw-bold "><?php echo $pelna_nazwa_szkoly ?></p>
            <p class="fs-3">Miejsce w którym czujesz się bezpiecznie</p>
        </div>
    </header>

    <!-- Kontakt -->

    <section class="box-section">
        <div class="container">
            <div class="my-4 text-center fw-bold">
                <h1>Kontakt</h1>
            </div>
            <div class="data-contact">
                <div class="data">
                    <h3>Dane kontatowe</h3>
                    <div class="adress">
                    <?php echo $pelna_nazwa_szkoly ?> </br>
                    <?php echo $adres_szkoly ?>
                    </div>
                    <div class="contact-number">
                    <?php echo $pierwszy_numer_tel ?> </br>
                    <?php echo $drugi_numer_tel ?> </br>
                    <?php echo $pierwszy_mail ?>

                    </div>

                </div>
                <div class="contact-form">

                    <h3>Formularz kontaktowy:</h3>
                    <form method="post" action="scripts/php/send_contact.php" id="contact_form">
                        <div><label for="name">Imię i nazwisko</label></div>
                        <div><input type="text" name="name" id="name" class="formField" /></div>
                        <div><label for="phone">Numer telefonu</label></div>
                        <div><input type="text" name="phone" id="phone" class="formField" /></div>
                        <div><label for="email">Adres email</label></div>
                        <div><input type="text" name="email" id="email" class="formField" /></div>
                        <div><label for="message">Treść wiadomości</label></div>
                        <div><textarea name="message" id="message" class="formField"></textarea></div>
                        <div><button id="sendBtn">Wyślij</button></div>
                    </form>

                </div>
            </div>

        </div>



    </section>
    <section class="maps">
        <div class="my-4 text-center fw-bold">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2469.8107932239545!2d19.3827829154604!3d51.754783300406594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471a356070f102d3%3A0xa5b42e013fc02ec0!2zS29uc3RhbnR5bm93c2thIDEwNywgOTAtMDAxIMWBw7Nkxbo!5e0!3m2!1spl!2spl!4v1655927554616!5m2!1spl!2spl"
                width="1280" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>




    <!-- /.container -->

    <!-- stopka  -->
    <?php
    include_once("footer.php");
    ?>

</body>

</html>