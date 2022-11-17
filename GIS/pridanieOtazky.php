<?php
session_start();
require 'connection.php';
$kategoria = $_POST['kategoria'];
$typOtazky = $_POST['typOtazky'];

////////////////
if($typOtazky == "lokalita kraj" || $typOtazky == "lokalita okres" || $typOtazky == "lokalita uj"){
    $lokalita = "lokalita";
    $query = $con->prepare("INSERT INTO otazky VALUES('',?,?,?)");
    $query->bind_param("sss", $typOtazky,$lokalita,$kategoria);
    $query->execute();
    header("Location: /GIS/uvodnaStranka.php");
}

if (isset($_POST['submitted'])){
    print_r($_POST);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pridanie otazky</title>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="pridanieOtazky.css">
</head>
<body>
<nav>
    <ul>
        <li><a href="uvodnaStranka.php" class="active">Domov</a></li>
        <li><a href="kategoria.php">Kategória</a></li>
        <li><a href="vybratieKategorieNaVlozenieOtazky.php">Pridanie otázky</a></li>
        <li><a href="vybratieFormularu.php">Vyplnenie formuláru</a></li>
        <li><a href="adminPrihlasenie.php" class="hover">Admin Prihlásenie</a></li>
    </ul>
</nav>
<script>
    $(document).ready(function(){
        var skuska = document.getElementById("typOtazky").value;
        console.log(skuska);
        if(skuska === "text"){
            $('#questionTitleDiv').hide();
            $('#question1Div').show();
            $('#question2Div').hide();
            $('#question3Div').hide();
            $('#addTextDiv').hide();
        }else if(skuska === "anonie"){
            $('#questionTitleDiv').show();
            $('#question1Div').show();
            $('#question2Div').show();
            $('#question3Div').hide();
            $('#addTextDiv').hide();
        }else{
            $('#questionTitleDiv').show();
            $('#question1Div').hide();
            $('#question2Div').hide();
            $('#question3Div').hide();
            $('#addTextDiv').show();
        }
    });
</script>

<form id="pridanieOtazkyForm" action="pridanieOtazkyHandler.php" method="post" name="pridanieOtazkyForm">
    <div class="card-body p-5">
        <input type="hidden" id="kategoria" name="kategoria" value="<?php echo $kategoria; ?>">
        <input type="hidden"  id="typOtazky" name="typOtazky" value="<?php echo $typOtazky; ?>">
        <div class="container col-sm-8" id="questionTitleDiv">
            <label>Question Title</label>
            <input type="text" id="questionTitle" name="questionTitle" /><br>
        </div>
        <div class="container col-sm-8" id="question1Div">
            <label>question1</label>
            <input type="text" id="question1" name="question1" /><br>
        </div>
        <div class="container col-sm-8" id="question2Div">
            <label>question2</label>
            <input type="text" id="question2" name="question2"/><br>
        </div>
        <div class="container col-sm-8" id="question3Div">
            <label>question3</label>
            <input type="text" id="question3" name="question3"/> <br>
        </div>
        <button type="submit" class="pridanieOtazky_btn" id="pridanieOtazkyButton" name="pridanieOtazkyButton">Pridať otázku</button>
    </div>
</form>

<div class="container col-sm-8" id="addTextDiv">
    <input type="text">
    <button onclick="add()">Add</button>
    <button onclick="remove()">remove</button>
    <div id="new_chq"></div>
    <input type="hidden" value="1" id="total_chq">
</div>


</body>
</html>

<script>
    function add(){
        var new_chq_no = parseInt($('#total_chq').val())+1;
        var new_input="<input type='text' id='new_"+new_chq_no+"'>";
        $('#new_chq').append(new_input);
        $('#total_chq').val(new_chq_no)
    }
    function remove(){
        var last_chq_no = $('#total_chq').val();
        if(last_chq_no>1){
            $('#new_'+last_chq_no).remove();
            $('#total_chq').val(last_chq_no-1);
        }
    }
</script>