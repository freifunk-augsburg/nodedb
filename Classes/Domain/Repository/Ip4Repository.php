<?php
namespace C1\Nodedb\Domain\Repository;

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

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('nodedb') . '/vendor/php-ip/ip.lib.php');

/**
 * The repository for Ips
 */
class Ip4Repository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * Inject the objectManager
     *
     * @param \TYPO3\CMS\Extbase\Object\ObjectManager objectManager
     * @return void
     */

    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function updateReferencesNode() {

        // update the reference index for the node field
        // counts references in the mm table for all ips and then updates the field 'node'.
        // this should be called every time ips are manipulated from the node object.
        // this is ugly, but i didn't find another way. If you happen to know one: please tell me!

        $ips = $this->findAll();

        foreach ($ips as $key => $ip) {
            $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                'uid',
                'tx_nodedb_node_ipnode_mm',
                'uid_foreign=' . $ip->getUid()
            );
            $rowsCount = $result->num_rows;

            $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                'tx_nodedb_domain_model_ip4',
                'uid=' . $ip->getUid(),
                array('node' => $rowsCount)
            );

        }
    }

    protected $defaultOrderings = array(
        // use network_first for sorting - first ip of the network in integer form
        'network_first' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    private function setFirstLast($newIp) {
        // set last IP
        $block = \IPBlock::create($newIp->getIpaddr(), $newIp->getNetmask());
        $firstIpInBlock = $block->getFirstIp()->numeric();
        $newIp->setNetworkFirst($firstIpInBlock);
        $lastIpInBlock = $block->getLastIp()->numeric();
        $newIp->setNetworkLast($lastIpInBlock);
        return $newIp;
    }

    public function update($newIp) {
        $newIp = $this->setFirstLast($newIp);
        parent::update($newIp);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $repository = $this->objectManager->get('C1\Nodedb\Domain\Repository\NodeRepository');
        $repository->updateReferencesIp4();
    }

    public function add($newIp) {
        $newIp = $this->setFirstLast($newIp);
        parent::add($newIp);
        $persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
        $persistenceManager->persistAll();
        $repository = $this->objectManager->get('C1\Nodedb\Domain\Repository\NodeRepository');
        $repository->updateReferencesIp4();
    }

    public function countByOverlapping($firstIpInBlock, $lastIpInBlock, $uid = 0) {
        $query = $this->createQuery();
        $query->getQuerySettings()->setIgnoreEnableFields(TRUE);
        $query->getQuerySettings()->setIncludeDeleted(TRUE);

        $constraints = array();
        $constraints2 = array();

        $constraints2[] = $query->logicalAnd(
            $query->greaterThanOrEqual('network_first', $firstIpInBlock),
            $query->lessThanOrEqual('network_first', $lastIpInBlock)
        );

        $constraints2[] = $query->logicalAnd(
            $query->greaterThanOrEqual('network_last', $firstIpInBlock),
            $query->lessThanOrEqual('network_last', $lastIpInBlock)
        );



        $constraintsFirstLast = $query->logicalOr($constraints2);

        $constraints[] = $constraintsFirstLast;

        if( $uid > 0) {
            $constraints[] = $query->logicalNot($query->equals('uid', $uid));
        }

        $query->matching($query->logicalAnd($constraints));
        return $query->execute()->count();
    }

    /**
     * find ip by owner
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @param array $storagePidOverride
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Ip4>
     */

    public function findByOwner(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser, $storagePidOverride = NULL) {

        if ($storagePidOverride !== NULL) {
            $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
            $querySettings->setStoragePageIds($storagePidOverride);
            $this->setDefaultQuerySettings($querySettings);
        }

        $query = $this->createQuery();
        $constraints = array();
        $constraints[] = $query->contains('owners', $frontendUser);
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

    /**
     * find usable ips by owner (unassigned or anycast or already assigned to this node)
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @param array $storagePidOverride
     * @param \C1\Nodedb\Domain\Model\Node $node
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Ip4>
     */

    public function findUsableByOwner(
        \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser,
        $storagePidOverride = NULL,
        \C1\Nodedb\Domain\Model\Node $node = NULL
    ) {

        if ($storagePidOverride !== NULL) {
            $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
            $querySettings->setStoragePageIds($storagePidOverride);
            $this->setDefaultQuerySettings($querySettings);
        }

        $query = $this->createQuery();
        $constraints = array();
        $constraintsOr = array();
        $constraints[] = $query->contains('owners', $frontendUser);
        //$constraintsUnused[] = $query->lessThan('node', 1);
        // needs another constraint to add all ips belonging to this node

        if ($node instanceof \C1\Nodedb\Domain\Model\Node) {
            $constraintsOr[] = $query->contains('node', $node);
        }
        $constraintsOr[] = $query->equals('anycast', 1);
        $constraintsOr[] = $query->lessThan('node', 1);
        $constraints[] = $query->logicalOr($constraintsOr);
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

}
