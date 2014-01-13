<?php
namespace Aijko\SharepointConnector\Domain\Repository\Mapping;

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
 * Attribute mapping repository
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class AttributeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

	/**
	 * Sync attributes to find new attributes
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $sharepointListAttributes
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes
	 * @return array
	 */
	public function findAllNewAttributes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sharepointListAttributes, \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes) {
		$newAttributes = array();
		foreach ($sharepointListAttributes as $sharepointListAttribute) {

			// check if sharepoint attribute exist in typo3 list mapping
			foreach ($typo3ListAttributes as $typo3Attribute) {
				if ($typo3Attribute->getSharepointFieldName() == $sharepointListAttribute->getSharepointFieldName()) {
					continue 2; // if attribute exist, continue with next sharepoint attribute
				}
			}

			$newAttributes[] = $sharepointListAttribute;
		}

		return $newAttributes;
	}

	/**
	 * Sync attributes to find deprecated attributes
	 *
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $sharepointListAttributes
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes
	 * @return void
	 */
	public function syncAttributesToFindDeprecatedAttributes(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sharepointListAttributes, \TYPO3\CMS\Extbase\Persistence\ObjectStorage $typo3ListAttributes) {
		foreach ($typo3ListAttributes as $typo3Attribute) {
			foreach ($sharepointListAttributes as $sharepointListAttribute) {
				if ($typo3Attribute->getSharepointFieldName() == $sharepointListAttribute->getSharepointFieldName()) {
					continue 2; // if attribute exist, continue with next typo3 attribute
				}
			}

			$typo3Attribute->setStatus(\Aijko\SharepointConnector\Domain\Model\Mapping\Attribute::STATUS_DEPRECATED);
			$this->update($typo3Attribute);
		}
	}

}

?>