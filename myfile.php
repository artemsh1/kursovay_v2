
<?php
        session_start();
        include 'config.php';
        if(isset($_POST['myArray'])){
        $myArray = $_POST['myArray'];
      
        // Подключение к базе данных (здесь предполагается использование MySQL)
        
      
        try {
          
          if (!isset($_SESSION['user_id'])) {
            echo 'Нужно войти в аккаунт';
          } else {

          print_r($_SESSION);
          $stmt1 = $connection->prepare("INSERT INTO `orders`(`date_order`, `sum_order`, `users_id_user`) VALUES (CURRENT_DATE(),". $_SESSION['orders']['LastOrder']['total_price'].",".$_SESSION['user_id'].")");
          $stmt1->execute();
          
          
          // Получение ID последней вставленной записи в таблицу orders
          $order_id = $connection->lastInsertId();

          // Подготовленный запрос для вставки массива в базу данных
          $stmt = $connection->prepare("INSERT INTO products_has_orders (orders_swyaz, products_swyaz, kolvo) VALUES ('$order_id' , :products_swyaz, :kolvo)");
          
          

        // Получение ID последней вставленной записи в таблицу orders
        $order_id = $connection->lastInsertId();
        $_SESSION['IDZAKAZA'] = $order_id+1;
        print_r($_SESSION['IDZAKAZA']);
             // Получение ID элемента из переменной $_SERVER
          if (isset($_SESSION['IDZAKAZA'])) {
            $elementId = $_SESSION['IDZAKAZA'];
          } else {
            $elementId = 'NaN';
          }
    

    // Передача переменной $elementId в JavaScript
    echo "<script>var elementId = '". $elementId ."';</script>";

        // Удаляем квадратные скобки из строки
        $myArray = str_replace(['{', '}', '"'], '', $myArray);
        // Разбиваем строку на массив
        $array = explode(',',$myArray);

        // Удаляем лишние пробелы у каждого элемента массива
        $array = array_map('trim', $array);
        

        for ($i=0; $i < count($array); $i++) {
          $str = $array[$i];
          $array1[$i]['id'] =  strstr($str, ':', true);
          $array1[$i]['value'] =  strstr($str, ':');
          $array1[$i]['value'] = mb_substr($array1[$i]['value'], 1);
        }
        print_r($array1);
          $index = 0;
          foreach ($array1 as $value) {
            $array1[$index]['id']++;
            // Привязка значения к параметру запроса
            $stmt->bindParam(':products_swyaz', $array1[$index]['id']);
            $stmt->bindParam(':kolvo', $array1[$index]['value']);
            $index++;
            // Выполнение запроса
            $stmt->execute();
          }
      
      
          // Возвращение ответа
          echo 'Массив успешно записан в базу данных!';
        }
        } catch(PDOException $e) {
          // Обработка ошибок подключения к базе данных
          echo 'Ошибка подключения к базе данных: ' . $e->getMessage();
        }
      }
      
?>