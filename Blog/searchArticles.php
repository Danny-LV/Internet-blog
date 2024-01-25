<?php
    // Подключение к базе данных
    $db=mysqli_connect('localhost','root','root','v_blog');
    mysqli_select_db($db,'v_blog');

    // Проверка подключения
    if ($db->connect_error) {
        die("Ошибка подключения: " . $db->connect_error);
    }

    // Получаем поисковой запрос из запроса
    $searchQuery = $_POST['searchQuery'];

    // SQL-запрос для поиска статей по запросу
    $sql_add = "select * from articles where title like '%$searchQuery%' or content like '%$searchQuery%'";
    $result_add = $db->query($sql_add);

    if ($result_add->num_rows > 0) {
        $articles = array(); // Массив для хранения статей
        while ($row = $result_add->fetch_assoc()) {
            $articles[] = $row; // Добавляем статью в массив
        }
        echo json_encode($articles); // Возвращаем статьи в формате JSON
    } else {
        echo "0 результатов";
    }

    // Закрытие соединения
    $db->close();
?>
