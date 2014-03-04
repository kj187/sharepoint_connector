<?php
$extensionClassesPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('sharepoint_connector');

return array(
	'Thybag\SharepointApi' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/SharePointAPI.php',
	'Thybag\Service\ListService' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Service/ListServiceService.php',
	'Thybag\Service\QueryObjectService' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Service/QueryObjectService.php',
	'Thybag\Auth\SoapClientAuth' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Auth/SoapClientAuth.php',
	'Thybag\Auth\StreamWrapperHttpAuth' => $extensionClassesPath . 'Resources/Private/Php/PHP-SharePoint-Lists-API/lib/Thybag/Auth/StreamWrapperHttpAuth.php',
);

?>