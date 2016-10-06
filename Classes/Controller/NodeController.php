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
        $this->view->assign('node', $node);
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        
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
            $this->addFlashMessage('You need to be logged in to create new nodes.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('list');
        }

        $newNode->addOwner($this->currentUser);
        $this->nodeRepository->add($newNode);
        $this->addFlashMessage('Node added.');
        $this->redirect('list');
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
        $this->hasAccess($node->getUid());
        $this->view->assign('node', $node);
    }
    
    /**
     * action update
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @return void
     */
    public function updateAction(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->hasAccess($node->getUid());
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->nodeRepository->update($node);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @return void
     */
    public function deleteAction(\C1\Nodedb\Domain\Model\Node $node)
    {
        $this->hasAccess($node->getUid());
        $this->addFlashMessage('Node deleted.');
        $this->nodeRepository->remove($node);
        $this->redirect('list');
    }

}