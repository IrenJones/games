/**
 *
 * @author Ananasy
 */
define(['WSQueries/sync'], function (sync) {
    return {
        compile: function (data) {
            if (data.name !== 'response') {
                return; }
            var currentTurn = $('.game-info').attr('data-turn');
            /**if (data.turn !== parseInt(currentTurn)){
                var gameId = $('.game-info').attr('data-game');
                sync.send(gameId, data.turn);
            }*/
        }
    }
})

