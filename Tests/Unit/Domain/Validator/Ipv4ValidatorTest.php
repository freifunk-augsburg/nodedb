<?php

namespace C1\Nodedb\Domain\Validator;
require_once __DIR__ . '/AbstractValidatorTestcase.php';

/**
 * Testcase for the hostname validator
 *
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */

class Ipv4ValidatorTest extends AbstractValidatorTestCase {

    protected $validatorClassName = 'C1\\Nodedb\\Domain\\Validator\\Ipv4Validator';
    protected $subject;

    public function setUp() {
        parent::setUp();
        $this->subject = $this->getMock(\C1\Nodedb\Domain\Validator\Ipv4Validator::class, array('translateErrorMessage'));
    }


    /**
     * @test
     */
    public function ipValidatorShouldValidateString() {
        $this->isValid('1.2.3.4');
        $this->isValid('123.2.3.123');
        $this->isValid('0.0.0.0');
        $this->isValid('255.255.255.255');
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
        $this->isInvalid('256.0.0.1');
        $this->isInvalid('a.b.c.d');
        $this->isInvalid('a.1.2.2');
        $this->isInvalid('1.a.b.1');
    }
}
