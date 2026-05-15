<?php

session_start();

header('Content-Type: application/json');

require_once('../../controllers/cartController.php');

remove();

?>