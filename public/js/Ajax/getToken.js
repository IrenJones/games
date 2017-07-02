/**
 *
 * @author Ananskelly
 */
define(function () {
    return {
        get: function myself(counter)
        {
            var current = counter;
            return new Promise(function (resolve, reject) {
                var request = new XMLHttpRequest();
                request.onload = function () {
                    if (this.status !== 200) {
                        reject(new Error('Error with some status code')); }
                    try {
                        var message = JSON.parse(this.responseText);
                        if (!message.hasOwnProperty('name') || !message.hasOwnProperty('data')) {
                            throw new Error("Invalid message format"); }
                        if (message.name !== 'token') {
                            throw new Error("Invalid message content"); }
                        resolve(message);
                    } catch (e) {
                        reject(e);
                    }
                }
                request.onerror = function (e) {
                    reject(e);
                }
                if (current === 0) {
                    request.open('GET', '/ajax/get/token', true);
                    request.send();
                } else {
                    setTimeout(function () {
                        request.open('GET', '/ajax/get/token', true);
                        request.send();
                    }, 5000)
                }
            }).then(function (response) {
                if (response.data.state === 'failed' && current<9) {
                    return myself(++current); } else if (current === 9) {
                    return Promise.reject(new Error('Limit exceeded')); }
                    return Promise.resolve(response);
            }, function (e) {
                return Promise.reject(e);
            })
        }
    }
})

