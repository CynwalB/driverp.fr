<?php require '../db/connect.php'; 

$result = mysqli_query($con, "SELECT * FROM `hwhitelist`") or die(mysqli_error($con));
while ($userInfo = mysqli_fetch_array($result)) {
	$ip = $userInfo['ip'];}

if ($ip == $_SERVER['REMOTE_ADDR']) {
    header('Location: ../error');
}

?>
<!DOCTYPE html>
<html lang="fr_FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire - DriveRP</title>
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
if (isset($_POST['submit'])) {
    if (isset($_POST['prenom']) && isset($_POST['age']) && isset($_POST['discord']) && isset($_POST['heuresteam']) && isset($_POST['freekill']) && isset($_POST['carkill']) && isset($_POST['nopainrp']) && isset($_POST['nofearp']) && isset($_POST['situation']) && isset($_POST['background'])) {
        $prenom = mysqli_real_escape_string($con, $_POST['prenom']);
        $age = mysqli_real_escape_string($con, $_POST['age']);
        $discord = mysqli_real_escape_string($con, $_POST['discord']);
        $heuresteam = mysqli_real_escape_string($con, $_POST['heuresteam']);
        $freekill = mysqli_real_escape_string($con, $_POST['freekill']);
        $carkill = mysqli_real_escape_string($con, $_POST['carkill']);
        $nopainrp = mysqli_real_escape_string($con, $_POST['nopainrp']);
        $nofearp = mysqli_real_escape_string($con, $_POST['nofearp']);
        $situation = mysqli_real_escape_string($con, $_POST['situation']);
        $background = mysqli_real_escape_string($con, $_POST['background']);
        $ipremote = mysqli_real_escape_string($con, $_SERVER['REMOTE_ADDR']);
        $confirmation = mysqli_real_escape_string($con, $_POST['confirmation']);
        $date = time();

        mysqli_query($con, "INSERT INTO hwhitelist (`prenom`, `age`, `discord`, `heuresteam`, `freekill`, `carkill`, `nopainrp`, `nofearp`, `situation`, `background`, `ip`, `date`, `confirmation`) VALUES('$prenom', '$age', '$discord', '$heuresteam', '$freekill', '$carkill', '$nopainrp', '$nofearp', '$situation', '$background', '$ipremote', '$date', '$confirmation')") or die(mysqli_error($con));

        //Embeds
        $authorname = "✈ WHITELIST ✈";
        $icon_url = "https://cdn1.iconfinder.com/data/icons/cybersecurity-1/512/Whitelisting-512.png";
        $title = "📢  Nouvelle demande de Whitelist";
        $color = 25500;
        $thumbnail_url = "https://cdn1.iconfinder.com/data/icons/cybersecurity-1/512/Whitelisting-512.png";
        $description = "**Prénom : **$prenom \n **Âge : **$age ans \n **Discord :** $discord \n **Nombre d'heures : **$heuresteam h \n **Définition Freekill : **$freekill \n **Définition Carkill : **$carkill \n **Définition NoPainRP : **$nopainrp \n **Définition NoFeaRP : **$nofearp \n **Situation : **$situation \n **Background : **$background";
        $footer_text = "Whitelist | DriveRP";
        $footer_icon_url = "https://cdn1.iconfinder.com/data/icons/cybersecurity-1/512/Whitelisting-512.png";

        $message = [
            'content' => null,
            'avatar_url' => $avatar,
            'embeds' => [[
                'author' => [
                    'name' => $authorname,
                    'url' => $url,
                    'icon_url' => $icon_url,
                ],
                'title' => $title,
                'description' => $description,
                'color' => $color,
                'thumbnail' => [
                    'url' => $thumbnail_url,
                ],
                'image' => [
                    'url' => $image_url,
                ],
                'footer' => [
                    'text' => $footer_text,
                    'icon_url' => $footer_icon_url
                ]
            ]]
        ];

        $encoded_message = json_encode($message, JSON_PRETTY_PRINT);

        //var_dump($encoded_message);

        $webhook_url = WEBHOOK_DISCORD;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webhook_url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_message);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($encoded_message)
            )
        );

        curl_exec($ch);
        curl_close($ch);

        echo '<script>
                $(document).ready(function () {
                    toastr["success"]("Demande de whitelist !", "Bravo :")
                });
            </script><META http-equiv="refresh" content="2;URL=../success">';
    }
} ?>

