<?php

    // Подключение к базе данных

    session_start();
    //  echo "Зашли в - createArticle.php";
    //echo "По посту пришло : ".print_r($_POST)."<br>";

    if ($_SERVER["REQUEST_METHOD"] == "POST" /*&& isset($_SESSION["username"])*/) {
        //  echo "Начали метод в PHP - createArticle.php";
        $title = $_POST["title"];
        $content = $_POST["content"];
        $author_id = 1;// $_POST["author_id"]; Взять  с сессии
        $created_at = $_POST["created_at"];
        $isEdit = $_POST["isEdit"];
        $id= $_POST["id"];

        $db=mysqli_connect('localhost','root','root','v_blog');
        mysqli_select_db($db,'v_blog');

        $username = $_SESSION["username"];
        //  echo "Распечатка сессии".print_r($_SESSION);

        // Получите user_id по имени пользователя
        $sql_add = "select id from users where username = '$username'";
        // echo "<br> Запрос <DEBUG>$sql_add составлен";
        $result_add = $db->query($sql_add);
        // echo "<br> Запрос <DEBUG>$sql_add выполнен";
        if ($result_add->num_rows == 1) {
            $row = $result_add->fetch_assoc();
            $user_id = $row["id"];

            // Добавление новой статьи в базу данных
            if ($isEdit == "1") 
            {
              $sql_add = "UPDATE articles SET title='$title', content='$content', author_id='$user_id', created_at=CURRENT_TIMESTAMP() WHERE id =$id";
              echo "SQL = $sql_add";
            //  echo "<br><DEBUG> Запрос $sql_add составлен";
            } else {
              $sql_add = "insert into articles (id, title, content, author_id, created_at)
              values (NULL, '$title', '$content', $user_id, CURRENT_TIMESTAMP())";
            }
            if ($db->query($sql_add)) {
                echo "Статья успешно создана!";
            } else {
                echo "Ошибка при создании статьи: " . $db->error;
            }
        } else {
            echo "Ошибка при создании статьи: Пользователь не найден.";
        }

        // // Получаем данные о новой статье из запроса
        // $title = $_POST['title'];
        // $content = $_POST['content'];

        // Закрытие соединения
        $db->close();
    }
?>
