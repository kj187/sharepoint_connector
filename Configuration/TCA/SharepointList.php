<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_sharepointconnector_domain_model_sharepointlist'] = array(
	'ctrl' => $TCA['tx_sharepointconnector_domain_model_sharepointlist']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, default_view_url, id, title, description, name, feature_id, base_type, web_id, scope_id, allow_deletion',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, default_view_url, id, title, description, name, feature_id, base_type, web_id, scope_id, allow_deletion,--div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access,starttime, endtime'),
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
				'foreign_table' => 'tx_sharepointconnector_domain_model_sharepointlist',
				'foreign_table_where' => 'AND tx_sharepointconnector_domain_model_sharepointlist.pid=###CURRENT_PID### AND tx_sharepointconnector_domain_model_sharepointlist.sys_language_uid IN (-1,0)',
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
		'default_view_url' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.default_view_url',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.description',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'name' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'feature_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.feature_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'base_type' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.base_type',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			),
		),
		'web_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.web_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'scope_id' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.scope_id',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'allow_deletion' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_sharepointlist.allow_deletion',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
	),
);

?>