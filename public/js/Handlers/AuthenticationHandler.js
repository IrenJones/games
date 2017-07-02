/**
 *
 * @author Ananskelly
 */
define(['WSQueries/subscribe'], function (subscribe) {
    return {
        compile: function (data) {
            if (data.type !== 'response') {
                return; }
            if (data.result === 'success') {
                subscribe.sendQuery();
            }
        }
    }
});


