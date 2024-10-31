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


class RSSCakeFeed{

	var $title;

	var $link;
	
	var $image = array();
	
	var $description;
	
	// Optional elements
	var $language;
	
	var $copyright;
	
	var $pubDate;
	
	var $lastBuildDate;
	
	function setTitle($title){
		$this->title = $title;	
		}
		
	function getTitle(){
		return $this->title;
		}
	
	function setLink($link){
		$this->link = $link;
		}
		
	function getLink(){
		return $this->link;
		}

	function setImage($url,$title){
		$image['url'] = $url;
		$image['title'] = $title;
		$this->image = $image;
	}
	
	function getImage(){
		return $this->image;
	}
	
	function setDescription($description){
		$this->description = $description;
	}
	
	function getDescription(){
		return $this->description;
	}
	
	// Optional Elements of an feed
	
	function setLanguage($language){
		$this->language = $language;
	}
	
	function getLanguage(){
		return $this->language;
	}
	
	function setCopyright($copyright){
		$this->copyright = $copyright;
	}
	
	function getCopyright(){
		return $this->copyright;
	}
	
	function setPubDate($pubDate){
		$this->pubDate = $pubDate;
	}
	
	function getPubDate(){
		return $this->pubDate;
	}
	
	function setLastBuildDate($lastBuildDate){
		$this->lastBuildDate = $lastBuildDate;
	}
	
	function getLastBuildDate(){
		return $this->lastBuildDate;
	}
		
}

?>