<body>
    <!-- <div class="background"> -->
            <div class="container">
                <a class="logo" href="https://driverp.fr/" title="Page d'accueil"><img src="../../image/Logo.png"></a>
                <div class="form-outer">
                    <header style="color:white;">Formualire de Whitelist</header>
                    <div class="progress-bar">
                        <div class="step">
                            <p></p>
                            <div class="bullet">
                                <span>1</span>
                            </div>
                            <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                            <p></p>
                            <div class="bullet">
                                <span>2</span>
                            </div>
                            <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                            <div class="bullet">
                                <span>3</span>
                            </div>
                            <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                            <p></p>
                            <div class="bullet">
                                <span>4</span>
                            </div>
                            <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                            <p></p>
                            <div class="bullet">
                                <span>5</span>
                            </div>
                            <div class="check fas fa-check"></div>
                        </div>
                        <div class="step">
                            <p></p>
                            <div class="bullet">
                                <span>6</span>
                            </div>
                            <div class="check fas fa-check"></div>
                        </div>
                    </div>

                    <form class="form" action="#" method="POST">
                        <div class="page slide-page">
                            <div class="title">1️⃣ - Information IRL :</div>
                            <div class="field">
                                <div class="label">Prénom :</div>
                                <input type="text" name="prenom" required placeholder="Patrice" />
                            </div>
                            <div class="field">
                                <div class="label">Âge (ans):</div>
                                <input type="number" name="age" required placeholder="18" />
                            </div>
                            <div class="field">
                                <button class="firstNext next">Page suivante 🠖</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">2️⃣ - Information IRL :</div>
                            <div class="field">
                                <div class="label">Nom d'utilisateur Discord :</div>
                                <input type="text" name="discord" required placeholder="univer_s" />
                            </div>
                            <div class="field">
                                <div class="label">Nombre d'heures FiveM :</div>
                                <input type="number" name="heuresteam" required placeholder="150" />
                            </div>
                            <div class="field btns">
                                <button class="prev-1 prev">🠔 Revenir </button>
                                <button class="next-1 next">Suivant 🠖</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">3️⃣ - Information RP :</div>
                            <div class="field">
                                <div class="label">Définition du FreeKill :</div>
                                <input type="text" name="freekill" required placeholder="Voler des voitures" />
                            </div>
                            <div class="field">
                                <div class="label">Définition du CarKill :</div>
                                <input type="text" name="carkill" required placeholder="Voler des avions" />
                            </div>
                            <div class="field btns">
                                <button class="prev-2 prev">🠔 Revenir </button>
                                <button class="next-2 next">Suivant 🠖</button>
                            </div>
                        </div>
                        <div class="page">
                            <div class="title">4️⃣ - Information RP :</div>
                            <div class="field">
                                <div class="label">Définition du Bunny Hopping :</div>
                                <input type="text" name="nopainrp" required placeholder="Faire des braquages" />
                            </div>
                            <div class="field">
                                <div class="label">Définition du NoFeaRP :</div>
                                <input type="text" name="nofearp" required placeholder="Insulter des personnes" />
                            </div>
                            <div class="field btns">
                                <button class="prev-3 prev">🠔 Revenir </button>
                                <button class="next-3 next">Suivant 🠖</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">5️⃣ - Situation RP :</div>
                            <div class="field">
                                <div class="label" class="label">Situation Roleplay :</div>
                                <textarea type="textarea" rows="5" cols="33" disabled>Un braqueur braque un agent de police en service, cette personne ne possède pas d’argent sur elle mais le braqueur ne lui a pas retiré ces moyens de communication. L'agent prévient donc ses collègues discrètement, le braqueur le conduit jusqu'à la banque et lui demande de retirer toute l’argent qu'il possède sur son compte ensuite elle part en course poursuite avec la police puis le braqueur fait un ALT - F4.</textarea>
                            </div><br><br>
                            <div class="field">
                                <div class="label">Votre réponse :</div>
                                <select required name="situation">
                                    <option value="Le policier n'avait pas à prévenir ses collègues">Le policier n'avait pas à prévenir ses collègues</option>
                                    <option value="Le braqueur est en faute quand il a ALT F4">Le braqueur est en faute quand il a ALT F4</option>
                                    <option value="Le braqueur est en faute pour ForceRP + ALT F4">Le braqueur est en faute pour ForceRP + ALT F4</option>
                                    <option value="Aucune Faute">Aucune Faute</option>
                                </select>
                            </div>
                            <div class="field btns">
                                <button class="prev-4 prev">🠔 Revenir </button>
                                <button class="next-4 next">Suivant 🠖</button>
                            </div>
                        </div>

                        <div class="page">
                            <div class="title">6️⃣ - Information Whitelist :</div>
                            <div class="field">
                                <div class="label" class="label">Votre Background :</div>
                                <textarea type="textarea" id="background" name="background" rows="5" cols="33" required placeholder="Frank Pacino a grandi dans les vieux quartiers de Blaine County. Vivant dans une famille nombreuses et ayant un fort caractères, il ce faisait souvent tabassez par ces frères et soeurs qui ne le supportaient pas. Son père étant un chomeur et sa mère femme de ménage, leur situation était vraiment précaire : c'est pourquoi Frank compris qu'il devait ce débrouillez lui même. Tandis que c'est frères ainés trainait avec différents cartel , il découvrit rapidement que sa mentalité et ses capacités a garder son calme était un vrai atout pour rebondir et sortir de sa galère pour ne pas finir comme ses frères. Il finira par sortir premier de sa promo à l'école des sheriffs avant de venir emménager à Los Santos"></textarea>
                            </div><br><br>
                            <div class="field">
                                <div class="label">Confirmer la lecture du <a style="color: #ea0171;" href="../../wiki" target="_blank">Règlement</a></div>
                                <select required name="confirmation">
                                    <option value="J'ai lu et j'accepte le règlement">✅ J'ai lu et j'accepte le règlement</option>
                                    <option value="Je n'accepte pas le règlement">❌ Je n'accepte pas le règlement</option>
                                </select>
                            </div>
                            <div class="field btns">
                                <button class="prev-5 prev">🠔 Revenir </button>
                                <button class="submit" name="submit">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <!-- </div> -->
    <script src="../assets/script.js"></script>
</body>

</html>