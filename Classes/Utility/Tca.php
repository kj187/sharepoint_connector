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

/**
 *  Sharepoint userFunc class
 */
class Tca {

	const TABLE_LISTMAPPING = 'tx_sharepointconnector_domain_model_listmapping';
	const TABLE_LISTMAPPING_ATTRIBUTE = 'tx_sharepointconnector_domain_model_listmappingattribute';

	/**
	 * Get all available listMappings
	 *
	 * @param array $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $formObject
	 * @return string
	 */
	public function getAvailableMappings(array $PA, \TYPO3\CMS\Backend\Form\FormEngine $formObject) {
		$resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery('uid, typo3_list_title', self::TABLE_LISTMAPPING, 'deleted = 0 ' . \TYPO3\CMS\Backend\Utility\BackendUtility::BEenableFields(self::TABLE_LISTMAPPING));
		$selectOption = array();
		$selectBox = '<select name="' . $PA['itemFormElName'] . '" onchange="' . htmlspecialchars(implode('', $PA['fieldChangeFunc'])) . '" ' . $PA['onFocus'] . '>';
		$selectOption[] = '<option value=""></option>';
		if (is_resource($resource) && $GLOBALS['TYPO3_DB']->sql_num_rows($resource)>0) {
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resource)) {
				$selected = ($row['uid'] == $PA['itemFormElValue'] ? 'selected="selected"' : '');
				$selectOption[] = '<option ' . $selected . ' value="' . $row['uid'] . '">' . $row['typo3_list_title'] . '</option>';
			}
		}

		$selectBox .= implode(chr(10), $selectOption);
		$selectBox .= '</select>';

		return $selectBox;
	}

	/**
	 * Get all available listMappings
	 *
	 * @param array $PA
	 * @param \TYPO3\CMS\Backend\Form\FormEngine $formObject
	 * @return string
	 */
	public function getAttributesFromMapping(array $PA, \TYPO3\CMS\Backend\Form\FormEngine $formObject) {
		$resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', self::TABLE_LISTMAPPING_ATTRIBUTE, 'listmapping = ' . (int)$PA['row']['sharepoint_list'] . ' AND deleted = 0 ' . \TYPO3\CMS\Backend\Utility\BackendUtility::BEenableFields(self::TABLE_LISTMAPPING_ATTRIBUTE));
		$selectOption = array();
		$selectBox = '<select name="' . $PA['itemFormElName'] . '" onchange="' . htmlspecialchars(implode('', $PA['fieldChangeFunc'])) . '" ' . $PA['onFocus'] . '>';
		$selectOption[] = '<option value=""></option>';
		if (is_resource($resource) && $GLOBALS['TYPO3_DB']->sql_num_rows($resource)>0) {
			while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resource)) {
				$selected = ($row['uid'] == $PA['itemFormElValue'] ? 'selected="selected"' : '');
				$selectOption[] = '<option ' . $selected . ' value="' . $row['uid'] . '">' . $row['typo3_field_name'] . '</option>';
			}
		}

		$selectBox .= implode(chr(10), $selectOption);
		$selectBox .= '</select>';

		return $selectBox;
	}
}

?>