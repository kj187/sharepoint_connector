<?php
namespace Aijko\SharepointConnector\Cache;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 AIJKO GmbH <info@aijko.de
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Clear cache hook
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class ClearCacheHook implements \TYPO3\CMS\Backend\Toolbar\ClearCacheActionsHookInterface {

	/**
	 * Modifies CacheMenuItems array
	 *
	 * @param array $cacheActions Array of CacheMenuItems
	 * @param array $optionValues Array of AccessConfigurations-identifiers (typically  used by userTS with options.clearCache.identifier)
	 * @return void
	 */
	public function manipulateCacheActions(&$cacheActions, &$optionValues) {
		if ($GLOBALS['BE_USER']->isAdmin()) {
			$cacheActions[] = array(
				'id'    => 'sharepoint_connector',
				'title' => 'Clear sharepoint cache',
				'href'  => $this->backPath . 'tce_db.php?vC=' . $GLOBALS['BE_USER']->veriCode() . '&cacheCmd=sharepoint_connector&ajaxCall=1' . \TYPO3\CMS\Backend\Utility\BackendUtility::getUrlToken('tceAction'),
				'icon'  => \TYPO3\CMS\Backend\Utility\IconUtility::getSpriteIcon('actions-system-cache-clear-impact-medium')
			);
		}
	}

	/**
	 * This method is called by the CacheMenuItem in the Backend
	 *
	 * @param array $_params
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler
	 * @return void
	 */
	public static function clear(array $_params, \TYPO3\CMS\Core\DataHandling\DataHandler $dataHandler) {
		if (in_array($_params['cacheCmd'], array('all', 'sharepoint_connector')) && $GLOBALS['BE_USER']->isAdmin()) {
			$GLOBALS['BE_USER']->writelog(3, 1, 0, 0, 'User %s has cleared the cache (cacheCmd=%s)', array($GLOBALS['BE_USER']->user['username'], $_params['cacheCmd']));
			$GLOBALS['typo3CacheManager']->flushCachesByTag('spc');
		}
	}

}

?>