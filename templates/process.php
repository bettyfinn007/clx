<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
   
header("Content-Type: application/json; charset=UTF-8");
$postData = ($_GET);

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
     

         if ( $contactName != '' && $email != '' && $message != '' ) {
           
                var_dump($postData);
               echo json_encode( '$_POST ');
            $mailTo = 'chelseapaulhus@gmail.com';
            $subject = 'New contact form submission';
            $body  = 'From: ' . $contactName . "\n";
            $body .= 'Company: ' . $company . "\n";
            $body .= 'Email: ' . $email . "\n";
            $body .= 'Phone: ' . $phone . "\n";
            $body .= "Message:\n" . $message . "\n\n";
             $body .= "Items I want to Exchange:\n" . $UserExchangeList . "\n\n";
              $body .= "What I Want in Return:\n" . $UserWantInReturn . "\n\n";

            $success = mail( $mailTo, $subject, $body );

            if ( $success ) {
                $response[ 'success' ] = true;
            }
         }
    // }

    echo json_encode( $response );
?>