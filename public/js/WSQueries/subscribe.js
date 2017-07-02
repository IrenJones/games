/**
 *
 * @author Ananaskelly
 */
define(function () {
    return {
        sendQuery: function () {
            var gameId = $('.game-info').attr('data-game');
            var msg = {
                'name': 'subscribe',
                'data': {
                    'type': 'request',
                    'game': gameId
                }
            }
            console.log(msg);
            conn.send(JSON.stringify(msg));
        }
    }
})
