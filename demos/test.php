<?php
require_once '../lib/SmarterSmarty.php';

$obj = new SmarterSmarty;
$obj->setTemplateDir(dirname(__FILE__) . '/templates');

// please do not use this keys in your applications ;-)
ViewOptions::$captchaPrivateKey = '6LebGcMSAAAAAMs6nyI6kXJjyMulJdPuEdwpiNxa';
ViewOptions::$captchaPublicKey = '6LebGcMSAAAAAGWcposI7-Rzpss7VCS8q87k929M';

// assign template variables
$testoptions = array('Zero', 'One', 'Two', 'Three', 'Four');

$obj->assign('testoptions', $testoptions);
$obj->assign('test1', 2);
$obj->assign('test2', "This <should>be no problem...");
$obj->assign('test3', "This is <strong>rather fine</strong>...");

if (isset($_POST) && count($_POST) > 0) {
    $vset = new ValidateSet;

    $vset->setField('test2')
         ->mandatory(array('error' => 'test2 is mandatory!'));
    $vset->setField('recaptcha_response_field')
         ->validateRecaptcha(array('privatekey' => ViewOptions::$captchaPrivateKey));

    $obj->setValidationResults($vset);
}

$obj->display('test.tpl');
