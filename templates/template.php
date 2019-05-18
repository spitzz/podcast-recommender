<?php
/**
 * Created by PhpStorm.
 * User: reshe
 * Date: 4/8/2019
 * Time: 7:08 PM
 */

//Establishing connection with MySQL database hosted on the server
$connection = mysqli_connect('localhost', 'root', 'fO2PxIJN4WCF', 'podcasts_lda6');/* or die("Error connecting to database: ".mysqli_error($connection));*/

if (!$connection) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

mysqli_select_db($connection,'podcast_list_lda6'); /*or die(mysqli_error($connection));*/
?>


<!DOCTYPE html>
<html>
<title>Podcast Recomender</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script src="script.js"></script>
<link rel="stylesheet" href="../dist/jquery.thumbs.css">
<script src="http://code.jquery.com/jquery.min.js"></script>
<script src="../dist/jquery.thumbs.js"></script>
<head>
    <!-- Website Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
        <a href="/index.php" class="w3-bar-item w3-button"><b>Podcast</b> Recommender</a>
        <div class="w3-right w3-hide-small">
            <a href="../index.php#aboutUs" class="w3-bar-item w3-button">About Us</a>
        </div>
        <div class="topnav">
            <form action="/resultsOfSearch.php" method="get">
                <input type="text" name="query" placeholder="Search podcasts.." >
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
</div>

<!-- Header
<header class="w3-display-container w3-content w3-wide" style="max-width:1400px;" id="home">
    <img class="w3-image" src="https://cdn.glitch.com/3d341d85-37b3-49a9-9d6e-20a47e7d531f%2Fpic04.jpg?1551832758831" alt="Architecture" width="1500" height="800">
    <div class="w3-display-middle w3-margin-top w3-center">
        <h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><b>Podcast</b></span> <span class="w3-hide-small w3-text-light-grey">Recommender</span></h1>
    </div>
</header> -->

<!-- Page content -->
<div class="w3-content w3-padding" style="max-width:1564px">

    <!-- Project Section -->
    <div class="w3-container w3-padding-32" id="projects">
        <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Podcast You Were Searching For</h3>
    </div>

    <div class="w3-row-padding">
        <div class="w3-col l3 m6 w3-margin-bottom" style="padding-left: 10px; padding-right: 10px;">
            <div class="w3-display-container">
                <div class="w3-display-topleft w3-black w3-padding">
                    <a href="<?php
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $current_url = "https";
                    else
                        $current_url = "http";

                    $current_url .= "://";
                    $current_url .= $_SERVER['HTTP_HOST'];
                    $current_url .= $_SERVER['REQUEST_URI'];
                    echo $current_url;
                    ?>" class="w3-hover-text-blue">{episode_name}</a></div>
                <img src="../podcast_pic.jpg" style="width:100%">
            </div>
        </div>
        <div class="w3-col 13 m6 w3-margin-bottom" >
            <div class="w3-display-container" style="margin-left: auto; margin-right: auto; padding-top: 0px;">
                <h1>{episode_name}</a></h1>
                <p class="w3-border-bottom w3-border-light-grey" style="padding-bottom: 5px;">Podcast: {podcast_name}</p>
            </div>
            <div class="w3-display-container" style="margin-left: auto; margin-right: auto;">
                <div>
                    <h2 style="padding-top: 10px;">Recommendations</h2>
                </div>
                    <div class="recommendation">
                        <div class="recommendation-header">
                            <h2><a href="<?php echo "../resultsOfSearch.php?query=".clean("{rec_1_episode}"); //$data = str_replace('#','','{rec_1_episode}'); ?>">{rec_1_episode}</a></h2>
                            <p>Podcast: {rec_1_podcast}</p>
                            <div class="js-rating" data-like="0" data-dislike="0"></div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-header">
                            <h2><a href="<?php echo "../resultsOfSearch.php?query=".clean("{rec_2_episode}"); //$data = str_replace('#','','{rec_2_episode}'); ?>">{rec_2_episode}</a></h2>
                            <p>Podcast: {rec_2_podcast}</p>
                            <div class="js-rating" data-like="0" data-dislike="0"></div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-header">
                            <h2><a href="<?php echo "../resultsOfSearch.php?query=".clean("{rec_3_episode}"); //$data = str_replace('#','','{rec_3_episode}'); ?>">{rec_3_episode}</a></h2>
                            <p>Podcast: {rec_3_podcast}</p>
                            <div class="js-rating" data-like="0" data-dislike="0"></div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-header">
                            <h2><a href="<?php echo "../resultsOfSearch.php?query=".clean("{rec_4_episode}"); //$data = str_replace('#','','{rec_4_episode}'); ?>">{rec_4_episode}</a></h2>
                            <p>Podcast: {rec_4_podcast}</p>
                            <div class="js-rating" data-like="0" data-dislike="0"></div>
                        </div>
                    </div>
                    <div class="recommendation">
                        <div class="recommendation-header">
                            <h2><a href="<?php echo "../resultsOfSearch.php?query=".clean("{rec_5_episode}"); //$data = str_replace('#','','{rec_5_episode}'); ?>">{rec_5_episode}</a></h2>
                            <p>Podcast: {rec_5_podcast}</p>
                            <div class="js-rating" data-like="0" data-dislike="0"></div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
<!-- End page content -->
<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16">
    <p>Powered by <a href="" title="W3.CSS" target="_blank" class="w3-hover-text-blue">W.3 CSS and Brooklyn College Computer Science Students</a></p>
</footer>
<script src="../dist/jquery.thumbs.js"></script>
<script>
    $(function () {
        $('.js-rating-simple').thumbs();
        $('.js-rating').thumbs({
            onLike: function (value) {
                console.log('Like ' + value);
            },
            onDislike: function(value) {
                console.log('Dislike ' + value)
            }
        });
    })
</script>
</body>
</html>

<?php
function clean($string){
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
?>