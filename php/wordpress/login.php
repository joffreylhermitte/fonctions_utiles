<?php
add_action('wp_ajax_ajaxlogin','loginUser');
add_action('wp_ajax_nopriv_ajaxlogin','loginUser');

function loginUser(){
    $identifiant = trim(strip_tags($_POST['identifiant']));
    $password = trim(strip_tags($_POST['password']));

    global $wpdb;

    $user = $wpdb->get_row($wpdb->prepare("SELECT * FROM user WHERE email = %s",$identifiant),OBJECT);

    if($user !== null){
        if(password_verify($password,$user->password)){
            $_SESSION['login'] = 'true';
            $_SESSION['idUser'] = $user->id;
            $_SESSION['email'] = $user->email;


            showJson('success');

        } else {
            showJson("Email/mot de passe incorrecte");
        }


    } else {
        showJson("Aucun compte avec cet identifiant");
    }
}
