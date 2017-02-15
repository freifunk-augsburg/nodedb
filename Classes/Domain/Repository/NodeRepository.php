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

/**
 * The repository for Nodes
 */
class NodeRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
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

    public function updateReferencesIp4() {

        // update the reference index for the ips field
        // counts references in the mm table for all nodes and then updates the field 'ip4'.
        // this should be called every time noddes are manipulated from the ip4 object.
        // this is ugly, but i didn't find another way. If you happen to know one: please tell me!

        $nodes = $this->findAll();

        foreach ($nodes as $key => $node) {
            $result = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                'uid',
                'tx_nodedb_node_ipnode_mm',
                'uid_local=' . $node->getUid()
            );

            $rowsCount = $result->num_rows;

            $GLOBALS['TYPO3_DB']->exec_UPDATEquery(
                'tx_nodedb_domain_model_node',
                'uid=' . $node->getUid(),
                array('ips' => $rowsCount)
            );

        }
    }

    protected $defaultOrderings = array(
        'hostname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING
    );

    public function update($newNode) {
        parent::update($newNode);
        $repository = $this->objectManager->get('C1\Nodedb\Domain\Repository\Ip4Repository');
        $repository->updateReferencesNode();
    }

    public function add($newNode) {
        parent::add($newNode);
        $repository = $this->objectManager->get('C1\Nodedb\Domain\Repository\Ip4Repository');
        $repository->updateReferencesNode();
    }


    public function countByProperty($property, $value, $uid = 0) {
        $query = $this->createQuery();

        $constraints = array();
        $constraints[] = $query->equals($property, $value);
        if( $uid > 0) {
            $constraints[] = $query->logicalNot($query->equals('uid', $uid));
        }
        $query->matching($query->logicalAnd($constraints));
        return $query->execute()->count();
    }

    /**
     * find node by owner
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser
     * @param array $storagePidOverride
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\C1\Nodedb\Domain\Model\Node>
     */

    public function findByOwner(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $frontendUser, $storagePidOverride = NULL) {

        if ($storagePidOverride !== NULL) {
            $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
            //$querySettings->setRespectStoragePage(FALSE);
            $querySettings->setStoragePageIds($storagePidOverride);
            $this->setDefaultQuerySettings($querySettings);
        }

        $query = $this->createQuery();
//        $query->setOrderings(
//            array(
//                'hostname' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
//            )
//        );
        $constraints = array();
        $constraints[] = $query->contains('owners', $frontendUser);
        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }
    
}