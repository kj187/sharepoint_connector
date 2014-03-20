<?php
$extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('sharepoint_connector');

return array(
	'Thybag\SharePointAPI' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/SharePointAPI.php',
	'Thybag\Service\ListService' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Service/List.php',
	'Thybag\Service\QueryObjectService' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Service/QueryObject.php',
	'Thybag\Auth\SoapClientAuth' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Auth/SoapClientAuth.php',
	'Thybag\Auth\StreamWrapperHttpAuth' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Auth/StreamWrapperHttpAuth.php',
);