<?php
add_action('wp_ajax_ajaxchangepassword','changePassword');
add_action('wp_ajax_nopriv_ajaxchangepassword','changePassword');

function changePassword(){
    global $wpdb;

    $token = trim(strip_tags($_POST['token']));
    $key = trim(strip_tags($_POST['key']));
    $hashKey = trim(strip_tags($_POST['hashkey']));
    $userId = trim(strip_tags($_POST['user']));
    $password = trim(strip_tags($_POST['password']));

    $hash = hash('sha256',$key);

    $check = hash_equals($hash,$hashKey);

    if($check){
        $user = $wpdb->get_row("SELECT * FROM user WHERE id = '$userId' AND token = '$token'");
        if($user !== null){
            if(!preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$ %^&*-]).{8,}$/',$password)){
                showJson('Erreur mot de passe (8 caractères, 1 majuscule, 1 chiffre, 1 caractère spécial) ');
            }
            $hashPassword = password_hash($password,PASSWORD_BCRYPT);
            $bytes = random_bytes(10);
            $newToken = bin2hex($bytes);
            $success = $wpdb->update('user',
                array(
                    'password'=> $hashPassword,
                    'token' => $newToken
                ),
                array('id'=>$userId)
            );
            if($success){
                showJson("Mot de passe modifié avec succès");
            } else {
                showJson("Une erreur est survenue");
            }
        } else {
            showJson("Compte non trouvé");
        }

    } else {
        showJson("Code non valide");
    }





}
