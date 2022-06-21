<?php
    require_once "config/config_sql.php";

    require 'autoload.php';

    $client = new MongoDB\Client(
        'mongodb://127.0.0.1:27017'
    );
    $laptop = $client->uas_pds->laptop_model;
    $cursor_laptop = $laptop->find();

    $brand = $client->uas_pds->brand;
    $cursor_brand = $brand->find();
    $cursor_brand2 = $brand->find();

    $rating = $client->uas_pds->rating;
    $cursor_rating = $rating->find();

    $count = 0;

    $brand_laptop = "";
    $array_brand = array("");

    foreach ($cursor_brand as $value2) {
        array_push($array_brand, $value2->brand);
    }

    $array_jumlah_rating = array();

    $array_jumlah_perating = array();

    for($i = 0; $i < $laptop->count(); $i++){
        array_push($array_jumlah_rating, 0);
        array_push($array_jumlah_perating, 0);
    }

    foreach ($cursor_rating as $value3) {
        $id_laptop_rating = $value3->id_laptop;
        
        $array_jumlah_rating[$id_laptop_rating - 1] += $value3->rating;
        $array_jumlah_perating[$id_laptop_rating - 1] += 1;
    }

    // $array2d = array(array(1, 2, 3, 4), array(5, 5, 5, 5));
    // print_r($array2d);
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Katalog Laptop</title>
</head>
<body class="bg-secondary">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="Laptop_Catalog.php">Laptop's Catalog</a>
            <form action="" method="post">
                <select name="filter" class="bg-secondary">
                    <option value=pilihan1>High spec and low price</option>
                    <option value=pilihan2>Best Selling Brand</option>
                    <option value=pilihan3>High rate and low price</option>
                </select>
                <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Filter
                </button>
            </form>
            <div class="dropstart">
                <button type="button" class="btn btn-secondary dropdown-toggle text-black" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo htmlspecialchars($_SESSION["username"]); ?>
                </button>
                <ul class="dropdown-menu bg-secondary ">
                    <li><a class="dropdown-item" href="auth/reset-password.php">Change Password</a></li>
                    <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <?php foreach ($cursor_laptop as $id => $value) { ?>
        <?php if ($count == 0) { ?>
            <div class="card-group">
        <?php } ?> 
            <div class="card text-white bg-secondary border-dark">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $value->tipe_laptop ?></h5>
                    <?php for ($j = 0; $j < 21; $j++) { ?>
                        <?php if ($j == $value->id_brand) { ?>
                            <?php $brand_laptop = $array_brand[$j]; ?>
                        <?php } ?>
                    <?php } ?>
                    <p class="card-text"><?php echo 'ID : '.$value->id ?></p>
                    <p class="card-text"><?php echo 'Brand : '.$brand_laptop ?></p>
                    <p class="card-text"><?php echo 'Processor : '.$value->processor_name ?></p>
                    <p class="card-text"><?php echo 'Processor Gen : '.$value->processor_gen ?></p>
                    <p class="card-text"><?php echo 'RAM : '.$value->ram." GB" ?></p>
                    <p class="card-text"><?php echo 'RAM Type : '.$value->ram_type ?></p>
                    <p class="card-text"><?php echo 'HDD | SSD : '.$value->hdd." GB | ".$value->ssd." GB" ?></p>
                    <p class="card-text"><?php echo 'OS : '.$value->os ?></p>
                    <p class="card-text"><?php echo 'OS Bit : '.$value->os_bit ?></p>
                    <p class="card-text"><?php echo 'Warranty : '.$value->warranty. " Year" ?></p>
                    <p class="card-text"><?php echo 'Ms Office : '.$value->ms_office ?></p>
                    <p class="card-text"><?php echo 'Price : '.$value->price ?></p>
                    <?php 
                        if($array_jumlah_perating[$value->id - 1] == 0){
                            $rata2_rating = 0;
                        }else{
                            $rata2_rating = $array_jumlah_rating[$value->id - 1] / $array_jumlah_perating[$value->id - 1];
                        }
                    ?>
                    <p class="card-text"><?php echo 'Rating : '.$rata2_rating." dari jumlah yang merating : ". $array_jumlah_perating[$value->id - 1] ?></p>
                </div>
            </div>
            <?php $count++; ?>
            <?php if ($count == 3) { ?>
                <?php echo '</div>'; $count = 0; ?>
            <?php } ?>
        <?php } ?>
        

    <!-- <div class="card-group">
        <div class="card text-white bg-secondary border-dark">
            <div class="card-body">
                <h5 class="card-title">ASUS A416</h5>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
            </div>
        </div>
        <div class="card text-white bg-secondary border-dark">
            <div class="card-body">
                <h5 class="card-title">ASUS E210</h5>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
            </div>
        </div>
        <div class="card text-white bg-secondary border-dark">
            <div class="card-body">
                <h5 class="card-title">ASUS A509</h5>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
                <p class="card-text">Merk : Asus</p>
            </div>
        </div>
    </div> -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table border="1" class="table">
                        <tr>
                            <th>ID</th>
                            <th>Brand</th>
                            <th>Total Penjualan</th>
                        </tr>
                        <?php 
                            $query_mysql = mysql_query("SELECT * FROM user")or die(mysql_error());
                            
                            foreach ($cursor_brand2 as $v) {
                                echo "<tr>";
                                echo "<td>".$v->id."</td>";
                                echo "<td>".$v->brand."</td>";
                            }
                            
                            // $nomor = 1;
                            // while($data = mysql_fetch_array($query_mysql)){
                        ?>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>