/**
 *
 * @author Ananskelly
 */
define(['./gameConfig'], function (gameConfig) {
    var $cellObj = $('.cell');
    var colors = ['white', 'black'];
    var pawnSpecial = gameConfig.getConfig('pawnSpecial');
    var current;
    var opposite;
    var attr;
    var userColor;
    function checkPawnSpecial(y,x)
    {
        if (pawnSpecial !== null) {
            var z1=0,z2=0;
            if (pawnSpecial[0] === y && Math.abs(Number(pawnSpecial[1])-Number(x))===1) {
                if (current === "black") {
                    z1 = Number(y) + 1; } else {
                    z1 = Number(y) - 1; }
                    if (pawnSpecial[1] - x > 0) {
                        z2 = Number(x) + 1; } else {
                        z2 = Number(x) - 1; }
                        $(attr+'='+z1+z2).addClass('cell-highlight-enemy');
            }
        }
    }
    function checkEnemy(y,x)
    {
        if ($('['+attr+'='+y+x+']').children().hasClass(opposite)) {
            $('['+attr+'='+y+x+']').addClass('cell-highlight-enemy');
        }
    }
    function simpleAdd(y,x,type)
    {
        if (x>8 || x<1 || y>8 || y<1) {
            return false; }
        if (!$('['+attr+'='+y+x+']').hasClass('busy')) {
            $('['+attr+'='+y+x+']').addClass('cell-highlighted');
            return true;
        } else if (type !== 'pawn') {
            checkEnemy(y,x);
        }

    }
    function diag(y,x,direction_y,direction_x)
    {
        y += direction_y;
        x += direction_x;
        while (!$('['+attr+'='+y+x+']').hasClass('busy') && y < 9 && y > 0 && x > 0 && x < 9) {
            $('['+attr+'='+y+x+']').addClass('cell-highlighted');
            y += direction_y;
            x += direction_x;
        }
        checkEnemy(y,x);
    }
    function parall(y,x,direction,flag)
    {
        
        if (flag === true) {
            x += direction;
            while (!$('['+attr+'='+y+x+']').hasClass('busy') && x < 9 && x > 0) {
                $('['+attr+'='+y+x+']').addClass('cell-highlighted');
                x += direction;
            }
        } else {
            y += direction;
            while (!$('['+attr+'='+y+x+']').hasClass('busy') && y<9 && y>0) {
                $('['+attr+'='+y+x+']').addClass('cell-highlighted');
                y += direction;
            }
        }
        checkEnemy(y,x);
    }
    return {
        compile: function (currentObj) {
        
            /*
             * get initial param
             */
            current = gameConfig.getConfig('userState');
            if (current === 'white') {
                opposite = 'black'; } else {
                opposite = 'white'; }
                if (!$(currentObj).hasClass(current)) {
                    return; }
                if (gameConfig.getConfig('revert')) {
                    attr = 'data-revert-id';
                } else {
                    attr = 'data-id';
                }
                $cellObj.removeClass('cell-highlight-enemy');
                $cellObj.removeClass('cell-highlighted');
            
                var type = $(currentObj).children().attr('data-type');
                var figure = $(currentObj).attr('id');
                var cell = $(currentObj).parent().attr(attr);
            
                if (current === 'black') {
                    direction = -1;
                } else {
                    direction = 1;
                }
            
                var cell_y = cell[0];
                var cell_x = cell[1];

                switch (type) {
                    case 'pawn' : {
                        console.log(Number(cell_y)+direction);
                        var goOnFlag = simpleAdd(Number(cell_y)+direction,Number(cell_x),'pawn');
                        if (Number(cell_y)===2 && current === 'white' && goOnFlag) {
                            simpleAdd(Number(cell_y)+2,Number(cell_x),'pawn'); } else if (Number(cell_y)===7 && current === 'black' && goOnFlag) {
                            simpleAdd(Number(cell_y)-2,Number(cell_x),'pawn'); }

                            checkEnemy(Number(cell_y)+direction,Number(cell_x)+direction);
                            checkEnemy(Number(cell_y)+direction,Number(cell_x)-direction);
                            checkPawnSpecial(cell_y,cell_x);
                        break;
                    }
                    case 'bishop' : {
                        diag(Number(cell_y),Number(cell_x),-1,1);
                        diag(Number(cell_y),Number(cell_x),1,1);
                        diag(Number(cell_y),Number(cell_x),1,-1);
                        diag(Number(cell_y),Number(cell_x),-1,-1);
                        break;
                    }
                    case 'rook' : {
                        parall(Number(cell_y),Number(cell_x),-1,true);
                        parall(Number(cell_y),Number(cell_x),1,true);
                        parall(Number(cell_y),Number(cell_x),1,false);
                        parall(Number(cell_y),Number(cell_x),-1,false);
                        break;
                    }
                    case 'knight': {
                        simpleAdd(Number(cell_y)-2,Number(cell_x)+1);
                        simpleAdd(Number(cell_y)-2,Number(cell_x)-1);
                        simpleAdd(Number(cell_y)-1,Number(cell_x)-2);
                        simpleAdd(Number(cell_y)+1,Number(cell_x)-2);
                        simpleAdd(Number(cell_y)+2,Number(cell_x)-1);
                        simpleAdd(Number(cell_y)+2,Number(cell_x)+1);
                        simpleAdd(Number(cell_y)+1,Number(cell_x)+2);
                        simpleAdd(Number(cell_y)-1,Number(cell_x)+2);
                        break;
                    }
                    case 'king': {
                        simpleAdd(Number(cell_y),Number(cell_x)+1);
                        simpleAdd(Number(cell_y),Number(cell_x)-1);
                        simpleAdd(Number(cell_y)+1,Number(cell_x)+1);
                        simpleAdd(Number(cell_y)-1,Number(cell_x)-1);
                        simpleAdd(Number(cell_y)+1,Number(cell_x)-1);
                        simpleAdd(Number(cell_y)-1,Number(cell_x)+1);
                        simpleAdd(Number(cell_y)-1,Number(cell_x));
                        simpleAdd(Number(cell_y)+1,Number(cell_x));

                        break;
                    }
                    case 'queen': {
                        parall(Number(cell_y),Number(cell_x),-1,true);
                        parall(Number(cell_y),Number(cell_x),1,true);
                        parall(Number(cell_y),Number(cell_x),1,false);
                        parall(Number(cell_y),Number(cell_x),-1,false);
                        diag(Number(cell_y),Number(cell_x),-1,1);
                        diag(Number(cell_y),Number(cell_x),1,1);
                        diag(Number(cell_y),Number(cell_x),1,-1);
                        diag(Number(cell_y),Number(cell_x),-1,-1);
                        break;
                    }
                }
        }
    }
})

