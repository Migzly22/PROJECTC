<?php
    require("../Database.php");
    session_start();
    ob_start();

    $usertoken = !isset($_SESSION["USERID"]) ?  null : $_SESSION["USERID"];
    $linksref = !isset($_SESSION["USERID"]) ?  "./login.php" : "./booking.php";


    if (!isset($_SESSION["USERID"]) || !isset($_SESSION["ACCESS"])){
        header("Location: ./index.php");
        ob_end_flush();
        exit;
    }


    $cin = isset($_GET["cin"]) ? $_GET["cin"] : "" ;
    $cout = isset($_GET["cout"]) ? $_GET["cout"] : "" ;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EliJosh Resort & Event</title>

    <link rel="stylesheet" href="./CSS/style212.css">
    <link href="./CSS/style.scss" rel="stylesheet/scss" type="text/css">
    <link rel="stylesheet" href="./CSS/app.css">
    <link rel="stylesheet" href="./Calendar/app.css">

    <script src="./JS/script.js" defer></script>
    <script src="./Calendar/app.js" defer></script>

             
</head>
<body>
    <nav class="Mainnavigation glassylink">
        <ul class="smoothmenu">
            <li class="creator">
                <a href="./index.php#HOME" class="textkainit">HOME</a>
            </li>
            <li>
                <a href="./index.php#ABOUT" class="textkainit">ABOUT</a>
            </li>
            <li>
                <a href="./index.php#TOUR" class="textkainit">TOUR</a>
            </li>
            <li class="HOMETITLELI">
                <a href="./index.php#HOME" class="HOMETITLE">EliJosh</a>
            </li>
            <li>
                <a href="./index.php#SERVICE" class="textkainit">SERVICES</a>
            </li>
            <li>
                <a href="./index.php#CONTACT" class="textkainit">CONTACT</a>
            </li>
            <li>
                <a href="" class="textkainit">BOOK NOW</a>
            </li>
        </ul>
        <div class="USERVALUE USERVALUE2 dropdown">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d="M399 384.2C376.9 345.8 335.4 320 288 320H224c-47.4 0-88.9 25.8-111 64.2c35.2 39.2 86.2 63.8 143 63.8s107.8-24.7 143-63.8zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm256 16a72 72 0 1 0 0-144 72 72 0 1 0 0 144z"/></svg>
            <ul class="dropdown-menu">
                <li><a href="#">Account</a></li>
                <li><a href="#">Booking Information</a></li>
                <li><a href="./logOut.php">Logout</a></li>
            </ul>
        </div>
    </nav>


    <section class="BOOKINGSECTION about top" id="ABOUT">

        <div class="left">
            <div class="boxtags">
                <div class="formboxtags">
                    <label for="Checkin">Checkin</label>
                    <input type="date" name="Checkin" id="Checkin" value="<?php  echo $cin;?>">
                </div>
                <div class="formboxtags">
                    <label for="Checkout">Checkout</label>
                    <input type="date" name="Checkout" id="Checkout" value="<?php echo $cout;?>">
                </div>
                <div class="formboxtags">
                    <label for="noAdult">No of Adults</label>
                    <input type="number" name="noAdult" id="noAdult" value="1">
                </div>
                <div class="formboxtags">
                    <label for="noKid">No. of Kids</label>
                    <input type="number" name="noKid" id="noKid" value="0">
                </div>
                <div class="formboxtags">
                    <label for="noSenior">No of Seniors</label>
                    <input type="number" name="noSenior" id="noSenior" value="0">
                </div>
                <div class="formboxtags">
                    <label for="noSenior">Time and Duration</label>
                    <select name="TND" id="TND">
                        <option value="">Day Time (8:00 AM - 5:00 PM)</option>
                        <option value="">Night Time (7:00 PM - 7:00 AM)</option>
                        <option value="">22 Hrs (2:00 PM - 12:00 PM)</option>
                    </select>
                </div>
    
                <div class="buttoncontianer">
                    <button>Suggest</button>
                    <button>Proceed</button>
                </div>
            </div>
        </div>
        <div class="right">

                <h1>Cottages</h1>
                <div class="listofchoices">

                        <?php
                            $sqlcottage = "SELECT *, CONCAT(MinPersons, ' - ', MaxPersons) as Counthead,
                            IF(MaxPersons>= 1, 'YES', 'NO') as Suggested
                            FROM cottagetypes;";
                            $query1 = mysqli_query($conn, $sqlcottage);
                            $datainsertedCottages = "";

                            $recommend = " <div class='Recommentd'>
                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z'/></svg>
                        </div>";


                            $recochoice = 0;
                            while ($result = mysqli_fetch_assoc($query1)) {

                                $recohandler = "";
                                if($result["Suggested"] == "YES" && $recochoice == 0){
                                    $recohandler = $recommend;
                                    $recochoice++;
                                }
                                $datainsertedCottages .= " <div class='addtocart'>
                                    <img src='./Images/".$result["ServiceTypeName"].".jpg' alt=''>
                                    <div class='textareapart'>
                                        <h2 style='text-align: center; color: #fff;letter-spacing:0.1ch;line-height:1em;margin-top:.5em'>".$result["ServiceTypeName"]."</h2>
                                        <div class='curseone'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 640 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z'/></svg>
                                            ".$result["Counthead"]."
                                        </div>
                                        <div class='curseone'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z'/></svg>    
                                            ₱ ".$result["DayPrice"]."
                                        </div>
                                        <div class='curseone'>
                                            <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 384 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z'/></svg>
                                            ₱ ".$result["NightPrice"]."
                                        </div>
                                        
                                        <div class='buttonitself'>
                                            <button>Add to Cart</button>
                                        </div>
                                    </div>
                                    $recohandler
                                </div>";
                            }
                            echo $datainsertedCottages;

                        ?>

 
            </div>


            <h1>Rooms</h1>
            <div class="listofchoices">

            <?php
    $sqlcottage = "SELECT * ,CONCAT(MinPeople, ' - ', MaxPeople) as Counthead,
    IF(MaxPeople>= 1, 'YES', 'NO') as Suggested FROM roomtypes;";
    $query1 = mysqli_query($conn, $sqlcottage);
    $datainsertedCottages = "";

    $recommend = " <div class='Recommentd'>
    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M313.4 32.9c26 5.2 42.9 30.5 37.7 56.5l-2.3 11.4c-5.3 26.7-15.1 52.1-28.8 75.2H464c26.5 0 48 21.5 48 48c0 18.5-10.5 34.6-25.9 42.6C497 275.4 504 288.9 504 304c0 23.4-16.8 42.9-38.9 47.1c4.4 7.3 6.9 15.8 6.9 24.9c0 21.3-13.9 39.4-33.1 45.6c.7 3.3 1.1 6.8 1.1 10.4c0 26.5-21.5 48-48 48H294.5c-19 0-37.5-5.6-53.3-16.1l-38.5-25.7C176 420.4 160 390.4 160 358.3V320 272 247.1c0-29.2 13.3-56.7 36-75l7.4-5.9c26.5-21.2 44.6-51 51.2-84.2l2.3-11.4c5.2-26 30.5-42.9 56.5-37.7zM32 192H96c17.7 0 32 14.3 32 32V448c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V224c0-17.7 14.3-32 32-32z'/></svg>
