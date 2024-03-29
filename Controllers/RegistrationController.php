<?php

namespace App\Controllers;

use App\Models\Member;
use App\Services\MemberManager;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (isset($_SESSION["member"])) {
    header("Location: home");
}

if (count($_POST) > 0) {
    $errors = [];
    if (isset($_POST['g-recaptcha-response'])) {
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=" . urlencode("6LchM_cUAAAAAGxAmsd65pJPlsD49OYfT13ddXdH") .  "&response=" . urlencode($_POST['g-recaptcha-response']) . "&remoteip=" . $_SERVER['REMOTE_ADDR'];
        $responseKeys = json_decode(file_get_contents($url), true);
    } else {
        $errors[] = "Vérifiez le Captcha.";
    }
    $email = $_POST["email"];
    $password = $_POST["password"];
    if (strlen($password) < 8 || !preg_match("/[0-9]+/", $password) || !preg_match("/[a-z]+/", $password) || !preg_match("/[A-Z]+/", $password)) {
        $errors[] = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un chiffre et au minimum 8 caractères.";
    }
    if ($password !== $_POST["confirmPassword"]) {
        $errors[] = "Les mots de passe doivent correspondre.";
    }
    if (MemberManager::exists($email)) {
        $errors[] = "Cet e-mail est déjà utilisé.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Le format de l'e-mail n'est pas valide.";
    }
    if (count($errors) === 0 && $responseKeys["success"]) {
        $member = new Member(0, $_POST["name"], $_POST["firstname"], $email, $password, "MEMBER");
        MemberManager::insert($member);
        $env = "dev";
        try {
            if ($env === "prod") {
                $mail = new PHPMailer();
                $mail->Host = 'smtp-thomaslaure.alwaysdata.net';
                $mail->Port = 587; // 465
                $mail->Username = 'thomaslaure@alwaysdata.net';
                $mail->Password = '';
                $mail->SetFrom('thomaslaure@alwaysdata.net');
                $verifyLink = "https://thomaslaure.alwaysdata.net/Shlagithon/index.php/verify?email=";
            } else {
                $mail = new PHPMailer(true);
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587; // 465
                $mail->Username = 'mdesligues@gmail.com';
                $mail->Password = '$$MaisonDesLigues2018';
                $mail->SetFrom('mdesligues@gmail.com');
                $verifyLink = "http://localhost/Shlagithon/index.php/verify?email=";
            }
            $mail->IsHTML(true);
            $mail->IsSMTP();
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls'; // ssl
            $mail->Subject = 'Vérification de compte';
            $mail->Body = "<p>Bonjour,</p>
                <p>Merci de vous être enregistré sur Patoketchup.</p>
                <p>Votre compte vient d'être créé, vous pourrez vous connecter après avoir confirmé votre e-mail.</p>
                <p>Pour ce faire, veuillez cliquer sur le lien suivant :</p>
                <p>" . $verifyLink . $email . "&hash=" . password_hash($password, PASSWORD_DEFAULT) . "</p>
                <p>À bientôt !</p>
                <p>L'équipe de Patoketchup</p>";
            $mail->AddAddress($email);
            $mail->send();
            header("Location: login?success=1&email=" . $email);
        } catch (Exception $e) {
            header("Location: login?success=0");
        }
    }
}

require __DIR__ . "/../Views/registration_account.php";