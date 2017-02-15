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
class NodeController extends AbstractController
{

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $nodes = $this->nodeRepository->findAll();

        $this->view->assign('nodes', $nodes);
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

        $nodes = $this->nodeRepository->findByOwner($this->currentUser);
        $this->view->assign('nodes', $nodes);
    }

    
    /**
     * action show
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @ignorevalidation $node
     * @return void
     */
    public function showAction(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->view->assign('hasAccess', $this->hasAccess($node, FALSE));
        $this->view->assign('node', $node);
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        $userIp4Addresses = $this->ip4Repository->findByOwner($this->currentUser);
        //$this->view->assign('returnToUrl', $this->uriBuilder->getRequest()->getRequestUri());
        $this->view->assign('userIp4Addresses', $userIp4Addresses);
    }
    
    /**
     * action create
     *
     * @param \C1\Nodedb\Domain\Model\Node $newNode
     * @return void
     */
    public function createAction(\C1\Nodedb\Domain\Model\Node $newNode)
    {
        if (empty($this->currentUser)) {
            $errmsg = LocalizationUtility::translate('create_node_login_required', 'Nodedb');
            $this->addFlashMessage($errmsg, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('list');
        }
        $newNode->addOwner($this->currentUser);
        $this->nodeRepository->add($newNode);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $this->addFlashMessage(LocalizationUtility::translate('tx_nodedb_domain_model_node.node_added', 'Nodedb'));
        // redirect to edit action to be able to add IPs
        $this->redirect('edit', NULL, NULL, array('node' => $newNode->getUid()));
    }
    
    /**
     * action edit
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @ignorevalidation $node
     * @return void
     */
    public function editAction(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->hasAccess($node);
        $userIp4Addresses = $this->ip4Repository->findUsableByOwner($this->currentUser, NULL, $node);
        $url = $this->uriBuilder->getRequest()->getRequestUri();
        $this->view->assign('userIp4Addresses', $userIp4Addresses);
        $this->view->assign('showIpSelect', '1');
        $this->view->assign('node', $node);
        $this->view->assign('returnToUrl', $url);
    }

    /**
     * initialize create action
     *
     * @return void
     */
    public function initializeUpdateAction() {
        if ($this->arguments->hasArgument('node')) {
            $this->arguments->getArgument('node')->getPropertyMappingConfiguration()->skipProperties('returnToUrl');
        }
    }
    
    /**
     * action update
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @return void
     */
    public function updateAction(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->hasAccess($node);
        $arguments = $this->request->getArguments();
        $this->addFlashMessage(
            LocalizationUtility::translate('tx_nodedb_domain_model_node.node_updated', 'Nodedb'),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);

        $this->nodeRepository->update($node);

        $returnUrl = $arguments['node']['returnToUrl'];

        if ($returnUrl) {
            $this->redirectToUri($returnUrl);
        } else {
            $this->redirect('list');
        }
    }
    
    /**
     * action delete
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @return void
     */
    public function deleteAction(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->hasAccess($node);
        $errmsg = LocalizationUtility::translate(
            'node_deleted',
            'Nodedb',
            array(1 => $node->getHostname())
        );
        $this->addFlashMessage($errmsg, '', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        $this->nodeRepository->remove($node);

        $this->redirect('list');
    }

}