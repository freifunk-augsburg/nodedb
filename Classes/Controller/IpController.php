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
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('nodedb') . '/vendor/php-ip/ip.lib.php');

/**
 * IpController
 */
class IpController extends AbstractController
{

    /**
     * @var \C1\Nodedb\Domain\Validator\Ipv4Validator
     * @inject
     */
    protected $validatorIpv4;

//    protected function initializeAction()
//    {
//        parent::initializeAction();
//        $this->validatorIpv4 = \C1\Nodedb\Domain\Validator\Ipv4Validator
//    }

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
     * @ignorevalidation $ip
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
        $arguments = $this->request->getArguments();

        $node = intval($arguments['node']);
        if (is_int($node)) {
            $this->view->assign('node', $node);
        }
    }
    
    /**
     * action create
     *
     * @param \C1\Nodedb\Domain\Model\Ip $newIp
     * @return void
     */
    public function createAction(\C1\Nodedb\Domain\Model\Ip $newIp)
    {
        if (empty($this->currentUser)) {
            $this->addFlashMessage('You need to be logged in to create new IPs.', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
            $this->redirect('list');
        }

//        $errorsIp = $this->validatorIpv4->validate('abc');
//
//        if ($errorsIp->hasErrors()) {
//            // @Todo validation for ipv4 and ipv6
//            $validationResults = $this->controllerContext->getArguments()->getValidationResults();
//            $validationResults->addError($errorsIp->getFirstError());
//            //$this->addFlashMessage('Ip has errors.');
//            //$this->view->assign('$newIp', $newIp);
//            // this doesn't pass the newIp for some reason, @Todo
//            $this->redirect('error');
//            //$this->forward('new', null, null, array('newIp'=>$newIp));
//        };

        if (strpos($newIp->getIpaddr(), ':') !== true ) {
            $newIp->setFamily(6);
        };

        $arguments = $this->request->getArguments();
        //DebuggerUtility::var_dump($newIp, 'before');
        $node = intval($arguments['newIp']['node']);
        if (is_int($node)) {
            $nodeObj = $this->nodeRepository->findByUid($node);
            if ($nodeObj) {
                $newIp->addNode($nodeObj);
            }
        }

        //DebuggerUtility::var_dump($newIp, 'after');
        $newIp->addOwner($this->currentUser);

        // set last IP
        $block = \IPBlock::create($newIp->getIpaddr(), $newIp->getNetmask());
        //$lastIpInBlock = gmp_intval($block->getLastIp()->numeric());
        $lastIpInBlock = $block->getLastIp()->numeric();
        $newIp->setIpaddrLast($lastIpInBlock);

        $this->ipRepository->add($newIp);
        $this->addFlashMessage('Ip saved.');
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