<?php
/*
 *
 * @author Ananaskelly
 */

namespace App\Sockets\Protocol;

use App\Sockets\PushServerSocket;
use Ratchet\ConnectionInterface;
use Exception;
use App\Token;
use Carbon\Carbon;
use DateTime;

class AuthenticationProtocol implements ProtocolInterface
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
        $this->client = $client;
        $this->server = $server;
    }
    public function compile()
    {
        if ($this->data['type'] != 'request') {
            throw new Exception("Invalid type");
        };
        $str = $this->data['token'];
        /**
         *
         * @var App\Token
         */
        $token = Token::find($str);
        $response = [
                'name' => 'authentication',
                'data' => [
                    'type' => 'response'
                ]
            ];
        if ($token === null || (new DateTime($token->expiration_date)) < Carbon::now()) {
            $response['data']['result'] = 'failed';
        } else {
            $this->server->linkUserIdToClient($this->client, $token->user_id);
            $response['data']['result'] = 'success';
        }
        $msg = json_encode($response);
        $this->client->send($msg);
        if ($token !== null) {
            $token->delete();
        }
    }
}
