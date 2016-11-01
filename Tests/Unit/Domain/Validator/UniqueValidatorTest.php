<?php

namespace C1\Nodedb\Domain\Validator;

use C1\Nodedb\Domain\Model\Node;

require_once __DIR__ . '/AbstractValidatorTestcase.php';

/**
 * Testcase for the hostname validator
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */

class UniqueValidatorTest extends AbstractValidatorTestCase {

    protected $validatorClassName = 'C1\\Nodedb\\Domain\\Validator\\UniqueValidator';
    protected $subject;

    public function setUp() {
        parent::setUp();
        $options = [
           'repository' => 'C1\Nodedb\Domain\Repository\NodeRepository',
           'property' => 'hostname',
        ];
        $this->validator = $this->getValidator($options);
        $this->subject = $this->getMock(\C1\Nodedb\Domain\Validator\UniqueValidator::class, array('translateErrorMessage'));
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldValidateString() {
        //$this->validatorOptions(array('repository' => 'C1\Nodedb\Domain\Repository\NodeRepository', 'property' => 'hostname'));
        /**
         * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject $objectManager
         */

        /**
         * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject $nodeRepositoryMock
         */
        $objectManager = $this->getMock(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $nodeRepositoryMock = $this->getMock(\C1\Nodedb\Domain\Repository\NodeRepository::class, array(), array($objectManager));
        $objectManager->expects($this->once())->method('isRegistered')->will($this->returnValue(TRUE));
        $objectManager->expects($this->once())->method('get')->will($this->returnValue($nodeRepositoryMock));
        $this->inject($this->validator, 'objectManager', $objectManager);
        $this->assertFalse($this->validator->validate(1)->hasErrors());
    }

    /**
     * @test
     */
    public function hostnameValidatorShouldReturnErrorAlreadyTaken() {
        //$this->validatorOptions(array('repository' => 'C1\Nodedb\Domain\Repository\NodeRepository', 'property' => 'hostname'));
        /**
         * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject $objectManager
         */
        $objectManager = $this->getMock(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        /**
         * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject $nodeRepositoryMock
         */

        $node1 = new Node();
        $node1->setHostname('testhostname');


        $nodeRepositoryMock = $this->getMock(\C1\Nodedb\Domain\Repository\NodeRepository::class, array(), array($objectManager));
        $nodeRepositoryMock->add($node1);
        $objectManager->expects($this->once())->method('isRegistered')->will($this->returnValue(TRUE));
        $objectManager->expects($this->once())->method('get')->will($this->returnValue($nodeRepositoryMock));

        $this->inject($this->validator, 'objectManager', $objectManager);
        //$this->assertTrue($this->validator->validate('testhostname')->hasErrors());
        $this->isInvalid(1);
    }

}
