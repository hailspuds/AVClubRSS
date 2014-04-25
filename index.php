<?
include 'simple_html_dom.php';

include 'Feeds/Item.php';
include 'Feeds/Feed.php';
include 'Feeds/RSS2.php';

// RSS TV SHOW LIST
$show_list = array(
			'http://www.avclub.com/tv/game-of-thrones-experts/', 
			'http://www.avclub.com/tv/game-of-thrones-newbies/',
		);
$episodes = array();


foreach ($show_list as $key => $show) 
{
	$html = file_get_html($show);

	foreach($html->find('.article-list') as $element)
	{
	
		foreach($element->find('.item') as $tv_review)
		{
			$each_episode = array();
			foreach($tv_review->find('h1.heading a[title]') as $title)
			{
				$each_episode['title'] = htmlspecialchars_decode(trim($title->title));
			}
			foreach($tv_review->find('h1.heading a') as $link)
			{
				$each_episode['url'] = "http://www.avclub.com" . $link->href;
			}		

			foreach($tv_review->find('span.season') as $season)
			{
				$each_episode['season'] = trim($season->plaintext);
			}
			foreach($tv_review->find('span.episode') as $episode)
			{
				$each_episode['episode'] = trim($episode->plaintext);
			}		
			array_push($episodes, $each_episode);
		}
	
	}
}

//Create Feed
date_default_timezone_set('UTC');
use \FeedWriter\RSS2;
$TestFeed = new RSS2;

//Use wrapper functions for common channel elements
$TestFeed->setTitle('AV Club - Personal Feed');
$TestFeed->setLink('http://www.avclub.com');
$TestFeed->setDescription('My personal feed for AV Club, based on a list of shows I tell it to check.');

foreach ($episodes as $key => $episode) 
{
	$feed = $TestFeed->createNewItem();
	$feed->setTitle($episode['title']);
	$feed->setLink($episode['url']);
	$feed->setDate(time());
	$feed->setDescription($episode['title'] . " - " . $episode['season'] . " " . $episode['episode']);
	
	$TestFeed->addItem($feed);
}

$TestFeed->printFeed();  
//print_r($episodes);
/*
    [17] => Array
        (
            [title] => Community: “Repilot”/“Introduction To Teaching”
            [url] => http://www.avclub.com/tvclub/repilotintroduction-to-teaching-106548
            [season] => Season 5
            [episode] => Episode 2
        )
*/
?>

