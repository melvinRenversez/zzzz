<?php

session_start();
if ( !isset($_SESSION["user"])){
        header("Location:./index.html");
        exit();
}else{
        $userId = $_SESSION["user"]["id"];
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="showKnowledge.css">
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
</head>
<body>
<div class="content">
        <h1 id="h1">Ajouter une connaissance</h1>
        <form  method="POST">
                        <div class="field">
                            <label for="titre">Titre</label>
                            <input type="text" name="titre" id="titre">
                        </div>
                        <div class="field" id="optionField">
                            <label for="type_code">Type de code</label>
                            
                        </div>
            <div class="field" id="textareaField">
                <div class="top">
                        <label for="code">Code</label>
                        <button id="fullscreen">
                        <svg class="A" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" fill="#e3e3e3" ><path d="M120-120v-200h80v120h120v80H120Zm520 0v-80h120v-120h80v200H640ZM120-640v-200h200v80H200v120h-80Zm640 0v-120H640v-80h200v200h-80Z"/></svg>
                        <svg class="B" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" fill="#e3e3e3"><path d="M240-120v-120H120v-80h200v200h-80Zm400 0v-200h200v80H720v120h-80ZM120-640v-80h120v-120h80v200H120Zm520 0v-200h80v120h120v80H640Z"/></svg>
                        </button>
                </div>
                <textarea name="code" id="code"></textarea>
            </div>
            <!-- <button type="submit" id="btn">Ajouter</button> -->
        </form>
        <a href="./accueil.php">Retour</a>
    </div>
</body>

<script>
        let params = new URLSearchParams(window.location.search);
        const KnowledgeId = params.get("id");
        var userId = 0;
        console.log("KnowledgeId : " + KnowledgeId);

        function getSession(callback){
                $.post("./database/getSession.php", {},
                        function(data, textStatus, jqXHR){
                        data = JSON.parse(data);
                        console.log("ses :" + data["user"]["id"]);
                        const id = data["user"]["id"];
                        userId = id;
                        callback();
                        }
                );
        }

        function getKnowledge(){
                $.post("./database/getKnowledge.php", {id: KnowledgeId}, 
                        function (data, textStatus, jqXHR) {
                        data = JSON.parse(data);
                        console.log(data);
                        console.log(data["titre"]);

                        console.log(data["id_user"]);
                        console.log("kno : " + userId);
                        console.log("-------" + data["titre"]);

                        console.log("comp : " + data["id_user"] + " : " + userId);

                        if (data["id_user"] == userId) {
                                console.log("user is good")

                                $("#h1").text("Modifier une connaissance")

                                $("#optionField").append(`<select id='type_code' name='type_code' value="${data["type_code"]}"></select>`);
                                
                                $("form").append(" <button id='btn'>Modifier</button>");

                                eventBtn();

                                insertTypeCode(data["type_code"]);

                                $("#titre").val(data["titre"])
                                $("#type_code").val(data["type"]);
                                $("#code").val(data["code"]);

                                
                        }else{
                                console.log("user is not good")

                                $("#h1").text("Connaissance de " + data["prenom"] + " " +  data["nom"])

                                $("#optionField").append("<input id='type_code'>");

                                $("input").prop("disabled", true);
                                $("textarea").prop("disabled", true);

                                console.log(data["type"]);

                                $("#titre").val(data["titre"])
                                $("#type_code").val(data["type"]);
                                $("#code").val(data["code"]);

                        }

                        }
                );
        }

        function insertTypeCode(selectedType){
    console.log("insert type code");
    $.post("./database/getTypeCode.php", {},
        function (dataList, textStatus, jqXHR) {
            $("#type_code").empty();
            dataList.forEach(element => {
                const option = `<option value="${element["id"]}">${element["nom"]}</option>`;
                $("#type_code").append(option);
            });

            $("#type_code").val(selectedType); // Appliquer la valeur après ajout des options
        });
}


        $("#fullscreen").on("click", function (e) {
            e.preventDefault();  // Corriger l'appel
            if ($("#fullscreen").hasClass("btnFull")) {  // Vérification sur le bouton
                $("textarea").removeClass("full");
                $("#fullscreen").removeClass("btnFull");
            } else {
                $("textarea").addClass("full");
                $("#fullscreen").addClass("btnFull");
            }
        });

        function eventBtn(){

                $("#btn").on("click", function(e) {
                        alert("click");
                        e.preventDefault();
                        const titre = $("#titre").val();
                        const type_code = $("#type_code").val();
                        const code = $("#code").val();
        
                        if (titre === "" || type_code === "" || code === "") {
                                alert("Veuillez remplir tous les champs");
                                return false;
                        }else{
                                $.post("./database/update.php", {titre, type_code, code, id: KnowledgeId},
                                                function (data, textStatus, jqXHR) {

                                                        window.location.href = "./accueil.php";

                                                })
                        }
        
                        })
                        
        
                        // Appeler getSession et passer l'ID à getKnowledge
                
        };

        getSession(getKnowledge);


</script>


</script>

</html>