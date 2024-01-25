<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $db=mysqli_connect('localhost','root','root','v_blog');
        mysqli_select_db($db,'v_blog');

        // Получение данных пользователя из базы данных
        $sql_add = "select * from users where username='$username'";
        $result_add = $db->query($sql_add);

        if ($result_add->num_rows == 1) {
            $row = $result_add->fetch_assoc();
            if (password_verify($password, $row["password"])) {
                $_SESSION["username"] = $username;
                $_SESSION["id"] = $row["password"];
                echo "Аутентификация успешна!";
            } else {
                echo "Неверный пароль.";
            }
        } else {
            echo "Пользователь не найден.";
        }
    }
?>
