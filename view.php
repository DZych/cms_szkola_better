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
    <title></title>
</head>

<body>

    <?php include_once("nav.php") ?>

    <?php
    if(isset($_REQUEST['id'])){
        $id = $_REQUEST['id'];

        require_once("config.php");
        $query = "SELECT * FROM ".$prefix."_news where news_id = $id";
        $result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

        while ($wynik = mysqli_fetch_assoc($result)) {
            $post_id = $wynik['news_id'];
            $post_title = $wynik['title'];
            $post_contet = $wynik['content'];
            $post_image = $wynik['image'];
            $post_date = $wynik['date'];

            echo'
                <div class="container mt-5">
                    <div class="col-md-8 offset-md-2">
                        <!-- Post header-->
                        <header class="mb-4">
                                <!-- Post title-->
                                <h1 class="fw-bolder mb-1">'.$post_title.'</h1>
                                 <!-- Post meta content-->
                                <div class="text-muted fst-italic mb-2">Opublikowano '.$post_date .'</div>
                            </header>
                            <!-- Preview image figure-->
                            <figure class="mb-4"><img class="img-fluid rounded" src="data:image/jpeg;base64,'.base64_encode($post_image).'" alt="..." /></figure>
                             <!-- Post content-->
                             <section class="mb-5">
                             '.$post_contet.'
                            </section>
                        </article>
                    </div>
                </div>
            ';
        }
        
    }
    ?>



    <?php include_once("footer.php") ?>

</body>

</html>