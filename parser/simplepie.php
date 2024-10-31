<?php

if(!class_exists('SimplePie')){
	include_once(dirname(__FILE__).'/SimplePie/SimplePie.php');
}

class RSSCake_SimplePie
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
		
		$feed = new SimplePie();

		$feed->set_feed_url($this->feed);

		if($this->cache){
			$feed->enable_cache($this->cache);
			$feed->set_cache_location($this->cachedir);
			$cache_time = (intval($this->cachetime) / 60); //convery from seconds to minutes
			$feed->set_cache_duration($cache_time);
		}else{
			$feed->enable_cache($this->cache);
		}
		
		// initialise the feed parsing
		$feed->init();
		
		$this->FeedParser = $feed;
	}
	
	function getFeed(){
		$newfeed = new RSSCakeFeed;
		$newfeed->setTitle($this->FeedParser->get_title());
		$newfeed->setLink($this->FeedParser->get_link());
		$newfeed->setImage($this->FeedParser->get_image_url(),$this->FeedParser->get_image_title());
		$newfeed->setDescription($this->FeedParser->get_description());
		return $newfeed;
	}
	
	function getItems($start="",$max=""){
	
		$itemCount = $this->FeedParser->get_item_quantity();
	
		if($max > $itemCount){
			$max = $itemCount;
		}
	
		if(empty($start) AND empty($max)){
			$items = $this->FeedParser->get_items();
		}else{
			$items = $this->FeedParser->get_items(0,$max);
		}
		
		return $items;

	}
	
	// ConvertItem into similiar function
	function ConvertItem($item){
	
			$newitem = new RSSCakeItem;
		
			$newitem->setTitle($item->get_title());
			$newitem->setPermalink($item->get_permalink());
			$newitem->setDescription($item->get_description());
			
			// Optional Elements of an item
			$newitem->setAuthor($item->get_author());
			$newitem->setEnclosure($item->get_enclosure());
			$newitem->setDate($item->get_date());
			
			return $newitem;
	}
}

RSSCake::register('simplepie',new RSSCake_SimplePie);
?>