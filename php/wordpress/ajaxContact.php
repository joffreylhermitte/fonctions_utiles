<?php
add_action('wp_ajax_ajaxcontact','sendMessage');
add_action('wp_ajax_nopriv_ajaxcontact','sendMessage');

function sendMessage(){

    $data = array(
        'secret' => "",
        'response' => $_POST['h-captcha-response']
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);
    $responseData = json_decode($response);
    if($responseData->success) {
        $nom = trim(strip_tags($_POST['nom']));
        $prenom = trim(strip_tags($_POST['prenom']));
        $email = trim(strip_tags($_POST['email']));
        $telephone = trim(strip_tags($_POST['telephone']));
        $message = trim(strip_tags($_POST['message']));

        $cleanMessage = stripslashes($message);

        if($nom !== "" && $prenom !== "" && $email !== ""){


            $headers  = "From: ".$email." \n";
            $headers .= "Reply-To:".$email." <".$email."> \n";
            $headers .= "MIME-Version: 1.0 \n";
            $headers .= "Content-type: text/html; charset=utf8 \n";

            $body = file_get_contents(get_template_directory_uri().'/assets/email_template/email-contact.php');
            $replace = [
                "[prenom]" => $prenom,
                "[nom]" => $nom,
                "[email]" => $email,
                "[telephone]" => $telephone,
                "[message]" => $cleanMessage,


            ];
            $email_content = strtr($body,$replace);
            if(wp_mail("test@test.com", "Nouveau contact", $email_content, $headers)){
                showJson('Message envoyé');

            } else {
                showJson("erreur");
            }
        } else {
            showJson('erreur');
        }

    } else {
        showJson('erreur');
    }




}
