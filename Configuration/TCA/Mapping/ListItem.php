<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 aijko GmbH <info@aijko.de>
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

$TCA['tx_sharepointconnector_domain_model_mapping_listitem'] = array(
	'ctrl' => $TCA['tx_sharepointconnector_domain_model_mapping_listitem']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, sharepoint_list_identifier, sharepoint_list_title, typo3_list_title, attributes',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, sharepoint_list_identifier, sharepoint_list_title, typo3_list_title, attributes,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_sharepointconnector_domain_model_mapping_listitem',
				'foreign_table_where' => 'AND tx_sharepointconnector_domain_model_mapping_listitem.pid=###CURRENT_PID### AND tx_sharepointconnector_domain_model_mapping_listitem.sys_language_uid IN (-1,0)',
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
		'sharepoint_list_identifier' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_listitem.sharepoint_list_identifier',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'sharepoint_list_title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_listitem.sharepoint_list_title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required',
				'readOnly' => 1
			),
		),
		'typo3_list_title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_listitem.typo3_list_title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'attributes' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_mapping_listitem.attributes',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_sharepointconnector_domain_model_mapping_attribute',
				'foreign_field' => 'list_item',
				'maxitems'      => 9999,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1
				),
			),
		),
	),
);

?>