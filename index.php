<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="./JQuery/jquery-3.1.1.js"></script>
        <script src="./Bootstrap/js/bootstrap.min.js"></script>
        <script src="./Bootstrap/js/bootstrap.js"></script>
        <link href="./Bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="./Bootstrap/css/bootstrap-theme.css" rel="stylesheet"/>
        <link href="./CSS/Styles.css" rel="stylesheet"/>
    </head>
    <body>
        <body>
            <?php
            if(isset($_GET["btnConnexion"]))
            {
                session_start();

                $sql = $cnx -> prepare("select login, motDePasse, nom, prenom, idEtudiant from etudiants where login=? and motDePasse=?");
                $sql->bindValue(1,$_GET['id'],PDO::PARAM_STR);
                $sql->bindValue(2,$_GET['mdp'],PDO::PARAM_STR);
                $sql->execute();
                $data=$sql->fetchALL(PDO::FETCH_ASSOC);

                $_SESSION['user'] = $data;

                if($data != null)
                {
                    header("Location:./PHP/Listequestionnaires.php");
                }
                else
                {
                    echo "Identifiant ou mot de passe incorect";
                }
                }
            if(isset($_GET["btnInscription"]))
            {
                header("Location:./PHP/Inscription.php");
            }
            ?>
            <div id='titrelogin'>Ingetis</div>
            <div id='stlogin'>Questionnaires à choix multiples</div><br/>
            
        <div id="pagelogin">
            <form method="get" action="index.php"><br/>
                <label>Identifiant</label><br/>
                <input type="text" name="id" style="width:80%;margin:auto;" class="form-control" placeholder="Identifiant"><br/>
                
                <label>Mot de passe</label><br/>
                <input type="password" name="mdp" style="width:80%;margin:auto;" class="form-control" placeholder="Mot de passe"><br/>
                
                <input type="submit" value="Connexion" name="btnConnexion" class="btn btn-primary mb-2"><br/><br/>
                
                <a href="./PHP/ChercheMDP.php">Mot de passe oublié</a> - <a href="./PHP/Inscription.php">S'inscrire</a><br/>
            </form>
        </div>
    </body>
</html>