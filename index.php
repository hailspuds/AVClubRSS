<?
include 'simple_html_dom.php';
include 'Feeds/Item.php';
include 'Feeds/Feed.php';
include 'Feeds/RSS2.php';
use \FeedWriter\RSS2;
date_default_timezone_set('UTC');

//List of shows - to add a new show to your personalised RSS list, just add it to the array below.
$show_list = array(
			'http://www.avclub.com/tv/game-of-thrones-experts/', 
			'http://www.avclub.com/tv/game-of-thrones-newbies/',
			'http://www.avclub.com/tv/community/',
			'http://www.avclub.com/tv/parks-and-recreation/',
			
		);


//Code below

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
			$time = "";
			$date = "";
			foreach($tv_review->find('span.date') as $date)
			{
				$date = $date->plaintext;
			}
			foreach($tv_review->find('span.time') as $time)
			{
				$time = $time->plaintext;
			}						
			
			$each_episode['timedate'] = strtotime($date . $time);
			$each_episode['timedate_human'] = date('Y-m-d H:m', $each_episode['timedate']);
			array_push($episodes, $each_episode);
		}
	
	}
}

uasort($episodes, 'do_compare');

//Create Feed
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
	$feed->setDate($episode['timedate']);
	$feed->setDescription($episode['title'] . " - " . $episode['season'] . " " . $episode['episode']);
	
	$TestFeed->addItem($feed);
}

$TestFeed->printFeed();  


function do_compare($item1, $item2) {
    $ts1 = $item1['timedate'];
    $ts2 = $item2['timedate'];
    return $ts2 - $ts1;
}
?>

