<?php

require("../Database.php");
session_start();
ob_start();

$sqlcode = (int)$_POST["sqlcode"];

?>
        <section class="mainbodycontainer contianermain2" id="COTTAGES">
                <h1>-Cottages-</h1>
                <div class="SOitemlist" id="SOITEMList">
                <?php
                                $sqlcottage = "SELECT *, CONCAT(MinPersons, ' - ', MaxPersons) as Counthead,
                                IF(MaxPersons>= $sqlcode, 'YES', 'NO') as Suggested
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
                                    $datainsertedCottages .= "
                                    <div class='SO-item'>
                                        <input type='checkbox' id='".$result["ServiceTypeName"]."' value='".$result['ServiceTypeName']."||".$result['ServiceTypeID']."||".$result['DayPrice']."||".$result['NightPrice']."||".$result['NightPrice']."' name='SOItemSelect'>
                                        <div class='addtocart2' onclick='activateClick(`".$result["ServiceTypeName"]."`)'>
                                            <img src='./Images/c1.jpg' alt=''>
                                            <div class='textareapart'>
                                                <h2>".$result["ServiceTypeName"]."</h2>
                                                <div class='smallinfos'>
                                                    <small>Day Price : ₱ ".$result["DayPrice"]."</small>
                                                    <small>Night Price : ₱ ".$result["NightPrice"]."</small>
                                                </div>
                                            </div>
                                            $recohandler
                                        </div>
                                    </div>";

                                    
                                }
                                echo $datainsertedCottages;

                            ?>
                    
                </div>
            </section>
            <section class="mainbodycontainer contianermain2" id="ROOMS">
                <h1>-Rooms-</h1>
                <div class="SOitemlist" id="SOITEMList">

                <?php
                    $sqlcottage = "SELECT * ,CONCAT(MinPeople, ' - ', MaxPeople) as Counthead,
                    IF(MaxPeople>= $sqlcode, 'YES', 'NO') as Suggested FROM roomtypes;";
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
                        $datainsertedCottages .= "
                            <div class='SO-item'>
                                <input type='checkbox' id='".$result["RoomType"]."' value='".$result['RoomType']."||".$result['RoomType']."||".$result['DayTimePrice']."||".$result['NightTimePrice']."||".$result['Hours22']."' name='SOItemSelect'>
                                <div class='addtocart2' onclick='activateClick(`".$result["RoomType"]."`)'>
                                    <img src='./Images/c1.jpg' alt=''>
                                    <div class='textareapart'>
                                        <h2>".$result["RoomType"]."</h2>
                                        <div class='smallinfos'>
                                            <small>Day Price : ₱ ".$result["DayTimePrice"]."</small>
                                            <small>Night Price : ₱ ".$result["NightTimePrice"]."</small>
                                        </div>
                                    </div>
                                    $recohandler
                                </div>
                            </div>";
                    }
                    echo $datainsertedCottages;

                ?>

                </div>
            </section>
            <section class="mainbodycontainer contianermain2" id="EVENTPLACE">
                <h1>-Event Place-</h1>
                <div class="SOitemlist" id="SOITEMList">
                <?php
                    $sqlcottage = "SELECT * FROM eventplace WHERE PAX >= $sqlcode LIMIT 1;";
                    $query1 = mysqli_query($conn, $sqlcottage);
                    $result = mysqli_fetch_assoc($query1);
                    
                    echo "
                    <div class='SO-item'>
                        <input type='checkbox' id='Pavilion' value='Pavilion||".$result['Evntid']."||".$result['Pavilion']."||".$result['Pavilion']."||".$result['Pavilion']."' name='SOItemSelect'>
                        <div class='addtocart2' onclick='activateClick(`Pavilion`)'>
                            <img src='./Images/c1.jpg' alt=''>
                            <div class='textareapart'>
                                <h2>Pavilion</h2>
                                <div class='smallinfos'>
                                    <small>Max Pax : ".$result["PAX"]."</small>
                                    <small>Price : ₱ ".$result["Pavilion"]."</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='SO-item'>
                        <input type='checkbox' id='Grand Pavilion' value='Grand Pavilion||".$result['Evntid']."||".$result['Grand Pavilion']."||".$result['Grand Pavilion']."||".$result['Grand Pavilion']."' name='SOItemSelect'>
                        <div class='addtocart2' onclick='activateClick(`Grand Pavilion`)'>
                            <img src='./Images/c1.jpg' alt=''>
                            <div class='textareapart'>
                                <h2>Grand Pavilion</h2>
                                <div class='smallinfos'>
                                    <small>Max Pax : ".$result["PAX"]."</small>
                                    <small>Price : ₱ ".$result["Grand Pavilion"]."</small>
                                </div>
                            </div>
                        </div>
                    </div>";
                ?>
                </div>
            </section>