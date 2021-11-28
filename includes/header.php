 <header>
   <div class="default-header">
     <div class="container">
       <div class="row">
         <div class="col-sm-3 col-md-2">
           <div class="logo">
             <a href="index.php">
               <img src="assets/images/favicon-icon/logo.svg" alt="image" />
             </a>
           </div>
         </div>
         <div class="col-sm-9 col-md-10">
           <div class="header_info">
             <?php
              $sql = "SELECT EmailId,ContactNo from tblcontactusinfo";

              $query = $dbh->prepare($sql);
              $query->bindParam(':vhid', $vhid, PDO::PARAM_STR);
              $query->execute();
              $results = $query->fetchAll(PDO::FETCH_OBJ);

              foreach ($results as $result) {
                $fullname = $result->FullName;
                $email = $result->EmailId;
                $contactno = $result->ContactNo;
              }
              ?>

             <div class="header_widgets">
               <div class="circle_icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
               <p class="uppercase_text">Написати нам на почту: </p>
               <a href="mailto:<?php echo htmlentities($email); ?>"><?php echo htmlentities($email); ?></a>
             </div>
             <div class="header_widgets">
               <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
               <p class="uppercase_text">Гаряча лінія: </p>
               <a href="tel:<?php echo htmlentities($contactno); ?>"><?php echo htmlentities($contactno); ?></a>
             </div>
             <div class="social-follow">

             </div>
             <?php if (strlen($_SESSION['login']) == 0) {
              ?>
               <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Авторизуватись</a> </div>
             <?php } else { ?>
               <span>Вітаємо в <span style="color: #ed145b;">RentLviv</span>!</span>
             <?php } ?>
           </div>
         </div>
       </div>
     </div>
   </div>

   <!-- Navigation -->
   <nav id="navigation_bar" class="navbar navbar-default">
     <div class="container">
       <div class="navbar-header">
         <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
       </div>
       <div class="header_wrap">
         <div class="user_login">
           <ul>
             <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i>
                 <?php
                  $email = $_SESSION['login'];
                  $sql = "SELECT FullName FROM tblusers WHERE EmailId=:email ";
                  $query = $dbh->prepare($sql);
                  $query->bindParam(':email', $email, PDO::PARAM_STR);
                  $query->execute();
                  $results = $query->fetchAll(PDO::FETCH_OBJ);
                  if ($query->rowCount() > 0) {
                    foreach ($results as $result) {

                      echo htmlentities($result->FullName);
                    }
                  } ?>
                 <i class="fa fa-angle-down" aria-hidden="true"></i></a>
               <ul class="dropdown-menu">
                 <?php if ($_SESSION['login']) { ?>
                   <li><a href="profile.php">Налаштування</a></li>
                   <li><a href="update-password.php">Змінити пароль</a></li>
                   <li><a href="my-booking.php">Мої замовлення</a></li>
                   <li><a href="post-testimonial.php">Залишити відгук</a></li>
                   <li><a href="my-testimonials.php">Мої відгуки</a></li>
                   <li><a href="logout.php">Вийти</a></li>
                 <?php } ?>
               </ul>
             </li>
           </ul>
         </div>
       </div>
       <div class="collapse navbar-collapse" id="navigation">
         <ul class="nav navbar-nav">
           <li><a href="index.php">Головна</a> </li>
           <li><a href="car-listing.php">Каталог Авто</a>
           <li><a href="contact-us.php">Контакти</a></li>
         </ul>
       </div>
     </div>
   </nav>
   <!-- Navigation end -->

 </header>