</div>";


    $recochoice = 0;
    while ($result = mysqli_fetch_assoc($query1)) {

        $recohandler = "";
        if($result["Suggested"] == "YES" && $recochoice == 0){
            $recohandler = $recommend;
            $recochoice++;
        }
        $datainsertedCottages .= " <div class='addtocart'>
            <img src='./Images/".$result["RoomType"].".jpg' alt=''>
            <div class='textareapart'>
                <h2 style='text-align: center; color: #fff;letter-spacing:0.1ch;line-height:1em;margin-top:.5em'>".$result["RoomType"]."</h2>
                <div class='curseone'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 640 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192h42.7c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0H21.3C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7h42.7C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3H405.3zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352H378.7C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7H154.7c-14.7 0-26.7-11.9-26.7-26.7z'/></svg>
                    ".$result["Counthead"]."
                </div>
                <div class='curseone'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 512 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M361.5 1.2c5 2.1 8.6 6.6 9.6 11.9L391 121l107.9 19.8c5.3 1 9.8 4.6 11.9 9.6s1.5 10.7-1.6 15.2L446.9 256l62.3 90.3c3.1 4.5 3.7 10.2 1.6 15.2s-6.6 8.6-11.9 9.6L391 391 371.1 498.9c-1 5.3-4.6 9.8-9.6 11.9s-10.7 1.5-15.2-1.6L256 446.9l-90.3 62.3c-4.5 3.1-10.2 3.7-15.2 1.6s-8.6-6.6-9.6-11.9L121 391 13.1 371.1c-5.3-1-9.8-4.6-11.9-9.6s-1.5-10.7 1.6-15.2L65.1 256 2.8 165.7c-3.1-4.5-3.7-10.2-1.6-15.2s6.6-8.6 11.9-9.6L121 121 140.9 13.1c1-5.3 4.6-9.8 9.6-11.9s10.7-1.5 15.2 1.6L256 65.1 346.3 2.8c4.5-3.1 10.2-3.7 15.2-1.6zM160 256a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zm224 0a128 128 0 1 0 -256 0 128 128 0 1 0 256 0z'/></svg>    
                    ₱ ".$result["DayTimePrice"]."
                </div>
                <div class='curseone'>
                    <svg xmlns='http://www.w3.org/2000/svg' height='1em' viewBox='0 0 384 512'><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><path d='M223.5 32C100 32 0 132.3 0 256S100 480 223.5 480c60.6 0 115.5-24.2 155.8-63.4c5-4.9 6.3-12.5 3.1-18.7s-10.1-9.7-17-8.5c-9.8 1.7-19.8 2.6-30.1 2.6c-96.9 0-175.5-78.8-175.5-176c0-65.8 36-123.1 89.3-153.3c6.1-3.5 9.2-10.5 7.7-17.3s-7.3-11.9-14.3-12.5c-6.3-.5-12.6-.8-19-.8z'/></svg>
                    ₱ ".$result["NightTimePrice"]."
                </div>
                
                <div class='buttonitself'>
                    <button>Add to Cart</button>
                </div>
            </div>
            $recohandler
        </div>";
    }
    echo $datainsertedCottages;

