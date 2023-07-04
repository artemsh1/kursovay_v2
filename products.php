<?php session_start();
include 'config.php'; ?>
<!DOCTYPE html>
<html lang="ru" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Продукция</title>
  <meta name="description" content="Состав и энергетическая ценность продукции ">
  <meta name="keywords" content="Продукция">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no">
  <link rel="icon" type="image/png" href="hostcmsfiles/sopdu/images/favicon.png">
  <script src="hostcmsfiles/sopdu/js/jquery-1.12.4.min.js"></script>
  <script src="hostcmsfiles/sopdu/js/jquery.validate.min.js"></script>
  <script src="hostcmsfiles/sopdu/js/jquery.swipebox.min.js"></script>
  <script src="hostcmsfiles/sopdu/js/responsiveslides.min.js"></script>
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css">
  <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/style.css">
  <script src="hostcmsfiles/js/script1.js"></script>
  <script src="hostcmsfiles/js/addDB.js"></script>
</head>
<body>
  <script src="hostcmsfiles/js/sweetalert2@11.js"></script>


 <?php
$stmt1 = $connection->prepare("SELECT MAX(id_order) FROM orders");
$stmt1->execute();

$result = $stmt1->fetch(PDO::FETCH_ASSOC);
if (isset($_SESSION['IDZAKAZA'])) {
  $elementId = $_SESSION['IDZAKAZA'];
} else {
  $elementId = 'NaN';
}

echo "<script>var elementId = '" . ($result['MAX(id_order)'] + 1) . "';</script>";
?>
<script>
function swallsweet() {
  Swal.fire({
    icon: 'success',
    title: 'Успешно',
    html: `<p>Ваш заказ №${elementId}</p>`,
    confirmButtonText: 'ОК',
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.clear();
      location.reload();
    }
  });
}

