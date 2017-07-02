<?php
/**
 *
 * @author artesby
 */

namespace App\Sockets\Protocol;

use Ratchet\ConnectionInterface;
use App\Sockets\PushServerSocket;

class TurnProtocol implements ProtocolInterface
{
    /**
     * WS server.
     *
     * @var PushServerSocket
     */
    protected $server;
    
    /**
     * Information about turn.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new TurnProtocol instance.
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
    }
    
    /**
     *
     * Send information about turn to all clients.
     *
     * @return void
     */
    public function compile()
    {
        echo sprintf('send turn to all subscribed clients' . PHP_EOL);
        $turn = [
            'name' => 'turn',
            'data' => $this->data,
        ];
        $msg = json_encode($turn);
        
        foreach ($this->server->getGameSubscribedClients($this->data['game']) as $client) {
            $client->send($msg);
        }
        $event = $this->data['event'];
        if ($event == 'mate' || $event = 'stalemate' || $event = 'surrender') {
            $this->server->unlinkGameClients($this->data['game']);
        }
    }
}
