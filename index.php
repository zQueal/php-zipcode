<?php

# Location data provided by: elevenbasetwo.com

# includes
include 'Network/Curl/Curl.php';

use Phalcon\Mvc\Micro as Micro;
use Network\Curl\Curl as Curl;

# init
$app = new Micro;
$curl = new Curl;


# class
class ZipCode {
    public function all($zipcode){
        global $curl;
        $r = $curl->get('http://zip.elevenbasetwo.com/v2/US/'.$zipcode);
        $d = (object) json_decode($r['data'], true);
        print $d->city;
        print $d->state;
        print $d->country;
    }
    public function city($zipcode){
        global $curl;
        $r = $curl->get('http://zip.elevenbasetwo.com/v2/US/'.$zipcode);
        $d = (object) json_decode($r['data'], true);
        print $d->city;
    }
    public function state($zipcode){
        global $curl;
        $r = $curl->get('http://zip.elevenbasetwo.com/v2/US/'.$zipcode);
        $d = (object) json_decode($r['data'], true);
        print $d->state;
    }
    public function country($zipcode){
        global $curl;
        $r = $curl->get('http://zip.elevenbasetwo.com/v2/US/'.$zipcode);
        $d = (object) json_decode($r['data'], true);
        print $d->country;
    }
}

# routes
$app->get('/', function(){
    echo "<strong>Invalid API Call...</strong><br /><br />Available: <br />/all/{zipcode}<br />/city/{zipcode}<br />/state/{zipcode}<br />/country/{zipcode}";
});

$app->get('/all/{zip}', function($zip){
    ZipCode::all($zip);
});

$app->get('/city/{zip}', function($zip){
    ZipCode::city($zip);
});

$app->get('/state/{zip}', function($zip){
    ZipCode::state($zip);
});

$app->get('/country/{zip}', function($zip){
    ZipCode::country($zip);
});

# error pages
$app->notFound(function() use ($app) {
    $app->response->setStatusCode(404, 'Not Found')->sendHeaders();
    echo '404';
});

# run app
$app->handle();