<?php
/**
 *
 * @author IrenJones
 */
use Illuminate\Support\Collection;
use App\User;

class GameTypeWithUserRelationTest extends TestCase
{
    /**
     *
     * @var User
     */
    protected $user;
    
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
    }
    
    public function testGameTypeToUserRelation()
    {
        $user = $this->user;
        $this->assertEquals($user->gameType->id, $user->default_game_type_id);
    }

    public function testUserToGameTypeIsCollection()
    {
        $user = $this->user;
        $gameType=$user->gameType;
        $this->assertTrue($gameType->users instanceof Collection);
    }
    
    /**
     *
     * @depends testUserToGameTypeIsCollection
     */
    public function testUserToGameTypesRelation()
    {
        $user = $this->user;
        $gameType=$user->gameType;
        $this->assertTrue($gameType->users->contains($user));
    }
    
    public function tearDown()
    {
        $user = $this->user;
        $user->delete();
        $user->gameType->delete();
        
        parent::tearDown();
    }
}
