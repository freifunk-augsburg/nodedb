<?php
namespace C1\Nodedb\Hooks;

class TCEMainHook {

    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {

        $extbaseObjectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        if ($table === 'tx_nodedb_domain_model_node') {
            $repository = $extbaseObjectManager->get('C1\Nodedb\Domain\Repository\Ip4Repository');
            $repository->updateReferencesNode();
        }

        if ($table === 'tx_nodedb_domain_model_ip4') {
            $repository = $extbaseObjectManager->get('C1\Nodedb\Domain\Repository\NodeRepository');
            $repository->updateReferencesIp4();
        }

    }

}