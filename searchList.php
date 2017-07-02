<?php
if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
  throw new \Exception('please run "composer require google/apiclient:~2.0" in "' . __DIR__ .'"');
}
require_once __DIR__ . '/vendor/autoload.php';

$keyword='';
$number;
$nextPage='';
$htmlBody = '';
$select=$_SERVER['REQUEST_URI'];
if(isset($_GET['nextPage'])){
    $nextPage = $_GET['nextPage'];
    $requestURL = $_SERVER['REQUEST_URI'];
    $url = strpos($requestURL,"&nextPage",0);
    $select = substr($requestURL,0,$url);
}

if(isset($_GET['query']) && isset($_GET['number'])){
    $keyword=$_GET['query'];
    $number=$_GET['number'];
    if($_GET['query']!=''){
        echo '關鍵字:'.$_GET['query'].'<br />';      
    }
    else{
        echo '無<br />';        
    }
    
    if($_GET['number']!=''){
        echo '數量:'.$_GET['number'].'<br />';  
    }
    else{
        echo '無number<br />';   
    }
    
    
    $DEVELOPER_KEY = 'AIzaSyCmIxo-TtHpnedhNpZtE-pD2489i7aX42w';
    $client = new Google_Client();
    $client->setDeveloperKey($DEVELOPER_KEY);
    // Define an object that will be used to make all API requests.
    $youtube = new Google_Service_YouTube($client);
    
    
    try {
    // Call the search.list method to retrieve results matching the specified
    // query term.
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
        'q' => $keyword,
        'maxResults' => $number,
        'type' => 'video',         
        'pageToken' => $nextPage,    
    ));
        
    $videos = '';
    $id='';
    $title='';
    // Add each result to the appropriate list, and then display the lists of
    // matching videos, channels, and playlists.
    foreach ($searchResponse['items'] as $searchResult) {      
        $id = 'https://www.youtube.com/watch?v='.$searchResult['id']['videoId'];
        $title = $searchResult['snippet']['title'];
        $videos .= $title."&nbsp;&nbsp;&nbsp;".$id."<br>";        
    }
    
    $nextPage=$searchResponse['nextPageToken'];
    echo 'nextPage = '.$nextPage."<br>";
    echo "<br>".$videos;
    
    } catch (Google_Service_Exception $e) {
        $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));
    } catch (Google_Exception $e) {
        $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
        htmlspecialchars($e->getMessage()));        
    }
}

echo '<p><a href="index.php">返回</a></p>';

$next = $select."&nextPage=".$nextPage;
$htmlBody .= <<<END
    <p><a href= $next >nextPage</a></p>
END;

echo $htmlBody;

