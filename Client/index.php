<?php
    require("../Database.php");
    session_start();
    ob_start();

    $usertoken = !isset($_SESSION["USERID"]) ?  null : $_SESSION["USERID"];
    $linksref = !isset($_SESSION["USERID"]) ?  "./Registration.php" : "#";

    error_reporting(E_ERROR | E_PARSE);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliJosh Resort & Event</title>

    <link rel="stylesheet" href="./CSS/stylev2v1.css">
    <link href="./CSS/style.scss" rel="stylesheet/scss" type="text/css">
    <link rel="stylesheet" href="./CSS/app.css">
    <link rel="stylesheet" href="./Calendar/app.css">

    <script src="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="../SweetAlert/node_modules/sweetalert2/dist/sweetalert2.min.css">

    <!--Jquery-->
    <script src="../Jquery/node_modules/jquery/dist/jquery.js"></script>
    <script src="../Jquery/node_modules/jquery/dist/jquery.min.js"></script>

    <script src="./JS/designv2.js" defer ></script>
    <script src="./JS/script1.js" defer></script>
    <script src="./Calendar/app23.js" defer></script>

             
</head>
<body>
    <nav class="Mainnavigation">
        <ul class="smoothmenu">
            <li class="creator">
                <a href="#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="#ABOUT" class="textkainit">ABOUT</a>
            </li>
            <li>
                <a href="#TOUR" class="textkainit">TOUR</a>
            </li>
            <li class="HOMETITLELI">
                <a href="#HOME" class="HOMETITLE">EliJosh</a>
            </li>
            <li>
                <a href="#SERVICE" class="textkainit">SERVICES</a>
            </li>
            <li>
                <a href="#CONTACT" class="textkainit">CONTACT</a>
            </li>
            <li class=" dropdown">
                <a href="<?php echo $linksref;?>" class="textkainit">ACCOUNT</a>

                <ul class="dropdown-menu">
                <?php  
                    if($usertoken != null){
                ?>

                    <li><a href="./InsideMain.php">Account Settings</a></li>
                    <?php
                        if($_SESSION["ACCESS"] != "CLIENT"){
                    ?>
                        <li><a href="../Admins/Mainpage.php">Admin</a></li>
                    <?php
                        }
                    ?>
                    <li><a href="./bookinginformations.php">Booking Information</a></li>
                    <li><a href="./logOut.php">Logout</a></li>

                <?php  
                    }else{
                ?>
                    <li><a href="./login.php">Login</a></li>
                    <li><a href="./Registration.php">Register now</a></li>
                <?php  
                    }
                ?>
                </ul>
            </li>
        </ul>
    </nav>

    <form action="" id="BOOKINGSSS">
        <section class="HOMEWHOLE" id="HOME">


            <div class="MiddlePART">
                <p class="textkainit">WELCOME TO</p>
                <h1>
                    <div class="H1p1">
                        EliJosh Resort 
                    </div>
                    <div class="H1p2"> &

                    </div>
                    <div class="H1p3">
                        Event Place
                    </div>
                </h1>
                <p>Where Every Moment Becomes a Memory</p>
            </div>
            <div class="MiddleLOW">
                <div class="formDTL notincluded ">
                    <div class="LABELTARGET">
                        CHECK-IN             
                    </div>
                    <label for="Checkin">
                        <div class="Databelow" id="CHECKINDATEA">
                            <div class="Number">
                                -
                            </div>
                            <div class="smallernumber">
                                / - 

                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm0-352a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                            </div>   

                        </div>
                    </label>
                    <input type="date" name="Checkin" id="Checkin"  style="display: none;">
                </div>
                <div class="formDTL">
                    <div class="LABELTARGET">
                        PACKAGE      
                    </div>
                    <label for="">
                        <select name="" id="packages">
                            <option value="Package1" selected>Swimming Only</option>
                            <option value="Package2">Rooms + Swimming</option>
                            <option value="Package3">Pavilions</option>
                        </select>
                    </label>
                </div>
                <div class="formDTL">
                    <div class="LABELTARGET">
                        TIME RANGE      
                    </div>
                    <label>
                        <select name="" id="tRANGE">
                            <option value="Day" selected>8:00 - 17: 00</option>
                            <option value="Night" >19:00 - 7: 00</option>
                            <option value="22Hrs" >14:00 - 12: 00</option>
                        </select>
                    </label>
                </div>
                <div class="formDTL fDTL2">
                    <div></div>
                    <button type="submit">CHECK AVAILABILITY</button>
                </div>
            </div>

            <div class="bgimages">
                <img src="./Images/c7.jpg" alt="">
            </div>
        
            <div class="magiccalendar">
                <div class="calendar">
                    <div class="calendar-header">
                        <span class="month-picker" id="month-picker">February</span>
                        <div class="year-picker">
                            <span class="year-change" id="prev-year">
                                <pre><</pre>
                            </span>
                            <span id="year">2021</span>
                            <span class="year-change" id="next-year">
                                <pre>></pre>
                            </span>
                        </div>
                    </div>
                    <div class="calendar-body">
                        <div class="calendar-week-day">
                            <div>Sun</div>
                            <div>Mon</div>
                            <div>Tue</div>
                            <div>Wed</div>
                            <div>Thu</div>
                            <div>Fri</div>
                            <div>Sat</div>
                        </div>
                        <div class="calendar-days"></div>
                    </div>
                    
                    <div class="month-list"></div>
                </div>
            
            </div>
        </section>
    </form>

    <section class="CONTAINERSECTIONS about top" id="ABOUT">

        <div class="left">
            <div class="img">
                <img src="./Images/c14.jpg" alt="" class="image1">
                <img src="./Images/c10.jpg" alt="" class="image2">
            </div>
        </div>
          <div class="right">
            <div class="heading">
              <h5>RAISING COMFOMRT TO THE HIGHEST LEVEL</h5>
              <h2>Welcome to Elijosh Resort and Events Place</h2>
              <p>Immerse yourself in the lap of luxury with our well-appointed accommodations, designed for comfort and elegance. Whether you're here for a romantic getaway, a family vacation, or a corporate retreat, Elijosh offers a range of rooms and suites to suit every need.</p>
              <p>Elijosh Resort and Events Place isn't just a retreat; it's a destination where memories are made, and experiences are cherished. Come, indulge in the extraordinary, and let us redefine your concept of leisure and luxury.</p>
            </div>
          </div>
    </section>

    <section class="ABOUT">
        <img src="./Images/c8.jpg" alt="" class="imagebg">
        <div class="wrapper top">
            <div class="container">
              <div class="text">
                <h2>Our Amenities</h2>
                <p>Discover a world of luxury and tranquility at Elijosh Resort and Event Place. Our amenities are designed to provide you with an unforgettable experience. Dive into our crystal-clear pools, surrounded by lush greenery  for the ultimate relaxation. Enjoy exquisite dining at our on-site restaurants.  At Elijosh, we redefine hospitality, ensuring your stay is filled with comfort, elegance, and lasting memories.</p>
        
                <div class="content">
                  <div class="box flex">
                    <i class="fas fa-swimming-pool"></i>
                    <span>Swimming pool</span>
                  </div>
                  <div class="box flex">
                    <i class="fas fa-dumbbell"></i>
                    <span>Karaoke & KTV</span>
                  </div>
                  <div class="box flex">
                    <i class="fas fa-spa"></i>
                    <span>Cottages</span>
                  </div>
                  <div class="box flex">
                    <i class="fas fa-ship"></i>
                    <span>Bar</span>
                  </div>
                  <div class="box flex">
                    <i class="fas fa-swimmer"></i>
                    <span>Gym & yoga</span>
                  </div>
                  <div class="box flex">
                    <i class="fas fa-microphone"></i>
                    <span>Pavilion</span>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </section>
    <section class="CONTAINERSECTIONS2" id="TOUR">
        <div class="box2">
            <div class="heading">
                <h2>Virtual Tour</h2>
            </div>
            <div class="boxbox2">
                <div class="containerVBox">
                    <div class="virtualtourdiv">
                        <?php
                            include_once "./virtualmap/index.html";
                        ?>
                    </div>
                </div>
                <div class="rightcontainert2">
                    <h3>🎮 How to Navigate</h3>
                    <p>
                        Using our virtual tour is a breeze. Simply click, drag, and zoom to explore the resort. Our interactive features allow you to move seamlessly from one area to another.
                        Ready to start your virtual journey at EliJosh Resort and Event Place? Click the "Start Tour" button below to begin your adventure!
                    </p>
                </div>
            </div>
            
        </div>
       
    </section>
    <section class="CONTAINERSECTIONS223 about top" id="SERVICE">
          <div class="right">
            <div class="heading">
                <div class="containehreading">
                    <h2>Our Services</h2>
                    <div class="facilitiesview">
                        <div class="box">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M320 32c0-9.9-4.5-19.2-12.3-25.2S289.8-1.4 280.2 1l-179.9 45C79 51.3 64 70.5 64 92.5V448H32c-17.7 0-32 14.3-32 32s14.3 32 32 32H96 288h32V480 32zM256 256c0 17.7-10.7 32-24 32s-24-14.3-24-32s10.7-32 24-32s24 14.3 24 32zm96-128h96V480c0 17.7 14.3 32 32 32h64c17.7 0 32-14.3 32-32s-14.3-32-32-32H512V128c0-35.3-28.7-64-64-64H352v64z"/></svg>
                            </div>
                            <div>
                                Rooms
                            </div>
                        </div>
                        <div class="box">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M152 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H64C28.7 64 0 92.7 0 128v16 48V448c0 35.3 28.7 64 64 64H384c35.3 0 64-28.7 64-64V192 144 128c0-35.3-28.7-64-64-64H344V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H152V24zM48 192h80v56H48V192zm0 104h80v64H48V296zm128 0h96v64H176V296zm144 0h80v64H320V296zm80-48H320V192h80v56zm0 160v40c0 8.8-7.2 16-16 16H320V408h80zm-128 0v56H176V408h96zm-144 0v56H64c-8.8 0-16-7.2-16-16V408h80zM272 248H176V192h96v56z"/></svg>
                            </div>
                            <div>
                                Events Place
                            </div>
                        </div>
                        <div class="box">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M309.5 178.4L447.9 297.1c-1.6 .9-3.2 2-4.8 3c-18 12.4-40.1 20.3-59.2 20.3c-19.6 0-40.8-7.7-59.2-20.3c-22.1-15.5-51.6-15.5-73.7 0c-17.1 11.8-38 20.3-59.2 20.3c-10.1 0-21.1-2.2-31.9-6.2C163.1 193.2 262.2 96 384 96h64c17.7 0 32 14.3 32 32s-14.3 32-32 32H384c-26.9 0-52.3 6.6-74.5 18.4zM160 160A64 64 0 1 1 32 160a64 64 0 1 1 128 0zM306.5 325.9C329 341.4 356.5 352 384 352c26.9 0 55.4-10.8 77.4-26.1l0 0c11.9-8.5 28.1-7.8 39.2 1.7c14.4 11.9 32.5 21 50.6 25.2c17.2 4 27.9 21.2 23.9 38.4s-21.2 27.9-38.4 23.9c-24.5-5.7-44.9-16.5-58.2-25C449.5 405.7 417 416 384 416c-31.9 0-60.6-9.9-80.4-18.9c-5.8-2.7-11.1-5.3-15.6-7.7c-4.5 2.4-9.7 5.1-15.6 7.7c-19.8 9-48.5 18.9-80.4 18.9c-33 0-65.5-10.3-94.5-25.8c-13.4 8.4-33.7 19.3-58.2 25c-17.2 4-34.4-6.7-38.4-23.9s6.7-34.4 23.9-38.4c18.1-4.2 36.2-13.3 50.6-25.2c11.1-9.4 27.3-10.1 39.2-1.7l0 0C136.7 341.2 165.1 352 192 352c27.5 0 55-10.6 77.5-26.1c11.1-7.9 25.9-7.9 37 0z"/></svg>
                            </div>
                            <div>
                                Pools
                            </div>
                        </div>
                        <div class="box">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M499.1 6.3c8.1 6 12.9 15.6 12.9 25.7v72V368c0 44.2-43 80-96 80s-96-35.8-96-80s43-80 96-80c11.2 0 22 1.6 32 4.6V147L192 223.8V432c0 44.2-43 80-96 80s-96-35.8-96-80s43-80 96-80c11.2 0 22 1.6 32 4.6V200 128c0-14.1 9.3-26.6 22.8-30.7l320-96c9.7-2.9 20.2-1.1 28.3 5z"/></svg>
                            </div>
                            <div>
                                Karaoke
                            </div>
                        </div>
                        <div class="box">
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 640 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M396.6 6.5L235.8 129.1c9.6 1.8 18.9 5.8 27 12l168 128c13.2 10.1 22 24.9 24.5 41.4l6.2 41.5H608c9.3 0 18.2-4.1 24.2-11.1s8.8-16.4 7.4-25.6l-24-160c-1.2-8.2-5.6-15.7-12.3-20.7l-168-128c-11.5-8.7-27.3-8.7-38.8 0zm-153.2 160c-11.5-8.7-27.3-8.7-38.8 0l-168 128c-6.6 5-11 12.5-12.3 20.7l-24 160c-1.4 9.2 1.3 18.6 7.4 25.6S22.7 512 32 512H224V352l96 160h96c9.3 0 18.2-4.1 24.2-11.1s8.8-16.4 7.4-25.6l-24-160c-1.2-8.2-5.6-15.7-12.3-20.7l-168-128z"/></svg>
                            </div>
                            <div>
                                Cottages
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
          </div>
    </section>

    <section class="CONTAINERSECTIONS2" id="CONTACT">
        <div class="box2">
            <div class="heading">
                <h2>Connect with Us</h2>
            </div>
            <div class="boxbox2">
                <div class="containerbb2">
                    <form action="" method="post" id="CONTACTFORM">
                        <?php
                            
                            if(!isset($_SESSION["USERID"])){

                        ?>
                            <div class="formcontainer">
                                <label for="">Name</label>
                                <input type="text" name="nameuser"  id="specialName" required>
                            </div>
                            <div class="formcontainer">
                                <label for="">Email</label>
                                <input type="email" name="Email" id="specialEmail" required>
                            </div>
                        <?php
                            }else{
                                $contactus = "SELECT CONCAT(LastName, ', ', FirstName, ' ', MiddleName) as NAME, Email FROM userscredentials WHERE userID = '".$_SESSION["USERID"]."';";
                                $contactusquery = mysqli_query($conn,$contactus);
                                $_SESSION["BasicContactinfo"] = mysqli_fetch_assoc($contactusquery);
                            }
                        ?>
                        <div class="formcontainer">
                            <label for="">Subject</label>
                            <input type="text" name="subject" id="specialSubject" required>
                        </div>
                        <div class="formcontainer">
                            <label for="">Message</label>
                            <textarea name="" id="specialmessage" cols="30" rows="5" required></textarea>
                        </div>
                        <div class="formcontainer">
                            <button type="submit">Send</button>
                        </div>
                    </form>
                </div>
                <div class="rightcontainerbb2">
                    <div class="infos">
                        <div class="callcontact">
                            <h3>Call Us</h3>
                            <div class="ISCONTAINER">
                                <div class="INSIDEISC">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M164.9 24.6c-7.7-18.6-28-28.5-47.4-23.2l-88 24C12.1 30.2 0 46 0 64C0 311.4 200.6 512 448 512c18 0 33.8-12.1 38.6-29.5l24-88c5.3-19.4-4.6-39.7-23.2-47.4l-96-40c-16.3-6.8-35.2-2.1-46.3 11.6L304.7 368C234.3 334.7 177.3 277.7 144 207.3L193.3 167c13.7-11.2 18.4-30 11.6-46.3l-40-96z"/></svg>
                                    0956 519 8692
                                </div>
                            </div>
                        </div>
                        <div class="linkcontacts">
                            <h3>Follow Us</h3>
                            <div class="ISCONTAINER">
                                <a href="http://" target="_blank" rel="noopener noreferrer"></a>
                                <a target="_blank" rel="noopener noreferrer" href="https://www.facebook.com/ElijoshResortAndEventPlace" class="INSIDEISC"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                                    Facebook</a>
                                <a target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/elijoshresortandeventsplace/?fbclid=IwAR3XRTmegdCv0eyhts_aYDadplgi8xM6BaAJSN7npaDqy56wL0vYpW91FBU" class="INSIDEISC"><svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                                    Instagram</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
       
    </section>
    <section class="CONTAINERSECTIONSMAPS" id="">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15474.631450458095!2d120.9550524!3d14.1562012!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd797878683881%3A0xc72e3698d24cca41!2sEliJosh%20Resort%20%26%20Events%20Place!5e0!3m2!1sen!2sph!4v1697414283430!5m2!1sen!2sph" width="100vw" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>



    <footer>
        <div class="container grid top">
          <div class="box">
            <h3>Payment</h3>
            <p>Accepted payment methods</p>
            <div class="payment grid">
              <img src="https://img.icons8.com/color/48/000000/visa.png" />
              <img src="https://img.icons8.com/color/48/000000/mastercard.png" />
              <img src="https://img.icons8.com/color-glass/48/000000/paypal.png" />
              <img src="https://img.icons8.com/fluency/48/000000/amex.png" />
            </div>
          </div>
    
          <div class="box">
            <h3>Recent News</h3>
    
            <ul>
              <li>Our Secret Island Boat Tour Is Just for You</li>
              <li>Chill and Escape in Our Natural Shelters</li>
              <li>September in Elijosh Resort</li>
              <li>Live Music Concerts at Elijosh</li>
            </ul>
          </div>
    
          <div class="box">
            <h3>For Customers</h3>
            <ul>
              <li>About Elijosh</li>
              <li>Customer Care/Help</li>
              <li>Customer Accounts</li>
              <li>Terms & Conditions</li>
            </ul>
          </div>
    
          <div class="box">
            <h3>Contact Us</h3>
    
            <ul>
              <li><i class="far fa-envelope"></i>elijosh111923@gmail.com</li>
              <li><i class="far fa-phone-alt"></i>0956 519 8692</li>
              <li><i class="far fa-comments"></i>24/ 7 Customer Services </li>
            </ul>
          </div>
        </div>
    </footer>


    
