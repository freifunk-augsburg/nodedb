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
 * Ip4Controller
 */
class Ip4Controller extends AbstractController
{

    /** Disable Flash messages for this controller
    *
    * @return boolean
    */
    protected function getErrorFlashMessage() {
        return FALSE;
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $ips = $this->ip4Repository->findAll();
        $this->view->assign('ips', $ips);
    }

    /**
     * action manage
     *
     * @return void
     */
    public function manageAction()
    {
        if (empty($this->currentUser)) {
            $errmsg = LocalizationUtility::translate('tx_nodedb_domain_model_node.need_login', 'Nodedb');
            $this->addFlashMessage($errmsg, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('list');
        }

        $ips = $this->ip4Repository->findByOwner($this->currentUser);
        $this->view->assign('ips', $ips);
    }
    
    /**
     * action show
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip
     * @ignorevalidation $ip
     * @return void
     */
    public function showAction(\C1\Nodedb\Domain\Model\Ip4 $ip)
    {
        $this->view->assign('ip', $ip);
    }
    
    /**
     * action new
     * @ignorevalidation $newIp
     *
     * @return void
     */
    public function newAction()
    {
        $arguments = $this->request->getArguments();
        if (empty($this->currentUser)) {
            $this->addFlashMessage(
                LocalizationUtility::translate('ip_create_login_required', $this->extensionName),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('list');
        } else {
            //add users nodes
            $userNodes = $this->nodeRepository->findByOwner($this->currentUser);
            $this->view->assign('userNodes', $userNodes);
            $node = intval($arguments['node']);

            if (is_int($node)) {
                $this->view->assign('node', $node);
            }
        }

        if ($this->request->hasArgument('returnToUrl')) {
            $returnUrl = $this->request->getArgument('returnToUrl');
            $this->view->assign('returnToUrl', $returnUrl);
        }
    }

    /**
     * initialize create action
     *
     * @return void
     */
    public function initializeCreateAction() {
        if ($this->arguments->hasArgument('newIp')) {
            $this->arguments->getArgument('newIp')->getPropertyMappingConfiguration()->skipProperties('returnToUrl');
        }
    }

    /**
     * action create
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $newIp
     * @return void
     */
    public function createAction(\C1\Nodedb\Domain\Model\Ip4 $newIp)
    {
        if (empty($this->currentUser)) {
            $this->addFlashMessage(
                LocalizationUtility::translate('ip_create_login_required', $this->extensionName),
                '',
                \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
            );
            $this->redirect('list');
        }

//

        $arguments = $this->request->getArguments();
        $node = intval($arguments['newIp']['node']);
        if (is_int($node)) {
            $nodeObj = $this->nodeRepository->findByUid($node);
            if ($nodeObj) {
                $newIp->addNode($nodeObj);
            }
        }

        $returnUrl = $arguments['newIp']['returnToUrl'];

        $newIp->addOwner($this->currentUser);
        $this->ip4Repository->add($newIp);

        $this->addFlashMessage(
            LocalizationUtility::translate('ip_created', $this->extensionName, array(1 => $newIp->getIpaddr()))
        );
        if ($returnUrl) {
            $this->redirectToUri($returnUrl);
        } else {
            $this->redirect('list');
        }

    }
    
    /**
     * action edit
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip
     * @ignorevalidation $ip
     * @return void
     */
    public function editAction(\C1\Nodedb\Domain\Model\Ip4 $ip)
    {
        $this->hasAccess($ip);

        if (! empty($this->currentUser)) {
            //add users nodes
            $userNodes = $this->nodeRepository->findByOwner($this->currentUser);
            $this->view->assign('userNodes', $userNodes);
        }

        $this->view->assign('ip', $ip);
    }
    
    /**
     * action update
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip
     * @return void
     */
    public function updateAction(\C1\Nodedb\Domain\Model\Ip4 $ip)
    {
        $this->hasAccess($ip);

        $this->ip4Repository->update($ip);
        $this->addFlashMessage(
            LocalizationUtility::translate('ip_updated', $this->extensionName, array(1 => $ip->getIpaddr())),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
        );
        $this->forward('edit');
    }
    
    /**
     * action delete
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip
     * @ignorevalidation $ip
     * @return void
     */
    public function deleteAction(\C1\Nodedb\Domain\Model\Ip4 $ip)
    {
        $this->hasAccess($ip);
        $this->ip4Repository->remove($ip);
        $this->addFlashMessage(
            LocalizationUtility::translate('ip_deleted', $this->extensionName, array(1 => $ip->getIpaddr())),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK
        );
        $this->redirect('list');
    }

}