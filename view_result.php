<?php
require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

use setasign\Fpdi\Fpdi;

$pdf = new Fpdi();
$pdf->AddPage();

// গিটহাবে থাকা পিডিএফটি লোড করুন
$pdf->setSourceFile("view_result.pdf"); 
$tplIdx = $pdf->importPage(1);
$pdf->useTemplate($tplIdx, 0, 0, 210); // A4 সাইজ

// টেক্সটের জন্য ফন্ট সেট করুন
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 0, 0);

// ডাটাবেস থেকে আসা তথ্য বসানো (উদাহরণস্বরূপ)
// $father_nid = $row['father_nid']; // ডাটাবেস থেকে ভেরিয়েবল নিন

// এখানে X এবং Y পজিশন দিয়ে ডাটা বসান
$pdf->SetXY(60, 150); // এই মানগুলো পরিবর্তন করে সঠিক জায়গায় বসাতে হবে
$pdf->Write(0, "199XXXXXXX"); // ডাটাবেসের ডাটা এখানে বসবে

$pdf->Output('I', 'Final_Server_Copy.pdf');
?>