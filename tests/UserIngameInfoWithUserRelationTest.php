<?php
/**
 *
 * @author IrenJones
 */

use Illuminate\Support\Collection;
use App\UserIngameInfo;

class UserIngameInfoWithUserRelationTest extends TestCase
{
    /**
     *
     * @var UserIngameInfo
     */
    protected $userInGameInfo;
   
    public function setUp()
    {
        parent::setUp();
        $this->userInGameInfo=factory(UserIngameInfo::class)->create();
    }
    
    public function testUserIngameInfoToUserRelation()
    {
        $userInGameInfo=$this->userInGameInfo;
        
        $this->assertEquals($userInGameInfo->user_id, $userInGameInfo->user->id);
    }
    
    public function testUserToUserIngameInfosIsCollection()
    {
        $userInGameInfo=$this->userInGameInfo;
        $user=$userInGameInfo->user;
        
        $this->assertTrue($user->userIngameInfos instanceof Collection);
    }
    
    /**
     *
     * @depends testUserToUserIngameInfosIsCollection
     */
    public function testUserToUserIngameInfosRelation()
    {
        $userInGameInfo=$this->userInGameInfo;
        $user=$userInGameInfo->user;
        
        $this->assertTrue($user->userIngameInfos->contains($userInGameInfo));
    }
   
    public function tearDown()
    {
        $userInGameInfo=$this->userInGameInfo;
        $userInGameInfo->delete();
        $userInGameInfo->user->delete();
        $userInGameInfo->user->gameType->delete();
        $userInGameInfo->gameType->delete();
        
        parent::tearDown();
    }
}
