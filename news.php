<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ru" xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Новости</title>
  <meta name="description" content="Новости сети пекарен 'веселый пекарь'" />
  <meta name="keywords" content="Новости" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="format-detection" content="telephone=no" />
  <link rel="icon" type="image/png" href="hostcmsfiles/sopdu/images/favicon.png" />
  <script src="hostcmsfiles/sopdu/js/jquery-1.12.4.min.js"></script>
  <script src="hostcmsfiles/sopdu/js/jquery.validate.min.js"></script>
  <script src="hostcmsfiles/sopdu/js/jquery.swipebox.min.js"></script>
  <script src="hostcmsfiles/sopdu/js/responsiveslides.min.js"></script>
		<link rel="stylesheet" type="text/css" href="hostcmsfiles/css/style.css">
    <link rel="stylesheet" type="text/css" href="hostcmsfiles/css/21e0deca58dfdeb107ce1a866cb622b0.css?1647963883">
  <script src="hostcmsfiles/js/script1.js"></script>
</head>

<body>

  <?php
  include('config.php');
  include 'header.php';
  ?>


  <div class="container-fluid head-bg text-center">
    <div class="logo three">
      <a href="../index.php">
        <div class="h1">Веселый<span>пекарь</span></div>
      </a>
    </div>
  </div>
  <div class="container contact-section">
    <h1 class="page-title">Новости</h1>
      <div id="page_bookings">
        <div class="container_bookings">
          <?php



          try {


            // SQL-запрос для выборки новостей из базы данных
            $query = "SELECT * FROM news ORDER BY date_new DESC"; // Предполагается, что  есть таблица "news" с колонками "title", "content" и "date"

            // Выполнение SQL-запроса
            $stmt = $connection->query($query);

            // Перебор результатов и вывод новостей
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              $title = $row['url_new'];
              $content = $row['txt_new'];
              $date = $row['date_new'];

              // Вывод новости
              echo '<div class="bookings_block"><div class="menu-grid" style=" background-image: url(' . $title . ');">
                      <div class="price">' . $date . '</div>
                      </div>
                      <div class="bookings_block padding">
                      <details>
                        <summary>Подробнее</summary>
                        <p>'.$content.'</p>
                      </details>
                    </div></div>';
            }
          } catch (PDOException $e) {
            echo "Ошибка: " . $e->getMessage();
          }
          ?>
        </div>
      </div>







    </div>
  </div>
  <?php include 'footer.php'; ?>
            
</body>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  // tracker methods like "setCustomDimension" should be called before "trackPageView"
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(["setCookieDomain", ""]);
  _paq.push(["setDomains", [""]]);
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);
  (function() {
    var u = "//ceo.sopdu.ru/";
    _paq.push(["setTrackerUrl", u + "piwik.php"]);
    _paq.push(["setSiteId", "12"]);
    var d = document,
      g = d.createElement("script"),
      s = d.getElementsByTagName("script")[0];
    g.type = "text/javascript";
    g.async = true;
    g.defer = true;
    g.src = u + "piwik.js";
    s.parentNode.insertBefore(g, s);
  })();
</script>
<!-- End Piwik Code -->

</html>
<!-- HostCMS Benchmark -->
<script>
  window.addEventListener("load", function() {
    var waiting =
      performance.timing.responseStart - performance.timing.requestStart,
      loadPage =
      performance.timing.loadEventStart - performance.timing.requestStart,
      dnsLookup =
      performance.timing.domainLookupEnd -
      performance.timing.domainLookupStart,
      connectServer =
      performance.timing.connectEnd - performance.timing.connectStart;

    xmlhttprequest = new XMLHttpRequest();
    xmlhttprequest.open("POST", "/hostcms-benchmark.php", true);
    xmlhttprequest.setRequestHeader(
      "Content-type",
      "application/x-www-form-urlencoded"
    );
    xmlhttprequest.send(
      "structure_id=139&waiting_time=" +
      waiting +
      "&load_page_time=" +
      loadPage +
      "&dns_lookup=" +
      dnsLookup +
      "&connect_server=" +
      connectServer
    );
  });
</script>