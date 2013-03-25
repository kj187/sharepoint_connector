<?php
namespace Aijko\SharepointConnector\Utility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
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

use \Aijko\SharepointConnector\Utility\Logger;

/**
 * Mapping class
 *
 * @package sharepoint_connector
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Mapping {

	/**
	 * Convert data from array to correct sharepoint data array
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping
	 * @param array $data
	 * @return array
	 */
	public function convertToSharepointData(\Aijko\SharepointConnector\Domain\Model\ListMapping $listMapping, array $data) {
		$returnData = array();
		foreach ($listMapping->getAttributes() as $key => $attribute) {
			if (array_key_exists($attribute->getTypo3FieldName(), $data)) {
				$returnData[$attribute->getSharepointFieldName()] = $data[$attribute->getTypo3FieldName()];
			}
		}

		if (!count($returnData)) {
			Logger::error('Could not map user data with mapping (list: ' . $listMapping->getTypo3ListTitle() . ':Uid:' . $listMapping->getUid() . '). Cant find matched attributes.', $data);
		}

		return $returnData;
	}

}

?>