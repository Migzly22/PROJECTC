<?php
    require '../printing/vendor/autoload.php';
    require '../database.php';


    use Dompdf\Dompdf;
    use Dompdf\Options;



    $options = new Options;
    $options ->setChroot(__DIR__);//file directory
    $options -> setIsRemoteEnabled(true);

    
    $dompdf = new Dompdf($options);
    $dompdf -> setPaper("A4", "portrait"); // change the paper properties to A4 and landscape
    


$path = "../logo.png";
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


    $specificitem =  $_GET['id'];

    $sqlcode = "SELECT * FROM baptisminfo WHERE ChildID = $specificitem";
    $queryrun = mysqli_query($con, $sqlcode);
    $result = mysqli_fetch_assoc($queryrun);


 




        $html = file_get_contents("../printing/baptism.html");
        $needtochange = [
            "{{IMG}}",
            "{{Baptismdate}}",
            "{{Childname}}", 
            "{{Cbday}}", 
            "{{Bplace}}", 
            "{{Fathername}}",
            "{{Fbplace}}",
            "{{Mothersname}}",
            "{{Mbplace}}",
            "{{Address}}",
            "{{Ninong}}",
            "{{NinongAddress}}",
            "{{Ninang}}",
            "{{NinangAddress}}",
            "{{Others}}",
            "{{Priest}}"
        ];
        $valuetochange = [
            $base64,
            $result['Baptismdate'],
            $result['Childname'],
            $result['Cbday'],
            $result['Bplace'],
            $result['Fathername'],
            $result['Fbplace'],
            $result['Mothersname'],
            $result['Mbplace'],
            $result['Address'],
            $result['Ninong'],
            $result['NinongAddress'],
            $result['Ninang'],
            $result['NinangAddress'],
            $result['Others'],
            $result['Priest']
            
        ];

        $html = str_replace($needtochange, $valuetochange, $html);


        $dompdf -> loadHtml($html); // load the value that you pass in it
        //$dompdf -> load_html_file('htmltemplate.html'); // use to load another html file
        $dompdf -> render();

        $dompdf -> addInfo("Title", 'Baptism'); // Add additional info in the pdf
        $dompdf->stream("Baptism.pdf", ["Attachment" => 0]); //the text here represent the name of the pdf file
        // Attachment -> 0 means view of the pdf
        // while Attachment -> 1 means download the pdf but differ on the configuration of the borwser
    



    

