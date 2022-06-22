<?php 
    require_once "all_query.php";
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
            <div class="dropdown">
                <button type="button" class="btn btn-secondary dropdown-toggle text-black" data-bs-toggle="dropdown" aria-expanded="false">
                    Analisa
                </button>
                <ul class="dropdown-menu bg-secondary ">
                    <li><a class="dropdown-item" href="analisa1_.php">Best Selling Brand</a></li>
                    <li><a class="dropdown-item" href="analisa2_.php">Search Laptop by Price</a></li>
                    <li><a class="dropdown-item" href="analisa3_.php">High rate and low price</a></li>
                </ul>
            </div>
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
                    <p class="card-text"><?php echo 'ID : '.$value->id ?></p>
                    <p class="card-text"><?php echo 'Brand : '.$array_brand_laptop[$count_brand++] ?></p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>