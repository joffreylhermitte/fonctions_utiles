<?php
add_action('wp_ajax_ajaxforgotpassword','forgotPassword');
add_action('wp_ajax_nopriv_ajaxforgotpassword','forgotPassword');

function forgotPassword(){
    global $wpdb;

    $email = trim(strip_tags($_POST['email']));
    $from = "email";

    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE email = %s",$email),OBJECT);

    if($user !== null){
        $data = [];
        $userId = $user->id;
        $token = $user->token;
        $key = random_int(100000,999999);
        $hashKey = hash('sha256',(string)$key);
        array_push($data,$token,$hashKey,$userId);



        $headers  = "From: ".$from." \n";
        $headers .= "Reply-To:".$from." <".$from."> \n";
        $headers .= "MIME-Version: 1.0 \n";
        $headers .= "Content-type: text/html; charset=utf8 \n";

        $body = file_get_contents(get_template_directory_uri().'/assets/email_template/email-mot-de-passe-oublie.php');
        $replace = [
            "[code]" =>$key,
        ];
        $email_content = strtr($body,$replace);
        if(wp_mail("test@test.com", "Réinitialisation mot de passe", $email_content, $headers)){
            showJson($data);

        } else {
            showJson("erreur");
        }

    } else {
        showJson("Compte non trouvé");
    }

}
