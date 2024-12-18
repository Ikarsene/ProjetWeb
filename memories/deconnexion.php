<?php
session_start();
require_once('admin/connex.inc.php');
unset($_SESSION);
session_destroy();
header("location: index.php");
