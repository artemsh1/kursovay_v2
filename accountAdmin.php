<?php
session_start();
include('config.php');
if ($_SESSION['accountlvl'] != 2) {
  echo '<script>window.location = "index.php";</script>';
}
?>



<!DOCTYPE html>
<html lang="ru">

<head>
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/style.css?1647963883" />
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css?1647963883">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css?1647963883">
  <link rel="stylesheet" href="hostcmsfiles/css/style.css">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Личный кабинет</title>
</head>

<body>

  <?php
  include('header.php');

  ?>

  <div class="container-fluid head-bg text-center">
    <div class="logo three">
      <a href="../index.php">
        <div class="h1">Веселый<span>пекарь</span></div>
      </a>
    </div>
  </div>

  <section class="greeting">
    <ul>
      <li>
        <div class="greeting-div"><span>Должность:</span></div>
        <div>Администратор</div>
      </li>
      <li>
        <div class="greeting-div"><span>Имя:</span></div>
        <?php
        $username = $_SESSION['username'];
        echo '<div>' . $username . '</div>';
        ?>
      </li>
    </ul>
  </section>


  <a href="add_new.php">
    <div class="add_new_btn">
      <p>Добавить новость</p>
    </div>
  </a>

  <div class="container contact-section">
    <h1 class="page-title">Редактировать новости</h1>
    <div class="container_bookings">


      <?php

      try {
        // SQL-запрос для выборки новостей из базы данных
        $query = "SELECT * FROM news ORDER BY date_new DESC"; // Предполагается, что у вас есть таблица "news" с колонками "title", "content" и "date"

        // Выполнение SQL-запроса
        $stmt = $connection->query($query);

        // Перебор результатов и вывод новостей
        $index = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $title = $row['url_new'];
          $content = $row['txt_new'];
          $date = $row['date_new'];
          $id_new = $row['id_new'];
          $_FILES[$id_new]['content'] = $content;
          // Вывод новости
          echo '<div class="bookings_block">
                  <div class="menu-grid" style="background-image: url(' . $title . ');">
                      <div class="price">' . $date . '</div>
                  </div>
                  <div class="bookings_block padding">
                      <details>
                          <summary>Подробнее</summary>
                          <p>' . $content . '</p>
                      </details>
                  </div>
                  <form method="POST">
                      <button type="submit" name="redact_new" value="' . $row['id_new'] . '">Редактировать</button>
                      <button type="submit" name="delete_new" value="' . $row['id_new'] . '">Удалить</button>
                  </form>
              </div>';
          $index++;
        }
      } catch (PDOException $e) {
        echo "Ошибка: " . $e->getMessage();
      } ?>
    </div>
  </div>
  <div class="modal_edit">
    <form  action="" method="post" enctype="multipart/form-data">
      <?php
      $redact_new = isset($_POST['redact_new']) ? $_POST['redact_new'] : '';
      $txt_new = isset($_FILES[$redact_new]['content']) ? $_FILES[$redact_new]['content'] : '';
      ?>
      Контент: <input type="hidden" name="redact_new" value="<?php echo $redact_new; ?>">
      <input value="<?php echo $txt_new; ?>" name="txt_new">
      <input type="file" name="url_new">
      <button name="oijfewoij" class="add_new_btn" type="submit" onclick="reloadPage()">Сохранить</button>
    </form>
  </div>
    <div class="container contact-section">
      <h1 class="page-title">Заказы пользователей</h1>
      <div class="container_bookings">


        <?php
        // ----------------------------------------------------------- вывод заказов
        try {
          // SQL-запрос для выборки новостей из базы данных
          // Предполагается, что у вас есть таблица "news" с колонками "title", "content" и "date"

          // Выполнение SQL-запроса
          $query = $connection->prepare("SELECT products.*, orders.*, users.username, users.phone ,products_has_orders.kolvo FROM products_has_orders
      JOIN products ON products_has_orders.products_swyaz = products.id_dish
      JOIN orders ON products_has_orders.orders_swyaz = orders.id_order
      JOIN users ON users.id_user = orders.users_id_user ORDER BY id_order DESC;");
          $query->execute();
          $result = $query->fetchAll(PDO::FETCH_ASSOC);
          for ($i_orders = 0; $i_orders < count($result); $i_orders++) {
            $id_order = $result[$i_orders]['id_order'];
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
        } catch (PDOException $e) {
          echo "Ошибка: " . $e->getMessage();
        }
        ?>
      </div>
    </div>
    <?php
    if (isset($_POST['delete_new'])) {
      $id = $_POST['delete_new'];
      try {
        // Подготовленный SQL-запрос для удаления новости
        $query = $connection->prepare("DELETE FROM news WHERE id_new = :id_new");
        $query->bindParam(":id_new", $id, PDO::PARAM_INT);
        $query->execute();
        echo '<meta http-equiv="refresh" content="0">';
      } catch (PDOException $e) {
        echo "Ошибка при удалении новости: " . $e->getMessage();
      }
    }
    ?>
    <style>
      .modal_edit input{
        width: 50%;
        margin: 2vh auto;
        text-align: center;
      }
      .add_new_btn{
        background-color: #fff;
        
      }
    </style>

    <?php
    if (isset($_POST['oijfewoij'])) {
      $redact_new = isset($_POST['redact_new']) ? $_POST['redact_new'] : '';
      $uploadname = basename($_FILES['url_new']['name']);
      $new_name = time() . '.' . $uploadname;
      $uploadpath = 'upload/foto/' . $new_name;
      $txt_new = isset($_POST['txt_new']) ? $_POST['txt_new'] : '';

      if (isset($_FILES['url_new']['tmp_name']) && move_uploaded_file($_FILES['url_new']['tmp_name'], $uploadpath)) {
        $query = $connection->prepare("UPDATE `news` SET `url_new`=?, `txt_new`=? WHERE `id_new`=?");
        $query->execute([$uploadpath, $txt_new, $redact_new]);
        echo '<meta http-equiv="refresh" content="0">';
      } else {
        $query = $connection->prepare("UPDATE `news` SET `txt_new`=? WHERE `id_new`=?");
        $query->execute([$txt_new, $redact_new]);
        echo '<meta http-equiv="refresh" content="0">';
      }
    }
    ?>


  </div>
  </div>
  </div>



  <?php include 'footer.php'; ?>
</body>

</html>