<?php
$serveur = "localhost";
$user = "root";
$passwd = "475Ju56n@";
$bdd="memories";

$connex = mysqli_connect($serveur, $user, $passwd, $bdd);
mysqli_get_host_info($connex);
mysqli_get_server_info($connex);
if (mysqli_connect_errno()) die ("Echec de la connexion : ".mysqli_connect_error());
?>
