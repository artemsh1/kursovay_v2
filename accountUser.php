<?php
session_start();
if (!$_SESSION['user_id'])
  header('location: login.php');
?>

<!DOCTYPE html>
<html lang="ru">

<head>
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/style.css?1647963883" />
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css?1647963883">
  <link rel="stylesheet" href="assets/style1.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css?1647963883">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Личный кабинет</title>
</head>

<body>

  <?php
  include 'header.php';
  include 'config.php';
  if (isset($_POST['delete_reservation'])) {
    $query = $connection->prepare("DELETE FROM `reservations` WHERE id_reservation=:id_reservation");
    $query->bindParam("id_reservation", $_POST['delete_reservation'], PDO::PARAM_STR);
    $query->execute();
    echo '<meta http-equiv="refresh" content="0">';
  }
  ?>
  <br><br><br><br><br>
  <div class="container contact-section">
    <h1 class="page-title">Ваши заказы</h1>
    <div class="container_bookings">

      <?php
      // —-------------------------------------------------------— вывод заказов
      try {
        // SQL-запрос для выборки новостей из базы данных
        // Предполагается, что у вас есть таблица "news" с колонками "title", "content" и "date"

        // Выполнение SQL-запроса
        $query = $connection->prepare("SELECT products.*, orders.*, users.username,users.id_user, users.phone ,products_has_orders.kolvo FROM products_has_orders
JOIN products ON products_has_orders.products_swyaz = products.id_dish
JOIN orders ON products_has_orders.orders_swyaz = orders.id_order
JOIN users ON users.id_user = orders.users_id_user ORDER BY id_order DESC;");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        for ($i_orders = 0; $i_orders < count($result); $i_orders++) {
          $id_order = $result[$i_orders]['id_order'];
          $_FILES['orders'][$id_order]['user_id'] = $result[$i_orders]['id_user'];
          $_FILES['orders'][$id_order]['name'] = $result[$i_orders]['username'];
          $_FILES['orders'][$id_order]['phone'] = $result[$i_orders]['phone'];
          $_FILES['orders'][$id_order]['sum_order'] = $result[$i_orders]['sum_order'];
          $_FILES['orders'][$id_order]['dishes'][0] = 'Товары:';
          $_FILES['orders'][$id_order]['prices'][0] = 0;
          $_FILES['orders'][$id_order]['kolvo'][0] = '';
          array_push($_FILES['orders'][$id_order]['dishes'], $result[$i_orders]['name_dish']);

          $_FILES['orders'][$id_order]['itog'] = $_FILES['orders'][$id_order]['prices'];
          array_push($_FILES['orders'][$id_order]['kolvo'], $result[$i_orders]['kolvo']);
        }
        // Перебор результатов и вывод новостей

        foreach ($_FILES['orders'] as $key => $value) {
          $name = $_FILES['orders'][$key]['name'];
          $id_order = $key;
          $phone = $_FILES['orders'][$key]['phone'];
          $sum_order = $_FILES['orders'][$key]['sum_order'];
          $dishes = $_FILES['orders'][$key]['dishes'];
          $kolvo = $_FILES['orders'][$key]['kolvo'];
          if ($_SESSION['user_id'] == $_FILES['orders'][$key]['user_id']) {
            echo '<div class="bookings_block padding">';
            echo '<p>Номер заказа: ' . $id_order . '</p><p>Сумма заказа: ' . $sum_order . '</p>';
            echo '<details class="orders">
<summary>Содержимое заказа</summary>';
            for ($i = 0; $i < count($dishes); $i++) {
              echo '<p>' . $dishes[$i] . ' - ' . $kolvo[$i] . ' шт. </p>';
            }
            echo '</details>';
            echo '<br>' . $phone . '</div>';
          }
        }
      } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
      }

      ?>
    </div>
  </div>
  </div>
  <?php
  include 'footer.php';
  ?>

  <script type="text/javascript" src="assets/JsBarcode.all.min.js"></script>

</body>

</html>