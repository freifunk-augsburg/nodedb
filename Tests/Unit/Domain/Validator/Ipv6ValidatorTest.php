<?php

namespace C1\Nodedb\Domain\Validator;
require_once __DIR__ . '/AbstractValidatorTestcase.php';

/**
 * Testcase for the hostname validator
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */

class Ipv6ValidatorTest extends AbstractValidatorTestCase {

    protected $validatorClassName = 'C1\\Nodedb\\Domain\\Validator\\Ipv6Validator';
    protected $subject;

    public function setUp() {
        parent::setUp();
        $this->subject = $this->getMock(\C1\Nodedb\Domain\Validator\Ipv6Validator::class, array('translateErrorMessage'));
    }


    /**
     * @test
     */
    public function ipValidatorShouldValidateString() {
        $this->isValid('::1');
        $this->isValid('2001:1:2:3::5');
        $this->isValid('2001:444:444:444:444:444:444:444');
    }

    /**
     * @test
     */
    public function ipValidatorShouldReturnErrorIfNumberIsGiven() {
        $this->isInvalid(42);
        $this->isInvalid(-42);
    }

    /**
     * @test
     */
    public function ipValidatorShouldReturnErrorIfBoolIsGiven() {
        $this->isInvalid(TRUE);
        $this->isInvalid(FALSE);
    }

    /**
     * @test
     */
    public function ipValidatorShouldReturnErrorIfInvalidIsGiven() {
        $this->isInvalid('2001::555::111');
        $this->isInvalid('1.2.3.4');
        $this->isInvalid('2001:a:b:c:d:e:f:1:2:3:4');
    }
}
