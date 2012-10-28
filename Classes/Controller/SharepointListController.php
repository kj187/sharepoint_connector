<?php
namespace aijko\SharepointConnector\Controller;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Erik Frister <erik.frister@aijko.de>, aijko GmbH
 *  Julian Kleinhans <julian.kleinhans@aijko.de>, aijko GmbH
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
 *
 *
 * @package sharepoint_connector
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class SharepointListController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * sharepointListRepository
	 *
	 * @var \aijko\SharepointConnector\Domain\Repository\SharepointListRepository
	 * @inject
	 */
	protected $sharepointListRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$sharepointLists = $this->sharepointListRepository->findAll();
		$this->view->assign('sharepointLists', $sharepointLists);
	}

	/**
	 * action show
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList
	 * @return void
	 */
	public function showAction(\aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList) {
		$this->view->assign('sharepointList', $sharepointList);
	}

	/**
	 * action new
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\SharepointList $newSharepointList
	 * @dontvalidate $newSharepointList
	 * @return void
	 */
	public function newAction(\aijko\SharepointConnector\Domain\Model\SharepointList $newSharepointList = NULL) {
		if ($newSharepointList == NULL) { // workaround for fluid bug ##5636
			$newSharepointList = t3lib_div::makeInstance('');
		}
		$this->view->assign('newSharepointList', $newSharepointList);
	}

	/**
	 * action create
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\SharepointList $newSharepointList
	 * @return void
	 */
	public function createAction(\aijko\SharepointConnector\Domain\Model\SharepointList $newSharepointList) {
		$this->sharepointListRepository->add($newSharepointList);
		$this->flashMessageContainer->add('Your new SharepointList was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList
	 * @return void
	 */
	public function editAction(\aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList) {
		$this->view->assign('sharepointList', $sharepointList);
	}

	/**
	 * action update
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList
	 * @return void
	 */
	public function updateAction(\aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList) {
		$this->sharepointListRepository->update($sharepointList);
		$this->flashMessageContainer->add('Your SharepointList was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList
	 * @return void
	 */
	public function deleteAction(\aijko\SharepointConnector\Domain\Model\SharepointList $sharepointList) {
		$this->sharepointListRepository->remove($sharepointList);
		$this->flashMessageContainer->add('Your SharepointList was removed.');
		$this->redirect('list');
	}

}
?>