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
    <link rel="icon" type="image/x-icon" href="./img/title_logo.ico">

    <link rel="stylesheet" href="./css/stylev1.css">
    <link href="./CSS/style.scss" rel="stylesheet/scss" type="text/css">
    <link rel="stylesheet" href="./CSS/app.css">
    <link rel="stylesheet" href="./Calendar/app.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	

    	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/7489440202.js" crossorigin="anonymous"></script>

    <!--Owl-->
    
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous"
  referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />

 <!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pickadate/lib/compressed/themes/classic.css">

<!-- JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/pickadate/lib/compressed/picker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/pickadate/lib/compressed/picker.date.js"></script>

    <script src="./JS/designv2.js" defer ></script>
    <script src="./JS/script1.js" defer></script>
    <script src="./Calendar/app23.js" defer></script>


    <style>
        html, body{
            overflow: auto;
        }
        .CONTAINERSECTIONS{

        }
    </style>
             
</head>
<body>
    <nav class="Mainnavigation">
        <div class="HOMETITLELI2">
            <a href="#HOME" class="HOMETITLE">EliJosh</a>
            <button onclick="shownav()">
                <i class="fa-solid fa-align-justify"></i>
            </button>
        </div>
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
                <a href="#GALLERY" class="textkainit">GALLERY</a>
            </li>
            <li>
                <a href="#CONTACT" class="textkainit">CONTACT</a>
            </li>
            <li class="dropdown">
                <a href="#" class="textkainit">ACCOUNT</a>

                <ul class="dropdown-menu">
                    <?php  
                        if($usertoken != null){
                    ?>
                          <li><i class='bx bxs-cog' ></i><a href="../EliJosh_Special/specialcon.php?nzlz=settings">Account</a></li>
                          <?php
                            if($_SESSION["ACCESS"] != "CLIENT"){
                          ?>
                            <li><i class='bx bxs-dashboard' ></i><a href="../EliJosh_Dashboard/index.php">Dashboard</a></li>
                          <?php
                            }
                          ?>
                          <li><i class='bx bxs-bookmark-alt' ></i><a href="../EliJosh_Special/specialcon.php?nzlz=bookingDetails">Booking Details</a></li>
                          <li><i class='bx bxs-door-open' ></i><a href="./logOut.php">Logout</a></li>

                    <?php
                      }else{
                    ?>
                      <li><i class='bx bxs-user-circle' ></i><a href="../EliJosh_Login/index.php">Login</a></li>
                      <li><i class='bx bxs-user-plus' ></i><a href="../EliJosh_Registration/index.php">Register</a></li>
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
                <div class="formDTL  ">
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
                    <input type="date" name="Checkin" id="Checkin" style="display: none;">
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
                            <option value="Day" selected>8:00 AM - 05: 00 PM</option>
                            <option value="Night" >07:00 PM - 7: 00 AM</option>
                            <option value="22Hrs" >02:00 PM- 12: 00 PM</option>
                        </select>
                    </label>
                </div>
                <div class="formDTL fDTL2 notincluded">
                    <div></div>
                    <button type="submit">CHECK AVAILABILITY</button>
                </div>
            </div>

            <div class="bgimages">
                <img src="./Images/hp1.png" alt="">
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
    <section class="about top" id="ABOUT">

        <div class="left">
            <div class="img">
                <img src="./Images/c14.jpg" alt="" class="image1">
                <img src="./Images/ap2.png" alt="" class="image2">
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
    <section class="CONTAINERSECTIONS" id="TOUR">
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

    <section class="gallary mtop " id="GALLERY">
        <div class="container">
          <div class="heading_top flex1">
            <div class="heading">
              <h5>WELCOME TO OUR PHOTO GALLERY</h5>
              <h2>Satisfied Guests</h2>
            </div>
          </div>
    
          <div class="owl-carousel owl-theme">
            <div class="item">
              <img src="./Images/s1.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s2.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s3.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s4.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s5.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s6.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s7.jpg" alt="">
            </div>
            <div class="item">
              <img src="./Images/s8.jpg" alt="">
            </div>
          </div>
    
        </div>
      </section>
      
    <section class="CONTAINERSECTIONS" id="CONTACT">
        <div class="box2">
            <div class="heading">
                <h2>Connect with Us</h2>
            </div>
            <div class="boxbox23">
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
                <div class="leftcontainerbb2">
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
    
            <ul class="footerul">
              <li ><i class="far fa-envelope"></i>elijosh111923@gmail.com</li>
              <li><i class="far fa-phone-alt"></i>0956 519 8692</li>
              <li><i class="far fa-comments"></i>24/ 7 Customer Services </li>
            </ul>
          </div>
        </div>
    </footer>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js" integrity="sha512-gY25nC63ddE0LcLPhxUJGFxa2GoIyA5FLym4UJqHDEMHjp8RET6Zn/SHo1sltt3WuVtqfyxECP38/daUc/WVEA==" crossorigin="anonymous"
      referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous"
      referrerpolicy="no-referrer"></script>
    <script>
      $('.owl-carousel').owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-chevron-left'></i>", "<i class='fas fa-chevron-right'></i>"],
        responsive: {
          0: {
            items: 1
          },
          768: {
            items: 2
          },
          1000: {
            items: 4
          }
        }
      })
    </script>

    <script>
        function shownav(){
            // Check if myDiv is visible
            if ($(".smoothmenu").is(":visible")) {
                // If it's visible, hide it with slideUp
                $(".smoothmenu").slideUp();
            } else {
                // If it's not visible, show it with slideDown
                $(".smoothmenu").slideDown();
            }
        };
    </script>
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
                    location.href = `../EliJosh_Special/specialcon.php?cin=${Checkin}&package=${Checkout}&tRANGE=${tRANGE}`;
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
</body>
</html>