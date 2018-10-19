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
        $sql = $cnx->prepare("select max(idQuestionnaire)as num from questionnaire");
        $sql->execute();
        $id = $sql->fetchAll(PDO::FETCH_ASSOC);
        $num = $id[0]['num'] + 1;

        if (isset($_GET["btnCQuestionnaire"])) {
            if (!$_GET["libelleQuestionnaire"] == "") {
                if (!$_GET["noteQuestionnaire"] == "") {
                    $sql = $cnx->prepare("insert into questionnaire values(" . $num . ",'" . $_GET['libelleQuestionnaire'] . "','" . $_GET['noteQuestionnaire'] . "')");
                    $sql->execute();
                    header("Location: ./CreerUnQuestionnairePageQuestion.php?tieude=".$num);
                } else {
                    echo "<div class='alertQ'>Veuillez indiquer une note</div>";
                }
            } else {
                echo "<div class='alertQ'>Veuillez entrer un nom de questionnaire</div>";
            }
        }
        ?>
        <form method="get" action="CreerUnQuestionnaireP1.php">
            <div class="InfoConnexion">
                <p>Bienvenue <?php echo $_SESSION['user'][0]['nom'] . " " . $_SESSION['user'][0]['prenom']; ?> - <a href="../index.php" class="btn btn-danger">Déconnexion</a><br/></p>
            </div>
            <div id='titrecreerquest'>Création d'un questionnaire</div>
            <div id='stcreerquest'>Pour commencer, entrez le nom de votre questionnaire</div><br/> 
            <div id='pagecreerquest'>
                <input type='text' name='idQuestionnaire' class="form-control" value="<?php echo $num; ?>" style="width:90%;margin:auto;" placeholder="Numéro du questionnaire" disabled><br/>
                <input type='text' name='libelleQuestionnaire' class="form-control" style="width:90%;margin:auto;" placeholder="Libellé du questionnaire"><br/>
                <input type='text' name='noteQuestionnaire' class="form-control" style="width:90%;margin:auto;" placeholder="Barème"><br/>

                <input type="submit" name="btnCQuestionnaire" class="btn btn-primary mb-2" value="Créer des questions">
            </div>
        </form>
    </body>
</html>