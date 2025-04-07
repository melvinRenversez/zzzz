<?php 

session_start();
if ( !isset($_SESSION["user"])){
        header("Location:../index.php");
        exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une connaissance</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <link rel="stylesheet" href="insertKnowledge.css">
</head>
<body>
    <div class="content">
        <h1>Ajouter une connaissance</h1>
        <form action="../database/insert.php" method="POST">
            <div class="field">
                <label for="titre">Titre</label>
                <input type="text" name="titre" id="titre">
            </div>
            <div class="field">
                <label for="type_code">Type de code</label>
                <select name="type_code" id="type_code">
                </select>
            </div>
            <div class="field">
                <label for="code">Code</label>
                <textarea name="code" id="code"></textarea>
            </div>
            <button type="submit" id="btn">Ajouter</button>
        </form>
        <a href="./accueil.php">Annuler</a>
    </div>
</body>

<script>


$("#btn").on("click", function(e) {
    e.preventDefault();
    const titre = $("#titre").val();
    const type_code = $("#type_code").val();
    const code = $("#code").val();

    if (titre === "" || type_code === "" || code === "") {
        alert("Veuillez remplir tous les champs");
        return false;
    }else{
        $.post("./database/insert.php", {titre, type_code, code},
                        function (data, textStatus, jqXHR) {
                                window.location.href = "./accueil.php";
                        })
    }

})


function getTypeCode(){
                $.post("./database/getTypeCode.php", {},
                        function (data, textStatus, jqXHR) {
                                data.forEach(element => {
                                        const option = `<option value="${element["id"]}">${element["nom"]}</option>`;
                                        $("#type_code").append(option);
                                });
        })};

        getTypeCode();

</script>

</html>
