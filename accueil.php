<?php
session_start();
if ( !isset($_SESSION["user"])){
        header("Location:./index.html");
        exit();
}else{
        $userId = $_SESSION["user"]["id"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="accueil.css">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
        <script src="./script.js" defer></script>
</head>
<body>

        <div class="ref">
                <a href="./insertKnowledge.php">Ajouter</a>
                <a href="./database/logout.php">Se déconnecter</a>
        </div>

        <div class="content">

                <div class="search">

                        <input type="search" id="search" placeholder="Search">

                        <select id="tc">
                                <option value="">type code</option>
                        </select>
                        <select id="user">
                                <option value="">De :</option>
                        </select>

                        <button id="clear">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m336-280 144-144 144 144 56-56-144-144 144-144-56-56-144 144-144-144-56 56 144 144-144 144 56 56ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                        </button>

                </div>

                <div class="knowledge" id="knowledge">
                        </div>
                </div>


        </div>
        
</body>


<script>

function escapeHtml(text) {
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&apos;");
}

$("#search").on('input', function(e) {
    getKnowledge();
});
$("#tc").on('input', function(e) {
    getKnowledge();
});
$("#user").on('input', function(e) {
    getKnowledge();
});
$("#clear").on("click", function(e) {
        $("#search").val("");
        $("#tc").val("");
        $("#user").val("");
        getKnowledge();
});

        function getKnowledge() {
                var mc = $("#search").val() ?? "";
                var tc = $("#tc").val() ?? "";
                var user = $("#user").val()?? "";


                $.post("./database/getKnowledges.php",{mc : mc, tc : tc, user : user},
                        function (data, textStatus, jqXHR) {
                                $("#knowledge").html(" ");
                                data.forEach(element => {


                                        const box = `
    <div class="box" id="${element["id"]}">
        <pre class="top">
            <h2>${escapeHtml(element["titre"])}</h2>
            <h4>${element["type_code"]}</h4>
        </pre>
        <div class="bottom">
            <pre>${escapeHtml(element["code"])}</pre>
        </div>
        <h4 class="auteur">
                <span>
                        ${element["auteurP"]} ${element["auteurN"]}
                </span>
                <span> 
                        ${element["date"]}
                </span>
        </h4>
    </div>
`;


                                        $("#knowledge").append(box);
                                });
                        }
                );
                createLink();
        }

        getKnowledge();
        setInterval(getKnowledge, 1000);


        function getTypeCode(){
                $.post("./database/getTypeCode.php", {},
                        function (data, textStatus, jqXHR) {
                                data.forEach(element => {
                                        const option = `<option value="${element["id"]}">${element["nom"]}</option>`;
                                        $("#tc").append(option);
                                });
        })};

        getTypeCode();

        function getUser(){
                $.post("./database/getUser.php", {},
                        function (data, textStatus, jqXHR) {
                                data.forEach(element => {
                                        const option = `<option value="${element["id"]}">${element["prenom"]} ${element["nom"]}</option>`;
                                        $("#user").append(option);
                                });
        })};

        getUser();

        function createLink(){
    $("#knowledge").off("click", ".box"); // pour éviter les doublons
    $("#knowledge").on("click", ".box", function() {
        var id = $(this).attr("id");
        window.location.href = "./showKnowledge.php?id=" + id;
    });
}




</script>

</html> 