<?php
/*
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/


include(dirname(__FILE__).'/RSSCakeConfig.php');
include(dirname(__FILE__).'/RSSCakeFeed.php');
include(dirname(__FILE__).'/RSSCakeItem.php');

$engines = array();

class RSSCake{

	// Feed URL
	var $feed;
	
	// Engine/Feed Parser
	var $engine;

	// Cache
	var $cache;
	var $cachedir;
	var $cachetime;
	
	// RSSCake Engine
	var $RSSCakeEngine;
	
	function RSSCake($feed,$engine){
			
			$this->setFeed($feed);
			$this->setEngine($engine);
			$this->cache = false;
	}
	
	function setFeed($feed){
		$this->feed = $feed;
	}
	
	function setEngine($engine){
		$this->engine = $engine;
	}
		
	function setCache($cachedir,$cachetime){
		$this->cache = true;
		$this->cachedir = $cachedir;
		$this->cachetime = $cachetime;
	}
	
	function ConvertItem($items){
		return $this->RSSCakeEngine->ConvertItem($items);
	}
	
	function init(){
		global $engines;
				
		// if no feed parser define then use default feed parser	
		if(empty($this->engine)){
			$this->engine = RSSCAKE_FEEDPARSER;
		}
		
		$RSSCakeEngine = $engines[$this->engine];
		
		// if empty feed then false
		if(empty($this->feed)) return false;
		
		$RSSCakeEngine->setFeed($this->feed);
		
		$RSSCakeEngine->setCache($this->cachedir,$this->cachetime);
		
		// Initialize the feedparser
		$RSSCakeEngine->init();
		
		$this->RSSCakeEngine = $RSSCakeEngine;
		
		return $RSSCakeEngine;
	}
			
	function register($id,$class){
		global $engines;
		$engines[$id] = $class;
	}
	
	function loadParser(){
	
		$openeddir = opendir(RSSCAKE_FEEDPARSER_DIR);
		
		while($files = readdir($openeddir)){
		
			if($files != "." && $files != ".."){
				$ext = end(explode('.',$files));
				
				if(strtoupper($ext) == "PHP") include(RSSCAKE_FEEDPARSER_DIR.'/'.$files);			
			}
		
		}
		
		closedir($openeddir);
		
	}
}

RSSCake::loadParser();
?>