<?php

const BUFFERED = true;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (BUFFERED) {
    ob_start();
}

require_once 'system/helpers.php';
require_once 'system/routes.php';

if (BUFFERED) {
    ob_end_flush();
}
