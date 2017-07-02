/**
 *
 * @author Ananskelly
 */
define(function () {
    return {
        send: function (data) {
            var msg = {
                'name': 'authentication',
                'data': {
                    'type': 'request',
                    'token': data.token,
                }
            }
            console.log(msg);
            conn.send(JSON.stringify(msg));
        }
    }
})


