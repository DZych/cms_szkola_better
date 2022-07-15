<?php
require_once("config.php");

$query = "SELECT * FROM ".$prefix."_news ORDER BY news_id DESC LIMIT 4";
$result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

echo '  <div class="container">
        <h1 class="my-4 text-center fw-bold">Ostatnio u nas</h1>
        <hr class="bg-secondary mx-auto" style="width:10%;">
        ';

while ($wynik = mysqli_fetch_assoc($result)) {
    $post_id = $wynik['news_id'];
    $post_title = $wynik['title'];
    $post_contet = $wynik['content'];
    $post_image = $wynik['image'];

    // przycięcie zawartości postu
    $result_content = strlen($post_contet) > 600 ? substr($post_contet,0,600)."..." : $post_contet;
    echo '
    <div class="row">
        <div class="col-md-7">
            <a href="view.php?id='.$post_id.'">
                <img class="img-fluid rounded mb-3 mb-md-0" src="data:image/jpeg;base64,'.base64_encode($post_image).'" alt="">
            </a>
        </div>
        <div class="col-md-5">
            <h3>'.$post_title.'</h3>
            <p>'.$result_content.'</p>
            <a class="btn btn-secondary float-end" href="view.php?id='.$post_id.'">Zobacz więcej</a>
        </div>
    </div>
    </br>
    </br>
    ';
  }

 echo "</div>";
 mysqli_close($link); 
?>
