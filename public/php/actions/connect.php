<?php
include_once "public/php/utils.php";

if (!isset($_SESSION["discord_id"]) || !isset($_SESSION["username"]) || !isset($_SESSION["discriminator"])) {
    if (get("code") == null) {
        get_code();
    } else {
        $user_info = get_user_info(exchange_token(get("code")));
        $_SESSION["discord_id"] = $user_info->id;
        $_SESSION["avatar_url"] = "https://cdn.discordapp.com/avatars/$user_info->id/$user_info->avatar.png";
        $_SESSION["username"] = $user_info->username;
        if (isset($user_info->global_name)) {
            $_SESSION["use_new_names"] = true;
            $_SESSION["global_name"] = $user_info->global_name;
        } else {
            $_SESSION["use_new_names"] = false;
            $_SESSION["discriminator"] = $user_info->discriminator;
        }
        $body = "<h2>Authentification terminée!</h2>";
        set_id_of_adress($_SESSION["discord_id"], get_user_ip());
        header("Refresh:0; url=index.php?action=greetings");
    }
}
