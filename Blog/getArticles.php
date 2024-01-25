<?php
    // $search = $_GET("search");
    // Подключение к базе данных
    $db=mysqli_connect('localhost','root','root','v_blog');
    mysqli_select_db($db,'v_blog');

    // Проверка подключения
    if ($db->connect_error) {
        die("Ошибка подключения: " . $db->connect_error);
    }

    // SQL-запрос для извлечения статей
    if (isset($_POST["search"]))
    {
        $search = $_POST["search"];
        $sql_add = "select articles.id, articles.title, articles.content, articles.author_id, articles.created_at,
        users.username from articles JOIN users ON articles.author_id = users.id WHERE articles.title LIKE '%$search%'
        ORDER BY created_at DESC";
       
    }else{
        $sql_add = "select articles.id, articles.title, articles.content, articles.author_id, articles.created_at,
        users.username from articles JOIN users ON articles.author_id = users.id
        ORDER BY created_at DESC";
    }
    $result_add = $db->query($sql_add);

    if ($result_add->num_rows > 0) {
        $articles = array(); // Массив для хранения статей
        while ($row = $result_add->fetch_assoc()) {
            $articles[]=$row; // Добавляем статью в массив
        }
        echo json_encode($articles); // Возвращаем статьи в формате JSON
    } else {
        echo "0 результатов";
    }

    // Закрытие соединения
    $db->close();
?>
