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

  <?php include 'header.php'; ?>

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

  <?php
  session_start();
  include('config.php');
  if (isset($_POST['login'])) {
    $email = $_POST['login-email'];
    $password = $_POST['password'];
    $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
      echo '<p class="error">Неверные пароль или почта!</p>';
    } else {
      if (password_verify($password, $result['password'])) {
        $_SESSION['user_id'] = $result['id_user'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['accountlvl'] = $result['accountlvl'];
        $_SESSION['phone'] = $result['phone'];
        $_SESSION['email'] = $result['email'];
        switch ($_SESSION['accountlvl']) {
          case 0:
            $redirect_url = "accountUser.php";
            break;
          case 1:
            $redirect_url = "accountModer.php";
            break;
          case 2:
            $redirect_url = "accountAdmin.php";
            break;
          default:
            $redirect_url = "accountUser.php";
        }
        echo "<p class=\"success\">Поздравляем, вы прошли авторизацию!</p><script>window.location =  \"$redirect_url \";</script>";
      } else {
        echo '<p class="error"> Неверные пароль!</p>';
      }
    }
  }
  ?>

  <section>
    <h1 class="input_header">Вход</h1>
    <form method="post" action="" class="form_inputs">

      <div class="form_row">
        <label for="email_user">Почта</label>
        <input type="email" name="login-email" id="login-email" placeholder="@gmail.com" required>
      </div>
      <div class="form_row">
        <label for="password_user">Пароль</label>
        <input type="password" name="password" id="password_user" placeholder="*********" required>
      </div>
      <button type="submit" name="login" value="login">Войти</button>
      <p>Вы еще не зарегистрированы? <br><a href="register.php">- Зарегистрируйтесь!</a></p>
      <p><a href="../index.htm">На главную</a></p>
    </form>

  </section>
  <?php include 'footer.php'; ?>
</body>

</html>