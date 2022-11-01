<?php
require_once('TCPDF/tcpdf_import.php');
require_once("phpqrcode/qrlib.php");
require('phpmailer/includes/PHPMailer.php');
require('phpmailer/includes/SMTP.php');
require('phpmailer/includes/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/*---------------- Sent Mail Start -----------------*/
$name = $_POST['name'];
$tel = $_POST["tel"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$message = $_POST["message"];

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$mail->isSMTP();
$mail ->Host = "smtp.gmail.com";
$mail->SMTPAuth ="true";
$mail->SMTPSecure="tls";
$mail->Port="587";
$mail->Username="yjh970224@gmail.com";
$mail->Password="mhekxkvtyssmfgew";
$mail->Subject="[捐款成功通知]";
$mail->setFrom("yjh970224@gmail.com");
$mail->isHTML(true);
$mail->addAttachment('order.pdf');
$mail->addAttachment('123.png');
$mail->Body="感謝您的支持<br><br>以下是您的資料:<br>姓名 : $name<br>電話 : $tel<br>性別 : $gender<br>備註: $message<br><br>";
$mail->addAddress($email);
$mail->smtpClose();

if($mail->Send()){
echo "Email sent successfully";
}else {
    echo "error sending email";
}

$URL='http://'.$_SERVER['HTTP_HOST'].'/order.pdf';
QRcode::png($URL, '123.png');

/*---------------- Sent Mail End -------------------*/

/*---------------- Print PDF Start -----------------*/
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetFont('cid0jp', '', 18);
$pdf->AddPage();

$name = $_POST['name'];
$tel = $_POST["tel"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$message = $_POST["message"];
$html = <<<EOF
<head>
    <title>test</title>
</head>
    <body>
    <table border="1">
    <tr style="text-align: center; background-color: #EEEEEE;" >
        <td colspan="4"><strong>捐款人資訊</strong></td>
    </tr>
    <tr style="text-align: left; background-color: #D0E4F5" >
        <td>姓名:</td>
        <td>$name</td>
        <td>電話:</td>
        <td>$tel</td>
    </tr>
    <tr style="text-align: left; background-color: #EEEEEE;" >
        <td>性別:</td>
        <td colspan="3">$gender</td>
    </tr>
    <tr style="text-align: left; background-color: #D0E4F5" >
        <td>E-mail:</td>
        <td colspan="3">$email</td>
    </tr>
    <tr style="text-align: center; background-color: #EEEEEE;" >
        <td colspan="4">備註</td>
    </tr>
    <tr style="text-align: left; background-color: #D0E4F5" >
        <td colspan="4" rowspan="3">$message</td>
    </tr>
    </table>
</body>

EOF;
/*---------------- Print PDF End -------------------*/

$pdf->writeHTML($html);
$pdf->lastPage();
$pdf->Output("order.pdf", 'I');
//$pdf->Output("http://140.138.77.70:8787/files/public_html/hw2/order.pdf", 'F');

$pdf->Output("/home/s1093522/public_html/HW2/order.pdf", 'F');

