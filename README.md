AVClubRSS
=========

This is a simple PHP scrip to create your very own AVClub RSS feed. It means you can follow - by RSS - only the shows you want.

####How to use
All you have to do is either download the project, or clone it via Git. 

Extract it to your webserver. The required libraries are included with the project.

Open index.php, and add the URL of the shows you want to follow.

For example, if you want to follow Game of Thrones, Community and Parks and Recreation it would look like this:

```
$show_list = array(
			'http://www.avclub.com/tv/game-of-thrones-newbies/',
			'http://www.avclub.com/tv/community/',
			'http://www.avclub.com/tv/parks-and-recreation/',
		);
```

If you decide you want to add 30 Rock to your RSS feed, it would look like this:

```
$show_list = array(
			'http://www.avclub.com/tv/game-of-thrones-newbies/',
			'http://www.avclub.com/tv/community/',
			'http://www.avclub.com/tv/parks-and-recreation/',
			'http://www.avclub.com/tv/30-rock/',
		);
```

If you then decide you've had enough blood and gore and no longer like Game of Thrones, remove the URL from the list:

```
$show_list = array(
			'http://www.avclub.com/tv/community/',
			'http://www.avclub.com/tv/parks-and-recreation/',
			'http://www.avclub.com/tv/30-rock/',
		);
```

Once you've set the list up on your webserver, point your RSS reader at the URL.

So for example, if your website is hosted at example.com and you have cloned the project, the RSS Reader URL would be: http://example.com/AVClubRSS

The RSS Reader will do the rest.

####Warning
This is designed to work only with AVClub.com. The scraper is setup to follow each individual show page you have in the list.

Also, the commas and single inverted commas are important. So are both the brackets.


##### Thanks
Thanks to mibe who maintains [FeedWriter](https://github.com/mibe/FeedWriter) for the PHP library which creates the RSS feed.

Thanks to S.C. Chen who maitains [PHP Simple HTML DOM Parser](http://simplehtmldom.sourceforge.net/) which scrapes AVClub so it can be added to the RSS feed.


