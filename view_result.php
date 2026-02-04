<?php
// ১. লাইব্রেরি ইনক্লুড করা
require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

use setasign\Fpdi\Fpdi;

// ২. ডাটাবেজ কানেকশন (আপনার দেওয়া তথ্য অনুযায়ী)
$hostname = "localhost";
$username = "আপনার_ইউজার_নেম"; // এখানে আপনার ডাটাবেজ ইউজার দিন
$password = "Mdimam@#5637$$$"; // আপনার দেওয়া পাসওয়ার্ড
$database = "nidpub_servercopy"; // আপনার ডাটাবেজ নাম

$conn = new mysqli($hostname, $username, $password, $database);

// কানেকশন চেক
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ৩. ডাটা রিট্রিভ করা (NID অনুযায়ী)
$nid = isset($_GET['nid']) ? $_GET['nid'] : ''; 
$sql = "SELECT * FROM users WHERE nid_number = '$nid'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row) {
    // ৪. পিডিএফ প্রসেসিং শুরু
    $pdf = new Fpdi();
    $pdf->AddPage();

    // আপনার হোস্টিংয়ে থাকা পিডিএফটি সোর্স হিসেবে নিন
    $pdf->setSourceFile("view_result.pdf"); 
    $tplIdx = $pdf->importPage(1);
    $pdf->useTemplate($tplIdx, 0, 0, 210);

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);

    // ৫. নির্দিষ্ট পজিশনে ডাটা বসানো
    // জাতীয় পরিচয় পত্র নম্বর
    $pdf->SetXY(80, 95); 
    $pdf->Write(0, $row['nid_number']); 

    // ভোটার এরিয়া
    $pdf->SetXY(80, 105); 
    $pdf->Write(0, $row['voter_area']); 

    $pdf->Output('I', 'NID_Server_Copy.pdf');
} else {
    echo "No record found!";
}
?>
