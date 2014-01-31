<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 AIJKO GmbH <info@aijko.de>
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

if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_sharepointconnector_domain_model_mapping_attribute'] = array(
	'ctrl' => $TCA['tx_sharepointconnector_domain_model_mapping_attribute']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sharepoint_display_name, sharepoint_field_name, typo3_field_name, type, required, lookuplist, sourceid',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, sharepoint_display_name, sharepoint_field_name, typo3_field_name, type, required, lookuplist, sourceid,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_sharepointconnector_domain_model_mapping_attribute',
				'foreign_table_where' => 'AND tx_sharepointconnector_domain_model_mapping_attribute.pid=###CURRENT_PID### AND tx_sharepointconnector_domain_model_mapping_attribute.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'sharepoint_field_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.sharepoint_field_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'sharepoint_display_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.sharepoint_display_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'typo3_field_name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.typo3_field_name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'type' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.type',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'required' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.required',
			'config' => array(
				'type' => 'check',
				'readOnly' => 1
			),
		),
		'lookuplist' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.lookuplist',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'sourceid' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_attribute.sourceid',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'list' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);

?>