<?php

/* 
 *
 * @author learp
 */
namespace App\Sockets\Protocol;

use App\Sockets\PushServerSocket;
use Ratchet\ConnectionInterface;
use Exception;
use App\Game;

class SubscribeProtocol implements ProtocolInterface
{
    
    /**
     *
     * @var array
     */
    protected $data;
    
    /**
     *
     * @var ConnectionInterface
     */
    protected $client;
    
    /**
     * WS server.
     *
     * @var PushServerSocket
     */
    protected $server;
    
    /**
     *
     * @param array $data
     * @param ConnectionInterface $client
     * @param PushServerSocket $server
     * @return void
     */
    public function __construct(array $data, ConnectionInterface $client, PushServerSocket $server)
    {
        $this->data = $data;
        $this->server = $server;
        $this->client = $client;
    }
    
    /**
     *
     * Try to subscribe
     *
     * @return void
     */
    public function compile()
    {
        if ($this->data["type"] != "request") {
            throw new Exception("Invalid type: not a request");
        }
        
        $gameId = $this->data["game"];
        $response = [
                "name" => "subscribe",
                "data" => [
                    "type" => "response",
                    "state" => "success"
                ]
            ];
        $game = Game::find($gameId);
        
        if (($game === null) || !$this->server->CheckIsSetClientToUserId($this->client)) {
            $response["data"]["state"] = "failed";
        } elseif ($game->time_finished !== null) {
            $response["data"]["state"] = "unavailable";
        } else {
            $turns = $game->turnInfos;
            if (!$turns->isEmpty()) {
                $response["data"]["turn"] = $turns->sortBy("turn_number")->last()->turn_number;
            } else {
                $response["data"]["turn"] = 0;
            }
            $this->server->linkClientIdToGame($this->client, $gameId);
        }
        
        $msg = json_encode($response);
        $this->client->send($msg);
    }
}
