<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION["username"])) {
        $title = $_POST["title"];
        $content = $_POST["content"];
        $author_id = $_POST["author_id"];
        $created_at = $_POST["created_at"];

        $db=mysqli_connect('localhost','root','root','v_blog');
        mysqli_select_db($db,'v_blog');

        $username = $_SESSION["username"];

        // Проверьте, что пользователь имеет доступ к редактированию статьи
        $sql_add = "select articles.id, users.username from articles join users on articles.author_id = users.id where articles.id = $author_id and users.username = '$username'";
        $result_add = $db->query($sql_add);

        if ($result_add->num_rows == 1) {
            // Обновление существующей статьи в базе данных
            $sql_add = "update articles set title = '$title', content = '$content', created_at = '$created_at' where id = $author_id";
            if ($db->query($sql_add) === TRUE) {
                echo "Статья успешно отредактирована!";
            } else {
                echo "Ошибка при редактировании статьи: " . $db->error;
            }
        } else {
            echo "Ошибка при редактировании статьи: Доступ запрещен.";
        }

        // Закрытие соединения
        $db->close();
    }
?>
