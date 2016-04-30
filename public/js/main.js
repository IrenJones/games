/**
 *
 * @author Ananskelly
 */
require(['./MessageHandler', './Ajax/sendTurn'], function(messageHandler, sendTurn) {

    var conn = new WebSocket('ws://games:8080');
    conn.onopen = function(e) {
        console.log('connection established');
    };

    conn.onmessage = function(e) {
        messageHandler.handle(e.data);
    };

    function send(data) {
        conn.send(data);
        console.log('data send: ' + data);
    }
});