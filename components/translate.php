<?php

if (isset($_SESSION['country'])) {

if ($_SESSION['country'] == ""){
    $_SESSION['country'] = "EN";
}

if ($_SESSION['country'] == "EN"){
    
    // Navbar
    
    $ts_home = "Home";
    $ts_center = "Center";
    $ts_account = "Account";
    $ts_company = "Company";
    $ts_logout = "Logout";
    $ts_lr = "Login / Register";
    $ts_account_change = "Change account";
    
    // Home Page
    
    $ts_hello = "Hello, ". $_SESSION['username'] ."";
    $ts_post_twist = "Post a Twist";
    $ts_post_insight = "Post a Insight";
    $ts_post = "Post";
    $ts_post_as_company = "Post as a company";
    $ts_text = "text";
    
    $ts_recommanded_accounts = "Recommanded accounts";
    $ts_recents_twists = "Recents Twists";
    $ts_liked_twists = "Most liked Twists";
    $ts_active_accounts = "Most active accounts";
    $ts_reply_twists = "Most reply Twists";
    
    $ts_follow = "Follow";
    $ts_followed = "Followed";
    
    // Account Page
    
    $ts_account_info = "Account info";
    $ts_total_posts_account = "Total twists posted";
    $ts_total_likes_account = "Total likes";
    $ts_total_visits_account = "Total account visits";
    
    $ts_edit_account = "Edit account";
    $ts_username = "Username";
    $ts_biography = "Biography";
    $ts_picture_account = "Profile picture";
    $ts_country = "Country";
    
} elseif ($_SESSION['country'] == "FR") {
    
    // Navbar
    
    $ts_home = "Accueil";
    $ts_center = "Centre";
    $ts_account = "Compte";
    $ts_company = "Entreprise";
    $ts_logout = "Déconnexion";
    $ts_lr = "Connexion / Inscription";
    $ts_account_change = "Changer de compte";
    
    // Home Page
    
    $ts_hello = "Bonjour, ". $_SESSION['username'] ."";
    $ts_post_twist = "Publier un Twist";
    $ts_post_insight = "Publier un Insight";
    $ts_post = "Publier";
    $ts_post_as_company = "Publier en tant qu'entreprise";
    $ts_text = "texte";
    
    $ts_recommanded_accounts = "Comptes recommandés";
    $ts_recents_twists = "Twists les plus récents";
    $ts_liked_twists = "Twists les plus appréciés";
    $ts_active_accounts = "Comptes les plus actifs";
    $ts_reply_twists = "Twists les plus reply";
    
    $ts_follow = "S'abonner";
    $ts_followed = "Abonné";
    
    // Account Page
    
    $ts_account_info = "Information du compte";
    $ts_total_posts_account = "Total de Twists postés";
    $ts_total_likes_account = "Total des likes";
    $ts_total_visits_account = "Total des vues";
    
    $ts_edit_account = "Modification du compte";
    $ts_username = "Nom d'utilisateur";
    $ts_biography = "Biographie";
    $ts_picture_account = "Image de profile";
    $ts_country = "Pays";
}

}