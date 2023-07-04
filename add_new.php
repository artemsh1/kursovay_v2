<meta charset="UTF-8">
<!DOCTYPE html>
<html lang="ru">

<head>
  <link rel="stylesheet" href="assets/style1.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/style.css?1647963883">
  
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css?1647963883">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Регистрация</title>
</head>

<body>

  <?php include 'header.php';
  include 'config.php';
  ?>

  <div class="container-fluid head-bg text-center">
    <div class="logo three">
      <a href="../index.htm">
        <div class="h1">Веселый<span>пекарь</span></div>
      </a>
    </div>
  </div>

  </div>
  </div>
  <div class="clearfix"></div>
  </div>

  <section>
    <h1 class="input_header">Добавить новость</h1>
    <form method="post" action="" class="form_inputs" enctype="multipart/form-data">
        <div class="form_row">
            <label for="img">Изображение записи</label>
            <input type="file" name="url_new" required/>
        </div>
      <div class="form_row">
        <label for="txt_new">Содержимое новости: </label>
        <textarea name="txt_new" id="txt_new" placeholder="Только сегодня повариха упала со стула!!! Ура!!!" required></textarea>
      </div>
      
      <button type="submit" name="add_new" value="add_new">Добавить новость</button>
      <p><a href="../index.htm">На главную</a></p>
    </form>
    <?php
                if (isset($_POST['add_new'])) {
                    $txt_new = $_POST['txt_new'];
                    $date_new = date('Y-m-d');
                    $uploadname = basename($_FILES['url_new']['name']);
                    $new_name = time() . '.' . $uploadname;
                    $uploadpath = 'upload/foto/' . $new_name;
                
                    if (move_uploaded_file($_FILES['url_new']['tmp_name'], $uploadpath)) {
                        $query = $connection->prepare("INSERT INTO `news` (`id_new`, `date_new`, `url_new`, `txt_new`) VALUES (NULL, :date_new, :url_new, :txt_new)");
                        $query->bindValue(':date_new', $date_new);
                        $query->bindValue(':url_new', $uploadpath);
                        $query->bindValue(':txt_new', $txt_new);
                        $query->execute();
                        echo 'новость успешно добавлено!';
                    } else {
                        echo 'Ошибка загрузки!';
                    }
                }
            ?>
  </section>
  <?php include 'footer.php'; ?>
</body>

</html>