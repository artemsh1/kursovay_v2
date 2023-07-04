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
            <li> <!--  class="active" -->
              <a href="index.php" title="Главная">Главная</a>
            </li>
            <li>
              <a href="products.php" title="Продукция">Продукция</a>
            </li>
            <li>
              <a href="news.php" title="Новости">Новости</a>
            </li>
            <?php if (isset($_SESSION['user_id'])) {
              

              if ($_SESSION['accountlvl'] == 2) {
                echo "<li><a href='accountAdmin.php' title='Личный кабинет'>Личный кабинет</a></li>";
              } else {
                echo "<li><a href='accountUser.php' title='Личный кабинет'>Личный кабинет</a></li>";
              }
              echo "<li><a href='session-destroy.php' title='Выйти'>Выйти</a></li>";
            } else {echo "<li><a href='login.php' title='Войти'>Войти</a></li>";
              }?>
          </ul>
        </div>
      </nav>
    </div>
  </div>
</div>