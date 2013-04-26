<?php
namespace Aijko\SharepointConnector\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 aijko GmbH <info@aijko.de
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
 * Sharepoint API - REST Service
 *
 * @author Julian Kleinhans <julian.kleinhans@aijko.de>
 * @copyright Copyright belongs to the respective authors
 * @package sharepoint_connector
 */
class RestService implements \Aijko\SharepointConnector\Service\SharepointInterface {

	/**
	 * @var resource a cURL handle on success, false on errors.
	 */
	protected $curlHandler = FALSE;

	/**
	 * @var array
	 */
	protected $httpHeader = array();

	/**
	 * @var array
	 */
	protected $settings = array();

	/**
	 * @var string
	 */
	protected $prependUrl = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @var array
	 */
	protected $configuration;

	/**
	 *
	 */
	public function __construct() {
		$this->objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
		$this->configuration = $this->objectManager->get('Aijko\\SharepointConnector\\Configuration\\ConfigurationManager')->getConfiguration();

		$this->curlHandler = curl_init();
		curl_setopt($this->curlHandler, CURLOPT_HEADER, FALSE);
		curl_setopt($this->curlHandler, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($this->curlHandler, CURLOPT_FRESH_CONNECT, TRUE);
		curl_setopt($this->curlHandler, CURLOPT_RETURNTRANSFER, TRUE);

		if ($this->configuration['security']['ntlm']) {
			//Use NTLM for HTTP authentication
			curl_setopt($this->curlHandler, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		}

		curl_setopt($this->curlHandler, CURLOPT_USERPWD, $this->configuration['username'] . ':' . $this->configuration['password']);

		//Stop cURL from verifying the peer’s certification
		#curl_setopt($this->curlHandler, CURLOPT_SSL_VERIFYPEER, false);
	}

	/**
	 * @param bool $json
	 * @return mixed
	 */
	public function execute($json = TRUE) {
		$url = $this->configuration['url'] . $this->configuration['rest']['serviceUrl'] . $this->prependUrl;
		curl_setopt($this->curlHandler, CURLOPT_URL, $url);

		if ($json) {
			curl_setopt($this->curlHandler, CURLOPT_HTTPHEADER, $this->configuration['rest']['httpHeader']['json']);
			$returnValue = json_decode(curl_exec($this->curlHandler));
		} else {
			curl_setopt($this->curlHandler, CURLOPT_HTTPHEADER, $this->configuration['rest']['httpHeader']['default']);
			$returnValue = curl_exec($this->curlHandler);
		}

		if (isset($returnValue->error)) {
			Logger::error('cURL execution: execute', array(
				'code' => $returnValue->error->code,
				'value' => $returnValue->error->message->value,
			));
		}

		return $returnValue;
	}

	/**
	 * Get all available sharepoint lists
	 *
	 * TODO use a own Model instead
	 *
	 * return array(
	 * 		'listTitle' => 'listTitle',
	 * 		[...],
	 * )
	 *
	 * @return array
	 */
	public function getAllLists() {
		curl_setopt($this->curlHandler, CURLOPT_HTTPGET, TRUE);
		$returnValue = $this->execute();
		$lists = array();
		foreach ($returnValue->d->EntitySets as $list) {
			$lists[$list] = $list;
		}

		return $lists;
	}

	/**
	 * Get all available attributes from a specific sharepoint list
	 *
	 * TODO use a own Model instead
	 *
	 * return array(
	 * 		'listTitle' => array(
	 *			'0' => array(
	 * 				'sharepointFieldName' => 'xxx',
	 * 				'attributeType' => 'xxx',
	 * 				'typo3FieldName' => '',
	 * 			),
	 * 			[...]
	 * 		),
	 * 		[...]
	 * )
	 *
	 * @param string $listTitle
	 * @return array
	 */
	public function getListAttributes($listTitle) {
		$this->prependUrl = $this->configuration['rest']['oData']['metadata'];
		curl_setopt($this->curlHandler, CURLOPT_HTTPGET, TRUE);
		$returnValue = $this->execute(FALSE);

		Logger::info('cURL execution: getListAttributes', array(
			'listTitle' => $listTitle,
			'curlInfo' => curl_getinfo($this->curlHandler),
		));

		$domDocument = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('DOMDocument');
		$domDocument->loadXML($returnValue);

		$propertyData = array();
		foreach ($domDocument->getElementsByTagName('EntityType') as $node) {

			// TODO create dynamic listname
			// <EntitySet Name="TestList" EntityType="Microsoft.SharePoint.DataService.TestListItem"/>
			// <EntityType Name="TestListItem">

			if ($listTitle . 'Item' == $node->getAttribute('Name')) {
				$propertyIterator = 0;
				foreach ($node->getElementsByTagName('Property') as $propertyNode) {
					$propertyData[$listTitle][$propertyIterator]['sharepointFieldName'] = $propertyNode->getAttribute('Name');
					$propertyData[$listTitle][$propertyIterator]['attributeType'] = $propertyNode->getAttribute('Type');
					$propertyData[$listTitle][$propertyIterator]['typo3FieldName'] = '';
					$propertyIterator++;
				}
			}
		}

		return $propertyData;
	}

	/**
	 * @param string $listTitle
	 * @param array $data
	 * @return mixed
	 */
	public function addRecordToList($listTitle, array $data) {
		$this->prependUrl = '/' . $listTitle;
		curl_setopt($this->curlHandler, CURLOPT_POST, TRUE);
		curl_setopt($this->curlHandler, CURLOPT_POSTFIELDS, json_encode($data));
		$result = $this->execute();

		Logger::info('cURL execution: addToList', array(
			'curlInfo' => curl_getinfo($this->curlHandler),
			'data' => $data
		));

		return $result;
	}


}

?>