<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="../JQuery/jquery-3.1.1.js"></script>
        <script src="../Bootstrap/js/bootstrap.min.js"></script>
        <script src="../Bootstrap/js/bootstrap.js"></script>
        <link href="../Bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="../Bootstrap/css/bootstrap-theme.css" rel="stylesheet"/>
        <link href="../CSS/Styles.css" rel="stylesheet"/>
    </head>
    <body>
        <?php
        include './cnx.php';
        $sql = $cnx->prepare("select max(idEtudiant)as num from etudiants");
        $sql->execute();
        $id = $sql->fetchAll(PDO::FETCH_ASSOC);
        $num = $id[0]['num'] + 1;


        if (isset($_GET["btnInserer"])) {
            if (!$_GET["txtNom"] == "") {
                if (!$_GET["txtPrenom"] == "") {
                    if (!$_GET["txtLogin"] == "") {
                        if (!$_GET["txtMDP"] == "") {
                            if (!$_GET["txtEmail"] == "") {
                                if (!empty($_GET['checkbox'])) {
                                    if (isset($_GET['checkbox']) == 'etudiant') {
                                        $sql = $cnx->prepare("insert into etudiants values(" . $num . ",'" . $_GET['txtLogin'] . "','" . $_GET['txtMDP'] . "','" . $_GET['txtNom'] . "','" . $_GET['txtPrenom'] . "','" . $_GET['txtEmail'] . "')");
                                        $sql->execute();
                                        header("Location:../index.php");
                                    } else {
                                        if (isset($_GET['checkbox']) == 'professeur') {
                                            $sql = $cnx->prepare("insert into professeur values(" . $num . ",'" . $_GET['txtLogin'] . "','" . $_GET['txtMDP'] . "','" . $_GET['txtNom'] . "','" . $_GET['txtPrenom'] . "','" . $_GET['txtEmail'] . "')");
                                            $sql->execute();
                                            header("Location:../index.php");
                                        }
                                    }
                                } else {
                                    echo "Aucune case n'a été cochée";
                                }
                            } else {
                                echo 'Veuillez saisir votre email';
                            }
                        } else {
                            echo 'Veuillez saisir votre mot de passe';
                        }
                    } else {
                        echo "Veuillez saisir votre identifiant";
                    }
                } else {
                    echo "Veuillez saisir votre prénom";
                }
            } else {
                echo "Veuillez saisir votre nom";
            }
        }
        ?>

        <div id='titreinscription'>Inscription</div>
        <div id='stinscription'>Veuillez entrer toutes les informations demandées</div><br/>
        <div id="pageinscription">
            <form method="get" action="Inscription.php"><br/>
                <label>Numéro</label><br>
                <input type="text" name="txtId" style="width:80%;margin:auto;" value="<?php echo $num; ?>" class="form-control" placeholder="Identifiant" style="text-align: center;" disabled><br>
                <label>Nom</label><br>
                <input type="text" name="txtNom" style="width:80%;margin:auto;" class="form-control" placeholder="Nom"><br>
                <label>Prénom</label><br>
                <input type="text" name="txtPrenom" style="width:80%;margin:auto;" class="form-control" placeholder="Prénom"><br>
                <label>Identifiant</label><br>
                <input type="text" name="txtLogin" style="width:80%;margin:auto;" class="form-control" placeholder="Identifiant"><br>
                <label>Mot de passe</label><br>
                <input type="text" name="txtMDP" style="width:80%;margin:auto;" class="form-control" placeholder="Mot de passe"><br>
                <label>Email</label><br>
                <input type="text" name="txtEmail" style="width:80%;margin:auto;" class="form-control" placeholder="Email"><br>
                <input type="checkbox" name="checkbox" value="etudiant">Etudiant
                <input type="checkbox" name="checkbox" value="professeur">Professeur<br/><br/>
                <input type="submit" value="S'inscrire" name="btnInserer" class="btn btn-primary mb-2"> - <a href="../index.php" class="btn btn-outline-primary">Retour</a>
            </form>
        </div>
    </body>
</html>