<script>
    const Onrun =async () =>{
        let data = sessionStorage.getItem("MissedBooked")
        if (data !== null){
            await Swal.fire({
                title: "Do you want to continue the booking ?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: `No`
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    sessionStorage.removeItem("MissedBooked");
                    location.href = `./breakdownv2.php?${data}`
                }
            });
        }
    }
    Onrun()


    const BOOKING = document.getElementById("BOOKINGSSS")
    BOOKING.addEventListener('submit',async (e)=>{
        e.preventDefault();

        let Checkin = document.getElementById('Checkin').value
        let Checkout = document.getElementById('packages').value
        let tRANGE = document.getElementById('tRANGE').value

        console.log(Checkin.length)

        if(Checkin.length > 0){
            const options = { timeZone: 'Asia/Tokyo' };
            const currentDate = new Date().toLocaleString('en-US', options);

            // Assuming Checkin is a string representing a date, replace it with your actual variable
            const inputDate = new Date(Checkin);



            let valdata = Math.floor((new Date(currentDate) - inputDate) / (1000 * 60 * 60 * 24))
            console.log(valdata)
            // Compare the input date with the current date
            if (valdata > 0) {
                let message = valdata === 1 ? 'It was yesterday.' : `The date was ${valdata} days ago.`;
                await Swal.fire({
                    text: message,
                    icon: "error"
                });
            }else{
                
                let  senddata = await AjaxSendv3(Checkout,"Availability",`&cin=${Checkin}&tday=${tRANGE}`)  
                if(senddata == "true"){
                    await Swal.fire({
                        text: "There's an available slot",
                        icon: "success"
                    });
                    location.href = `./bookingv2.php?cin=${Checkin}&package=${Checkout}&tRANGE=${tRANGE}`;
                }else{
                    await Swal.fire({
                        text: "The date has been fully booked",
                        icon: "info"
                    });
                }
            }
            
        }else{
            await Swal.fire({
                text: "Enter Checkin Date First",
                icon: "error"
            });
        }

        //location.href = `./bookingv2.php?cin=${Checkin}&package=${Checkout}&tRANGE=${tRANGE}`;
    })

    const CONTACTFORM = document.getElementById('CONTACTFORM')

    CONTACTFORM.addEventListener('submit',async (e)=>{
        e.preventDefault()

        const specialmessage = document.getElementById('specialmessage')
        const specialEmail = document.getElementById('specialEmail')
        const specialName = document.getElementById('specialName')
        const specialSubject = document.getElementById('specialSubject')

        let data1 = ""
        let data2 = ""
        let data3 = ""
        let data4 = ""
        if(specialName && specialEmail){
    
            data1 = specialName.value
            data2 = specialEmail.value
        }

        data3 = specialSubject.value
        data4 = specialmessage.value

        sendinggmailnotif(data3, data4, data1,data2 )
    })

    async function sendinggmailnotif (data1, data2, data3 = "", data4=""){
        $.ajax({    
            type: "post",
            url: "../Contactus.php",             
            data: `data1=${data1}&&data2=${data2}&&data3=${data3}&&data4=${data4}`,    
            beforeSend: async function(){
                await Swal.fire({
                    text: "Send Successfully",
                    icon: "success"
                });
            }, 
            error:function(response){
                // Remove the loading screen
                console.log(response)
            },
            success: async function(response) {
                console.log(response)
                await Swal.fire({
                    text: "Send Successfully",
                    icon: "success"
                });
            }


        });
    }
</script>
</script>
    
</body>
</html>