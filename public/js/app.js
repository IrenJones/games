/**
 *
 * @Ananaskelly
 */
require(['./GameControl/highlight', './GameControl/gameConfig', './GameControl/setInitial', './Ajax/sendTurn'], function (highlight, gameConfig, setInitial, sendTurn) {
    $(document).ready(function () {
        $('.user-info').popover({
            title: 'User info',
            content: '<img class="img-user" width="48px" src="/alien.png">maybe rating or something else',
            template: '<div class="popover" role="tooltip"><div class="arrow"></div>' +
            '<h3 class="center font popover-title"></h3><div class="font center popover-content"></div></div>',
            html: true,
            trigger: 'hover'
        });
        /**
        *
        * SIZE PROBLEM
        */
        var $cellObj = $('.cell');
        var cellSize = $cellObj.width();
        gameConfig.setConfig('figureSize', cellSize);
        $cellObj.css({height: cellSize});
        $('.cell-corner').css({height: ($('.cell-bottom').height()*1.15) });
        $('.user1,.user2').css({height: cellSize});
        var border = $(window).height() * 0.04;
        var config = ['pawn', 'rook', 'knight', 'bishop', 'queen', 'king'];
        var colors = ['white', 'black'];
        /**
         *
         * Set config
         */
        if (!gameConfig.getConfig('init')) {
            setInitial.compile(); }
        /*
        *
        * DO RESIZE
        */
        $(window).resize(function () {
            $cellObj.css({height: $cellObj.width()});
            $('.cell-corner').css({height: ($('.cell-bottom').height()*1.15) });
        });
        /*
         *
         * false if user is waiting
         */
        var activeState;
        var userStatus;
        var currentFigure = '';
        var current;
        $(document).on('click', '.figure', function () {
            activeState = gameConfig.getConfig('activeState');
            current = colors[gameConfig.getConfig('current')];
            userStatus = gameConfig.getConfig('userState');
            if (userStatus !== current || !activeState ) {
                return; }
            if ($(this).hasClass(current)) {
                $cellObj.removeClass('cell-key'); } else {
                return; }
                currentFigure = $(this).attr('id');
                $(this).parent().addClass('cell-key');
        });
        $(document).on('mouseenter', '.figure', function () {
            highlight.compile(this);
        });
        $(document).on('mouseleave', '.figure', function () {
            $cellObj.removeClass('cell-highlighted');
            $cellObj.removeClass('cell-highlight-enemy');
        });
        $cellObj.click(function () {
            current = colors[gameConfig.getConfig('current')];
            activeState = gameConfig.getConfig('activeState');
            if (userStatus !== current || !activeState) {
                return; }
            $cellObj.removeClass('cell-highlighted')
            var attr;
            if (gameConfig.getConfig('revert')) {
                attr = 'data-revert-id'
            } else {
                attr = 'data-id'
            }
            var newFigure = null;
            if (currentFigure!=='' && currentFigure!==$(this).children().attr('id')) {
                $(this).addClass('cell-highlight-aim');
                var position = $(this).attr(attr);
                var gameId = $('.game-info').attr('data-game');
                var y = $(this).attr(attr)[0];
                if ($('#'+currentFigure).children().attr('data-type') === 'pawn' && (y === '1' || y === '8')) {
                    $('input[type=checkbox').change(function () {
                        if ($(this).is(':checked')) {
                            newFigure = config.indexOf($(this).attr('id'));
                            $('.custom').not(this).attr('disabled', true)
                        } else {
                            $('.custom').attr('disabled', false);
                            newFigure = null;
                        }
                    })
                }
                var token = $('meta[name=csrf-token]').attr('content');
                var data = {
                    'game': gameId,
                    'figure': currentFigure,
                    'y': position[0],
                    'x': position[1],
                    'typeId': newFigure
                }
                sendTurn.send(data, token);
                gameConfig.setConfig('activeState', false);
                currentFigure = '';
            }
            $('#'+currentFigure).parent().removeClass('cell-key');
        });
        $('.giveUp').click(function () {
            $('.winner').text(opposite + ' are win!!!');
            $('.cover').show();
            $('.cover-content').show();
        });
        $('.close-win-window').click(function () {
            $('.cover').hide();
            $('cover-content').hide();
        });
    });
})