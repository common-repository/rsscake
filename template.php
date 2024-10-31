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

?>

<div class="rsscake">

<?php if($showFeedTitle):?>
<div class="rsscake-feed-title">
<a href="<?php echo $feed->getLink();?>" title="<?php echo $feed->getTitle();?>">
<?php echo $feed->getTitle();?>
</a>
</div>
<?php endif;?>

<?php if($showFeedImage):?>
<div class="rsscake-feed-image">
<?php $image = $feed->getImage();?>
<img src="<?php echo $image['url'];?>" alt="<?php echo $image['title'];?>" />
</div>
<?php endif;?>

<?php if($showFeedDescription):?>
<div class="rsscake-feed-description">
<?php echo $feed->getDescription();?>
</div>
<?php endif;?>


<ul class="rsscake-items">
<?php 
foreach($items as $item):
	// ConvertItem to familiar object function
	$item = $feedparser->convertItem($item);
?>
	<li>
	<div class="rsscake-item-title">
	<a href="<?php echo $item->getPermalink();?>" title="<?php echo $item->getTitle();?>" target="_blank">
	<?php echo $item->getTitle();?>
	</a>
	</div>
	<?php 
	if($showItemDescription):
	?>
	<div class="rsscake-item-description">
	<?php 
		echo $item->getDescription();
	?>
	<br />

	</div>
	<?php endif; ?>
	</li>

<?php 
endforeach; 
?>
</ul>
<!-- Please don`t remove this copyright
<div class="rsscake-linkback">
<a href="http://www.artonesia.org">RSSCake/a>
</div>
-->
</div>