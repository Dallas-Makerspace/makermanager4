<?php
namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use app\Controller\Api\MembershipController

public function setUp() {
    parent::setUp();
    $this->Invoice = ClassRegistry::init('Invoice');
}


class MembershipControllerTest extends TestCase
{

    /**
     * @return void
     */

    public function setUp() {
        parent::setUp();
        $this->Membership = ClassRegistry::init('Membership');
    }
    
    public function tearDown() {
        unset($this->Membership);
        parent::tearDown();
    }

    /**
     * Test the Membership API controller
     *
     * @return void
     */

    public function testMembershipControllerData()
    {
    
       $this->testAction('/Memberships/xml/', array('method' => 'get'));
       $this->assertFalse(isEmpty($this->Membership->data));

    }
}
