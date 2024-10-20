<?php require '../db/connect.php';

if (isset($_SESSION['user'])) {
    header('Location: ../manage');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr_FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Staff - DriveRP</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <meta property="og:locale" content="fr_FR" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Système de Whitelist" />
    <meta property="og:description" content="Rejoint nous dès maintenant !" />
    <meta property="og:site_name" content="Système de Whitelist" />
    <meta property="og:image" content="../assets/logofivedev.png" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="1080" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:label1" content="Écrit par">
    <meta name="twitter:data1" content="HydraDev">
    <meta name="twitter:label2" content="Durée de lecture est.">
    <meta name="twitter:data2" content="0 minute">
    <link rel="shortcut icon" href="../../image/Logo.png" type="image/x-icon">
    <link rel="icon" href="../../image/Logo.png" type="image/x-icon">
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">

    <?php

    $maxAttempts = 5;
    $lockoutTime = 900;

    $connect = mysqli_connect("everlid1603.mysql.db", "everlid1603", "WeshMaReuss1603", "everlid1603");

    if (isset($_POST['login'])) {
        if ($_POST['password'] == "H54zesfgrveUHF546") {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $result = mysqli_query($con, "SELECT * FROM `hwhitelist-staff` WHERE `username` = '$username'") or die(mysqli_error($con));
            while ($row = mysqli_fetch_array($result)) {
                if ($username == $row['username']) {
                    header("Location: ../reinscription");
                    exit;
                } else {
                    echo "<script>
                            $(document).ready(function () {
                                toastr[\"error\"](\"Ce compte est introuvable.\", \"Erreur :\")
                            });
                        </script>";
                }
            }
        }
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = mysqli_real_escape_string($con, sha1(sha1(sha1(sha1(sha1($_POST['password']))))));

            $result = mysqli_query($con, "SELECT * FROM `hwhitelist-staff` WHERE `username` = '$username'") or die(mysqli_error($con));
            if (mysqli_num_rows($result) < 1) {
                echo "<script>
                              $(document).ready(function () {
                                   toastr[\"error\"](\"Ce compte est introuvable.\", \"Erreur :\")
                              });
                           </script>";
            }

            while ($row = mysqli_fetch_array($result)) {

                if($row['failed_attempts'] >= $maxAttempts && time() - $row['last_failed_attempt'] >= $lockoutTime) {
                    mysqli_query($connect, "UPDATE `hwhitelist-staff` SET `failed_attempts` = 0, `last_failed_attempt` = 0  WHERE `id` = " . $row['id']) or die(mysqli_error($connect));
                }
                if ($row['failed_attempts'] >= $maxAttempts && time() - $row['last_failed_attempt'] < $lockoutTime) {
                    echo "<script>
                        $(document).ready(function () {
                            toastr[\"error\"](\"Votre compte est temporairement verrouillé. Veuillez réessayer plus tard.\", \"Erreur :\")
                        });
                    </script>";
                } else {

                    if ($password != $row['password']) {

                        mysqli_query($connect, "UPDATE `hwhitelist-staff` SET `failed_attempts` = `failed_attempts` + 1, `last_failed_attempt` = " . time() . " WHERE `id` = " . $row['id']) or die(mysqli_error($connect));

                        $count = $maxAttempts - $row['failed_attempts'];

                        if ($count <= 3) {
                            echo "<script>
                                $(document).ready(function () {
                                    toastr[\"error\"](\"Votre mot de passe est incorrect. Attention il ne vous reste plus que " . $count . " tentative(s) avant que votre compte soit verrouillé pendant 15 mins\", \"Erreur :\")
                                });
                            </script>";
                        } else {
                            echo "<script>
                                $(document).ready(function () {
                                    toastr[\"error\"](\"Mot de passe invalide.\", \"Erreur :\")
                                });
                            </script>";
                        }
        
                    } elseif (preg_match('`\'`', $_POST['username'])) {
                        echo "<script>
                                $(document).ready(function () {
                                    toastr[\"error\"](\"Caractère(s) non autorisé(s).\", \"Erreur :\")
                                });
                            </script>";
                    } elseif ($row['status'] == "0") {
                        echo "<script>
                                $(document).ready(function () {
                                    toastr[\"warning\"](\"Vous devez attentre la validation.\", \"Erreur :\")
                                });
                            </script>";
                        $info = '<div class="callout alert" data-closable="">.</div>';
                    } else {
                        $_SESSION['user'] = $row;
                        $_SESSION['ID'] = $row['ID'];

                        $usernameTemp = $_SESSION['user']['username'];

                        mysqli_query($connect, "UPDATE `hwhitelist-staff` SET `failed_attempts` = 0, `last_failed_attempt` = 0  WHERE `id` = " . $row['id']) or die(mysqli_error($connect));

                        echo  "<script>
                                    $(document).ready(function () {
                                        toastr[\"success\"](\"Connexion réussie !\", \"Information :\")
                                    });
                                    </script> <META http-equiv=\"refresh\" content=\"2;URL=../manage\"></div>";
                    }
                }
            }
        } else {
            echo "<script>
              $(document).ready(function () {
                   toastr[\"error\"](\"Veuillez remplir tous les champs.\", \"Erreur :\")
              });
           </script>";
        }
    }
    ?>

<body>
    <!-- <div class="background"> -->
        <!-- <div class="tel">
            <p>Cet appareil n'est pas adapté à cette partie du site</p>
        </div> -->
        <div class="container">
            <a class="logo" href="https://driverp.fr/" title="Page d'accueil"><img src="../../image/Logo.png"></a>
            <div class="form-outer">
                <h2 style="color:white;">Connexion staff</h2>
                <h5 style="color:white">Pas encore de compte ? <a style="color:#ea0171" href="../inscription">Cliquez ici</a></h5>
                <form class="form" action="#" method="POST">
                    <div class="page slide-page">
                        <div class="field">
                            <div class="label">Nom d'utilisateur :</div>
                            <input type="text" name="username" required placeholder="Nom d'utilisateur" />
                        </div>
                        <div class="field">
                            <div class="label">Mot de passe :</div>
                            <input type="password" name="password" required placeholder="Mot de passe" />
                        </div>
                        <div class="field">
                            <button type="submit" name="login" class="firstNext">Connexion</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- </div> -->
    <!-- <script src="../assets/script.js"></script> -->
</body>

</html>