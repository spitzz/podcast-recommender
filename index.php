<?php
/**
 * Created by PhpStorm.
 * User: reshe
 * Date: 3/28/2019
 * Time: 6:47 PM
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
<head>
    <!-- Website Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
        <a href="index.php" class="w3-bar-item w3-button"><b>Podcast</b> Recommender</a>
        <!-- Float links to the right. Hide them on small screens -->
        <div class="w3-right w3-hide-small">
            <a href="#aboutUs" class="w3-bar-item w3-button">About Us</a>
        </div>
        <div class="topnav">
            <form action="resultsOfSearch.php" method="get">
                <input type="text" name="query" placeholder="Search podcasts.." >
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
</div>

<!-- Header -->
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
    <img class="w3-image" src="https://cdn.glitch.com/3d341d85-37b3-49a9-9d6e-20a47e7d531f%2Fpic04.jpg?1551832758831" style="height: 300px;" >
    <div class="w3-display-middle w3-margin-top w3-center">
        <h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><b>Enjoy</b></span> <span class="w3-hide-small w3-text-black">Podcasts</span></h1>
    </div>
</header>

<!-- Page content -->
<div class="w3-content w3-padding" style="max-width:1564px">

    <!-- Project Section -->
    <div class="w3-container w3-padding-32" id="projects">
        <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Podcast We Find Interesting</h3>
    </div>

        <?php
        // PHP code that randomly chooses 8 podcast episodes
        // (By generating random numbers for podcasts' IDs, querying them, and retrieving its information),
        // displays them on the page, and creates page for each of them if such doesn't exist

        for($i = 0; $i < 8; $i++){
            $random_number = rand(1, 2028);
            $podcast_sql = "SELECT * FROM `podcast_list_lda6` WHERE id = ".$random_number;
            $raw_results = mysqli_query($connection, $podcast_sql);
            if(mysqli_num_rows($raw_results) > 0) {
                $results = mysqli_fetch_array($raw_results);
                    ?>
                    <!-- Generating divs for randomly chosen podcasts -->
                    <div class="w3-col l3 m6 w3-margin-bottom" style="padding-left: 10px; padding-right: 10px;">
                        <div class="w3-display-container">
                            <div class="w3-display-topleft w3-black w3-padding">
                                <?php

                                // Name of the template file.
                                $template_file = 'template.php';

                                // Path to the directory where template file is stored.
                                $template_path = './templates/';

                                // Path to the directory where php will store the auto-generated podcasts' pages.
                                $podcasts_path = './podcasts/';

                                $data['episode_name'] = $results['episode_name'];
                                $data['podcast_name'] = $results['podcast_name'];
                                $data['rec_1_episode'] = $results['rec_1_episode'];
                                $data['rec_1_podcast'] = $results['rec_1_podcast'];
                                $data['rec_2_episode'] = $results['rec_2_episode'];
                                $data['rec_2_podcast'] = $results['rec_2_podcast'];
                                $data['rec_3_episode'] = $results['rec_3_episode'];
                                $data['rec_3_podcast'] = $results['rec_3_podcast'];
                                $data['rec_4_episode'] = $results['rec_4_episode'];
                                $data['rec_4_podcast'] = $results['rec_4_podcast'];
                                $data['rec_5_episode'] = $results['rec_5_episode'];
                                $data['rec_5_podcast'] = $results['rec_5_podcast'];

                                // Data array (Should match with data above's order).
                                $placeholders = array("{episode_name}", "{podcast_name}", "{rec_1_episode}", "{rec_1_podcast}", "{rec_2_episode}", "{rec_2_podcast}", "{rec_3_episode}", "{rec_3_podcast}", "{rec_4_episode}", "{rec_4_podcast}", "{rec_5_episode}", "{rec_5_podcast}");

                                // Get the template.php as a string.
                                $template = file_get_contents($template_path.$template_file);

                                // Fills the template with information stored in placeholders' array.
                                $new_podcast_file = str_replace($placeholders, $data, $template);

                                // Generates URL for every podcast that is chosen.
                                $data['episode_name'] = clean($data['episode_name']);
                                $podcast_file_name = $data['episode_name'].".php";

                                // Save file into podcasts directory.
                                $fp = fopen($podcasts_path.$podcast_file_name,'w');
                                fwrite($fp, $new_podcast_file);
                                fclose($fp);

                                ?>
                                <!-- Code creates link for podcast from name of episode. -->
                                <a href="<?php echo $podcasts_path . $podcast_file_name ?>"
                                   class="w3-hover-text-blue"><?php echo $results['episode_name'] ?></a>
                            </div>
                            <!-- Places image in preview and podcast's page. As we couldn't parse images for podcasts,
                            we used template picture 'podcast_pic.jpg' for podcasts. -->
                            <img src="../podcast_pic.jpg" style="width:100%">
                            <!-- Displays name of podcast in preview of podcast when it is shown as search result. -->
                            <p><?php echo $results['podcast_name'] ?></p>
                        </div>
                    </div>
                    <?php
            }
            else{ // if there is no matching rows do following
                echo "No results";
            }

        }
        ?>

<div class="w3-row-padding">
    <!-- About Section -->
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16" id="aboutUs">Website Creators</h3>
    <div class="w3-row-padding w3-grayscale">
        <div class="w3-col l3 m6 w3-margin-bottom">

            <h3>Lauren Burgess</h3>
            <p class="w3-opacity"></p>
            <p> A charismatic artist<br><br><br></p>  <!-- the <br>'s keep the format the same-->

        </div>
        <div class="w3-col l3 m6 w3-margin-bottom">

            <h3>Ethan Boiangu</h3>
            <p class="w3-opacity"></p>
            <p>A Digital Artist.<br><br><br></p>  <!-- the <br>'s keep the format the same-->

        </div>
        <div class="w3-col l3 m6 w3-margin-bottom">

            <h3>Harry Shomer</h3>
            <p class="w3-opacity"></p>
            <p>A mysterious man behind the code.<br><br><br></p>

        </div>
        <div class="w3-col l3 m6 w3-margin-bottom">

            <h3>Nikita Reshetov</h3>
            <p class="w3-opacity"></p>
            <p>A hard working man!<br><br><br></p>  <!-- the <br>'s keep the format the same-->

        </div>
        <div class="w3-col l3 m6 w3-margin-bottom">

            <h3>Hakeem Gayle</h3>
            <p class="w3-opacity"></p>
            <p> A modern computer scientist<br><br><br></p>

        </div>
    </div>

    <!-- End page content -->
</div>
    <div class="w3-container" id="projects">
        <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Our Story</h3>
    </div>
    <div class="w3-row-padding">
        <div class="w3-display-container" style="padding: 0px;">
            <div class="w3-white w3-padding">
                <p style="padding-top: 5px;">
                    This project came to life when five Brooklyn College students banded together for an independent project.
                    We all chose on AMAZING professor to supervise <br>our project ~Mr.Michael Mandel~ Throughout this project we have encountered many
                    challenging events. Learning what would the end user want from such a product, how to connect this website to a simple database, but overall
                    creating an algorithm that will search through a database of podcasts.
                    <br><br>
                    We hope that you will enjoy this website and all of the hard work that has been placed into it!
                    <br>
                    ~ A Cool Group of CUNY Students
                </p>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<footer class="w3-center w3-black w3-padding-16">
    <p>Powered by <a href="" title="W3.CSS" target="_blank" class="w3-hover-text-blue">W.3 CSS and Brooklyn College Computer Science Students</a></p>
</footer>

</body>
</html>

<?php
function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
?>
