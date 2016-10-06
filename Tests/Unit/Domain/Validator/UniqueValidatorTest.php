<?php

namespace C1\Nodedb\Domain\Validator;

require_once __DIR__ . '/AbstractValidatorTestcase.php';

/**
 * Testcase for the hostname validator
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */

class UniqueValidatorTest extends AbstractValidatorTestCase {

    protected $validatorClassName = 'C1\\Nodedb\\Domain\\Validator\\UniqueValidator';

    public function setUp() {
        $options = [
           'repository' => 'C1\Nodedb\Domain\Repository\NodeRepository',
           'property' => 'hostname',
        ];
        $this->validator = $this->getValidator($options);
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldValidateString() {
        $objectManager = $this->getMock('TYPO3\\CMS\\Extbase\\Object\\ObjectManager', array(), array(), '', FALSE);
        $this->inject($this->validator, 'objectManager', $objectManager);
//        $mockObjectManager = $this->getMock(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface::class, array('isRegistered', 'get', 'getEmptyObject', 'getScope'), array(), '', false);
//        $this->validator = $this->getAccessibleMockForAbstractClass(\C1\Nodedb\Domain\Validator\UniqueValidator::class, array());
//        $this->validator->_set('objectManager', $mockObjectManager);
        $this->validatorOptions(array('repository' => 'C1\Nodedb\Domain\Repository\NodeRepository', 'property' => 'hostname'));
        $this->assertFalse($this->validator->validate(1)->hasErrors());
    }


}
