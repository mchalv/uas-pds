<?php
    require_once "all_query.php";

    $cursor_cari = $laptop->find();

    $cari = 0;

    if (!empty($_POST)) {
        if ($_POST["sbmtBtn"] == "Cari") {
            $cari = $_POST['usr-inpt'];
            if(empty($cari)){
                $cursor_cari = $laptop->find();
            }
            else {
                $cursor_cari = $laptop->find(['price'=>$cari]);
                print_r($cursor_cari);
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Search Laptop by Price</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="Laptop_Catalog.php">Laptop's Catalog</a>
            <a class="navbar-brand">Search Laptop by Price</a>
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

    <div style="margin-left: 12px; margin-bottom: 15px; margin-top: 10px;">
        <h4>Masukkan harga laptop (tertinggi)</h4>
        <form action="" method="post">
            <input type="text" name="usr-inpt">
            <input type="submit" class="btn-primary text-white" value="Cari" name="sbmtBtn"/>
        </form>
    </div>

    <table border="1" class="table">
        <tr>
            <th>ID</th>
            <th>Brand</th>
            <th>Tipe Laptop</th>
            <th>Harga</th>
        </tr>
        <?php 
            $c=0;
            foreach ($cursor_cari as $v) {
                echo "<tr>";
                echo "<td>".$v->id."</td>";
                echo "<td>".$array_brand_laptop[$v->id_brand]."</td>";
                echo "<td>".$v->tipe_laptop."</td>";
                echo "<td>".$v->price."</td>";
                echo "</tr>";
            }
        ?>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>