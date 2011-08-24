<?php
/**
 * @version		$Id: default.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	mod_footer
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
            <h2><?php echo $title; ?></h2>
<?php foreach ($articles as $item) : ?>            
              <div class="article preview">
                <div class="photo">
                  <img src="/<?php echo $item->primaryimage; ?>" alt="" />
                  <div class="detail">
                    <div class="category"><?php echo $item->category_title; ?></div>
                    <div class="headline"><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>"><?php echo $item->title; ?></a></div>
                  </div>
                </div>
                <?php echo $item->introtext; ?>
                <div class="a">by <?php echo $item->author; ?></div>
                <div class="c"><a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid)); ?>#disqus_thread">(113)</a></div>
              </div>              
<?php endforeach; ?>