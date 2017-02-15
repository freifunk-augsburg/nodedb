<?php
namespace C1\Nodedb\Domain\Validator;

require_once(\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('nodedb') . '/vendor/php-ip/ip.lib.php');

class Ip4Validator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
{

    /* validates the complete ip model */


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
     * Validates if an netmask is valid (i.e. configured in settings.ipv4available_netmasks).
     *
     * @param mixed $netmask The netmask that should be validated
     * @return boolean
     */
    public function isValidNetmask($netmask)
    {
        $configurationManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManager');
        $settings = $configurationManager->getConfiguration(\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

        if( !in_array($netmask, $settings[ipv4_available_netmasks]) ) {
            $error = new \TYPO3\CMS\Extbase\Validation\Error(
                $this->translateErrorMessage('tx_nodedb.errors.invalid_netmask', 'Nodedb'),
                1478026525
            );
            $this->result->forProperty('netmask')->addError($error);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Inject the objectManager
     *
     * @param mixed $ip The ip address to validate
     * @return boolean
     */

    private function isValidIpv4($ip)
    {
        $filterResult = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);

        if ($filterResult === false) {
            $error = new \TYPO3\CMS\Extbase\Validation\Error(
                $this->translateErrorMessage('tx_nodedb.errors.ipv4.invalid', 'Nodedb'),
                1221560718
            );
            $this->result->forProperty('ipaddr')->addError($error);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Validates if an ipv4 address or network is free (i.e. not registered ip or overlapping network)
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip4 The IP4 object that should be validated
     * @return boolean
     */
    private function isUniqueIpv4($ip4)
    {
        $block = \IPBlock::create($ip4->getIpaddr(), $ip4->getNetmask());
        $firstIpInBlock = $block->getFirstIp()->numeric();
        $lastIpInBlock = $block->getLastIp()->numeric();

        $repository = $this->objectManager->get('C1\Nodedb\Domain\Repository\Ip4Repository');

        $uid = $ip4->getUid();

        $count = $repository->countByOverlapping(intval($firstIpInBlock), intval($lastIpInBlock), $uid);

        if ($count !== 0) {
            $error = new \TYPO3\CMS\Extbase\Validation\Error(
                $this->translateErrorMessage('tx_nodedb.errors.ip_not_free', 'Nodedb'),
                1478019001
            );
            $this->result->forProperty('ipaddr')->addError($error);
            return FALSE;
        }

        return TRUE;

    }

    /**
     * Validates if an ipv4 address or network is anycast and thus allowed to have multiple nodes
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip4 The IP4 object that should be validated
     * @return boolean
     */
    private function isAnycastCanHaveMultiple($ip4)
    {

        if (count($ip4->getNode()) > 1 && $ip4->getAnycast() ===  FALSE) {
            $error = new \TYPO3\CMS\Extbase\Validation\Error(
                $this->translateErrorMessage('tx_nodedb.errors.ip_not_anycast_multiple_not_allowed', 'Nodedb'),
                1485012368
            );
            $this->result->forProperty('node')->addError($error);
            return FALSE;
        }

        return TRUE;

    }

    /**
     * Validates if an ipv4 address or network is free (i.e. not registered ip or overlapping network)
     *
     * @param \C1\Nodedb\Domain\Model\Ip4 $ip4 The IP4 object that should be validated
     * @return boolean
     */
    public function isValid($ip4)
    {

        if (!$ip4 instanceof \C1\Nodedb\Domain\Model\Ip4) {
            $this->addError('The given Object is not an Ip4.', 1483824081);
            return FALSE;
        }

        $has_error = FALSE;

        if ($this->isValidNetmask($ip4->getNetmask()) === FALSE) {
            $has_error = TRUE;
        };

        if ($this->isValidNetmask($this->isAnycastCanHaveMultiple($ip4)) === FALSE) {
            $has_error = TRUE;
        };


        if ($this->isValidIpv4($ip4->getIpaddr()) === FALSE) {
            $has_error = TRUE;
        };

        if ($has_error === FALSE) {
            if ($this->isUniqueIpv4($ip4) === FALSE) {
                $has_error = TRUE;
            };
        }

        return $has_error;
    }
}