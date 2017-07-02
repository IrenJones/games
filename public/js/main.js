/**
 *
 * @author Ananskelly
 */
var conn;
require(['./MessageHandler', './WSQueries/sendToken', './Ajax/getToken', './app'], function (messageHandler, sendToken, getToken) {
    conn = new ReconnectingWebSocket(
        'ws://games:8080',
        null,
        {reconnectInterval: 5000, reconnectDecay: 1, maxReconnectAttempts: 10}
    )
    conn.onopen = function (e) {
        console.log('connection established');
        getToken.get(0).then(function (response) {
            console.log(response.data);
            sendToken.send(response.data);
        }, function (err) {
            console.log(err);
        })
    };

    conn.onmessage = function (e) {
        messageHandler.handle(e.data);
    };

    function send(data)
    {
        conn.send(data);
        console.log('data send: ' + data);
    }
});
