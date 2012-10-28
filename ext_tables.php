<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'aijko.' . $_EXTKEY,
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

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'aijko.' . $_EXTKEY,
		'sharepoint',	 // Make module a submodule of 'sharepoint'
		'mapping',	// Submodule key
		'',						// Position
		array(
			'ListMap' => 'list, new, create',
			
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/sharepoint.png',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mapping.xlf',
		)
	);

}

\TYPO3\CMS\Core\Extension\ExtensionManager::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Sharepoint Connector');

\TYPO3\CMS\Core\Extension\ExtensionManager::addLLrefForTCAdescr('tx_sharepointconnector_domain_model_listmap', 'EXT:sharepoint_connector/Resources/Private/Language/locallang_csh_tx_sharepointconnector_domain_model_listmap.xlf');
\TYPO3\CMS\Core\Extension\ExtensionManager::allowTableOnStandardPages('tx_sharepointconnector_domain_model_listmap');
$TCA['tx_sharepointconnector_domain_model_listmap'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:sharepoint_connector/Resources/Private/Language/locallang_db.xlf:tx_sharepointconnector_domain_model_listmap',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'sortby' => 'sorting',
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
		'searchFields' => 'title,',
		'dynamicConfigFile' => \TYPO3\CMS\Core\Extension\ExtensionManager::extPath($_EXTKEY) . 'Configuration/TCA/ListMap.php',
		'iconfile' => \TYPO3\CMS\Core\Extension\ExtensionManager::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_sharepointconnector_domain_model_listmap.gif'
	),
);

?>