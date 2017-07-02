<?php
/**
 *
 * @author artesby
 */

use Illuminate\Support\Collection;
use App\User;

class UserWithFriendRelationTest extends TestCase
{
    /**
     *
     * @var User
     */
    protected $user;
    protected $friend;
    
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->friend = factory(User::class)->create();
        $this->user->friends()->attach($this->friend->id);
        $this->friend->friends()->attach($this->user->id);
    }
    
    public function testUserToFriendsIsCollection()
    {
        $user = $this->user;
        $this->assertTrue($user->friends instanceof Collection);
    }
    
    /**
     *
     * @depends testUserToFriendsIsCollection
     */
    public function testUserToFriendsRelation()
    {
        $user = $this->user;
        $friend = $this->friend;
        $this->assertTrue($user->friends->contains($friend));
    }
   
    public function tearDown()
    {
        $user = $this->user;
        $friend = $this->friend;
        $user->gameType->delete();
        $friend->gameType->delete();
        
        parent::tearDown();
    }
}