function swallsweet1() {
  Swal.fire({
    icon: 'error',
    title: 'Упс...',
    text: 'Чтобы сделать заказ вам нужно войти в аккаунт!',
    footer: '<a href="register.php">Зарегистрироваться</a>'
  });
}
</script>



  <style>
    .shopping_busket {
      width: 100vw;
      display: flex;
      justify-content: right;
      margin-left: auto;
      position: fixed;

    }

    .shopping_busket_back {
      transition: all 0.2s;
      box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.274);
      width: max-content;
      background-color: rgb(255, 255, 255);
      display: flex;
      flex-direction: row;
      margin-right: 30px;
      margin-top: 3px;
      padding: 3px;
      border-radius: 7px;
    }

    .shopping_busket_back:hover {
      transition: all 0.2s;
      box-shadow: 5px 5px 10px 1px rgba(0, 0, 0, 0.274);
      width: max-content;

      display: flex;
      flex-direction: row;
      margin-right: 30px;
      margin-top: 3px;
      padding: 3px;
      border-radius: 7px;
    }

    .shopping_busket img {
      width: 50px;
    }

    .allsum1 {
      height: 300px;
      display: table-cell;
      vertical-align: middle;
    }

    .modal {
      height: 100vh;
      position: fixed;
      text-align: center;

    }

    .modal-content h2 {
      color: #e68137;
      font-weight: 700;

    }

    .modal-content table {
      width: 100%;
      margin: 3vh auto;
      font-size: 20px;
    }

    .modal-content th {
      text-align: center;
      padding: 3vh;
    }

    #delBuscket button,
    .checkout_button {
      padding: 1.2vh 1.5vw;
      font-size: 16px;
      font-weight: 700;
      border: 1px solid #e68137;
      background-color: white;
      border-radius: 30px;
      margin: 2vh auto;
    }

    #modal_content_table tr:nth-child(odd) {
      background-color: #ffa666;
    }

    @media (max-width: 800px) {
      .shopping_busket_back {
        margin-top: 60px;
      }

      .shopping_busket_back:hover {
        margin-top: 60px;
      }
    }
  </style>

  <div>

    <div id="modal" class="modal">
      <form action="" method="post">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Корзина</h2>
          <form action="" method="post">
            <table id="cart-table">
              <thead>
                <tr>
                  <th>Название блюда</th>
                  <th>Цена</th>
                  <th>Количество</th>
                  <th>Действия</th>
                </tr>
              </thead>
              <tbody id="modal_content_table">
              </tbody>
            </table>
            <div class="foot_modal">
              <div id="delBuscket" style=""></div>
              <div class="foot_modal_form">
                <p>Итоговая сумма заказа: <input type="text" readonly="readonly" id="total-price" name="total_price" value="" /> ₽</p>
                <?php
                if (isset($_SESSION['user_id'])) echo '<button id="checkout_button" class="checkout_button" type="submit" name="checkout_button">Оформить заказ</button>';
                else echo '<button id="checkout_button" onclick="swallsweet1();" class="checkout_button" name="checkout_button" type="button">Оформить заказ</button>';
                ?>
              </div>
            </div>
          </form>
        </div>
        <p id="cart-info"></p>
    </div>
    

    <div class='shopping_busket'>
      <div id="openModalBtn" onclick="OpenModalBtn('openModalBtn')" class='shopping_busket_back'>
        <div id="allsum1"></div>

        <img src="hostcmsfiles/sopdu/images/shopping-basket.svg" alt="">
      </div>

    </div>

    <?php include "header.php";
    if (isset($_POST['checkout_button'])) {
      $_SESSION['orders']['LastOrder']['total_price'] = $_POST['total_price'];
      echo '<script>addDB();swallsweet()</script>';
    }
    ?>



    <div class="container-fluid head-bg text-center">
      <div class="logo three">
        <a href="index.php">
          <div class="h1">Веселый<span>пекарь</span></div>
        </a>
      </div>
    </div>
    <div class="container contact-section">
      <h1 class="page-title">Продукция</h1>


      <div class="portfolio-bottom prodfoto">
        <div class="gallery-one two">
          <div class="col-sm-6 col-md-3 gallery-left two">
            <a href="upload/foto/information_system_28/5/5/7/item_557/small_item_557.jpg" class="mask b-link-stripe b-animate-go swipebox" title="Осетинский пирог с мясом">
              <img src="upload/foto/information_system_28/5/5/7/item_557/small_item_557.jpg" alt="Осетинский пирог с мясом" class="img-responsive zoom-img">
            </a>
          </div>
          <div class="col-sm-6 col-md-3 gallery-left two">
            <a href="upload/foto/information_system_28/5/5/6/item_556/small_item_556.jpg" class="mask b-link-stripe b-animate-go swipebox" title="Осетинский пирог с сыром">
              <img src="upload/foto/information_system_28/5/5/6/item_556/small_item_556.jpg" alt="Осетинский пирог с сыром" class="img-responsive zoom-img">
            </a>
          </div>
          <div class="col-sm-6 col-md-3 gallery-left two">
            <a href="upload/foto/information_system_28/5/5/5/item_555/small_item_555.jpg" class="mask b-link-stripe b-animate-go swipebox" title="Кутабы">
              <img src="upload/foto/information_system_28/5/5/5/item_555/small_item_555.jpg" alt="Кутабы" class="img-responsive zoom-img">
            </a>
          </div>
          <div class="col-sm-6 col-md-3 gallery-left two">
            <a href="upload/foto/information_system_28/5/5/4/item_554/small_item_554.jpg" class="mask b-link-stripe b-animate-go swipebox" title="Кутабы">
              <img src="upload/foto/information_system_28/5/5/4/item_554/small_item_554.jpg" alt="Кутабы" class="img-responsive zoom-img">
            </a>
          </div>
        </div>
        <div class="text-center">
          <a href="gallery.php">Перейти в фотогалерею</a>
        </div>
      </div>
      <div class="clearfix"></div>
      <section class="products_composition">
        <h2 class="page-title">
          <strong>Состав продуктов</strong>и энергетическая ценность
        </h2>






































        <script src="hostcmsfiles/js/main.js"></script>



























        <div class="panel-group" id="products" role="tablist">
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group10">Хлеб</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group10">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="1" onclick="addProduct(0)" class="bucket_button">+</button><a href="#product199" data-toggle="modal">Батон</a>
                    </li>
                    <li>
                      <button value="2" onclick="addProduct(1)" class="bucket_button">+</button><a href="#product200" data-toggle="modal">Багет французский</a>
                    </li>
                    <li>
                      <button value="3" onclick="addProduct(2)" class="bucket_button">+</button><a href="#product201" data-toggle="modal">Ржаной круглый</a>
                    </li>
                    <li>
                      <button value="4" onclick="addProduct(3)" class="bucket_button">+</button><a href="#product203" data-toggle="modal">Бородинский</a>
                    </li>
                    <li>
                      <button value="5" onclick="addProduct(4)" class="bucket_button">+</button><a href="#product208" data-toggle="modal">Злаковый</a>
                    </li>
                    <li>
                      <button value="6" onclick="addProduct(5)" class="bucket_button">+</button><a href="#product209" data-toggle="modal">Кукурузный</a>
                    </li>
                    <li>
                      <button value="7" onclick="addProduct(6)" class="bucket_button">+</button><a href="#product210" data-toggle="modal">Деревенский</a>
                    </li>
                    <li>
                      <button value="8" onclick="addProduct(7)" class="bucket_button">+</button><a href="#product211" data-toggle="modal">Багет с сыром</a>
                    </li>
                    <li>
                      <button value="9" onclick="addProduct(8)" class="bucket_button">+</button><a href="#product504" data-toggle="modal">Атлетик</a>
                    </li>
                    <li>
                      <button value="10" onclick="addProduct(9)" class="bucket_button">+</button><a href="#product505" data-toggle="modal">Провансаль</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/0/group_10/group_10.jpg" alt="Хлеб" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group11">Пирожки</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group11">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="11" onclick="addProduct(10)" class="bucket_button">+</button><a href="#product204" data-toggle="modal">С мясом (50гр)</a>
                    </li>
                    <li>
                      <button value="12" onclick="addProduct(11)" class="bucket_button">+</button><a href="#product205" data-toggle="modal">С капустой (50гр)</a>
                    </li>
                    <li>
                      <button value="13" onclick="addProduct(12)" class="bucket_button">+</button><a href="#product206" data-toggle="modal">С картофелем (50гр)</a>
                    </li>
                    <li>
                      <button value="14" onclick="addProduct(13)" class="bucket_button">+</button><a href="#product207" data-toggle="modal">С яйцом и зеленью (50гр)</a>
                    </li>
                    <li>
                      <button value="15" onclick="addProduct(14)" class="bucket_button">+</button><a href="#product508" data-toggle="modal">С картофелем и грибами (50гр)</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/1/group_11/group_11.jpg" alt="Пирожки" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group12">Булочки с начинкой</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group12">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="16" onclick="addProduct(15)" class="bucket_button">+</button><a href="#product212" data-toggle="modal">С маком (120гр)</a>
                    </li>
                    <li>
                      <button value="17" onclick="addProduct(16)" class="bucket_button">+</button><a href="#product213" data-toggle="modal">С корицей (120гр)</a>
                    </li>
                    <li>
                      <button value="18" onclick="addProduct(17)" class="bucket_button">+</button><a href="#product214" data-toggle="modal">С яблоком (120гр)</a>
                    </li>
                    <li>
                      <button value="19" onclick="addProduct(18)" class="bucket_button">+</button><a href="#product215" data-toggle="modal">С вишней (120гр)</a>
                    </li>
                    <li>
                      <button value="20" onclick="addProduct(19)" class="bucket_button">+</button><a href="#product216" data-toggle="modal">С абрикосом (120гр)</a>
                    </li>
                    <li>
                      <button value="21" onclick="addProduct(20)" class="bucket_button">+</button><a href="#product217" data-toggle="modal">С клубникой (120гр)</a>
                    </li>
                    <li>
                      <button value="22" onclick="addProduct(21)" class="bucket_button">+</button><a href="#product218" data-toggle="modal">Со смородиной (120гр)</a>
                    </li>
                    <li>
                      <button value="23" onclick="addProduct(22)" class="bucket_button">+</button><a href="#product219" data-toggle="modal">С ежевикой (120гр)</a>
                    </li>
                    <li>
                      <button value="24" onclick="addProduct(23)" class="bucket_button">+</button><a href="#product220" data-toggle="modal">Чайная булочка с творогом (160гр)</a>
                    </li>
                    <li>
                      <button value="25" onclick="addProduct(24)" class="bucket_button">+</button><a href="#product509" data-toggle="modal">С ветчиной и сыром (120гр)</a>
                    </li>
                    <li>
                      <button value="26" onclick="addProduct(25)" class="bucket_button">+</button><a href="#product510" data-toggle="modal">С банановым кремом (150гр)</a>
                    </li>
                    <li>
                      <button value="27" onclick="addProduct(26)" class="bucket_button">+</button><a href="#product511" data-toggle="modal">С шоколадным кремом (150гр)</a>
                    </li>
                    <li>
                      <button value="28" onclick="addProduct(27)" class="bucket_button">+</button><a href="#product512" data-toggle="modal">Со сливочно-ванильным кремом (150гр)</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/2/group_12/group_12.jpg" alt="Булочки с начинкой" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group14">Кутабы</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group14">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="29" onclick="addProduct(28)" class="bucket_button">+</button> <a href="#product224" data-toggle="modal">С зеленью и сыром (120гр)</a>
                    </li>
                    <li>
                      <button value="30" onclick="addProduct(29)" class="bucket_button">+</button><a href="#product225" data-toggle="modal">С зеленью (120гр)</a>
                    </li>
                    <li>
                      <button value="31" onclick="addProduct(30)" class="bucket_button">+</button> <a href="#product226" data-toggle="modal">С мясом (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(31)" class="bucket_button">+</button><a href="#product513" data-toggle="modal">С сыром (120гр)</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/4/group_14/group_14.jpg" alt="Кутабы" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group15">Выпечка</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group15">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(32)" class="bucket_button">+</button><a href="#product227" data-toggle="modal">Ватрушка (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(33)" class="bucket_button">+</button><a href="#product228" data-toggle="modal">Венгерка (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(34)" class="bucket_button">+</button><a href="#product229" data-toggle="modal">Плюшка (100гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(35)" class="bucket_button">+</button><a href="#product230" data-toggle="modal">Сочник (150гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(36)" class="bucket_button">+</button><a href="#product231" data-toggle="modal">Курник (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(37)" class="bucket_button">+</button><a href="#product232" data-toggle="modal">Рыбник (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(38)" class="bucket_button">+</button><a href="#product233" data-toggle="modal">Сосиска в тесте (110гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(39)" class="bucket_button">+</button><a href="#product234" data-toggle="modal">Хачапури слоёное (85гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(40)" class="bucket_button">+</button><a href="#product235" data-toggle="modal">Хачапури с копченым сыром (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(41)" class="bucket_button">+</button><a href="#product236" data-toggle="modal">Хачапури по-мегрельски (250гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(42)" class="bucket_button">+</button><a href="#product237" data-toggle="modal">Беляш (180гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(43)" class="bucket_button">+</button><a href="#product238" data-toggle="modal">Кулебяка (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(44)" class="bucket_button">+</button><a href="#product239" data-toggle="modal">Рогалик с сыром (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(45)" class="bucket_button">+</button><a href="#product240" data-toggle="modal">Самса с говядиной (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(46)" class="bucket_button">+</button><a href="#product514" data-toggle="modal">Самса с курицей (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(47)" class="bucket_button">+</button><a href="#product242" data-toggle="modal">Косичка с творогом и изюмом (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(48)" class="bucket_button">+</button><a href="#product243" data-toggle="modal">Косичка с маком (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(49)" class="bucket_button">+</button><a href="#product244" data-toggle="modal">Гнездышко с жульеном (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(50)" class="bucket_button">+</button><a href="#product245" data-toggle="modal">Гнездышко с ветчиной, сыром и ананасом (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(51)" class="bucket_button">+</button><a href="#product246" data-toggle="modal">Гнездышко со шпинатом и яйцом (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(52)" class="bucket_button">+</button><a href="#product241" data-toggle="modal">Кесадилья (230гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(53)" class="bucket_button">+</button><a href="#product515" data-toggle="modal">Чебурек с сыром (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(54)" class="bucket_button">+</button><a href="#product516" data-toggle="modal">Чебурек с мясом (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(55)" class="bucket_button">+</button><a href="#product517" data-toggle="modal">Расстегай (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(56)" class="bucket_button">+</button><a href="#product518" data-toggle="modal">Шаурма (250гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(57)" class="bucket_button">+</button><a href="#product519" data-toggle="modal">Пицца мини (250гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(58)" class="bucket_button">+</button><a href="#product520" data-toggle="modal">Лепешка с сыром и чесноком (100гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(59)" class="bucket_button">+</button><a href="#product521" data-toggle="modal">Косичка с курагой и орехом (250гр)</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/5/group_15/group_15.jpg" alt="Выпечка" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group16">Слоеные изделия (плацинды)</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group16">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(60)" class="bucket_button">+</button><a href="#product259" data-toggle="modal">Слойка (плацинда) с творогом и зеленью (130гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(61)" class="bucket_button">+</button> <a href="#product258" data-toggle="modal">Слойка (плацинда) с капустой (130гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(62)" class="bucket_button">+</button> <a href="#product260" data-toggle="modal">Слойка (плацинда) с яблоком (130гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(63)" class="bucket_button">+</button> <a href="#product261" data-toggle="modal">Слойка (плацинда) с картофелем (130гр)</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6"></div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group25">Слоеные изделия</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group25">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(64)" class="bucket_button">+</button><a href="#product538" data-toggle="modal">Берлинское (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(65)" class="bucket_button">+</button><a href="#product534" data-toggle="modal">Бриошь с грецким орехом (140гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(66)" class="bucket_button">+</button><a href="#product533" data-toggle="modal">Бриошь с клубникой (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(67)" class="bucket_button">+</button><a href="#product536" data-toggle="modal">Кольцо с корицей (125гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(68)" class="bucket_button">+</button><a href="#product540" data-toggle="modal">Кольцо слоеное с творогом (130гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(69)" class="bucket_button">+</button><a href="#product526" data-toggle="modal">Круассан классический (75гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(70)" class="bucket_button">+</button><a href="#product530" data-toggle="modal">Круассан с абрикосом (140гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(71)" class="bucket_button">+</button> <a href="#product529" data-toggle="modal">Круассан с ветчиной и сыром (130гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(72)" class="bucket_button">+</button> <a href="#product531" data-toggle="modal">Круассан с вишней (140гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(73)" class="bucket_button">+</button><a href="#product527" data-toggle="modal">Круассан с миндалем (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(74)" class="bucket_button">+</button> <a href="#product528" data-toggle="modal">Круассан с шоколадом (120гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(75)" class="bucket_button">+</button><a href="#product539" data-toggle="modal">Слойка с грушей (140гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(76)" class="bucket_button">+</button> <a href="#product532" data-toggle="modal">Слойка с яблоком (140гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(77)" class="bucket_button">+</button> <a href="#product537" data-toggle="modal">Улитка с изюмом (160гр)</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(78)" class="bucket_button">+</button><a href="#product535" data-toggle="modal">Французский язык (150гр)</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/2/5/group_25/group_25.jpg" alt="Слоеные изделия" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group17">Осетинские пироги</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group17">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(79)" class="bucket_button">+</button><a href="#product262" data-toggle="modal">С сыром</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(80)" class="bucket_button">+</button><a href="#product263" data-toggle="modal">С картошкой и сыром</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(81)" class="bucket_button">+</button><a href="#product264" data-toggle="modal">С зеленью и сыром</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(82)" class="bucket_button">+</button><a href="#product265" data-toggle="modal">С капустой</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(83)" class="bucket_button">+</button><a href="#product266" data-toggle="modal">С мясом</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/7/group_17/group_17.jpg" alt="Осетинские пироги" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group18">Сдобные и слоеные пироги</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group18">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(84)" class="bucket_button">+</button><a href="#product267" data-toggle="modal">С ягодами сдобный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(85)" class="bucket_button">+</button><a href="#product269" data-toggle="modal">С мясом сдобный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(86)" class="bucket_button">+</button><a href="#product270" data-toggle="modal">С капустой сдобный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(87)" class="bucket_button">+</button><a href="#product272" data-toggle="modal">С картофелем и грибами сдобный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(88)" class="bucket_button">+</button><a href="#product273" data-toggle="modal">Творожно-ягодный сдобный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(89)" class="bucket_button">+</button><a href="#product274" data-toggle="modal">С жульеном слоеный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(90)" class="bucket_button">+</button><a href="#product559" data-toggle="modal">С мясом слоеный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(91)" class="bucket_button">+</button><a href="#product560" data-toggle="modal">С рыбой слоеный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(92)" class="bucket_button">+</button><a href="#product561" data-toggle="modal">Творожно-ягодный песочный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(93)" class="bucket_button">+</button><a href="#product562" data-toggle="modal">Лимонник песочный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(94)" class="bucket_button">+</button><a href="#product563" data-toggle="modal">Штрудель с вишней слоеный</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(95)" class="bucket_button">+</button><a href="#product564" data-toggle="modal">Штрудель с яблоком слоеный</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/8/group_18/group_18.jpg" alt="Сдобные и слоеные пироги" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group19">Пицца</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group19">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(96)" class="bucket_button">+</button><a href="#product275" data-toggle="modal">классическая</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(97)" class="bucket_button">+</button><a href="#product276" data-toggle="modal">Пепперони</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(98)" class="bucket_button">+</button><a href="#product277" data-toggle="modal">Цезарь</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(99)" class="bucket_button">+</button><a href="#product278" data-toggle="modal">Делюкс</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(100)" class="bucket_button">+</button><a href="#product279" data-toggle="modal">Густосо</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(101)" class="bucket_button">+</button><a href="#product280" data-toggle="modal">Маргарита</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(102)" class="bucket_button">+</button><a href="#product281" data-toggle="modal">Сицилия</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(103)" class="bucket_button">+</button><a href="#product282" data-toggle="modal">Четыре сыра</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(104)" class="bucket_button">+</button><a href="#product283" data-toggle="modal">Средиземноморье</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(105)" class="bucket_button">+</button><a href="#product284" data-toggle="modal">Кольцоне закрытая</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(106)" class="bucket_button">+</button><a href="#product285" data-toggle="modal">Вердура овощная</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(107)" class="bucket_button">+</button><a href="#product506" data-toggle="modal">Перфетто</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(108)" class="bucket_button">+</button><a href="#product507" data-toggle="modal">Перченто</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/1/9/group_19/group_19.jpg" alt="Пицца" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
          <div class="panel">
            <div class="panel-heading" role="tab">
              <h3 class="panel-title" data-toggle="collapse" data-parent="#products" data-target="#group24">Кулинария</h3>
            </div>
            <div class="panel-collapse collapse" role="tabpanel" id="group24">
              <div class="row">
                <div class="col-xs-12 col-lg-6">
                  <ul class="products_list list-unstyled">
                    <li>
                      <button value="32" onclick="addProduct(109)" class="bucket_button">+</button><a href="#product522" data-toggle="modal">Сырники</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(110)" class="bucket_button">+</button><a href="#product523" data-toggle="modal">Лазанья овощная</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(111)" class="bucket_button">+</button><a href="#product524" data-toggle="modal">Лазанья мясная</a>
                    </li>
                    <li>
                      <button value="32" onclick="addProduct(112)" class="bucket_button">+</button><a href="#product525" data-toggle="modal">Ачма</a>
                    </li>
                  </ul>
                </div>
                <div class="visible-lg col-lg-6">
                  <img src="upload/foto/information_system_25/0/2/4/group_24/group_24.jpg" alt="Кулинария" class="img-responsive center-block">
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product199">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Батон</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, маргарин молочный 82%, сахар, соль, дрожжи сухие, мажимикс</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 241 ккал/1010 кДж</li>
                    <li>белки - 6,8 гр</li>
                    <li>жиры - 2,6 гр</li>
                    <li>углеводы - 46,6 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/1/9/9/item_199/item_199.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product200">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Багет французский</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, закваска сухая O-tentik, соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 214 ккал/895 кДж</li>
                    <li>белки - 6,6 гр</li>
                    <li>жиры - 0,7 гр</li>
                    <li>углеводы - 44,1 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/0/item_200/item_200.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product201">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Ржаной круглый</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, мука ржаная обдирная, сахар, масло растительное, солод красный, глофа экстракт солода, соль, дрожжи сухие, мажимикс серый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 236 ккал/990 кДж</li>
                    <li>белки - 6,2 гр</li>
                    <li>жиры - 3,7 гр</li>
                    <li>углеводы - 43,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/1/item_201/item_201.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product203">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Бородинский</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, солод красный, мука ржаная обдирная, сахар, масло растительное, соль, кориандр, мёд, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 298 ккал/1246 кДж</li>
                    <li>белки - 6,3 гр</li>
                    <li>жиры - 8,1 гр</li>
                    <li>углеводы - 49,2 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/3/item_203/information_items_203.png)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product208">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Злаковый</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, смесь сухая Мультизлаковая, маргарин молочный 82%, сахар, соль, дрожжи сухие, мажимикс серый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 245 ккал/1025 кДж</li>
                    <li>белки - 7,1 гр</li>
                    <li>жиры - 3,9 гр</li>
                    <li>углеводы - 45,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product209">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Кукурузный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, смесь сухая кукурузная "Супер", сахар, маргарин молочный 82%, соль, дрожжи сухие, мажимикс серый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 245 ккал/1010 кДж</li>
                    <li>белки - 6,9 гр</li>
                    <li>жиры - 3,4 гр</li>
                    <li>углеводы - 45,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product210">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Деревенский</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, закваска сухая "O-tentik", соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 214 ккал/895 кДж</li>
                    <li>белки - 6,6 гр</li>
                    <li>жиры - 0,7 гр</li>
                    <li>углеводы - 44,1 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/1/0/item_210/item_210.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product211">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Багет с сыром</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, сыр пармезан, закваска сухая "O-tentik", соль, маргарин молочный 82% для смазки</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 223 ккал/932 кДж</li>
                    <li>белки - 7,5 гр</li>
                    <li>жиры - 2,0 гр</li>
                    <li>углеводы - 42,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product504">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Атлетик</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, паско Атлетик, вода, дрожжи сухие, посыпка зерновая, соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 288 ккал/1204 кДж</li>
                    <li>белки - 12,2 гр</li>
                    <li>жиры - 8,9 гр</li>
                    <li>углеводы - 37,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product505">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Провансаль</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, мука ржаная, вода, дрожжи сухие, семена подсолнечника, соль, солод, экстракт глофа, маргарин молочный 82%, сахар</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 246 ккал/1029 кДж</li>
                    <li>белки - 7,0 гр</li>
                    <li>жиры - 7,6 гр</li>
                    <li>углеводы - 36,3 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product204">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С мясом (50гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мясо(говядина), мука в/с, лук репчатый, молоко 3,2%, масло растительное, яйцо, сахар, сливки, соль, дрожжи сухие, масло сливочное, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 241 ккал/1010 кДж</li>
                    <li>белки - 6,8 гр</li>
                    <li>жиры - 2,6 гр</li>
                    <li>углеводы - 46,6 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/4/item_204/item_204.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product205">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С капустой (50гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> капуста, мука в/с, лук репчатый, молоко 3,2%, масло растительное, яйцо, соль, дрожжи сухие, масло сливочное, майонез, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 211 ккал/884 кДж</li>
                    <li>белки - 4,7 гр</li>
                    <li>жиры - 11,1 гр</li>
                    <li>углеводы - 22,8 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/5/item_205/item_205.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product206">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С картофелем (50гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> картофель отварной, мука в/с, лук репчатый, молоко 3,2%, масло растительное, яйцо, сахар, соль, дрожжи сухие, масло сливочное, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 230 ккал/963 кДж</li>
                    <li>белки - 4,6 гр</li>
                    <li>жиры - 11,6 гр</li>
                    <li>углеводы - 26,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/6/item_206/item_206.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product207">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С яйцом и зеленью (50гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> лук зеленый, яйцо вареное, мука в/с, лук репчатый, молоко 3,2%, масло растительное, яйцо, сахар,&nbsp; соль, дрожжи сухие, масло сливочное, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 259 ккал/1086 кДж</li>
                    <li>белки - 14,1 гр</li>
                    <li>жиры - 13,1 гр</li>
                    <li>углеводы - 21,0 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/0/7/item_207/item_207.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product508">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С картофелем и грибами (50гр)</h4>
                <div class="product-text">
                  <p><em>Состав: </em>картофель, лук репчатый, масло раст.для обжарки, шампиньоны, мука в/с, молоко 3,2%, масло растительное, яйцо, сахар, сливки, соль, дрожжи сухие, масло сливочное, перец черный молотый, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 237 ккал/992 кДж</li>
                    <li>белки - 5,2 гр</li>
                    <li>жиры - 11,4 гр</li>
                    <li>углеводы - 27,9 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/0/8/item_508/item_508.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product212">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С маком (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> маковая начинка, мука в/с, молоко 3,2%, яйцо, масло растительное, сахар, сахарная пудра нетающая,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 298 ккал/1247 кДж</li>
                    <li>белки - 5,3 гр</li>
                    <li>жиры - 11,2 гр</li>
                    <li>углеводы - 45,1 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/1/2/item_212/item_212.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product213">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С корицей (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: </em>сахар песок, мука в/с, молоко 3,2%, масло растительное, яйцо, масло сливочное, корица, сахарная пудра нетающая,&nbsp; дрожжи сухие, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 357 ккал/1495 кДж</li>
                    <li>белки - 4,1 гр</li>
                    <li>жиры - 10,8 гр</li>
                    <li>углеводы - 62,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product214">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С яблоком (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> яблоко, мука в/с, сахар, молоко 3,2%, яйцо, лимон (сок), масло растительное, загуститель Софтбиндер,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 196 ккал/821 кДж</li>
                    <li>белки - 3,4 гр</li>
                    <li>жиры - 6,0 гр</li>
                    <li>углеводы - 31,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product215">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С вишней (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> вишня вс/м, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, сахарная пудра нетающая, загуститель Каби, дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 244 ккал/1021 кДж</li>
                    <li>белки - 4,0 гр</li>
                    <li>жиры - 7,1 гр</li>
                    <li>углеводы - 41,3 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/1/5/item_215/item_215.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product216">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С абрикосом (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> абрикос св/м, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, сахарная пудра нетающая, загуститель Каби,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 242 ккал/1013 кДж</li>
                    <li>белки - 4,1 гр</li>
                    <li>жиры - 7,1 гр</li>
                    <li>углеводы - 40,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product217">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С клубникой (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> клубника св/м, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, сахарная пудра нетающая, загуститель Каби,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 239 ккал/999 кДж</li>
                    <li>белки - 3,9 гр</li>
                    <li>жиры - 7,1 гр</li>
                    <li>углеводы - 40,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product218">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Со смородиной (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:смородина черная св/м, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, сахарная пудра нетающая, загуститель Каби, дрожжи сухие, масло сливочное, соль, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 242 ккал/1011 кДж</li>
                    <li>белки - 4,1 гр</li>
                    <li>жиры - 7,2 гр</li>
                    <li>углеводы - 40,2 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product219">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С ежевикой (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> ежевика св/м, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, сахарная пудра нетающая, загуститель Каби, дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 238 ккал/997 кДж</li>
                    <li>белки - 4,3 гр</li>
                    <li>жиры - 7,2 гр</li>
                    <li>углеводы - 39,3 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product220">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Чайная булочка с творогом (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> творог 9%, мука в/с, сахар, молоко 3,2%, яйцо, изюм, масло растительное, сахарная пудра нетающая, дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 269 ккал/1128 кДж</li>
                    <li>белки - 9,5 гр</li>
                    <li>жиры - 10,2 гр</li>
                    <li>углеводы - 34,9 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/2/0/item_220/item_220.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product509">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С ветчиной и сыром (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, сыр Гауда, ветчина, молоко 3,2%, яйцо, масло растительное, сахар, дрожжи сухие, масло сливочное, соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 322 ккал/1347 кДж</li>
                    <li>белки - 15,3 гр</li>
                    <li>жиры - 18,8 гр</li>
                    <li>углеводы - 22,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product510">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С банановым кремом (150гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> начинка "Банан", мука в/с, молоко 3,2%, яйцо, масло растительное, крошка, сахар, сахарная пудра нетающая,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 294 ккал/1233 кДж</li>
                    <li>белки - 4,9 гр</li>
                    <li>жиры - 9,3 гр</li>
                    <li>углеводы - 48,1 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product511">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С шоколадным кремом (150гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> начинка "Какао", мука в/с, молоко 3,2%, яйцо, масло растительное, крошка, сахар, сахарная пудра нетающая,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 298 ккал/1246 кДж</li>
                    <li>белки - 4,9 гр</li>
                    <li>жиры - 11,0 гр</li>
                    <li>углеводы - 47,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product512">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Со сливочно-ванильным кремом (150гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> начинка "Сливочно-ванильная", мука в/с, молоко 3,2%, яйцо, масло растительное, крошка, сахар, сахарная пудра нетающая,&nbsp; дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 348 ккал/1459 кДж</li>
                    <li>белки - 5,3 гр</li>
                    <li>жиры - 10,4 гр</li>
                    <li>углеводы - 55,0 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product224">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С зеленью и сыром (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, сыр сулугуни, шпинат, кинза, укроп, лук зеленый, масло растительное, соль, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 214 ккал/896 кДж</li>
                    <li>белки - 8,5 гр</li>
                    <li>жиры - 7,9 гр</li>
                    <li>углеводы - 26,5 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/2/4/item_224/item_224.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product225">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С зеленью (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, вода, шпинат, кинза, укроп, лук зеленый, масло растительное, соль, черный перец молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 159 ккал/666 кДж</li>
                    <li>белки - 4,6 гр</li>
                    <li>жиры - 3,6 гр</li>
                    <li>углеводы - 26,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/2/5/item_225/item_225.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product226">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С мясом (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, мясо (говядина/свинина), вода, лук репчатый, масло растительное, соль, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 221 ккал/925 кДж</li>
                    <li>белки - 11,0 гр</li>
                    <li>жиры - 8,0 гр</li>
                    <li>углеводы - 25,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/2/6/item_226/item_226.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product513">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С сыром (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, сыр Сулугуни, вода, соль, масло растительное</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 299 ккал/1251 кДж</li>
                    <li>белки - 14,0 гр</li>
                    <li>жиры - 13,6 гр</li>
                    <li>углеводы - 28,3 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/1/3/item_513/item_513.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product227">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Ватрушка (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: творог 9%, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, дрожжи сухие, масло сливочное, соль, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 264 ккал/1105 кДж</li>
                    <li>белки - 10,3 гр</li>
                    <li>жиры - 10,6 гр</li>
                    <li>углеводы - 31,1 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/2/7/item_227/item_227.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product228">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Венгерка (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: тесто слоеное дрожжевое, творог 9%, цедра лимона, сахар, яйцо, сахарная пудра нетающая, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 259 ккал/1084 кДж</li>
                    <li>белки - 8,5 гр</li>
                    <li>жиры - 13,0 гр</li>
                    <li>углеводы - 26,4 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product229">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Плюшка (100гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, молоко 3,2%,&nbsp;</em><em>масло растительное, </em><em>яйцо, сахарная пудра нетающая, дрожжи сухие, масло сливочное, соль, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 340 ккал/1423 кДж</li>
                    <li>белки - 6,1 гр</li>
                    <li>жиры - 12,2 гр</li>
                    <li>углеводы - 52,0 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product230">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Сочник (150гр)</h4>
                <div class="product-text">
                  <p><em>Состав: творог 9%, мука в/с, сахар, маргарин песочный,&nbsp; яйцо, сахарная пудра нетающая, соль, сода, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 328 ккал/1371 кДж</li>
                    <li>белки - 9,1 гр</li>
                    <li>жиры - 15,3 гр</li>
                    <li>углеводы - 38,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/3/0/item_230/item_230.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product231">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Курник (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: курица отварная, мука в/с, молоко 3,2%, масло растительное, лук репчатый, рис, яйцо, сахар, майонез,дрожжи сухие, масло сливочное, соль, ванилин, перец черный молотый</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 286 ккал/1196 кДж</li>
                    <li>белки - 11,9 гр</li>
                    <li>жиры - 15,7 гр</li>
                    <li>углеводы - 24,0 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product232">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Рыбник (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: филе хека св/м, мука в/с, молоко 3,2%, масло растительное, яйца, сахар, лук зеленый, укроп, отжимки лимона, рис, майонез, дрожжи сухие, масло сливочное, соль, оливки отделка, перец черный молотый</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 211 ккал/883 кДж</li>
                    <li>белки - 10,4 гр</li>
                    <li>жиры - 8,7 гр</li>
                    <li>углеводы -22,5&nbsp;гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product233">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Сосиска в тесте (110гр)</h4>
                <div class="product-text">
                  <p><em>Состав: сосиска, мука в/с, молоко 3,2%, яйцо, масло растительное, сахар, дрожжи сухие, масло сливочное, соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 285 ккал/1195 кДж</li>
                    <li>белки - 9,6 гр</li>
                    <li>жиры - 20,0 гр</li>
                    <li>углеводы - 16,5 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/3/3/item_233/item_233.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product234">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Хачапури слоёное (85гр)</h4>
                <div class="product-text">
                  <p><em>Состав: тесто слоеное бездрожжевое, сыр сулугуни, сыр гауда, яйцо на смазку</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 325 ккал/1359 кДж</li>
                    <li>белки - 9,4 гр</li>
                    <li>жиры - 20,7 гр</li>
                    <li>углеводы - 24,1 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product235">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Хачапури с копченым сыром (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: сыр колбасный копченый, мука в/с, молко 3,2%, масло растительное, яйцо, сахар, дрожжи сухие, масло сливочное, соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 303 ккал/1269 кДж</li>
                    <li>белки - 14,2 гр</li>
                    <li>жиры - 16,4 гр</li>
                    <li>углеводы - 24,3 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product236">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Хачапури по-мегрельски (250гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сыр сулугуни, сыр осетинский, молоко 3,2%, масло растительное, яйцо, сахар, дрожжи сухие, масло сливочное, соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 320 ккал/1341 кДж</li>
                    <li>белки - 13,2 гр</li>
                    <li>жиры - 17,8 гр</li>
                    <li>углеводы - 26,2 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product237">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Беляш (180гр)</h4>
                <div class="product-text">
                  <p><em>Состав: фарш (говядина), мука в/с, молоко 3,2%, яйцо, масло растительное, лук репчатый, сахар, дрожжи сухие, масло сливочное, соль, перец черный молотый</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 294 ккал/1230 кДж</li>
                    <li>белки - 9,9 гр</li>
                    <li>жиры - 16,6 гр</li>
                    <li>углеводы - 25,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product238">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Кулебяка (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: капуста, мука в/с, молоко 3,2%, морковь, масло растительное, яйцо, сахар, лук репчатый, яйцо вареное, дрожжи сухие, масло сливочное, соль, перец черный молотый&nbsp;</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 208 ккал/870 кДж</li>
                    <li>белки - 5,2 гр</li>
                    <li>жиры - 10,1 гр</li>
                    <li>углеводы - 23,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product239">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Рогалик с сыром (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: сыр сулугуни, сыр осетинский, мука в/с, молоко 3,2%, масло растительное, яйцо, сахар, дрожжи сухие, масло сливочное, соль, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 295 ккал/1237 кДж</li>
                    <li>белки - 12,6 гр</li>
                    <li>жиры - 16,6 гр</li>
                    <li>углеводы - 22,7 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product240">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Самса с говядиной (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, мясо (говядина), лук репчатый, вода, маргарин для слоения, яйцо, соль, кунжут, зира</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 196 ккал/819 кДж</li>
                    <li>белки - 9,0 гр</li>
                    <li>жиры - 7,8 гр</li>
                    <li>углеводы - 21,7 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product514">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Самса с курицей (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, филе курицы, картофель, лук репчатый, вода, маргарин для слойки, яйцо, соль, кунжут, перец черный молотый, зира</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 193 ккал/806 кДж</li>
                    <li>белки - 9,6 гр</li>
                    <li>жиры - 7,3 гр</li>
                    <li>углеводы - 21,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product242">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Косичка с творогом и изюмом (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: творог 9%, мука в/с, сахар, молоко 3,2%, яйцо, масло растительное, изюм, сахарная пудра нетающая, дрожжи сухие, масло сливочное, соль, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 271 ккал/1134 кДж</li>
                    <li>белки - 9,6 гр</li>
                    <li>жиры - 10,5 гр</li>
                    <li>углеводы - 34,3 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/4/2/item_242/item_242.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product243">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Косичка с маком (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: маковая начинка, мука в/с, молоко 3,2%, масло растительное, изюм, яйцо, сахар, сахарная пудра нетающая, дрожжи сухие, масло сливочное, соль, ванилин</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 299 ккал/1253 кДж</li>
                    <li>белки - 5,1 гр</li>
                    <li>жиры - 11,0 гр</li>
                    <li>углеводы - 46,2 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/4/3/item_243/item_243.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product244">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Гнездышко с жульеном (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, шампиньоны, курица обжаренная, сыр гауда, молоко 3,2%, масло растительное, майонез,яйцо, сахар, дрожжи сухие, масло сливочное, соль, кунжут, перец черный молотый</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 276 ккал/1157 кДж</li>
                    <li>белки - 10,7 гр</li>
                    <li>жиры - 17,2 гр</li>
                    <li>углеводы - 21,6 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/4/4/item_244/item_244.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product245">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Гнездышко с ветчиной, сыром и ананасом (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, ветчина, сыр гауда, молоко 3,2%, ананас, майонез, масло растительное, яйцо, сахар, дрожжи сухие, масло сливочное, соль, кунжут</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 305 ккал/1278 кДж</li>
                    <li>белки - 12,4 гр</li>
                    <li>жиры - 20,1 гр</li>
                    <li>углеводы - 22,5 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/4/5/item_245/item_245.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product246">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Гнездышко со шпинатом и яйцом (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: сыр гауда, мука в/с, шпинат, молоко 3,2%, майонез, масло растительное, яйцо, яйцо вареное, сахар, дрожжи сухие, масло сливочное, соль, кунжут</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 299 ккал/1254 кДж</li>
                    <li>белки - 10,5 гр</li>
                    <li>жиры - 21,3 гр</li>
                    <li>углеводы - 21,5 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/4/6/item_246/item_246.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product241">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Кесадилья (230гр)</h4>
                <div class="product-text">
                  <p><em>Состав: лепешка тортилья, шампиньоны, курица обжаренная, сыр моцарелла, майонез, помидоры, перец сладкий, сойс красный кимчи, кукуруза, вода, масло растительное для обжарки, чеснок,перец черный молотый, соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 163 ккал/683 кДж</li>
                    <li>белки - 6,7 гр</li>
                    <li>жиры - 9,0 гр</li>
                    <li>углеводы - 13,1 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product515">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Чебурек с сыром (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, вода, яйцо, маргарин для слойки, сыр гауда, сыр сулугуни, яйцо на смазку</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 154 ккал/644 кДж</li>
                    <li>белки - 3,2 гр</li>
                    <li>жиры - 5,9 гр</li>
                    <li>углеводы - 21,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product516">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Чебурек с мясом (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: фарш (говядина), мука в/с, вода, лук репчатый, маргарин для слойки, яйцо, соль, перец черный молотый</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 267 ккал/1118 кДж</li>
                    <li>белки - 9,7 гр</li>
                    <li>жиры - 15,8 гр</li>
                    <li>углеводы - 20,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product517">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Расстегай (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: филе горбуши св/м, мука в/с, филе морского языка св/м, молоко 3,2%, масло растительное, яйцо, сахар, лук зеленый, укроп, соевый соус киккоман, дрожжи сухие, масло сливочное, соль, паприка</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 223 ккал/934 кДж</li>
                    <li>белки - 12,3 гр</li>
                    <li>жиры - 9,3 гр</li>
                    <li>углеводы - 22,2 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product518">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Шаурма (250гр)</h4>
                <div class="product-text">
                  <p><em>Состав: курица обжаренная, лаваш армянский, капуста свежая, помидоры, соус белый, соус красный, огурцы</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 190 ккал/797 кДж</li>
                    <li>белки - 10,1 гр</li>
                    <li>жиры - 10,4 гр</li>
                    <li>углеводы - 12,7 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product519">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Пицца мини (250гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, вода, масло подсолнечное, помидор, перец болгарский, сыр моцарелла, пепперони, </em><em>сахар, дрожжи сухие, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 221 ккал/927 кДж</li>
                    <li>белки - 8,3 гр</li>
                    <li>жиры - 11,4 гр</li>
                    <li>углеводы - 21,4 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product520">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Лепешка с сыром и чесноком (100гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, яйцо, вода, соус чесночный, майонез, сыр, чеснок, сахар, дрожжи сухие, масло подсолнечное, соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 583 ккал/1948 кДж</li>
                    <li>белки - 8,3 гр</li>
                    <li>жиры - 44,9 гр</li>
                    <li>углеводы - 8,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product521">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Косичка с курагой и орехом (250гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, курага, орех грецкий, яйцо, сахар, вода, масло подсолнечное, дрожжи сухие, соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 313 ккал/1319 кДж</li>
                    <li>белки - 6,5 гр</li>
                    <li>жиры - 11,5 гр</li>
                    <li>углеводы - 46,1 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product259">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Слойка (плацинда) с творогом и зеленью (130гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> творог 9%, мука в/с, масло подсолнечное, вода, яйцо, укроп, соль, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 266 ккал/1115 кДж</li>
                    <li>белки - 10,7 гр</li>
                    <li>жиры - 18,6 гр</li>
                    <li>углеводы - 12,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product258">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Слойка (плацинда) с капустой (130гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> капуста, лук репчатый, мука в/с, масло подсолнечное, вода, соль, перец черный молотый, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 255 ккал/1066 кДж</li>
                    <li>белки - 3,0 гр</li>
                    <li>жиры - 18,1 гр</li>
                    <li>углеводы - 19,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product260">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Слойка (плацинда) с яблоком (130гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> яблоко, мука в/с, сахар, масло подсолнечное, вода, соль, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 286 ккал/1196 кДж</li>
                    <li>белки - 6,1 гр</li>
                    <li>жиры - 12,2 гр</li>
                    <li>углеводы - 38,4 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product261">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Слойка (плацинда) с картофелем (130гр)</h4>
                <div class="product-text">
                  <p><em>Состав:</em> картофель, лук репчатый, мука в/с, масло подсолнечное, вода, соль, перец черный молотый, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 258 ккал/1082 кДж</li>
                    <li>белки - 3,0 гр</li>
                    <li>жиры - 13,5 гр</li>
                    <li>углеводы - 19,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product538">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Берлинское (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, соль, сахар, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, джем лимон, фондант&nbsp;</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 338 ккал/1416 кДж</li>
                    <li>белки - 4,8 гр</li>
                    <li>жиры - 14,1 гр</li>
                    <li>углеводы - 45,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product534">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Бриошь с грецким орехом (140гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, яйцо, молоко 3,2%, масло сливочное, дрожжи сухие, мажимикс голубой, соль, сухая смесь кремико, вода, крем слив-ванильный, грецкий орех, глазурь для желирования</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 325 ккал/1361 кДж</li>
                    <li>белки - 7,7 гр</li>
                    <li>жиры - 13,8 гр</li>
                    <li>углеводы - 42,4 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product533">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Бриошь с клубникой (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, яйцо, молоко 3,2%, масло сливочное, дрожжи сухие, мажимикс голубой, соль, сухая смесь кремико, вода, крем слив-ванильный, клубника св/м, загуститель каби, маргарин, глазурь для желирования</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 303 ккал/1269 кДж</li>
                    <li>белки - 6,2 гр</li>
                    <li>жиры - 9,6 гр</li>
                    <li>углеводы - 47,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product536">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Кольцо с корицей (125гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, соль, сахар, дрожжи саф-инстант, яйцо, маргарин для слойки, вода, мажимикс голубой, корица, глазурь для желирования</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 321 ккал/1345 кДж</li>
                    <li>белки - 5,0 гр</li>
                    <li>жиры - 15,5 гр</li>
                    <li>углеводы - 40,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product540">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Кольцо слоеное с творогом (130гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, соль, сахар, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, творог 9%, загуститель каби, миндальные лепестки</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 309 ккал/1295 кДж</li>
                    <li>белки - 10,5 гр</li>
                    <li>жиры - 15,6 гр</li>
                    <li>углеводы - 31,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product526">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Круассан классический (75гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 327 ккал/1371 кДж</li>
                    <li>белки - 5,6 гр</li>
                    <li>жиры - 16,5 гр</li>
                    <li>углеводы - 39,3 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/2/6/item_526/item_526.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product530">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Круассан с абрикосом (140гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, абрикос консервированный, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 292 ккал/1223 кДж</li>
                    <li>белки - 4,3 гр</li>
                    <li>жиры - 12,1 гр</li>
                    <li>углеводы - 41,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product529">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Круассан с ветчиной и сыром (130гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, творожный сыр креметте, сыр гауда, ветчина, сыр моцарелла, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 320 ккал/1342 кДж</li>
                    <li>белки - 11,1 гр</li>
                    <li>жиры - 19,9 гр</li>
                    <li>углеводы - 26,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product531">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Круассан с вишней (140гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, дрожжи саф-инстант, вишня св/м, загуститель каби, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 298 ккал/1249 кДж</li>
                    <li>белки - 4,1 гр</li>
                    <li>жиры - 11,4 гр</li>
                    <li>углеводы - 45,1 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product527">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Круассан с миндалем (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, дрожжи саф-инстант, яйцо, вода, сухая смесь кремико, молоко 3,2%, крем ванильно-сливочный, миндальные лепестки, сахарная пудра нетающая, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 297 ккал/1245 кДж</li>
                    <li>белки - 4,7 гр</li>
                    <li>жиры - 12,5 гр</li>
                    <li>углеводы - 42,0 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/2/7/item_527/item_527.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product528">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Круассан с шоколадом (120гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, дрожжи саф-инстант, ганаш шоколадный, посыпка шоколадная, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 351 ккал/1472 кДж</li>
                    <li>белки - 5,2 гр</li>
                    <li>жиры - 20,1 гр</li>
                    <li>углеводы - 36,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product539">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Слойка с грушей (140гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, груша консервированная, гель миррор карамель, гель горячего приготовления, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 281 ккал/1176 кДж</li>
                    <li>белки - 4,2 гр</li>
                    <li>жиры - 15,8 гр</li>
                    <li>углеводы - 38,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product532">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Слойка с яблоком (140гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, яблоко свежее, гель миррор карамель, корица, гель горячего приготовления, миндальные лепестки, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, </em><em>соль</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 281 ккал/1176 кДж</li>
                    <li>белки - 4,4 гр</li>
                    <li>жиры - 12,6 гр</li>
                    <li>углеводы - 37,4 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product537">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Улитка с изюмом (160гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, соль, сахар, дрожжи саф-инстант, яйцо, вода, мажимикс голубой, маргарин для слойки, сухая смесь кремико, молоко 3,2%, крем слив-ванильный, изюм, глазурь для желирования</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 321 ккал/1344 кДж</li>
                    <li>белки - 5,2 гр</li>
                    <li>жиры - 15,0 гр</li>
                    <li>углеводы - 41,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product535">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Французский язык (150гр)</h4>
                <div class="product-text">
                  <p><em>Состав: мука в/с, сахар, яйцо, молоко 3,2%, масло сливочное, дрожжи сухие, мажимикс голубой, соль, сухая смесь кремико, вода, крем слив-ванильный, шоколадные капли, глазурь для желирования</em></p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 318 ккал/1333 кДж</li>
                    <li>белки - 7,8 гр</li>
                    <li>жиры - 12,9 гр</li>
                    <li>углеводы - 41,5 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/3/5/item_535/item_535.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product262">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С сыром</h4>
                <div class="product-text">
                  <p><em>Состав: </em>сыр осетинский, мука в/с, молоко 3,2%, вода, масло сливочное, соль, сахар, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 278 ккал/1165 кДж</li>
                    <li>белки - 15,5 гр</li>
                    <li>жиры - 15,3 гр</li>
                    <li>углеводы - 19,3 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/6/2/item_262/item_262.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product263">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С картошкой и сыром</h4>
                <div class="product-text">
                  <p><em>Состав:</em> сыр осетинский, картофель отварной, мука в/с, молоко 3,2%, вода, масло сливочное, соль, сахар, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 213 ккал/892 кДж</li>
                    <li>белки - 10,3 гр</li>
                    <li>жиры - 9,8 гр</li>
                    <li>углеводы - 20,7 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/6/3/item_263/item_263.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product264">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С зеленью и сыром</h4>
                <div class="product-text">
                  <p><em>Состав:</em> сыр осетинский, мука в/с, молоко 3,2%, вода, шпинат, укроп, кинза, лук зеленый, масло сливочное, соль, сахар, перец черный молотый, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 197 ккал/825 кДж</li>
                    <li>белки - 9,6 гр</li>
                    <li>жиры - 8,8 гр</li>
                    <li>углеводы - 19,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/6/4/item_264/item_264.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product265">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С капустой</h4>
                <div class="product-text">
                  <p><em>Состав:</em> капуста обжаренная, мука в/с, молоко 3,2%, вода, масло сливочное, масло растительное, соль, сахар, дрожжи сухие</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 146 ккал/611 кДж</li>
                    <li>белки - 4,2 гр</li>
                    <li>жиры - 5,3 гр</li>
                    <li>углеводы - 20,1 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/6/5/item_265/item_265.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product266">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С мясом</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мясо (говядина), мука в/с, лук репчатый, молоко 3,2%, вода, масло сливочное, масло растительное, сливки растительные, соль, сахар, дрожжи сухие, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 197 ккал/826 кДж</li>
                    <li>белки - 7,4 гр</li>
                    <li>жиры - 9,3 гр</li>
                    <li>углеводы - 20,1 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/6/6/item_266/item_266.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product267">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С ягодами сдобный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> ягоды св/м, мука в/с, сахар песок, молоко 3,2%, масло растительное, яйцо, гель нейтральный палетта, загуститель каби, дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 222 ккал/930 кДж</li>
                    <li>белки - 4,2 гр</li>
                    <li>жиры - 6,0 гр</li>
                    <li>углеводы - 38,0 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/6/7/item_267/item_267.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product269">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С мясом сдобный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мясо (говядина, свинина, курица), мука в/с, лук репчатый, молоко 3,2%, масло растительное, яйцо, сливки, дрожжи сухие, масло сливочное, соль, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 286 ккал/1199 кДж</li>
                    <li>белки - 9,7 гр</li>
                    <li>жиры - 16,3 гр</li>
                    <li>углеводы - 26,3 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product270">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С капустой сдобный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> капуста обжаренная, мука в/с, лук репчатый, молоко 3,2%, масло растительное, сахар, яйцо, майонез, дрожжи сухие, масло сливочное, соль, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 263 ккал/1102 кДж</li>
                    <li>белки - 4,7 гр</li>
                    <li>жиры - 15,1 гр</li>
                    <li>углеводы - 27,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product272">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С картофелем и грибами сдобный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> картофель отварной, мука в/с, лук репчатый, шампиньоны, молоко 3,2%, масло растительное, сахар, яйцо, майонез, дрожжи сухие, масло сливочное, соль, перец черный молотый</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 249 ккал/1043 кДж</li>
                    <li>белки - 4,9 гр</li>
                    <li>жиры - 13,1 гр</li>
                    <li>углеводы - 28,2 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product273">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Творожно-ягодный сдобный</h4>
                <div class="product-text">
                  <p><em>Состав:</em>&nbsp; мука в/с, ягоды св/м в ассортименте, творог 9%, ,сахар песок, молоко 3,2%, масло растительное, яйцо, гель нейтральный палетта, дрожжи сухие, масло сливочное, соль, ванилин</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 227 ккал/952 кДж</li>
                    <li>белки - 6,7 гр</li>
                    <li>жиры - 7,4 гр</li>
                    <li>углеводы - 33,3 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product274">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С жульеном слоеный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто слоеное (мука, соль, сахар, дрожжи саф-инстант, яйцо, маргарин, вода, мажимикс голубой, маргарин для слоения), шампиньоны, курица обжаренная, сыр моцарелла, майонез, яйцо, соль, перец черный молотый, масло растительное</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 287 ккал/1200 кДж</li>
                    <li>белки - 10,1 гр</li>
                    <li>жиры - 20,5 гр</li>
                    <li>углеводы - 17,3 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product559">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С мясом слоеный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто слоеное (мука, соль, сахар, дрожжи саф-инстант, яйцо, маргарин, вода, мажимикс голубой, маргарин для слоения), говядина, сыр Гауда, лук пассерованный, соль, перец черный молотый, масло растительное</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 281 ккал/1177 кДж</li>
                    <li>белки - 8,2 гр</li>
                    <li>жиры - 17,9 гр</li>
                    <li>углеводы - 21,0 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product560">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">С рыбой слоеный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто слоеное (мука, соль, сахар, дрожжи саф-инстант, яйцо, маргарин, вода, мажимикс голубой, маргарин для слоения), горбуша, морской язык, рис, лук зеленый, укроп, соль, перец черный молотый, соевый соус, масло растительное</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 270 ккал/1133 кДж</li>
                    <li>белки - 9,8 гр</li>
                    <li>жиры - 15,7 гр</li>
                    <li>углеводы - 21,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product561">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Творожно-ягодный песочный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> песочное тесто (мука в/с, сахар, маргарин, вода, дрожжи саф-инстант), творог 9%, сахар,&nbsp; вишня вяленая, яйцо, загуститель каби, сахарная пудра нетающая</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 359 ккал/1504 кДж</li>
                    <li>белки - 9,5 гр</li>
                    <li>жиры - 16,8 гр</li>
                    <li>углеводы - 42,2 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product562">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Лимонник песочный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> песочное тесто (мука в/с, сахар, маргарин, вода, дрожжи саф-инстант), лимон, апельсин, сахар, загуститель каби, сахарная пудра нетающая, мука, масло сливочное</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 413 ккал/1730 кДж</li>
                    <li>белки - 4,8 гр</li>
                    <li>жиры - 15,2 гр</li>
                    <li>углеводы - 67,1 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product563">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Штрудель с вишней слоеный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто слоеное (мука, соль, сахар, дрожжи саф-инстант, яйцо, маргарин, вода, мажимикс голубой, маргарин для слоения), вишня св/м, сахар, грецкий орех, загуститель каби</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 262 ккал/1101 кДж</li>
                    <li>белки - 3,9 гр</li>
                    <li>жиры - 10,1 гр</li>
                    <li>углеводы - 38,9 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product564">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Штрудель с яблоком слоеный</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто слоеное (мука, соль, сахар, дрожжи саф-инстант, яйцо, маргарин, вода, мажимикс голубой, маргарин для слоения), яблоко печеное, сахар, корица, изюм</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 240 ккал/1009 кДж</li>
                    <li>белки - 2,8 гр</li>
                    <li>жиры - 8,8 гр</li>
                    <li>углеводы - 37,4 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product275">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Веселый пекарь</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, бекон в/к, помидоры, шампиньоны</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 233,9 ккал/980,2 кДж</li>
                    <li>белки - 10,8 гр</li>
                    <li>жиры - 11,1 гр</li>
                    <li>углеводы - 22,7 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/7/5/item_275/item_275.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product276">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Пепперони</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, пепперони</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 278,2 ккал/1164,6 кДж</li>
                    <li>белки - 12,8 гр</li>
                    <li>жиры - 14,2 гр</li>
                    <li>углеводы - 24,8 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/7/6/item_276/item_276.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product277">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Цезарь</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус цезарь, сыр моцарелла, куриная грудка, помидоры черри, сыр пармезан, салат айсберг</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 236,3 ккал/989,4 кДж</li>
                    <li>белки - 12,6 гр</li>
                    <li>жиры - 11,9 гр</li>
                    <li>углеводы - 19,7 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/7/7/item_277/item_277.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product278">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Делюкс</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, креветки тигровые, помидоры, оливки</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 217,3 ккал/912,4 кДж</li>
                    <li>белки - 11,6 гр</li>
                    <li>жиры - 8,9 гр</li>
                    <li>углеводы - 22,7 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/7/8/item_278/item_278.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product279">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Густосо</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, куриная грудка, помидоры, шампиньоны</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 215,2 ккал/904,1 кДж</li>
                    <li>белки - 12,7 гр</li>
                    <li>жиры - 8,4 гр</li>
                    <li>углеводы - 22,2 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/7/9/item_279/item_279.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product280">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Маргарита</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, помидоры</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 233,9 ккал/982,2 кДж</li>
                    <li>белки - 11,2 гр</li>
                    <li>жиры - 9,5 гр</li>
                    <li>углеводы - 25,9 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/8/0/item_280/item_280.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product281">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Сицилия</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, фарш говяжий</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 254,4 ккал/1066,7 кДж</li>
                    <li>белки - 14,5 гр</li>
                    <li>жиры - 11,6 гр</li>
                    <li>углеводы - 23,0 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/8/1/item_281/item_281.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product282">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Четыре сыра</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, сыр чедер, сыр пармезан, сыр дор-блю</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 269,1 ккал/1127,3 кДж</li>
                    <li>белки - 14,3 гр</li>
                    <li>жиры - 13,1 гр</li>
                    <li>углеводы - 23,5 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/8/2/item_282/item_282.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product283">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Средиземноморье</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, морской коктейль, сыр дор-блю</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 236,7 ккал/993,1 кДж</li>
                    <li>белки - 13,0 гр</li>
                    <li>жиры - 10,3 гр</li>
                    <li>углеводы - 23,0 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/8/3/item_283/item_283.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product284">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Кольцоне закрытая</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, помидоры, салями, шампиньоны</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 267,5 ккал/1118,5 кДж</li>
                    <li>белки - 12,2 гр</li>
                    <li>жиры - 14,7 гр</li>
                    <li>углеводы - 21,6 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/8/4/item_284/item_284.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product285">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Вердура овощная</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, перец болгарский, помидоры, шампиньоны</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 213,0 ккал/894,5 кДж</li>
                    <li>белки - 10,3 гр</li>
                    <li>жиры - 8,6 гр</li>
                    <li>углеводы - 23,6 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/2/8/5/item_285/item_285.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product506">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Перфетто</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, салями, ветчина, шампиньоны</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 252,4 ккал/1049,9 кДж</li>
                    <li>белки - 12,4 гр</li>
                    <li>жиры - 12,8 гр</li>
                    <li>углеводы - 21,9 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/0/6/item_506/item_506.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product507">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Перченто</h4>
                <div class="product-text">
                  <p><em>Состав:</em> тесто (мука, вода, масло оливковое, соль, сахар, дрожжи), соус томатный, сыр моцарелла, бекон в/к, помидоры, салями, оливки</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 259,8 ккал/1086,9 кДж</li>
                    <li>белки - 11,5 гр</li>
                    <li>жиры - 13,8 гр</li>
                    <li>углеводы - 22,4 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/0/7/item_507/item_507.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product522">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Сырники</h4>
                <div class="product-text">
                  <p><em>Состав:</em> творог 9%, яйцо, сахар, мука в/с, сахарная пудра, загуститель каби</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 189 ккал/790 кДж</li>
                    <li>белки - 14,4 гр</li>
                    <li>жиры - 7,9 гр</li>
                    <li>углеводы - 13,7 гр</li>
                  </ul>
                </div>
              </div>
              <div class="product-image" style="background-image: url(upload/foto/information_system_25/5/2/2/item_522/item_522.jpg)"></div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product523">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Лазанья овощная</h4>
                <div class="product-text">
                  <p><em>Состав:</em> сыр гауда, кабачки, шампиньоны, перец сладкий красный, мука в/с, помидоры, лук репчатый, соус бешамель, яйцо, вода, масло растительное, соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 67 ккал/280 кДж</li>
                    <li>белки - 2,0 гр</li>
                    <li>жиры - 2,2 гр</li>
                    <li>углеводы - 9,6 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product524">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Лазанья мясная</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мясо (говядина), мука в/с, сыр гауда, сыр моцарелла, лук репчатый, морковь, помито, яйцо, вода, масло растительное, соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 190 ккал/798 кДж</li>
                    <li>белки - 22,3 гр</li>
                    <li>жиры - 8,1 гр</li>
                    <li>углеводы - 5,5 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal fade" id="product525">
          <div class="modal-dialog product_desc">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
              <div class="modal-body">
                <h4 class="modal-title">Ачма</h4>
                <div class="product-text">
                  <p><em>Состав:</em> мука в/с, сметана, сыр моцарелла, сыр осетинский, сыр гауда, яйцо, вода, масло сливочное, соль</p>
                  <p><em>На 100 гр:</em></p>
                  <ul>
                    <li>энергетическая ценность - 240 ккал/1007 кДж</li>
                    <li>белки - 10,1 гр</li>
                    <li>жиры - 15,2 гр</li>
                    <li>углеводы - 17,8 гр</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include 'footer.php'; ?>

</body>