<?php
    session_start();
    // print_r($_POST);
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["username"]) && isset($_POST["password"])) {
        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $email = $_POST["email"];
        $created_at = $_POST["created_at"];

        $db=mysqli_connect('localhost','root','root','v_blog');
        mysqli_select_db($db,'v_blog');

        // Добавление данных пользователя в базу данных
        $sql_add = "insert into users (id, username, password, email, created_at) values (NULL, '$username', '$password', '$email', CURRENT_TIMESTAMP())";
        if ($db->query($sql_add) === TRUE) {
            $_SESSION["username"] = $username;
            echo "Регистрация успешна!";
        } else {
            echo "Ошибка регистрации: " . $db->error;
        }
    }
?>
