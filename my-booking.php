<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {
?>
  <!DOCTYPE HTML>
  <html lang="en">

  <head>

    <title>Car Rental Portal - My Booking</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!--slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!--bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!--FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- SWITCHER -->
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/favicon.svg">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/favicon.svg">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/favicon.svg">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/favicon.svg">
    <link rel="shortcut icon" href="assets/images/favicon-icon/favicon.svg">
    <!-- Google-Font-->
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <script src="assets/js/jquery.min.js"></script>
  </head>

  <body>

    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!--Page Header-->
    <!-- /Header -->

    <!--Page Header-->
    <section class="page-header profile_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>Мої Замовлення</h1>
          </div>
          <ul class="coustom-breadcrumb">
            <li><a href="#">Головна</a></li>
            <li>Мої Замовлення</li>
          </ul>
        </div>
      </div>
      <!-- Dark Overlay-->
      <div class="dark-overlay"></div>
    </section>
    <!-- /Page Header-->

    <?php
    $useremail = $_SESSION['login'];
    $sql = "SELECT * from tblusers where EmailId=:useremail ";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
      foreach ($results as $result) { ?>
        <section class="user_profile inner_pages">
          <div class="container">
            <div class="user_profile_info gray-bg padding_4x4_40">
              <div class="upload_user_logo"> <img src="assets/images/dealer-logo.jpg" alt="image">
              </div>

              <div class="dealer_info">
                <h5><?php echo htmlentities($result->FullName); ?></h5>
                <p><?php echo htmlentities($result->Address); ?><br>
                  <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country);
                                                                }
                                                              } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>

                <div class="col-md-8 col-sm-8">
                  <div class="profile_wrap">
                    <h5 class="uppercase underline">Мої Замовлення</h5>
                    <div class="my_vehicles_list">
                      <ul class="vehicle_listing">
                        <?php
                        $useremail = $_SESSION['login'];
                        $sql = "SELECT tblvehicles.Vimage1 as Vimage1,tblvehicles.VehiclesTitle,tblvehicles.id as vid,tblbrands.BrandName,tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.Status,tblvehicles.PricePerDay,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays,tblbooking.BookingNumber  from tblbooking join tblvehicles on tblbooking.VehicleId=tblvehicles.id join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblbooking.userEmail=:useremail order by tblbooking.id desc";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {  ?>

                            <li>
                              <h4 style="color:red">Замовлення №<?php echo htmlentities($result->BookingNumber); ?></h4>
                              <div class="vehicle_img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>"><img src="http://localhost/carrental/admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="image"></a> </div>
                              <div class="vehicle_title">

                                <h6><a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>"> <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></a></h6>
                                <p><b>Від. </b> <?php echo htmlentities($result->FromDate); ?> <b>До. </b> <?php echo htmlentities($result->ToDate); ?></p>
                                <div style="float: left">
                                  <p><b>Особисті вподобання:</b> <?php echo htmlentities($result->message); ?> </p>
                                </div>
                              </div>
                              <?php if ($result->Status == 1) { ?>
                                <div class="vehicle_status"> <a href="#" class="btn outline btn-xs active-btn">Підтверджений</a>
                                  <div class="clearfix"></div>
                                </div>

                              <?php } else if ($result->Status == 2) { ?>
                                <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Відхилений</a>
                                  <div class="clearfix"></div>
                                </div>



                              <?php } else { ?>
                                <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Розглядається</a>
                                  <div class="clearfix"></div>
                                </div>
                              <?php } ?>

                            </li>

                            <div class="table-flex">
                              <h5 style="color:red">Рахунок</h5>
                              <span class="table-download-button">Завантажити</span>
                            </div>
                            <style>
                              .table-flex {
                                display: flex;
                                justify-content: space-between;
                                align-items: center;
                              }

                              .table-flex h5 {
                                margin: 20px 0;
                              }

                              span.table-download-button {
                                padding: 5px 20px;
                                color: #ed145b;
                                border-radius: 0px;
                                cursor: pointer;
                                margin: 20px 0;
                                transition: all 0.3s;
                                -o-transition: all 0.3s;
                                -moz-transition: all 0.3s;
                                -webkit-transition: all 0.3s;
                                -ms-transition: all 0.3s;
                              }

                              span.table-download-button:hover {
                                background: #ed145b;
                                border-radius: 10px;
                                color: #fff;
                              }
                            </style>
                            <div class="table-to-print">
                              <table>
                                <thead>
                                  <tr>
                                    <td>Назва Авто</td>
                                    <td>Від Дати</td>
                                    <td>До Дати</td>
                                    <td>Кількість Днів</td>
                                    <td>Ціна / День</td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><?php echo htmlentities($result->VehiclesTitle); ?>, <?php echo htmlentities($result->BrandName); ?></td>
                                    <td><?php echo htmlentities($result->FromDate); ?></td>
                                    <td> <?php echo htmlentities($result->ToDate); ?></td>
                                    <td><?php echo htmlentities($tds = $result->totaldays); ?></td>
                                    <td> <?php echo htmlentities($ppd = $result->PricePerDay); ?></td>
                                  </tr>
                                  <tr>
                                    <th colspan="4" style="text-align:center;">Сумарно</th>
                                    <th><?php echo htmlentities($tds * $ppd); ?></th>
                                  </tr>
                                </tbody>
                              </table>
                            </div>

                            <hr />
                          <?php }
                        } else { ?>
                          <h5 align="center" style="color:red">Ще не було бронювань</h5>
                        <?php } ?>


                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
        <!-- <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe> -->
        <!--/my-vehicles-->
        <?php include('includes/footer.php'); ?>

        <!-- Scripts -->



        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/interface.js"></script>
        <!--Switcher-->
        <script src="assets/switcher/js/switcher.js"></script>
        <!--bootstrap-slider-JS-->
        <script src="assets/js/bootstrap-slider.min.js"></script>
        <!--Slider-JS-->
        <script src="assets/js/slick.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>

        <script src="assets/js/printThis.js"></script>

        <script>
          $('.table-download-button').click(function() {
            $('.profile_wrap').printThis({
              loadCSS: ["http://localhost/carrental/assets/css/style.css", "http://localhost/carrental/assets/css/print.css"],
            });
          });
        </script>
  </body>

  </html>
<?php } ?>