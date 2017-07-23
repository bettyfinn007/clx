<?php
    $response = array( 'success' => false );
    $_POST = file_get_contents( 'php://input' );
    $data = json_decode( $_POST );
    if ( $data->submit && empty( $data->honeypot ) ) {
        $name = $data->name;
        $email = $data->email;
        $phone = $data->phone;
        $company = $data->company;
        $message = $data->message;

        if ( $name != '' && $email != '' && $message != '' ) {
            $mailTo = 'example@mydomain.com';
            $subject = 'New contact form submission';
            $body  = 'From: ' . $name . "\n";
            $body .= 'Company: ' . $company . "\n";
            $body .= 'Email: ' . $email . "\n";
            $body .= 'Phone: ' . $phone . "\n";
            $body .= "Message:\n" . $message . "\n\n";

            $success = mail( $mailTo, $subject, $body );

            if ( $success ) {
                $response[ 'success' ] = true;
            }
        }
    }

    echo json_encode( $response );
?>