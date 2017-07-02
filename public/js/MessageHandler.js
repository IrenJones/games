/**
 *
 * @author Ananskelly
 */
define(
    ['./Handlers/TurnHandler', './Handlers/InitHandler', './Handlers/SynchronizeHandler', './Handlers/AuthenticationHandler', './Handlers/SubscribeHandler'],
    function (TurnHandler, InitHandler, SynchronizeHandler, AuthenticationHandler, SubscribeHandler) {
        var scope = {
            'TurnHandler' : TurnHandler,
            'InitHandler' : InitHandler,
            'SynchronizeHandler': SynchronizeHandler,
            'AuthenticationHandler': AuthenticationHandler,
            'SubscribeHandler': SubscribeHandler
        }
        return {
            handle: function (data) {
                try {
                    var message = JSON.parse(data);
                    if (!message.hasOwnProperty('name') || !message.hasOwnProperty('data')) {
                        throw new Error("Invalid data"); }
                    var name = message.name.slice(0,1).toUpperCase() + message.name.slice(1) + "Handler";
                    if (!require.defined("Handlers/"+name)) {
                        throw new Error("Invalid data name"); }
                    scope[name].compile(message.data);
                } catch (e) {
                    console.log(e.message);
                }
            }
        }
    }
);
