<!-- Establishing connection with database -->
<?php
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
?>


<!-- HTML -->
<!DOCTYPE html>
<html>
<title>Podcast Recomender</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<!-- Navbar (sit on top) -->
<div class="w3-top">
    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
        <a href="/index.php" class="w3-bar-item w3-button"><b>Podcast</b> Recommender</a>
        <!-- Float links to the right. Hide them on small screens -->
        <div class="w3-right w3-hide-small">
            <!--<a href="#projects" class="w3-bar-item w3-button">Projects</a>
            <a href="#about" class="w3-bar-item w3-button">About Us</a> -->
            <a href="../index.php#aboutUs" class="w3-bar-item w3-button">About Us</a>
            <!-- <a href="#Genre" class="w3-bar-item w3-button">Genre</a> -->
        </div>
        <div class="topnav">
            <form action="/resultsOfSearch.php" method="get">
                <input type="text" name="query" placeholder="Search podcasts..">
                <input type="submit" value="Search">
            </form>
        </div>
    </div>
</div>

<!-- Header
<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
    <img class="w3-image" src="https://cdn.glitch.com/3d341d85-37b3-49a9-9d6e-20a47e7d531f%2Fheadphone%20lady.jpg?1551908620507" alt="Architecture" width="1500" height="800">
    <div class="w3-display-middle w3-margin-top w3-center">
        <h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><b>Enjoy</b></span> <span class="w3-hide-small w3-text-light-grey">Podcasts</span></h1>
    </div>
</header> -->

<header class="w3-display-container w3-content w3-wide" style="max-width:1500px;" id="home">
    <img class="w3-image" src="https://cdn.glitch.com/3d341d85-37b3-49a9-9d6e-20a47e7d531f%2Fheadphone%20lady.jpg?1551908620507" style="height: 300px;" >
    <div class="w3-display-middle w3-margin-top w3-center">
        <h1 class="w3-xxlarge w3-text-white"><span class="w3-padding w3-black w3-opacity-min"><b>Enjoy</b></span> <span class="w3-hide-small w3-text-black">Podcasts</span></h1>
    </div>
</header>

<div class="w3-content w3-padding" style="max-width:1564px">

    <!-- Project Section -->
</div>

<?php
$query = $_GET['query'];
// Gets value sent over search form

$min_length = 3;
// minimum length of the query

if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then

    $query = htmlspecialchars($query);
    // changes characters used in html to their equivalents

    $query = mysqli_real_escape_string($connection, $query);
    // makes sure nobody uses SQL injection

    $query_tokens = array();
    // Creates array for token storage

    $token = strtok($query, " ,-");
    // Tokenizes query string

    while ($token !== false)
    {
        array_push($query_tokens, $token);
        $token = strtok(" ,-");
    }

    $sql = array();
    $sql2 = array();

    // Creates two SQL query by glueing tokens in search string together with needed SQL command
    foreach ($query_tokens as $word){
        $sql[] = "`episode_name` LIKE '%".$word."%'";
    }

    foreach ($query_tokens as $word){
        $sql2[] = "`podcast_name` LIKE '%".$word."%'";
    }

    $sql = "SELECT * FROM podcast_list_lda6 WHERE (".implode(" AND ", $sql);
    $sql2 = ") OR (".implode(" AND ", $sql2);

    $sql_query = $sql.$sql2.")";
    $raw_results = mysqli_query($connection, $sql_query);

    if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following

        while($results = mysqli_fetch_array($raw_results)){
            // $results = mysql_fetch_array($rec_results) puts data from database into array, while it's valid it does the loop
            ?>
                <!-- Generating divs for output of search results -->
                <div class="w3-col l3 m6 w3-margin-bottom" style="padding-left: 10px; padding-right: 10px;">
                    <div class="w3-display-container">
                        <div class="w3-display-topleft w3-black w3-padding">
                            <?php
                            // Name of the template file.
                            $template_file = 'template.php';

                            // Path to the directory where you store the template file.
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

                            // Fills the template.
                            $new_podcast_file = str_replace($placeholders, $data, $template);

                            // Generates URL for every podcast that appears in the search results.
                            $data['episode_name'] = clean($data['episode_name']);
                            $podcast_file_name = $data['episode_name'].".php";

                            // Save file into podcasts directory.
                            $fp = fopen($podcasts_path.$podcast_file_name,'w');
                            fwrite($fp, $new_podcast_file);
                            fclose($fp);

                            ?>
                            <!-- Places image in preview and podcast's page. As we couldn't parse images for podcasts,
                            we used template picture 'podcast_pic.jpg' for podcasts. -->
                            <a href="<?php echo $podcasts_path.$podcast_file_name?>" class="w3-hover-text-blue"><?php echo $results['episode_name'] ?></a></div>
                        <img src="../podcast_pic.jpg" style="width:100%">
                        <!-- Displays name of podcast in preview of podcast when it is shown as search result. -->
                        <p><?php echo $results['podcast_name'] ?></p>
                    </div>
                </div>
            <?php
        }

    }
    else{ // if there is no matching rows do following
        echo "No results";
    }

}
else{ // if query length is less than minimum
    echo "Minimum length is ".$min_length;
}
?>

</body>
</html>
<?php
function clean($string) {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

    return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
?>
