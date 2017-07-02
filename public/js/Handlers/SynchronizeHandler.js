/**
 *
 * @author Ananaskelly
 */
define(['GameControl/turnControl'], function (turnControl) {
    return {
        compile: function (data) {
            if (data.type !== 'response') {
                return; }
            if (data.state === 'success') {
                for (var i=0; i<data.turnes.length; i++) {
                    turnControl.apply(data.turnes[i])
                }
            }
        }
    }
})

