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
        <div id="pageResultats"><br/>
    <center><h1>Résultat du QCM</h1></center>
        <?php
            session_start();
            include './cnx.php';
        
            $idQ = $_SESSION['user']['idQuest'];
            //echo $idQ;
            $resultat = 0;
            
            // Calcul du nombre de points par questions avec la note maximum rentré dans la BDD divisé par le nombre de questions
            $sql = $cnx -> prepare("SELECT COUNT(q.idQuestion) as nbQuestion FROM question q, questionquestionnaire qq WHERE q.idQuestion = qq.idQuestion AND qq.idQuestionnaire = ".$idQ);
            $sql->execute();
            $nbQuestion=$sql->fetchALL(PDO::FETCH_ASSOC);
            
            //var_dump($nbQuestion);
            //echo $nbQuestion[0]['nbQuestion'];
            //echo "<br>";
            
            $sql = $cnx -> prepare("SELECT note FROM questionnaire WHERE idQuestionnaire = ".$idQ);
            $sql->execute();
            $noteFinale=$sql->fetchALL(PDO::FETCH_ASSOC);
            
            //var_dump($noteFinale);
            //echo $noteFinale[0]['note'];
            //echo "<br>";
            $noteQuest = $noteFinale[0]['note'];
            
            $nbPointsParQuestion = $noteFinale[0]['note']/$nbQuestion[0]['nbQuestion'];
            //echo $nbPointsParQuestion;
            
            // Récupérer les questions du questionnaire
            $sql = $cnx -> prepare("SELECT q.idQuestion, q.nbBonneReponse, q.libelleQuestion FROM question q, questionquestionnaire qq WHERE q.idQuestion = qq.idQuestion AND qq.idQuestionnaire = ".$idQ);
            $sql->execute();
            $reponseUser=$sql->fetchALL(PDO::FETCH_ASSOC);
            
            $numQuestion = 1;
            
            foreach ($reponseUser as $repQ)
            {
                
                // Affichage de la question
                echo "<div id='pageResultat'><div class='blocquestion'>Question ".$numQuestion." : ".$repQ['libelleQuestion']."</div><br/>";
                echo "<div class='blocreponse1'>Vous avez répondu : <br/>";
                $numQuestion = $numQuestion + 1;
                
                // Affichage de la réponse à la question de l'utilisateur
                $texte = "reponseChoisiQuestion".$repQ['idQuestion'];
                if($repQ['nbBonneReponse']>1)
                {
                    foreach($_GET[$texte] as $valeur)
                    {
                        echo $valeur." - "; 
                    }
                }
                else
                {
                    echo $_GET[$texte];
                }
                echo "<br/></div><br/>";
                
                // Récupération des bonnes réponses dans une requête
                $sql = $cnx -> prepare("SELECT r.valeur FROM reponse r, questionreponse qr, question q, questionquestionnaire qq WHERE r.idReponse = qr.idReponse AND qr.idQuestion = q.idQuestion AND q.idQuestion = qq.idQuestion AND qq.idQuestionnaire = ".$idQ." AND q.idQuestion = ".$repQ['idQuestion']." AND qr.bonne = 1");
                $sql->execute();
                $reponseQuestion=$sql->fetchALL(PDO::FETCH_ASSOC);
                
                //var_dump($reponseQuestion);
                //echo $reponseQuestion[0]["valeur"];
                $compteur = 0;
                $lesReponses = "";
                $lesBonnesReponses = "";
                
                // Comparaison des réponses de l'utilisateur aux bonnes réponses en respectant les réponses multiples
                foreach ($reponseQuestion as $bonneReponse)
                {
                    if($repQ['nbBonneReponse']>1)
                    {
                        $lesReponses .= $bonneReponse["valeur"]." - ";
                        $compteur = $compteur + 1;
                        if($compteur == $repQ['nbBonneReponse'])
                        {
                            //echo $bonneReponse["valeur"];
                            foreach($_GET[$texte] as $valeur)
                            {
                                $lesBonnesReponses .= $valeur." - ";
                                //echo $lesBonnesReponses; 
                            }
                            if($lesBonnesReponses == $lesReponses)
                            {
                                $resultat = $resultat + $nbPointsParQuestion;
                                echo "<div class='blocreponse2'>Les bonnes réponses sont : ".$lesReponses."<br/>";
                                echo '<b>Vous avez bien répondu</b></div>';
                            }
                            else 
                            {
                                echo "<div class='blocmauvaiserep'>Les bonnes réponses sont : ".$lesReponses."<br/>";
                                echo '<b>Votre réponse est fausse</b>'."<br/>";
                            } 
                        }
                    }
                    else
                    {   
                        if($bonneReponse["valeur"] == $_GET[$texte])
                        {
                            $resultat = $resultat + $nbPointsParQuestion;
                            echo "<div class='blocreponse2'>La bonne réponse est : ".$bonneReponse["valeur"]."<br/>";
                            echo '<b>Vous avez bien répondu</b></div><br/>';
                        }
                        else 
                        { 
                            echo "<div class='blocmauvaiserep'>La bonne réponse est : ".$bonneReponse["valeur"]."<br/>";
                            echo "<b>Votre réponse est fausse</b>"."<br/></div>";
                        }
                    }
                }
                echo "</div>";
                
                // Update de la date
                $rqt = $cnx->prepare("UPDATE qcmfait SET dateFait=(SELECT DATE(NOW())) WHERE idEtudiant = ".$_SESSION['user'][0]['idEtudiant']." AND idQuestionnaire = ".$idQ);
                $rqt->execute();
                
                //echo $_SESSION['user'][0]['idEtudiant'];

            }
            
            $noteEtudiant = round($resultat, 2);
            echo "<div id='resultatTotal'>Vous avez obtenue la note de : ".$noteEtudiant." /".$noteQuest."</div>";
            echo "<center><a href='Listequestionnaires.php' class='btn btn-primary mb-2' style='margin-bottom:10px;'>Retourner à la liste des questionnaires</a><br/>";
        ?>
        </div>
    </body>
</html>