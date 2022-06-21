<?php
    require_once "config/config_sql.php";

    require 'autoload.php';

    $client = new MongoDB\Client(
        'mongodb://127.0.0.1:27017'
    );
    $laptop = $client->uas_pds->laptop_model;
    $cursor_laptop = $laptop->find();
    $cursor_laptop_transaksi = $laptop->find();

    $brand = $client->uas_pds->brand;
    $cursor_brand = $brand->find();
    $cursor_brand2 = $brand->find();

    $rating = $client->uas_pds->rating;
    $cursor_rating = $rating->find();
    $cursor_rating2 = $rating->find();

    $count = 0;
    $count_brand = 1;

    $array_id_brand_laptop = array("");
    $array_brand_laptop = array("");
    $array_brand = array("");
    $array_tipe_laptop = array("");
    $array_harga_laptop = array("");

    $array_jumlah_rating = array();
    $array_jumlah_perating = array();
    $array_jumlah_brand_terjual = array();

    foreach ($cursor_brand as $value2) {
        array_push($array_brand, $value2->brand);
    }

    for($i = 0; $i < $laptop->count(); $i++){
        array_push($array_jumlah_rating, 0);
        array_push($array_jumlah_perating, 0);
    }

    foreach ($cursor_rating as $value3) {
        $id_laptop_rating = $value3->id_laptop;
        $array_jumlah_rating[$id_laptop_rating - 1] += $value3->rating;
        $array_jumlah_perating[$id_laptop_rating - 1] += 1;
    }

    foreach ($cursor_laptop_transaksi as $value4) {
        array_push($array_brand_laptop, $array_brand[$value4->id_brand]);
        array_push($array_id_brand_laptop, $value4->id_brand);
        array_push($array_tipe_laptop, $value4->tipe_laptop);
        array_push($array_harga_laptop, $value4->price);
    }

    $sql_transaksi = "SELECT id_laptop FROM transaksi";
    $query_transaksi = mysqli_query($link, $sql_transaksi);
    $item_terjual = array("");

    while($row = mysqli_fetch_assoc($query_transaksi)) {
        array_push($item_terjual, $row);
    }
    
    for($i = 0; $i < count($array_brand); $i++){
        array_push($array_jumlah_brand_terjual, 0);
    }

    for($i = 0; $i < count($item_terjual) - 1; $i++){
        $array_jumlah_brand_terjual[$array_id_brand_laptop[$item_terjual[$i + 1]['id_laptop']]] += 1;
    }
?>

<?php
    // Initialize the session
    session_start();
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: auth/login.php");
        exit;
    }
?>