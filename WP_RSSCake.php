<?php
/*
Plugin Name: RSS Cake
Plugin URI: http://www.artonesia.org
Description: RSSCake is evolution from Wordpress QuickRSS. More info visit <a href="http://www.artonesia.org">http://www.artonesia.org</a>  
Author: Abdul Ibad
Version: 0.1 Beta
Author URI: http://www.artonesia.org
*/

include(dirname(__FILE__).'/RSSCake.php');

$patterns[] = "%<!--\[RSSCAKE\](.*?)\[/RSSCAKE\]-->%";
$patterns[] = "%<!--\[RSSCAKE(=(.*?))\](.*?)\[/RSSCAKE\]-->%";
$patterns[] = "%\[RSSCAKE\](.*?)\[/RSSCAKE\]%";
$patterns[] = "%\[RSSCAKE(=(.*?))\](.*?)\[/RSSCAKE\]%";


// For QuickRSS Tags, uncomment this if you want to use QuickRSS tags
// $patterns[] = "%<!--\[QuickRSS\](.*?)\[/QuickRSS\]-->%";
// $patterns[] = "%(<!--\[QuickRSS=(.*?)\](.*?)\[/QuickRSS\]-->)%";
// $patterns[] = "%\[QuickRSS\](.*?)\[/QuickRSS\]%";
// $patterns[] = "%(\[QuickRSS=(.*?)\](.*?)\[/QuickRSS\])%";


class WP__RSSCake{

	var $feed;
	
	var $cache;
	
	var $cachedir;
	
	var $cachetime;

	var $params;
	
	var $template;
	
	function WP__RSSCake($feed=""){
		$this->setFeed($feed);
		}
	
	function setFeed($feed){
		$this->feed = $feed;
		}
		
	function setCache($cachedir,$cachetime){
		$this->cache = true;
		$this->cachedir = $cachedir;
		$this->cachetime = $cachetime;
		}
	
	function setParams($params){
		$this->params = $params;
		}
		
	function setTemplate($template){
		$this->template = $template;
		}

	function parse(){
		
		$rsscake = new RSSCake($this->feed,'simplepie');
	
		if($this->cache){
			$rsscake->setCache($this->cachedir,$this->cachetime);
		}
		
		$feedparser = $rsscake->init();
	
		if(!$feedparser){ return;}
		
		$feed = $feedparser->getFeed();
		
		$showFeedTitle = $this->params['ShowFeedTitle']=="TRUE" ? true : false;
		$showFeedImage = $this->params['ShowFeedImage']=="TRUE" ? true : false;
		$showFeedDescription = $this->params['ShowFeedDescription'] == "TRUE" ? true : false;
		$MaxItems = intval($this->params['ItemNumber']);
		$showItemDescription = $this->params['ItemDescription']=="FALSE" ? false : true;
		
		if($MaxItems != "" OR $MaxItems != 0){
			$items = $feedparser->getItems(0,$MaxItems);
		}else{
			$items = $feedparser->getItems();
		}	
		
		$template = $this->template;
		
		if(empty($template) || strstr($template,"default")){
			$template = RSSCAKE_TEMPLATE;
		}
		
		
		ob_start();
		
		include($template);	
	
		$content = ob_get_contents(); 
		
		ob_end_clean();
		
		return $content;
	}

}


function WP_RSSCake_Extract($matches){

		if(!empty($matches[3])){
			$feedurl = trim($matches[3]);
		}else{
			$feedurl = trim($matches[1]);
		}
		
		$params = explode(',',strtoupper($matches[2]));
		$rssParams = array("ShowFeedTitle"=>$params[0],
						   "ShowFeedImage"=>$params[1],
						   "ShowFeedDescription"=>$params[2],
						   "ItemNumber"=>$params[3],
						   "ItemDescription"=>$params[4]);
		
		$rsscake = new WP__RSSCake;
				
		$rsscake->setFeed($feedurl);
		
		$rsscake->setCache(dirname(__FILE__).'/cache/',5000);
		
		$rsscake->setParams($rssParams);
		
		$content = $rsscake->parse();
		
		return $content;
}

function WP_RSSCake_Content($content){
	
	global $patterns;
	
	foreach($patterns as $pattern){
		
		if(!preg_match($pattern,$content)){
			continue;
		}
		
		$content  = preg_replace_callback( $pattern ,'WP_RSSCake_Extract', $content);
	}
	
	return $content;
}

add_filter('the_content','WP_RSSCake_Content');


function WP_RSSCake($feed,$params,$template="default",$cache=""){

		$rsscake = new WP__RSSCake;
		
		if(is_array($cache) && !empty($cache)){
			$cachedir = $cache['dir'];
			$cachetime = $cache['time'];
		}else{
			$cachedir = dirname(__FILE__).'/cache/';
			$cachetime = 5000;
		}
		
		$rsscake->setFeed($feed);
		
		$rsscake->setCache($cachedir,$cachetime);
		
		$rsscake->setParams($params);
		
		$rsscake->setTemplate($template);
		
		$content = $rsscake->parse();
		
		return $content;
}

?>