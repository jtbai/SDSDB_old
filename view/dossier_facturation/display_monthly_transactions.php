<?php
$MainOutput->addtexte(sprintf("État de compte mensuel en date du %01.0d/%2d \n",$month, $year),'titre' );

$MainOutput->br();

$MainOutput->addtexte("facturé",'titre' );
$MainOutput->br();
foreach($billed_by_cote as $cote=>$amount){
    $MainOutput->addtexte(str_pad($cote,10," ").": ".number_format($amount,0,'.'," ")." $<br>");
}
$MainOutput->addtexte("Total: ".number_format($total_billed,0,'.'," ")." $",'titre' );
$MainOutput->br(2);

$MainOutput->addtexte("encaissé",'titre');
$MainOutput->br();
foreach($paid_by_cote as $cote=>$amount){
    $MainOutput->addtexte(str_pad($cote,10," ")." ".number_format($amount,0,'.'," ")." $<br>");
}
$MainOutput->addtexte("Total: ".number_format($total_paid,0,'.'," ")." $",'titre' );

print($MainOutput->send(1));