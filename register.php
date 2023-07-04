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
    <script src="hostcmsfiles/js/sweetalert2@11.js"></script>
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
	
<script>
    function sweet_true(sw_icon, sw_title) {
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      Toast.fire({
        icon: sw_icon,
        title: sw_title
      })
    }
  </script>
		
<script src="assets/mask.js"></script>
    <?php
        session_start();
        include('config.php');
        if (isset($_POST['register'])) {
            $username = $_POST['username'];
            $phone = $_POST['phone'];
            $email = $_POST['register-mail'];
            $password = $_POST['register-password']; 
            $passworddouble = $_POST['register-password-double'];
            $password_hash = password_hash($password, PASSWORD_BCRYPT);
            $query = $connection->prepare("SELECT * FROM users WHERE email=:email OR phone=:phone");
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->bindParam(":phone", $email, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result['email'] == $email) {
              echo "<script>sweet_true('error','такая почта уже зарегистрирована!');</script>";
            
            } else if ($result['phone'] == $phone) {
              echo "<script>sweet_true('error','Пользователь с таким телефоном уже есть!');console.log('1');</script>";
            } else {
              $query = $connection->prepare("INSERT INTO users(username,password,email,phone) VALUES (:username,:password_hash,:email,:phone)");
              $query->bindParam(":phone", $phone, PDO::PARAM_STR);
              $query->bindParam(":username", $username, PDO::PARAM_STR);
              $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
              $query->bindParam(":email", $email, PDO::PARAM_STR);
              $result = $query->execute();
              if ($result) {
                echo "<script>sweet_true('sucess','Регистрация прошла успешно!');</script>";
                $query = $connection->prepare("SELECT * FROM users WHERE email=:email");
                $query->bindParam("email", $email, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                $_SESSION['user_id'] = $result['id_user'];
                $_SESSION['username'] = $result['username'];
                $_SESSION['accountlvl'] = $result['accountlvl'];
                $_SESSION['phone'] = $result['phone'];
                $_SESSION['email'] = $result['email'];
                $_SESSION['timeonline_users'] = $result['timeonline_users'];
                echo '<script>window.location = "index.php";</script>';
              } else {
                echo '<p class="error">Неверные данные!</p>';
              }
            }
        }
    ?>

    <section >
    
   <h1 class="input_header">Регистрация</h1>
    <form method="post" action="" class="form_inputs">
 
      <div class="form_row"><label for="name_user">Имя</label>                <input type="text" name="username" id="name_user" placeholder="Максим" required></div>
      <div class="form_row"><label for="email_user">Почта</label>             <input type="email" name="register-mail" id="email_user" placeholder="ghffhgsuvhis635@gmail.com" required></div>
      <div class="form_row"><label for="email_user">Телефон</label>           <input type="tel" name="phone" id="phone" data-phone-pattern /></div>
      <div class="form_row"><label for="password_user">Пароль</label>         <input type="password" name="register-password" id="password_user" placeholder="*********" required></div>
      <div class="form_row"><label for="repeat_password" id="repeat_password_label">Повтор пароля</label><input type="password" name="register-password-double" id="repeat_password" placeholder="*********" required></div>
      <button type="submit"  name="register" value="register">Зарегистрироваться</button>
      <p>У вас уже есть аккаунт? <br><a href="login.php">- Войдите!</a></p>
      <p><a href="../index.htm">На главную</a></p>
    </form>

  </section>
  <?php include 'footer.php'; ?>
</body>
<script src="hostcmsfiles/js/mask.js"></script>
</html>