Orvelo API Library for PHP
=====================================

Description
-------------------------------------
<p>The Orvelo PHP API for use with an Orvelo account.</p>
<p>Use this class to submit your forms to Orvelo</p>
<p>Obtaine your unique channel hash from the Settings->profile->Edit Channel section of Orvelo</p>


###Requirements:
  PHP 5.3.x or higher [http://www.php.net/]<br />
  PHP Curl extension [http://www.php.net/manual/en/intro.curl.php]<br />

###Project page:
  [Orvelo](http://www.orvelo.com/)<br />
  [Orvelo API](https://github.com/Orvelo/PHP-ORVELO-API)<br />

###Install:
####Composer:
    "require": {
        "orvelo/php-orvelo-api": "1.*"
    }
  
####Git:
    git clone https://github.com/Orvelo/PHP-ORVELO-API
    
<p>In the controller or on the page that handles your form submission </p>
    
Basic Example
----------------------------------------
<p>This will submit all the $_REQUEST parameters to Orvelo</p>
<p>If you opt to use this method each form will need a hidden field with a unique form identifier, named OrveloName or FormName</p>

<p><strong>WARNING: Do not use this method on forms that handle sensitive information such as credit card details or account passwords.</strong></p>

    $orvelo = new Orvelo('<your unique hash>');
    orvelo->send();
    
Advanced Example
----------------------------------------
<p>This method will allow you to build the form data before sending it to Orvelo.</p>
<p>You can set fields individually or with an array, using setFields after addFields will overwrite any previously set fields.</p>

    $orvelo = new Orvelo();
    $orvelo
        ->setFormName('FormIdentifier')
        ->setChannelHash('<your unique hash>')
        ->setFields(array("fieldName" => "Field Value", "fieldTwoName" => "Field Two Value"))
        ->addField('name', 'value')
        ->send(false);
