<?php
namespace Aijko\SharepointConnector\Sharepoint\Rest;

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

use \Aijko\SharepointConnector\Utility\Logger;

/**
 * Sharepoint API Service
 *
 * TODO - error handling
 * TODO - XML caching
 *
 * @package sharepoint_connector
 */
class Sharepoint implements \Aijko\SharepointConnector\Sharepoint\SharepointInterface {

	/**
	 * @var resource a cURL handle on success, false on errors.
	 */
	protected $curlObject = FALSE;

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
	 * @param array $settings
	 */
	public function initialize(array $settings) {
		$this->settings = $settings;

		$this->curlObject = curl_init();
		curl_setopt($this->curlObject, CURLOPT_HEADER, FALSE);
		curl_setopt($this->curlObject, CURLOPT_AUTOREFERER, TRUE);
		curl_setopt($this->curlObject, CURLOPT_FRESH_CONNECT, TRUE);
		curl_setopt($this->curlObject, CURLOPT_RETURNTRANSFER, TRUE);

		if ($this->settings['security']['ntlm']) {
			//Use NTLM for HTTP authentication
			curl_setopt($this->curlObject, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
		}

		curl_setopt($this->curlObject, CURLOPT_USERPWD, $this->settings['username'] . ':' . $this->settings['password']);

		//Stop cURL from verifying the peer’s certification
		#curl_setopt($this->curlObject, CURLOPT_SSL_VERIFYPEER, false);
	}

	/**
	 * @param bool $json
	 * @return mixed
	 */
	protected function execute($json = TRUE) {
		$url = $this->settings['url'] . $this->settings['rest']['serviceUrl'] . $this->prependUrl;
		curl_setopt($this->curlObject, CURLOPT_HTTPHEADER, $this->settings['rest']['httpHeader']);
		curl_setopt($this->curlObject, CURLOPT_URL, $url);

		if ($json) {
			curl_setopt($this->curlObject, CURLOPT_HTTPHEADER, array(
				'Accept: application/json'
			));
			$returnValue = json_decode(curl_exec($this->curlObject));
		} else {
			$returnValue = curl_exec($this->curlObject);
		}

		if (isset($returnValue->error)) {
			Logger::error('cURL execution: execute', array(
				'value' => $returnValue->error->message->value,
			));
		}

		return $returnValue;
	}

	/**
	 * @param string $listTitle
	 * @param array $data
	 * @return mixed
	 */
	public function addToList($listTitle, array $data) {
		$this->prependUrl = '/' . $listTitle;
		curl_setopt($this->curlObject, CURLOPT_POST, TRUE);
		curl_setopt($this->curlObject, CURLOPT_POSTFIELDS, json_encode($data));
		$result = $this->execute();

		Logger::info('cURL execution: addToList', array(
			'curlInfo' => curl_getinfo($this->curlObject),
			'data' => $data
		));

		return $result;
	}

	/**
	 * @return array
	 */
	public function getAllLists() {
		curl_setopt($this->curlObject, CURLOPT_HTTPGET, TRUE);
		$returnValue = $this->execute();
		$lists = array();
		foreach ($returnValue->d->EntitySets as $list) {
			$lists[$list] = $list;
		}

		return $lists;
	}

	/**
	 * @param $listTitle
	 * @return array
	 */
	public function getListAttributes($listTitle) {
		$this->prependUrl = $this->settings['rest']['oData']['metadata'];
		curl_setopt($this->curlObject, CURLOPT_HTTPGET, TRUE);
		$returnValue = $this->execute(FALSE);

		Logger::info('cURL execution: getListAttributes', array(
			'listTitle' => $listTitle,
			'curlInfo' => curl_getinfo($this->curlObject),
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


}

?>