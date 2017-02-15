<?php
namespace C1\Nodedb\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Manuel Munz <t3dev@comuno.net>, comuno.net
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


use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * NodeController
 */
class AbstractController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * nodeRepository
     *
     * @var \C1\Nodedb\Domain\Repository\NodeRepository
     * @inject
     */
    protected $nodeRepository = NULL;

    /**
     * ip4Repository
     *
     * @var \C1\Nodedb\Domain\Repository\Ip4Repository
     * @inject
     */
    protected $ip4Repository = NULL;

    /**
     * current frontend user
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $currentUser;

    /**
     * frontendUserRepository
     *
     * @var \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository;

    /**
     * get the currently logged in user
     *
     * @return void
     */
    protected function getCurrentUser() {
        if ($GLOBALS['TSFE']->fe_user->user['uid'] > 0) {
            $this->currentUser = $this->frontendUserRepository->findByUid($GLOBALS['TSFE']->fe_user->user['uid']);
        }
    }

    /**
     * initialize
     *
     * @return void
     */
    protected function initializeAction() {
        parent::initializeAction();
        $this->getCurrentUser();
    }

    /**
     * check if a user has access to a node
     *
     * @param mixed
     * @return bool
     */
    public function hasAccess($object, $redirect=TRUE) {

        if ($redirect===TRUE && empty($this->currentUser)) {
            $this->addFlashMessage(
                LocalizationUtility::translate('tx_nodedb_domain_model_node.need_login', 'Nodedb'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('list');
        }

        if (! empty($this->currentUser)) {
            $owners = $object->getOwners();
            foreach ($owners as $key => $value) {
                if ($value === $this->currentUser) {
                    return true;
                }
            }
        }

        if ($redirect===TRUE) {
            $this->addFlashMessage(
                LocalizationUtility::translate('tx_nodedb_domain_model_node.access_denied', 'Nodedb'),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('list');
        }

        return false;
    }
}