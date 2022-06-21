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
    <title>High rate and low price</title>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="Laptop_Catalog.php">Laptop's Catalog</a>
            <a class="navbar-brand">High rate and low price</a>
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
    <table border="1" class="table">
        <tr>
            <th>ID</th>
            <th>Tipe Laptop</th>
            <th>Rating</th>
            <th>Harga</th>
        </tr>
        <?php 
            $c=0;

            $db = $client->uas_pds;

            $collections = $db->listCollections();
            $collectionNames = [];
            
            foreach ($collections as $collection) {
                $collectionNames[] = $collection->getName();
            }

            $exists = in_array('sorting_harga', $collectionNames);

            if ($exists) {
                $bul = $db->sorting_harga;
            } else {
                $bul = $db->createCollection("sorting_harga");
                $bul = $db->sorting_harga;
                foreach ($cursor_rating2 as $v) {
                    echo "<tr>";
                    echo "<td>".$v->id."</td>";
                    echo "<td>".$array_tipe_laptop[$v->id_laptop]."</td>";
                    echo "<td>".$v->rating."</td>";
                    echo "<td>".$array_harga_laptop[$v->id_laptop]."</td>";
                    echo "</tr>";
                    $insert = $bul->insertOne([
                        "id" => $v->id,
                        "tipe_laptop" => $array_tipe_laptop[$v->id_laptop],
                        "rating" => $v->rating,
                        "harga_laptop" => $array_harga_laptop[$v->id_laptop]
                    ]);
                }
            }

            $filter = [];
            $options = ['sort' => ['rating' => -1]];
            $bul = $db->sorting_harga;
            $result = $bul->find($filter, $options);

            foreach ($result as $v2) {
                echo "<tr>";
                echo "<td>".$v2->id."</td>";
                echo "<td>".$v2->tipe_laptop."</td>";
                echo "<td>".$v2->rating."</td>";
                echo "<td>".$v2->harga_laptop."</td>";
                echo "</tr>";
            }
        ?>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>