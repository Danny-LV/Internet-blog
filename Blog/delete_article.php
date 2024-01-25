<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["username"])) {
        $id = $_POST["id"];

        $db=mysqli_connect('localhost','root','root','v_blog');
        mysqli_select_db($db,'v_blog');

        $username = $_SESSION["username"];

        // Проверьте, что пользователь имеет доступ к удалению статьи
        $sql_add = "select articles.id, users.username from articles
        join users on articles.author_id = users.id
        where articles.id = $id and users.username = '$username'";
        $result_add = $db->query($sql_add);

        if ($result_add->num_rows == 1) {
            // Удаление статьи из базы данных
            $sql_add = "delete from articles where id = $id";
            if ($db->query($sql_add) === TRUE) {
                echo "Статья успешно удалена!";
            } else {
                echo "Ошибка при удалении статьи: " . $db->error;
            }
        } else {
            echo "Ошибка при удалении статьи: Доступ запрещен.";
        }

        // Закрытие соединения
        $db->close();
    }
?>
