<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
    "http://www.w3.org/TR/html4/strict.dtd">

<html lang="de">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Smarter Smarty Test</title>

    {*
    <meta name="description" content="{$meta_description|escape}">
    <meta name="keywords" content="{$meta_keywords|escape}">
    *}

    <link rel="stylesheet" href="/lib/blueprint/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="/lib/blueprint/print.css" type="text/css" media="print">

    <!--[if lt IE 8]>
    <link rel="stylesheet" href="/lib/blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
</head>
<body>

<div class="container">

{if isset($vresults)}
    {foreach from=$vresults->messages item=message}
        <div class="error">
            {$message|escape}
        </div>
    {/foreach}
{/if}

<form method="post" action="test.php">
    {input_selectone label="Select One:" name="test1" id="test1" options=$testoptions value=$test1}
    {input_text label="Text:" name="test2" id="test2" value=$test2 size="30" maxlength="30"}
    {input_wysiwyg label="WYSIWYG:" name="test3" id="test3" value=$test3}

    {input_captcha}

    <input type="submit" />
</form>

</body>
</html>