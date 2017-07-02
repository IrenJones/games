/**
 *
 * @author Ananskelly
 */

define(['GameControl/turnControl', 'GameControl/gameConfig'], function (turnControl, gameConfig) {
    return {
        compile: function (data) {
            
            turnControl.apply(data);

        }
    };
});
