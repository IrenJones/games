/**
 *
 * @author Ananskelly
 */
define(['./gameConfig'], function (gameConfig) {
    return {
        compile: function (data) {
            data = JSON.parse(data);
            
            if (data.data.state !== 'success') {
                gameConfig.setConfig('activeState', true);
                $('.cell').removeClass('cell-highlight-aim');
                $('.cell').removeClass('cell-key');
                // show some info
            }
        }
    }
});

