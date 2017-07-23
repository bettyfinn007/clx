<?php
Echo "<html>";
 Echo "<title>HTML with PHP</title>";
 Echo "<div class=\"feedbackMessage\"><b>Thank You For Your Submission</b><br>";
 Echo "We will get back to you shortly.</div>";
 Echo "</html>";



$postData = ($_POST);


  $response = array( 'success' => false );

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
                $UserExchangeListAsString.="Type: $val\n";
                }else  if($key=="make"){
                $UserExchangeListAsString.="Make: $val\n";
                }else if($key=="model"){
                $UserExchangeListAsString.="Model: $val\n";
                }else if($key=="comment"){
                $UserExchangeListAsString.="Comment: $val\n\n";
                }
        }
    }
  

            $jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($UserWantInReturn, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$UserWantInReturnAsString="";
foreach ($jsonIterator as $val) {
     $UserWantInReturnAsString.= "• $val \n";
    }


         if ( $contactName != '' && $email != '' && $message != '' ) {
           

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

?>
