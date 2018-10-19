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
        <?php
        session_start();
        include './cnx.php';
        $sql = $cnx->prepare("select max(idQuestion) as num from question");
        $sql->execute();
        $id = $sql->fetchAll(PDO::FETCH_ASSOC);
        
        $questionNum = $id[0]['num'] + 1;
        $nbRep = 0;

        if (isset($_POST['btnCQuestion'])) {
            $vraiOuFaux = array();
            $reponses = $_POST['creationReponse'];
            $questionLabel = $_POST['creationQuestion'];
            
            $nombreReponseNonVide = 0;
            $nombreBonneReponse = 0;
            
            for($i = 0; $i < count($reponses); $i++) 
            {
                $vraiOuFaux[$i] = $_POST["VraiOuFaux".($i + 1)]; // Vérifier la valeur des radio button
                
                
                if(!empty($reponses[$i])) { //  Vérifier si les input sont vides ou non
                    $nombreReponseNonVide += 1;
                    
                    if($vraiOuFaux[$i] == 1)
                    {
                        $nombreBonneReponse += 1;
                    }
                }
            }
            
            if(empty($questionLabel)) 
            {
                echo "Veuillez indiquer un libellé de question";
            } 
            else if($nombreReponseNonVide < 2)
            {
                echo "Vous devez entrer au moins deux réponses possibles";
            }
            else
            {
                $sql = $cnx->prepare("insert into question values(".$questionNum.",'".$questionLabel."', 1, ".$nombreReponseNonVide.",'".$nombreBonneReponse."')");
                $sql->execute();
                $sql = $cnx->prepare("insert into questionquestionnaire values (".$_GET["idQuestionnaire"].",".$questionNum.")");
                $sql->execute();
                
                $order = 1;
                for($i = 0; $i < count($reponses); $i++)
                {
                    if(!empty($reponses[$i])) // Création de la question avec ses réponses si les input ne sont pas vides
                    {
                        $sql = $cnx->prepare("select max(idReponse) as num from questionreponse");
                        $sql->execute();
                        $id = $sql->fetchAll(PDO::FETCH_ASSOC);
                        $reponseNum = $id[0]['num'] + 1;
                        
                        $sql = $cnx->prepare("insert into reponse values (".$reponseNum.",'".$reponses[$i]."', '')");
                        $sql->execute();
                        
                        $sql = $cnx->prepare("insert into questionreponse values (".$questionNum.",".$reponseNum.",".$order.",".$vraiOuFaux[$i].")");
                        $sql->execute();
                        //print_r($reponses[$i]);

                        $order += 1;
                    }
                }
                
            }
        }
        ?>
        <form method="post" action="CreerUnQuestionnairePageQuestion.php?idQuestionnaire=<?php echo $_GET['idQuestionnaire'];?>">
            <div class="InfoConnexion">
                <p>Bienvenue <?php echo $_SESSION['user'][0]['nom'] . " " . $_SESSION['user'][0]['prenom']; ?> - <a href="../index.php" class="btn btn-danger">Déconnexion</a><br/></p>
            </div>
            <div id='titrecreerquest'>Création d'un questionnaire</div>
            <div id='stcreerquest'>Entrer une question et ses réponses</div><br/> 
            <div id='pagecreerquest'>
                <input type='text' name='creationQuestion' class="form-control" style="width:90%;margin:auto;" placeholder="Intitulé de la question"><br/>
                <table style="width:142%;margin:auto;">
                    <tr>
                        <td>
                            <input type='text' name='creationReponse[]' class="form-control" style="width:95%;" placeholder="Réponse 1"><br/>
                        </td>
                        <td width="40%">
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux1' placeholder="V/F" value='1' checked> Bonne</div>
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux1' placeholder="V/F" value='0'> Mauvaise</div><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type='text' name='creationReponse[]' class="form-control" style="width:95%;" placeholder="Réponse 2"><br/>
                        </td>
                        <td width="40%">
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux2' placeholder="V/F" value='1' checked> Bonne</div>
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux2' placeholder="V/F" value='0'> Mauvaise</div><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type='text' name='creationReponse[]' class="form-control" style="width:95%;" placeholder="Réponse 3"><br/>
                        </td>
                        <td width="40%">
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux3' placeholder="V/F" value='1' checked> Bonne</div>
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux3' placeholder="V/F" value='0'> Mauvaise</div><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type='text' name='creationReponse[]' class="form-control" style="width:95%;" placeholder="Réponse 4"><br/>
                        </td>
                        <td width="40%">
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux4' placeholder="V/F" value='1' checked> Bonne</div>
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux4' placeholder="V/F" value='0'> Mauvaise</div><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type='text' name='creationReponse[]' class="form-control" style="width:95%;" placeholder="Réponse 5"><br/>
                        </td>
                        <td width="40%">
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux5' placeholder="V/F" value='1' checked> Bonne</div>
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux5' placeholder="V/F" value='0'> Mauvaise</div><br/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type='text' name='creationReponse[]' class="form-control" style="width:95%;" placeholder="Réponse 6"><br/>
                        </td>
                        <td width="40%">
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux6' placeholder="V/F" value='1' checked> Bonne</div>
                            <div style="font-size:11px;"><input type='radio' name='VraiOuFaux6' placeholder="V/F" value='0'> Mauvaise</div><br/>
                        </td>
                    </tr>
                </table><br/>
                <input type='submit' name='btnCQuestion' class='btn btn-primary mb-2' value='Valider la question'>  
                <a href="./Listequestionnaires.php" class='btn btn-danger'>Terminer</a>
            </div>
        </form>
    </body>
</html>