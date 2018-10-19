<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../JQuery/jquery-3.1.1.js"></script>
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="../Bootstrap/js/bootstrap.js"></script>
        <link href="../Bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../Bootstrap/css/bootstrap-theme.css" rel="stylesheet">
        <link href="../CSS/Styles.css" rel="stylesheet">
    </head>
    <body>
        <div id="pageQuChoisi">
        <?php
            session_start();
            include './cnx.php';
        
            //var_dump($_SESSION['user'][0]['nom']);
            echo "<div id='questchbienvenue'>";
            echo "Bienvenue ".$_SESSION['user'][0]['prenom']." ".$_SESSION['user'][0]['nom'];
            echo "<br/>";
            echo "Vous avez choisi le questionnaire sur le : ".$_GET['nomQ']."<br/>";
            echo "</div></center>";
            
            // Pour la page Résultat
            $_SESSION['user']['idQuest'] = $_GET['idQuestionnaire'];
            
            $sql = $cnx -> prepare("SELECT q.libelleQuestion, q.idQuestion, q.nbBonneReponse FROM question q, questionquestionnaire qq WHERE q.idQuestion = qq.idQuestion AND qq.idQuestionnaire = ".$_GET['idQuestionnaire']);
            $sql->execute();
            $question=$sql->fetchALL(PDO::FETCH_ASSOC);
            
            $numQuestion = 1;

            echo "<form method='get' action='./Resultat.php'>";
                foreach ($question as $ligne)
                {
                    echo "<div id='libelleQuest1'>Question ".$numQuestion.": </div>";
                    $numQuestion = $numQuestion + 1;
                    
                    echo "<div id='libelleQuest2'>".$ligne['libelleQuestion']."</div><br/>";
                    echo "<div class='blocquest1'>";

                    $sql = $cnx -> prepare("SELECT r.idReponse, r.valeur, qr.idQuestion FROM reponse r, questionreponse qr, question q, questionquestionnaire qq WHERE r.idReponse = qr.idReponse AND qr.idQuestion = q.idQuestion AND q.idQuestion = qq.idQuestion AND qq.idQuestionnaire = ".$_GET['idQuestionnaire']." AND q.idQuestion = ".$ligne['idQuestion']);
                    $sql->execute();
                    $reponse=$sql->fetchALL(PDO::FETCH_ASSOC);
                    foreach ($reponse as $rep)
                    {
                        if($ligne['nbBonneReponse'] > 1){
                            echo "<input type='checkbox' name='reponseChoisiQuestion".$ligne['idQuestion']."[]' value='".$rep['valeur']."'>".$rep['valeur']."<br/>";
                        }
                        else{
                            echo "<input type='radio' name='reponseChoisiQuestion".$ligne['idQuestion']."' value='".$rep['valeur']."'>".$rep['valeur']."<br/>";
                        }
                    }
                    echo "</div>";
                }
                echo "<br/><center><input type='submit' name='btnValider' value='Valider' class='btn btn-primary'></input></center><br/>";
            echo "</form>";
        ?>
        </div>
    </body>
</html>