<?php
session_start();
require "connection.php";

if(isset($_GET['kategoria'])) {
    $kategoria = $_GET['kategoria'];
}
else
{
    header("Location: /GIS/uvodnaStranka.php");
    exit();
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
    <title>Formular</title>
    <script
            src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="formular.css">
</head>
<body>
<div class="container">
    <input id="kategoria" type="hidden" name="kategoria" value="<?php echo $kategoria; ?>">
    <div class="container">
        <div class="col-sm-10">
            <button type="submit"  onclick="location.href='/GIS/uvodnaStranka.php'" class="submitFormular" id="submitFormular"  name="submitFormular">Odoslať formulár</button>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function(){
        $("#submitFormular").click(function(){
            var array = document.getElementsByClassName('question');
            var questions = [];
            var kategoria = document.getElementById("kategoria").value;
            var lokalita = document.getElementById("lokalita").value;
                var test = {lokalita};
                questions.push(test);
            for(let j = 0; j < array.length; j ++){
                if(array[j].classList.contains('checkbox')){
                    var otazka = array[j].querySelectorAll('input[name="option"]');
                    for( let l = 0; l < otazka.length; l ++){
                        var Otazka = otazka[0].value;
                        if (otazka[l].checked) {
                            var Odpoved = otazka[l].value;
                            var result = {Otazka, Odpoved};
                            questions.push(result);
                        }
                    }
                }else if(array[j].classList.contains('text')){
                    var Otazka = array[j].querySelector('input[class="inputQuestionText"]').value;
                    var Odpoved = array[j].querySelector('input[class="inputAnswerText"]').value;
                    var result = {Otazka,Odpoved};
                    questions.push(result);
                }else if(array[j].classList.contains('anonie')){
                    var questionANONIE = array[j].querySelectorAll('input[class="inputANONIE"]');
                    for( let l = 0; l < questionANONIE.length; l ++){
                        var Otazka = questionANONIE[0].value;
                        if (questionANONIE[l].checked) {
                            var Odpoved = questionANONIE[l].value;
                            var result = {Otazka, Odpoved};
                            questions.push(result);
                        }
                    }
                }else{
                    var questionRadio = array[j].querySelectorAll('input[class="inputRadioQuestion"]');
                    for( let l = 0; l < questionRadio.length; l ++){
                        var Otazka = questionRadio[0].value;
                        if (questionRadio[l].checked) {
                            var Odpoved = questionRadio[l].value;
                            var result = {Otazka, Odpoved};
                            questions.push(result);
                        }
                    }
                }
            }

            $.ajax({
                url: 'formularHandler.php',
                method: "post",
                data: {questions, kategoria},
                success: function (res) {
                    console.log(res);
                }
                ,
                error: function (jqXHR, exception) {
                    console.log('Error occured!!');
                }
            });
        });
    });
</script>
