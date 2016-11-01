<?php
namespace C1\Nodedb\Domain\Validator;
/***************************************************************
 *  Copyright notice
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

class Ipv4RangeFreeValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
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

    /**
     * Validates if an ipv4 address is free (i.e. not registered ip or overlapping network)
     *
     * @param mixed $ip The IP that should be validated
     * @return void
     */
    public function isValid($ip)
    {
        $postVars = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_nodedb_ip4');

        if (isset($postVars['newIp'])) {
            $netmask = isset($postVars['newIp']['netmask']) ? $postVars['newIp']['netmask'] : NULL;
        } else {
            $netmask = isset($postVars['Ip']['netmask']) ? $postVars['Ip']['netmask'] : NULL;
        }


        if ($netmask === NULL) {
            $errMsg = $this->translateErrorMessage('tx_nodedb.errors.ipv4.no_netmask', 'Nodedb');
            $this->addError($errMsg, 1478018988, array($ip));
            return FALSE;
        }

        $uid = isset($postVars['Ip']['__identity']) ? $postvars['Ip']['__identity'] : 0;

        $block = \IPBlock::create($ip, $netmask);
        $firstIpInBlock = $block->getFirstIp()->numeric();
        $lastIpInBlock = $block->getLastIp()->numeric();

        $repository = $this->objectManager->get('C1\Nodedb\Domain\Repository\Ip4Repository');
        $count = $repository->countByOverlapping(intval($firstIpInBlock), intval($lastIpInBlock), $uid);

        if ($count == 0) {
            return TRUE;
        } else {
            $errMsg = $this->translateErrorMessage('tx_nodedb.errors.ip_not_free', 'Nodedb');
            $this->addError($errMsg, 1478019001, array($ip));
            return FALSE;
        }

    }
}