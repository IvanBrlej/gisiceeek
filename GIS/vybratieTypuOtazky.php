<?php
session_start();
require 'connection.php';

if(isset($_POST['kategoria'])){
    $kategoria = $_POST['kategoria'];
}

$query = $con->prepare("SELECT * FROM otazky where kategoria = ?");
$query->bind_param("s",$kategoria);
$query->execute();
$result = $query->get_result();
$arr = array();
$i = 0;
$id = 0;

$sql = $con->prepare("SELECT nazov FROM kraj");
$sql->execute();
$kraj = $sql->get_result();

$sql = $con->prepare("SELECT nazov FROM okresy");
$sql->execute();
$okres = $sql->get_result();

$sql = $con->prepare("SELECT nazov FROM uzemnaJednotka");
$sql->execute();
$uj = $sql->get_result();



while(($row = mysqli_fetch_array($result))) {
    $arr = explode(',', $row['otazka']);
    $typOtazky = $row['typOtazky'];
    echo "<div class='question container $typOtazky'>";
    ?>
    <br>
    <?php
    foreach ($arr as $key => $value) {
        if($typOtazky == "checkbox"){
            if($i == 0){
                $i++;
                ?>
                <input name="option" class="inputQuestion" id="<?php echo "Question [$i]:";?>" value="<?php echo   $value;?>" readonly>
                <br>
                <?php
            }else{
                ?>
                <input type="checkbox" name="option" class="inputQuestion" id="<?php echo "Question [$i]:";?>" value="<?php echo   $value;?>">
                <label for="<?php echo "Question [$i]:";?>"><?php echo   $value;?></label>
                <br>
                <?php
            }

        }else if($typOtazky == "text"){
            ?>
            <input class="inputQuestionText" id="<?php echo "Question Text: ";?>" value="<?php echo   $value;?>" readonly>
            <br>
            <br>
            <input  class="inputAnswerText" id="<?php echo "Answer Text: ";?>" placeholder="odpoved na otazku">
            <br>
            <br>
            <?php
        }else if($typOtazky == "radius button"){
            if($i == 0){
                $i++;
                ?>
                <input name="optionRadiusButton" class="inputRadioQuestion" id="<?php echo "Question [$id]:";?>" value="<?php echo   $value;?>" readonly>
                <br>
                <?php
            }else{
                ?>
                <input type="radio"  class="inputRadioQuestion" name="<?php echo "Question [$id]:";?>" value="<?php echo   $value;?>">
                <label for="<?php echo "Question [$id]:";?>"><?php echo   $value;?></label>
                <br>
                <?php

            }
        }else if($typOtazky == "anonie"){
            if($i == 0){
                $i++;
                ?>
                <input name="optionANONIE" class="inputANONIE" id="<?php echo "Question [$id]:";?>" value="<?php echo   $value;?>" readonly>
                <br>
                <?php
            }else{
                ?>
                <input type="radio"  class="inputANONIE" name="<?php echo "Question [$id]:";?>" value="<?php echo   $value;?>">
                <label for="<?php echo "Question [$id]:";?>"><?php echo   $value;?></label>
                <br>
                <?php
            }
        }else if($typOtazky == "lokalita kraj"){
            ?>
            <select type="select" class="form-control" id="lokalita" name="lokalita">
                <?php
                while($row = mysqli_fetch_array($kraj)) {
                    ?>
                    <option value="<?php echo $row['nazov']; ?>"><?php echo $row['nazov']; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
        else if($typOtazky == "lokalita okres"){
            ?>
            <select type="select" class="form-control" id="lokalita" name="lokalita">
                <?php
                while($row = mysqli_fetch_array($okres)) {
                    ?>
                    <option value="<?php echo $row['nazov']; ?>"><?php echo $row['nazov']; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
        else if($typOtazky == "lokalita uj"){
            ?>
            <select type="select" class="form-control" id="lokalita" name="lokalita">
                <?php
                while($row = mysqli_fetch_array($uj)) {
                    ?>
                    <option value="<?php echo $row['nazov']; ?>"><?php echo $row['nazov']; ?></option>
                    <?php
                }
                ?>
            </select>
            <?php
        }
    }
    $id++;
    $i = 0;
    ?>
    </select>
    <?php
    echo "</div>";
    echo "<br>";
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vyber typ otazky</title>
    <link rel="stylesheet" type="text/css" href="vybratieKategorieNaVlozenieOtazky.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="uvodnaStranka.php">Domov</a></li>
        <li><a href="kategoria.php">Kategória</a></li>
        <li><a href="vybratieKategorieNaVlozenieOtazky.php">Pridanie otázky</a></li>
        <li><a href="vybratieFormularu.php">Vyplnenie formuláru</a></li>
        <li><a href="adminPrihlasenie.php">Admin Prihlásenie</a></li>
    </ul>
</nav>


<div class="container">
    <form id="pridanieOtazkyForm" method="post" action="pridanieOtazky.php" name="pridanieOtazkyForm">
        <input type="hidden" name="kategoria" value="<?php  echo $kategoria; ?>">
        <div class="container">
            <select type="select" class="form-control" name="typOtazky" id="typOtazky" style="max-width: 50%; text-align: center">
                <option value="text">Text</option>
                <option value="checkbox">Checkbox</option>
                <option value="radius button">Radius Button</option>
                <option value="anonie">Ano/Nie</option>
                <option value="lokalita kraj">Lokalita Kraj</option>
                <option value="lokalita okres">Lokalita Okres</option>
                <option value="lokalita uj">Lokalita územmná jednotka</option>
            </select>
        </div>
        <div class="container">
            <div class="col-sm-10">
                <button type="submit" class="button_send" id="vybertTypuOtazky" name="vybertTypuOtazky">Vyber typu</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>
