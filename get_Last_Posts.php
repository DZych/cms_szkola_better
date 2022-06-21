<?php
require_once("config.php");

$query = "SELECT * FROM wiadomosci";
$result = mysqli_query($link, $query) or die ("Zapytanie zakończone niepowodzeniem");

echo '  <div class="container">
        <h1 class="my-4 text-center fw-bold">Ostatnio u nas</h1>
        <hr class="bg-secondary mx-auto" style="width:10%;">
        ';

while ($wynik = mysqli_fetch_assoc($result)) {
    $post_id = $wynik['id_wiadomosci'];
    $post_title = $wynik['tytul'];
    $post_contet = $wynik['tresc'];
    $post_image = $wynik['zdjecie'];

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

 echo "</div>" 
?>
