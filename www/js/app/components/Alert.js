const alertClassTypes = {
    ERROR: 'bg--error',
    SUCCESS: 'bg--success',
    INFO: 'bg--primary',
    WARNING: 'bg--warning'
};

const messageTypes = {
    ERROR: -1,
    CLEAR: 0,
    SUCCESS: 1,
    COMPLETE: 2
};

class Alert
{
    static getTemplate()
    {
        return $('.js-alert-template').html();
    }

    /**
     * @param {string} message
     * @param {number} [messageType=messageType.ERROR]
     * @param {jQuery} container
     * @param {{}} options
     */
    static showMessage(message, messageType, container = $('.js-container-alert'), options = {})
    {
        if (messageType === undefined) {
            messageType = messageTypes.ERROR;
        }

        let alertClass = messageTypes.ERROR;

        switch (messageType) {
            case messageTypes.ERROR:
                alertClass = alertClassTypes.ERROR;
                $('.' + alertClassTypes.ERROR).remove();
                break;
            case messageTypes.SUCCESS:
                alertClass = alertClassTypes.SUCCESS;
                $('.' + alertClassTypes.SUCCESS).fadeOut();
                break;
        }

        let template = Alert.getTemplate();

        template = template
            .replace(/\{type\}/gi, alertClass)
            .replace(/\{message\}/gi, message);
        template = $(template);


        container.append(template);

        options = options || {};
        if (options['visibleTime'] !== 'notTimeout') {
            let visibleTime = options['visibleTime'] || 5000;

            setTimeout(function () {
                template.fadeOut(function () {
                    template.remove();
                    if (options.onHide instanceof Function) {
                        options.onHide();
                    }
                });
            }, visibleTime);
        }

        if (options['close'] === false) {
            template.find($('.close')).hide();
        }

    };
}

export {Alert, messageTypes};