<?php
namespace Aijko\SharepointConnector\Utility;

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

use \Aijko\SharepointConnector\Utility\Logger;

/**
 * Mapping
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class Mapping {

	/**
	 * Convert users post-data-array to correct sharepoint data array
	 *
	 * @param \Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list
	 * @param array $data
	 * @return array
	 */
	public function convertToSharepointData(\Aijko\SharepointConnector\Domain\Model\Mapping\Lists $list, array $data) {
		$returnData = array();
		foreach ($list->getAttributes() as $key => $attribute) {
			if (array_key_exists($attribute->getTypo3FieldName(), $data)) {
				$returnData[$attribute->getSharepointFieldName()] = $data[$attribute->getTypo3FieldName()];
			}
		}

		if (!count($returnData)) {
			Logger::error('Could not map user data with mapping (list: ' . $list->getTypo3ListTitle() . ':Uid:' . $list->getUid() . '). Cant find matched attributes.', $data);
		}

		return $returnData;
	}

}

?>