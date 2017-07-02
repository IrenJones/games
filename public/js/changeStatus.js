/**
 *
 * @author IrenJones
 */
define(function () {
    return {
        changeStatus: function () {
            var element = document.getElementById('statusContent');
            var status = $('.stateGame').attr('value');
            var userId = parseInt($('.board').attr('data-user'));
            var playersId = [
                parseInt($('.board').attr('data-player-white')),
                parseInt($('.board').attr('data-player-black'))
            ];
            if (playersId.indexOf(userId) >= 0) {
                //if gamer
                element.innerHTML = status;
            }
        }
    }
})
