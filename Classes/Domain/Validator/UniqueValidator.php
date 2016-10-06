<?php
namespace C1\Nodedb\Domain\Validator;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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


class UniqueValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator
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

    protected $supportedOptions = array(
        'repository' => array(NULL, 'The repository to check for uniqueness', 'string'),
        'property' => array(NULL, 'The property that is to be checked for uniqueness', 'string')
    );

    /**
     * @param string $value
     * @return bool
     * @throws \TYPO3\CMS\Extbase\Validation\Exception\InvalidValidationConfigurationException
     */
    public function isValid($value)
    {
        if ($this->options['repository'] && $this->options['property']) {
            if ($this->objectManager->isRegistered($this->options['repository'])) {
                // if this is an edit action, then there will be an __identity field and we need to exclude this uid
                // from the count when checking for uniqueness, see
                // http://www.typo3-nürnberg.de/typo/extbase/fehlerbehandlung-formulare/
                $paramsEdit = \TYPO3\CMS\Core\Utility\GeneralUtility::_GP('tx_nodedb_node');
                $paramsEdit = isset($paramsEdit['node']) ? $paramsEdit['node'] : '';
                $uid = isset($paramsEdit['__identity']) ? $paramsEdit['__identity'] : 0;
                $repository = $this->objectManager->get($this->options['repository']);
                $count = $repository->countByProperty($this->options['property'], $value, $uid);

                if ($count == 0) {
                    return TRUE;
                } else {
                    $errmsg = LocalizationUtility::translate('tx_nodedb_domain_model_node.hostname_not_unique', 'Nodedb');
                    $error = new \TYPO3\CMS\Extbase\Validation\Error($errmsg, 1474788841);
                    $this->result->addError($error);
                    return FALSE;
                }
            }
            throw new \TYPO3\CMS\Extbase\Validation\Exception\InvalidValidationConfigurationException('Invalid configuration for the Nodedb Unique Validator. Annotation should include a valid repository name and a property name', 1474788842);
        }
    }
}