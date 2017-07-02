<?php
/*
 *
 * @author artesby
 */

namespace App\Sockets\Protocol;

use App\Sockets\PushServerSocket;
use Ratchet\ConnectionInterface;

interface ProtocolInterface
{
    /**
     * Create an instance of class which process the message from Laravel server\Client
     * @param array $data Part of message, excluding "name"
     * @param ConnectionInterface $client A socket/connection
     * @param PushServerSocket $server WS server
     */
    public function __construct(array $data, ConnectionInterface $client, PushServerSocket $server);
    
    /**
     * Response of WS server to message
     */
    public function compile();
}