?>
        
            </div>


            <h1>Events Place</h1>
            <div class="listofchoices">
                <div class="addtocart">
                    <img src="./Images/c1.jpg" alt="">
                    <div class="textareapart">
                        <p style="text-align: center; color: #fff;">Name</p>
                        <p style="color: #fff;">2 - 3 Persons</p>
                        <p style="color: #fff;">₱ 1000.00</p>
                        <div class="buttonitself">
                            <button>Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="addtocart">
                    <img src="./Images/c1.jpg" alt="">
                    <div class="textareapart">
                        <p style="text-align: center; color: #fff;">Name</p>
                        <p style="color: #fff;">2 - 3 Persons</p>
                        <p style="color: #fff;">₱ 1000.00</p>
                        <div class="buttonitself">
                            <button>Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
      </div>
    </section>



    <script>
        // Get references to all input elements with the class "input-box"
        const inputElements = document.querySelectorAll("input[type='number']");
        
        // Add event listeners to all selected input elements
        inputElements.forEach(input => {
            input.addEventListener("input", function() {
                // Parse the input value as a number
                const value = parseFloat(input.value);
                
                // Check if the value is less than 0
                if (value < 0) {
                    // Set the value to 0
                    input.value = 0;
                }
            });
        });
    </script>




</body>
</html>