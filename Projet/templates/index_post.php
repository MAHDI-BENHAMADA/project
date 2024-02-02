<?php
require_once 'functions/functions.php';
require_once 'functions/database.php';


function request_ride($data) {
    functions\json_respond('OK', 'Request Sent!');
}

if ($_POST) {
    request_ride(json_decode($_POST['data'], true));
}

?>