<?php
namespace Aijko\SharepointConnector\Sharepoint;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
 *  Erik Frister <ef@aijko.de>, aijko GmbH
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
 * Sharepoint interface
 *
 * @package sharepoint_connector
 */
interface SharepointInterface {

	/**
	 * @return array
	 * @api
	 */
	public function getAllLists();

	/**
	* @param $listTitle
	* @return array
	* @api
	*/
	public function getListAttributes($listTitle);

	/**
	 * Add to multiple lists
	 *
	 * 		$data[LIST_UID][ATTRIBUTE_NAME]
	 *
	 * @param array $data
	 * @return array
	 * @api
	 */
	public function addToMultipleLists(array $data);

	/**
	 * @param $listTitle
	 * @param array $data
	 * @return FALSE|xml
	 * @api
	 */
	public function addToList($listTitle, array $data);

	/**
	 * @param integer $uid
	 * @return object
	 * @api
	 */
	public function getListMappingByUid($uid);

	/**
	 * @param integer $uid
	 * @return object
	 * @api
	 */
	public function getListMappingAttributeByUid($uid);
}

?>