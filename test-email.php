<?php

require 'vendor/autoload.php';

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Variable;

$mailersend = new MailerSend([
    'api_key' => 'mlsn.25a8aa3ac3ed2405feb357095f0eb377e92fbce498a227fc2de534400312dd28'
]);

$recipients = [
    new Recipient( "$email", 'DigiPharm'),
];

$variables = [
    new Variable("$email", [
        'time' => "$time",
        'dosage' => "$dossage",
        'medicine' => "$name"
    ])
];

$emailParams = (new EmailParams())
    ->setFrom('test@trial-pr9084zyepegw63d.mlsender.net')
    ->setFromName('DigiPharm')
    ->setRecipients($recipients)
    ->setSubject('Medicine Alert')
    ->setTemplateId('x2p0347xjkkgzdrn')
    ->setReplyTo('cshfaisalhalid@gmail.com')
    ->setReplyToName('DigiPharm')
    // ->setSendAt($sendAtTimestamp)
    ->setVariables($variables);

$mailersend->email->send($emailParams);

?>
