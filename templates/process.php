<?php
Echo "<html>";
 Echo "<title>HTML with PHP</title>";
 Echo "<b>Thank You For Your Submission</b><br>";
 Echo "We will get back to you shortly.";
 Echo "</html>";
// ini_set('display_errors', 'On');
// error_reporting(E_ALL | E_STRICT);
   
// header("Content-Type: application/json; charset=UTF-8");


$postData = ($_POST);

//     echo json_encode( $_POST );
  $response = array( 'success' => false );
//     $_POST = file_get_contents( 'php://input' );
//     $_POST = json_decode( $_POST );
    // if ( $_POST['submit && empty( $_POST['honeypot ) ) {
        $contactName = $postData[contactName];

        $email = $postData[email];

        $phone = $postData[phone];
 
        $company = $postData[company];

        $message = $postData[message];
        $UserExchangeList = $postData[UserExchangeList];
        $UserWantInReturn = $postData[UserWantInReturn];
        
        $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($UserExchangeList, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$UserExchangeListAsString="";
foreach ($jsonIterator as $key => $val) {
    if(!is_array($val)) {
    
                if($key=="type"){
                $UserExchangeListAsString.="$key: $val\n";
                }else  if($key=="make"){
                $UserExchangeListAsString.="$key: $val\n";
                }else if($key=="model"){
                $UserExchangeListAsString.="$key: $val\n";
                }else if($key=="comment"){
                $UserExchangeListAsString.="$key: $val\n\n";
                }
        }
    }
    // echo($UserExchangeListAsString);

            $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($UserWantInReturn, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$UserWantInReturnAsString="";
foreach ($jsonIterator as $val) {
     $UserWantInReturnAsString.= "• $val \n";
    }
    // echo($UserWantInReturnAsString);

// echo '<h2>Thank you for your inquiry</h2><br>
//                 We\'ll be in touch with you shortly.';

         if ( $contactName != '' && $email != '' && $message != '' ) {
           
               //  var_dump($postData);
               // echo json_encode( '$_POST ');
            $mailTo = 'chelseapaulhus@gmail.com';
            $subject = 'New contact form submission';
            $body  = 'From: ' . $contactName . "\n";
            $body .= 'Company: ' . $company . "\n";
            $body .= 'Email: ' . $email . "\n";
            $body .= 'Phone: ' . $phone . "\n";
            $body .= "Message:\n" . $message . "\n\n";
             $body .= "Items I want to Exchange:\n" . $UserExchangeListAsString . "\n\n";
              $body .= "What I Want in Return:\n" . $UserWantInReturnAsString . "\n\n";

            $success = mail( $mailTo, $subject, $body );

            if ( $success ) {
                $response[ 'success' ] = true;
            }
         }
    // }

//   Echo "<html>";
           

    // echo json_encode( $response );
?>
