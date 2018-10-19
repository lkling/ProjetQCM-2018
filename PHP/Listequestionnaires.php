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
        <?php session_start(); ?>
        
        <div class="InfoConnexion">
            <p>Bienvenue <?php echo $_SESSION['user'][0]['nom'] . " " . $_SESSION['user'][0]['prenom']; ?> - <a href="../index.php" class="btn btn-danger">Déconnexion</a><br/></p>
        </div>
        
        <?php
        include 'cnx.php';

        $rqt = $cnx->prepare("SELECT q.idQuestionnaire, q.libelleQuestionnaire FROM questionnaire q");
        $rqt->execute();
        
        echo "<div id='pagelstquest'>";
        echo "<div class='titrelstquest'>Liste des questionnaires</div><br>";
        echo "<table class='table table-striped'>";
        echo "<tr>";
        echo "<td><b>Numéro</b></td>";
        echo "<td><b>Libellé</b></td>";
        echo "<td><b>Fait le :</b></td>";
        echo "<td></td>";
        echo "</tr>";
        foreach ($rqt->fetchAll(PDO::FETCH_ASSOC) as $ligne) {
            echo "<tr>";
            echo "<td>" . $ligne['idQuestionnaire'] . "</td>";
            echo "<td>" . $ligne['libelleQuestionnaire'] . "</td>";

            echo "<td><a href='QuestionnaireChoisi.php?idQuestionnaire=" . $ligne['idQuestionnaire'] . "&nomQ=" . $ligne['libelleQuestionnaire'] . "'>Choisir</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<center><a href='CreerUnQuestionnaireP1.php' class='btn btn-primary mb-2'>Créer un questionnaire</a>";
        echo "</div>";
        ?>
    </body>
</html>