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
class RSSCakeItem{

	var $title;
	
	var $link;
	
	var $description;
	
	var $author;
	
	var $enclosure;
	
	var $date;
		
	function setTitle($title){
		$this->title = $title;
	}
	
	function getTitle(){
		return $this->title;
	}
	
	function setPermalink($link){
		$this->link = $link;
	}
	
	function getPermalink(){
		return $this->link;
	}
	
	function setDescription($description){
			$this->description = $description;
	}
	
	function getDescription(){
		return $this->description;
	}
	
	function setAuthor($author){
		$this->author = $author;
	}
	
	function getAuthor(){
		return $this->author;
	}
	
	function setEnclosure($enclosure){
		$this->enclosure = $enclosure;
	}
	
	function getEnclosure(){
		return $this->enclosure;
	}
	
	function setDate($date){
		$this->date = $date;
	}
	
	function getDate(){
		return $this->date;
	}
}
?>