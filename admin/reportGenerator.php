<?php
/**
 * Created by PhpStorm.
 * User: DiniX
 * Date: 07-Jul-17
 * Time: 12:59 PM
 */
$startDate="2017.07.01";
$finishDate="2017.07.21";

if(isset($_POST["generate"])){
    include("../database.php");
    include("../table.php");
    include("../book_session.php");
    require('../fpdf181/fpdf.php');
    $dbObj=database::getInstance();
    $dbObj->connect('localhost','root','','lms_db');

    $startDate = new DateTime($_POST["startDate"]);
    $finishDate = new DateTime($_POST["finishDate"]);
    $lastDate = $finishDate;
    $finishDate = $finishDate->modify( '+1 day' );

    $pdf = new FPDF();
    $pdf->AddPage();
    $topic = "Daily Circulation Report ( ".date_format($startDate,'Y-m-d')." - ".($_POST["finishDate"])." ) ";
    $cat=array("000-099","100-199","200-299","300-399","400-499","500-599","600-699","700-799","800-899","900-999");
    $pdf->SetFont("Arial","B",16);
    $pdf->Cell(190,20,$topic,1,1,"C",0,0);
    $pdf->Cell(40,20,"Date",1,0,"C");
    $pdf->Cell(150,10,"Category No.",1,1,"C");
    $pdf->Cell(40,10,"",0,0);
    $pdf->SetFont("Arial","",11);
    for($i=0;$i<10;$i++){
        $pdf->Cell(15,10,$cat[$i],1,0,"C");
    }
    $pdf->Ln();
    $interval = DateInterval::createFromDateString('1 day');
    $period =new DatePeriod($startDate,$interval,$finishDate);
    foreach ($period as $dt){
        $date = $dt->format("Y-m-d");
        $pdf->Cell(40,10,$date,1,0);
        for ($i=0;$i<10;$i++){
            $bs = new book_session();
            $sql = "Select book_title from book_sessions where date_of_borrowal = '$date' and category_no like '$i%'";
            $result = $bs->featuredLoad($dbObj,$sql);
            $numOfRows = mysqli_num_rows($result);
            $pdf->Cell(15,10,$numOfRows,1,0,"C");
                /*if($numOfRows==0){
                    continue;
                }else {
                    for ($j = 0; $j < $numOfRows; $j++) {
                        foreach (mysqli_fetch_assoc($result) as $key => $value) {
                            echo $value . "<br />";
                        }
                    }
                }*/
            }$pdf->Ln();
    }$pdf->Output();
}


?>
