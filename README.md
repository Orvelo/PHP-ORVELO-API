Orvelo API Library for PHP
=====================================

Description
-------------------------------------

###Requirements:
  PHP 5.3.x or higher [http://www.php.net/]<br />
  PHP Curl extension [http://www.php.net/manual/en/intro.curl.php]<br />

###Project page:
  [Orvelo](http://www.orvelo.com/)<br />
  [Orvelo API](https://github.com/Orvelo/PHP-ORVELO-API)<br />

###Install:
####Composer:
    "require": {
        "orvelo/php-orvelo-api": "dev-master"
    }
  
####Git:
    git clone https://github.com/Orvelo/PHP-ORVELO-API
    
Basic Example
----------------------------------------
    $orvelo = new Orvelo('<your unique hash>');
    orvelo->send();
    
Advanced Example
----------------------------------------
    $orvelo = new Orvelo();
    $orvelo
        ->setFormName('FormIdentifier')
        ->setChannelHash('<your unique hash>')
        ->setFields(array("fieldName" => "Field Value", "fieldTwoName" => "Field Two Value"))
        ->addField('name', 'value')
        ->send(false);
