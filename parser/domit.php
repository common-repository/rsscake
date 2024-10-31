<?php

include_once(dirname(__FILE__).'/domit/xml_domit_rss.php');

class RSSCake_DOMIT
{ 
	var $feed;
	
	// Caching
	var $cache;
	var $cachedir;
	var $cachetime;
	
	// Feed Parser
	var $FeedParser;
	
	function setFeed($feed){
		$this->feed = $feed;
		$this->cache = false;
	}
	
	function setCache($cachedir, $cachetime){
			$this->cache = true;
			$this->cachedir = $cachedir;
			$this->cachetime = $cachetime;
	}
		
	function init(){
		
		$feed = new xml_domit_rss_document($this->feed,$this->cachedir,$this->cachetime);
		
		// Get the first channel
		$this->FeedParser = $feed->getChannel(0);
	}
	
	function getFeed(){
		$image =& $this->FeedParser->getImage();
		$newfeed = new RSSCakeFeed;
		$newfeed->setTitle($this->FeedParser->getTitle());
		$newfeed->setLink($this->FeedParser->getLink());
		$newfeed->setImage($image->getUrl(),$image->getTitle());
		$newfeed->setDescription($this->FeedParser->getDescription());
		return $newfeed;
	}
	
	function getItems($start="",$max=""){
		
		$item = array();
	
		$itemCount = $this->FeedParser->getItemCount();
		
		if(empty($start) AND empty($max)){
			
			for($i = ($itemCount-1); $i >= 0; $i--){
				$item[$i] =& $this->FeedParser->getItem($i);
			}
			
		}else{		
		
			if($start > $max){
				$start = $max;
			}
			
			if($max > $itemCount){
				$max = $itemCount;
			}
		
			$x = 0 ;
			for($i = ($itemCount-1); $i >= 0 && $x <= $max; $i--){
				$item[$i] = $this->FeedParser->getItem($i);
				$x++;
			}
		
		}
				
		return $item;
	}	
		
	function ConvertItem($item){
			$newitem = new RSSCakeItem;
			
			$newitem->setTitle($item->getTitle());
			$newitem->setPermalink($item->getLink());
			$newitem->setDescription($item->getDescription());
			
			// Optional Elements of an item
			$newitem->setAuthor($item->getAuthor());
			$newitem->setEnclosure($item->getEnclosure());
			$newitem->setDate($item->getPubDate());
			
			return $newitem;
	}
}

RSSCake::register('domit',new RSSCake_DOMIT);
?>