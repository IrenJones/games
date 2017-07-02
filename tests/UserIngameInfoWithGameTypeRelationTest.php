<?php
/**
 *
 * @author IrenJones
 */

use Illuminate\Support\Collection;
use App\UserIngameInfo;

class UserIngameInfoWithGameTypeRelationTest extends TestCase
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
    
    public function testUserIngameInfoToGameTypeRelation()
    {
        $userInGameInfo=$this->userInGameInfo;
        
        $this->assertEquals($userInGameInfo->game_type_id, $userInGameInfo->gameType->id);
    }
    
    public function testGameTypeToUserIngameInfosIsCollection()
    {
        $userInGameInfo=$this->userInGameInfo;
        $gameType=$userInGameInfo->gameType;
        
        $this->assertTrue($gameType->userIngameInfos instanceof Collection);
    }
    
    /**
     *
     * @depends testGameTypeToUserIngameInfosIsCollection
     */
    public function testGameTypeToUserIngameInfosRelation()
    {
        $userInGameInfo=$this->userInGameInfo;
        $gameType=$userInGameInfo->gameType;
       
        $this->assertTrue($gameType->userIngameInfos->contains($userInGameInfo));
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
