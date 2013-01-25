<?php

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

if (!defined('TYPO3_MODE')) die ('Access denied.');


if (TYPO3_MODE === 'BE') {


	//
	// Main Module
	//

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Aijko.' . $_EXTKEY,
		'sharepoint',	 // Make module a master module
		'',	// Submodule key
		'',						// Position
		array(),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/sharepoint.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_sharepoint.xlf',
		)
	);


	//
	// Mapping Module
	//

	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'Aijko.' . $_EXTKEY,
		'sharepoint',	 // Make module a submodule of 'web'
		'mapping',	// Submodule key
		'',						// Position
		array(
			'ListMapping' => 'list, newStep1, newStep2, create, edit, update, delete',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/ext_icon.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mapping.xlf',
		)
	);

}

//
// Add static typoscript file
//

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Sharepoint Connector');



//
// Add pageTSConfig
//

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('mod.web_list.hideTables := addToList(tx_sharepointconnector_domain_model_listmappingattribute)');



//
//
//

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sharepointconnector_domain_model_listmapping', 'EXT:sharepoint_connector/Resources/Private/Language/locallang_csh_tx_sharepointconnector_domain_model_listmapping.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sharepointconnector_domain_model_listmapping');
$TCA['tx_sharepointconnector_domain_model_listmapping'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_listmapping',
		'label' => 'typo3_list_title',
		'label_alt' => 'sharepoint_list_identifier',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'sharepoint_list_identifier,typo3_list_title,attributes,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/ListMapping.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_sharepointconnector_domain_model_listmapping.gif'
	),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_sharepointconnector_domain_model_listmappingattribute', 'EXT:sharepoint_connector/Resources/Private/Language/locallang_csh_tx_sharepointconnector_domain_model_listmappingattribute.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sharepointconnector_domain_model_listmappingattribute');
$TCA['tx_sharepointconnector_domain_model_listmappingattribute'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_listmappingattribute',
		'label' => 'typo3_field_name',
		'label_alt' => 'sharepoint_field_name',
		'label_alt_force' => TRUE,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'versioningWS' => 2,
		'versioning_followPages' => TRUE,
		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'sharepoint_field_name,typo3_field_name,attribute_type,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath($_EXTKEY) . 'Configuration/TCA/ListMappingAttribute.php',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_sharepointconnector_domain_model_listmappingattribute.gif'
	),
);

?>