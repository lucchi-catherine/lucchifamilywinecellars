<?php

$from = 'Contact form <info@lucchifamilywinecellars.com>';

$sendTo = 'Contact form <info@lucchifamilywinecellars.com>';

$subject = 'New message from Lucchi Family Wine Cellars Website';

$fields = array('firstName' => 'First Name', 'lastName' => 'Last Name', 'email' => 'Email', 'phone' => 'Phone Number', 'message' => 'Message');

$okMessage = 'Contact form successfully submitted. Thanks!';

$errorMessage = 'There was an error while submitting the form. Please try again.';

error_reporting(0);

try {
    if (count($_POST) == 0) {
        throw new \Exception('Form is empty');
    }
    $emailText = "You have a new message from your contact form\n=============================\n";

    foreach ($_POST as $key => $value) {
        if (isset($fields[$key])) {
            $emailText .= "$fields[$key]: $value\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset="UTF-8";',
    'From: '.$from,
    'Reply-To:'.$from,
    'Return-Path: '.$from,
    );

    mail($sendTo, $subject, $emailText, implode("\n", $headers));

    $responseArray = array('type' => 'success', 'message' => $okMessage);
} catch (Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);

    header('Content-Type: application/json');

    echo $encoded;
} else {
    echo $responseArray['message'];
}
