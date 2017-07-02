/**
 *
 * @author Ananaskelly
 */
define(function () {
    var config = {
        'userState': 'none',
        'activeState': true,
        'revert': false,
        'current': 0,
        'opposite': 1,
        'figureSize': 0,
        'coeff': 0.4,
        'init': false,
        'pawnSpecial': null
    }
    return {
        setConfig: function (param, value) {
            config[param] = value;
        },
        getConfig: function (param) {
            return config[param];
        }
    }
})
