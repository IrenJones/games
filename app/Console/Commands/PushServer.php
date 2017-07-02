<?php
/**
 *
 * @author malinink
 */
namespace App\Console\Commands;

use ZMQ;
use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\Sockets\PushServerSocket;
use React\EventLoop\Factory as ReactLoop;
use React\Socket\Server as ReactServer;
use React\ZMQ\Context as ReactContext;

class PushServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test websocket server';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Push Server started');
        
        $loop = ReactLoop::create();
        
        $context = new ReactContext($loop);
        
        $pushServerSocket = new PushServerSocket();
        
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555');
        $pull->on('message', $pushServerSocket);
        
        $webSocket = new ReactServer($loop);
        $webSocket->listen(8080, '0.0.0.0');
        $server = new IoServer(
            new HttpServer(
                new WsServer(
                    $pushServerSocket
                )
            ),
            $webSocket,
            $loop
        );
        $loop->run();
    }
}
