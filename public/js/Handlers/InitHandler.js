/**
 *
 * @author Ananskelly
 */
define(['GameControl/gameConfig', 'changeStatus'], function (gameConfig, changeStatus) {
    var config = ['pawn', 'rook', 'knight', 'bishop', 'king', 'queen'];
    var colors = ['white', 'black']
    return {
        compile: function (data) {
            if (data.game !== parseInt($('.game-info').attr('data-game'))) {
                return;
            }
            changeStatus.changeStatus();
            $('.game-info').attr('data-turn', data.turn);
            gameConfig.setConfig('init', true);
            var userId = parseInt($('.board').attr('data-user'));
            var attr = '';
            switch (userId) {
                case data.users[0].id:
                    gameConfig.setConfig('userState', colors[data.users[0].color]);
                    break;
                case data.users[1].id:
                    gameConfig.setConfig('userState', colors[data.users[1].color]);
                    break;
                default:
                    gameConfig.setConfig('userState', 'none');
                    break;
            }
            if ((parseInt(data.users[0].color) === 0 && data.users[0].id === userId) ||
                 (parseInt(data.users[1].color) === 0 && data.users[1].id === userId)) {
                attr = 'data-revert-id';
                gameConfig.setConfig('revert', true);
                $('#user1').attr('data-color', 'black');
                $('#user2').attr('data-color', 'white');
                $('#user1-img').attr('src', '/img/black.png');
                $('#user2-img').attr('src', '/img/white.png');
                $('.up').addClass('hit-white');
                $('.down').addClass('hit-black');
            } else {
                attr = 'data-id';
                $('.up').addClass('hit-black');
                $('.down').addClass('hit-white');
            }
            for (var k=0; k<data.users.length; k++) {
                var colorInd = parseInt(data.users[k].color);
                $('.board').attr('data-player-'+colors[colorInd], data.users[k].id);
                $('[data-color='+colors[parseInt(data.users[k].color)]+']').text(data.users[k].login);
            }
            for (var j=0; j<colors.length; j++) {
                for (var i=0; i<data[colors[j]].length; i++) {
                    var $img = $('<img>');
                    $img.attr('src','/figure/'+config[parseInt(data[colors[j]][i].type)]+'-'+colors[j]+'.png');
                    $img.attr('data-type', config[parseInt(data[colors[j]][i].type)]);
                    $('<div class="figure '+colors[j]+'" id="' + data[colors[j]][i].id +'">').appendTo('['+attr+'='+data[colors[j]][i].position+']').append($img);
                    $img.addClass('img-content');
                    $('['+attr+'='+data[colors[j]][i].position+']').addClass('busy');
                }
            }
        }
    };
});

