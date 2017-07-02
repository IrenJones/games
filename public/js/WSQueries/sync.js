/**
 *
 * @author Ananaskelly
 */
define(function () {
    return {
        send: function (gameId, turnId) {
            var data = {
                'name': 'synchronize',
                'data': {
                    'type': 'request',
                    'game': gameId,
                    'turn': turnId
                }
            };
            conn.send(JSON.stringify(data));
        }
    }
});

