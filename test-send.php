<?php 

use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;

$mailersend = new MailerSend();

$recipients = [
    new Recipient('cshfaisalhalid@gmail.com', 'Faisal'),
];

$emailParams = (new EmailParams())
    ->setFrom('cshfaisalhalid@gmail.com')
    ->setFromName('Faisal Test')
    ->setRecipients($recipients)
    ->setSubject('Test')
    ->setHtml('This is the HTML content')
    ->setText('This is the text content')
    ->setReplyTo('cshfaisalhalid@gmail.com')
    ->setReplyToName('Faisal');

$mailersend->email->send($emailParams);

?>