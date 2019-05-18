<?php
/**
 * Created by PhpStorm.
 * User: reshe
 * Date: 5/17/2019
 * Time: 2:05 AM
 */
$connection = mysqli_connect('localhost', 'root', 'fO2PxIJN4WCF', 'podcasts_lda6');/* or die("Error connecting to database: ".mysqli_error($connection));*/

if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

//echo "Success: A proper connection to MySQL was made! The my_db database is great." . PHP_EOL;
//echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL;

//mysqli_close($connection);
mysqli_select_db($connection,'podcast_list_lda6'); /*or die(mysqli_error($connection));*/

mysqli_query($connection, "UPDATE podcast_list_lda6 SET ".." = ".$data[]." WHERE episode_name = 'Answers'");




?>