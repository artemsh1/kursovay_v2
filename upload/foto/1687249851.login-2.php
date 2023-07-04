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
    <link rel="stylesheet" type="text/css" href="../hostcmsfiles/css/5af183c861fdef245647388da9743802.css?1647963883">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>

<div id="home" class="container-fluid header-top">
  <div class="row">
    <div class="container top-nav">
      <nav class="navbar navbar-default" role="navigation">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse" id="main-navbar">
          <ul class="nav navbar-nav">
            <li>
              <a href="../index.htm" title="Главная">Главная</a>
            </li>
            <li>
              <a href="../products/index.htm" title="Продукция">Продукция</a>
            </li>
            <li>
              <a href="../news/index.htm" title="Новости">Новости</a>
            </li>
          
            <li class="active" style="background-image: none">
              <a href="index.htm" title="Войти">Войти</a>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</div>
		
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
        print_r($_SESSION);
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
                    $_SESSION['timeonline_users'] = $result['timeonline_users'];
                    switch ($_SESSION['accountlvl']){
                      case 0: $redirect_url = "accountUser.php"; break;
                      case 1: $redirect_url = "accountModer.php"; break;
                      case 2: $redirect_url = "accountAdmin.php"; break;
                      default: $redirect_url = "accountUser.php";
                    }
                    echo "<p class=\"success\">Поздравляем, вы прошли авторизацию!</p>
                    <script>window.location =  \"${redirect_url} \";</script>";
                    
                } else {
                    echo '<p class="error"> Неверные пароль!</p>';
                }
            }
        }
    ?>

<section class="form_inputs">
    <h1>Вход</h1>

    <form method="post" action="">

      <div class="form_row"><label for="email_user">почта</label>             <input type="email" name="login-email" id="login-email" placeholder="@gmail.com" required></div>
      <div class="form_row"><label for="password_user">Пароль</label>         <input type="password" name="password" id="password_user" placeholder="*********" required></div>
      <button type="submit" name="login" value="login">Войти</button>

    </form>
      <a href="register.php">Вы еще не зарегистрированы?</a>
      <a href="index.php#account_url">На главную</a>
  </section>
  <footer class="footer">
      <div class="container">   
        <div class="row flex-row">     
          <div class="col-xs-12 col-md-4 footer-grid">
						<div class="footer-logo">
							<a href="../index.htm">
								<div class="brand_mob">Веселый<span>пекарь</span></div>
								<div class="brand_pc">
									<img src="../hostcmsfiles/sopdu/images/logo_white.png" alt="Сеть пекарен Веселый пекарь">
								</div>
							</a>
						</div>
          </div>
          <div class="hidden-xs col-sm-6 col-md-4 footer-grid">
						

<div class="bottom-nav">
  <ul>
    <li>
      <a href="../index.htm" title="Главная">Главная</a>
    </li>
    <li>
      <a href="../products/index.htm" title="Продукция">Продукция</a>
    </li>
    <li>
      <a href="../news/index.htm" title="Новости">Новости</a>
    </li>
   
    <li>
      <a href="index.htm" title="Контакты">Контакты</a>
    </li>
  </ul>
</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-4 footer-grid">
						<div class="footer-contact">
               <script>//<![CDATA[
function hostcmsEmail(c){return c.replace(/[a-zA-Z]/g, function (c){return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c-26);})}document.write ('<a  href="mailto:' + hostcmsEmail('cncna-onxrel@vaobk.eh') + '" class="email">' + hostcmsEmail('                   cncna-onxrel@vaobk.eh               ') + '</a>');//]]>
</script>
							            </div>
					</div>
				</div>
			</div>
		</footer>
		<div class="copy-right">
				<div class="container">
										<p>Веселый &laquo;Пекарь&raquo; &copy; 2016 - 2023</p>
				</div>		
		</div>
		<a href="#" id="toTop"> 
       <i class="material-icons">expand_less</i>
    </a
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>