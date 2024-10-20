<?php require '../db/connect.php';

if (isset($_SESSION['user'])) {
    header('Location: ../account');
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

function get_ip()
{
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    }
}

if (isset($_POST['reregister'])) {

        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordconf']) && isset($_POST['code'])) {
            $username = mysqli_real_escape_string($con, $_POST['username']);
            $password = mysqli_real_escape_string($con, sha1(sha1(sha1(sha1(sha1($_POST['passwordconf']))))));
            $password1 = mysqli_real_escape_string($con, $_POST['password']);
            $repeat_password = mysqli_real_escape_string($con, sha1(sha1(sha1(sha1(sha1($_POST['passwordconf']))))));

            $passwordLength = strlen($password1);

            $result = mysqli_query($con, "SELECT * FROM `hwhitelist-staff` WHERE `username` = '$username'") or die(mysqli_error($con));
            if (mysqli_num_rows($result) < 1 OR $_POST['code'] !== "H54zesfgrveUHF546") {
                echo "<script>
                            $(document).ready(function () {
                                toastr[\"error\"](\"Ce compte n'existe pas ou le code n'est pas le bon.\", \"Erreur :\")
                            });
                        </script>";
                
            } else {
                if ($password != $repeat_password) {
                    echo "<script>
                            $(document).ready(function () {
                                toastr[\"error\"](\"Les mots de passe ne correspondent pas.\", \"Erreur :\")
                            });
                        </script>";
                } else {
                    mysqli_query($con, "UPDATE `hwhitelist-staff` SET `password` = '$password' WHERE `username` = '$username'") or die(mysqli_error($con));
                    mysqli_query($con, "UPDATE `hwhitelist-staff` SET `failed_attempts` = 0, `last_failed_attempt` = 0  WHERE `username` = '$username'") or die(mysqli_error($con));

                    echo "<script>
                            $(document).ready(function () {
                                toastr[\"success\"](\"Mot de passe changé !\", \"Bravo :\")
                            });
                        </script> <META http-equiv=\"refresh\" content=\"2;URL=../connexion\"></div>";

                } 
            }

            // if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordconf'])) {
	        //     $username = htmlspecialchars(mysqli_real_escape_string($con, $_POST['username']));
            //     $password = mysqli_real_escape_string($con, sha1(sha1(sha1(sha1(sha1($_POST['passwordconf']))))));
            //     $password1 = mysqli_real_escape_string($con, $_POST['password']);
            //     $repeat_password = mysqli_real_escape_string($con, sha1(sha1(sha1(sha1(sha1($_POST['passwordconf']))))));

                // $passwordLength = strlen($password1);
                // $date = time();

                // $ip = get_ip();

                // $result1 = mysqli_query($con, "SELECT * FROM `hwhitelist-staff` WHERE `username` = '$username'") or die(mysqli_error($con));
                // $result2 = mysqli_query($con, "SELECT * FROM `hwhitelist-staff` WHERE `ip` = '$ip'") or die(mysqli_error($con));

                // if (mysqli_num_rows($result2) > 0) {
                //     echo "<script>
                //               $(document).ready(function () {
                //                    toastr[\"error\"](\"Vous possédez déjà un compte avec cette IP.\", \"Erreur :\")
                //               });
                //            </script>";
                // } else {
                //     if (mysqli_num_rows($result1) > 0) {
                //         echo "<script>
                //               $(document).ready(function () {
                //                    toastr[\"error\"](\"Nom d'utilisateur déjà enregistré.\", \"Erreur :\")
                //               });
                //            </script>";
                //     } elseif (preg_match('`\'`', $_POST['username'])) {
                //         echo "<script>
                //                 $(document).ready(function () {
                //                     toastr[\"error\"](\"Caractère(s) non autorisé(s).\", \"Erreur :\")
                //                 });
                //             </script>";
                //     } else {
                //                     if ($password != $repeat_password) {
                //                         echo "<script>
                //                   $(document).ready(function () {
                //                        toastr[\"error\"](\"Les mots de passe ne correspondent pas.\", \"Erreur :\")
                //                   });
                //                </script>";
                //                     } else {
                //                         mysqli_query($con, "INSERT INTO `hwhitelist-staff` (`username`, `password`, `ip`, `date`) VALUES ('$username', '$password', '$ip', '$date')") or die(mysqli_error($con));

                //                         echo "<script>
                //                   $(document).ready(function () {
                //                        toastr[\"success\"](\"Inscription réussi !\", \"Bravo :\")
                //                   });
                //                </script> <META http-equiv=\"refresh\" content=\"2;URL=../connexion\"></div>";

                //                     }              
                //     }
                // }

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
                <h2 style="color:white;">Réinitialisation mot de passe</h2>
                <h5 style="color:white">Vous possédez déjà un compte ? <a style="color:#ea0171" href="../connexion">Cliquez ici</a></h5>
                <form class="form" action="#" method="POST">
                    <div class="page slide-page">
                        <div class="field">
                            <div class="label">Nom d'utilisateur :</div>
                            <input type="text" name="username" required placeholder="Nom d'utilisateur" />
                        </div>
                        <div class="field">
                            <div class="label">Code de réinitialisation :</div>
                            <input type="password" name="code" required placeholder="Code" />
                        </div>
                        <div class="field">
                            <div class="label">Mot de passe :</div>
                            <input type="password" name="password" required placeholder="Mot de passe" />
                        </div>
                        <div class="field">
                            <div class="label">Confirmation mot de passe :</div>
                            <input type="password" name="passwordconf" required placeholder="Confirmer mot de passe" />
                        </div>
                        <div class="field">
                            <button type="submit" name="reregister" class="firstNext">Réinitialiser</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <!-- </div> -->
    <!-- <script src="../assets/script.js"></script> -->
</body>

</html>