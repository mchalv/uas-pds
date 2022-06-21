<?php
    require 'autoload.php';

    $client = new MongoDB\Client(
        'mongodb://127.0.0.1:27017'
    );
    $laptop = $client->uas_pds->laptop_model;
    $cursor_laptop = $laptop->find();

    $brand = $client->uas_pds->brand;
    $cursor_brand = $brand->find();

    $brand_laptop = "";
    $count = 0;
    $array_brand = array("");

    foreach ($cursor_brand as $value2) {
        array_push($array_brand, $value2->brand);
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
                    <option value=pilihan1>Best Selling Brand</option>
                    <option value=pilihan1>High rate and low price</option>
                </select>
                <button class="btn btn-outline-success" type="submit" name="filter" value="Filter">Filter</button>
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
            <?php echo '<div class="card-group">'; $count++; ?>
        <?php } elseif ($count == 4) { ?>
            <?php echo '</div>'; $count = 0; ?>
        <?php } else { ?>
            <div class="card text-white bg-secondary border-dark">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $value->tipe_laptop ?></h5>
                    <?php for ($j = 0; $j < 21; $j++) { ?>
                        <?php if ($j == $value->id_brand) { ?>
                            <?php $brand_laptop = $array_brand[$j]; ?>
                        <?php } ?>
                    <?php } ?>
                    <p class="card-text"><?php echo 'Brand : '.$brand_laptop ?></p>
                    <p class="card-text"><?php echo $value->tipe_laptop ?></p>
                    <p class="card-text"><?php echo $value->tipe_laptop ?></p>
                    <p class="card-text"><?php echo $value->tipe_laptop ?></p>
                    <p class="card-text"><?php echo $value->tipe_laptop ?></p>
                    <p class="card-text"><?php echo $value->tipe_laptop ?></p>
                </div>
            </div>
        <?php $count++; } ?>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>