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

/**
 * IpController
 */
class IpController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * ipRepository
     *
     * @var \C1\Nodedb\Domain\Repository\IpRepository
     * @inject
     */
    protected $ipRepository = NULL;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $ips = $this->ipRepository->findAll();
        $this->view->assign('ips', $ips);
    }
    
    /**
     * action show
     *
     * @param \C1\Nodedb\Domain\Model\Ip $ip
     * @return void
     */
    public function showAction(\C1\Nodedb\Domain\Model\Ip $ip)
    {
        $this->view->assign('ip', $ip);
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
     * @param \C1\Nodedb\Domain\Model\Ip $newIp
     * @return void
     */
    public function createAction(\C1\Nodedb\Domain\Model\Ip $newIp)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->ipRepository->add($newIp);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param \C1\Nodedb\Domain\Model\Ip $ip
     * @ignorevalidation $ip
     * @return void
     */
    public function editAction(\C1\Nodedb\Domain\Model\Ip $ip)
    {
        $this->view->assign('ip', $ip);
    }
    
    /**
     * action update
     *
     * @param \C1\Nodedb\Domain\Model\Ip $ip
     * @return void
     */
    public function updateAction(\C1\Nodedb\Domain\Model\Ip $ip)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->ipRepository->update($ip);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \C1\Nodedb\Domain\Model\Ip $ip
     * @return void
     */
    public function deleteAction(\C1\Nodedb\Domain\Model\Ip $ip)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->ipRepository->remove($ip);
        $this->redirect('list');
    }

}