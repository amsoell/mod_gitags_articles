<?php
/**
 * @version		$Id: helper.php 21766 2011-07-08 12:20:23Z eddieajau $
 * @package		Joomla.Site
 * @subpackage	mod_articles_archive
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

class modGitTagArticles
{
	static function getArticles(&$params)
	{
		//get database
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$query->select('DISTINCT CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(":", a.id, a.alias) ELSE a.id END as slug, a.id, a.catid, a.title, a.primaryimage, a.primaryimagecaption, a.primaryimagealign, a.introtext, u.name AS author, u.id AS user_id, CASE WHEN CHAR_LENGTH(c.alias) THEN CONCAT_WS(":", c.id, c.alias) ELSE c.id END as catslug, c.title as category_title, MONTH(created) AS created_month, created');
		$query->from('#__content a INNER JOIN #__users u ON a.created_by=u.id INNER JOIN #__categories c ON a.catid=c.id INNER JOIN #__gitags_items i ON a.id=i.item_id INNER JOIN #__gitags_tags t ON i.tag_id=t.tag_id ');
		$query->where("a.state = 1 AND a.checked_out = 0 AND LCASE(t.name)='".addslashes(strtolower($params->get('tag')))."'");
		$query->order('publish_up DESC');


		$db->setQuery($query, 0, intval($params->get('count')));
		$rows = (array) $db->loadObjectList();

		$app	= JFactory::getApplication();
		$menu	= $app->getMenu();
		$item	= $menu->getItems('link', 'index.php?option=com_content&view=archive', true);
		$itemid = isset($item) ? '&Itemid='.$item->id : '';

		$i		= 0;
		$lists	= array();
		foreach ($rows as $row) {
			$date = JFactory::getDate($row->created);

			$created_month	= $date->format('n');
			$created_year	= $date->format('Y');

			$created_year_cal	= JHTML::_('date', $row->created, 'Y');
			$month_name_cal	= JHTML::_('date', $row->created, 'F');

			$lists[$i] = new stdClass;

      $lists[$i]->id = $row->id;
      $lists[$i]->slug = $row->slug;
      $lists[$i]->catid = $row->catid;
      $lists[$i]->title = $row->title;
      $lists[$i]->primaryimage = $row->primaryimage;
      $lists[$i]->primaryimagecaption = $row->primaryimagecaption;
      $lists[$i]->primaryimagealign = $row->primaryimagealign;
      $lists[$i]->introtext = $row->introtext;
			$lists[$i]->link	= JRoute::_('index.php?option=com_content&id='.$row->id);
			$lists[$i]->text	= JText::sprintf('MOD_ARTICLES_ARCHIVE_DATE', $month_name_cal, $created_year_cal);
			$lists[$i]->author = $row->author;
			$lists[$i]->category_title = $row->category_title;
			$lists[$i]->catslug = $row->catslug;

			$i++;
		}
		return $lists;
	}
}
