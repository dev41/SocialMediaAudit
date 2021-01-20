import {VisualComponent} from "../VisualComponent";

class Confirmation extends VisualComponent
{
    /**
     * @param {{}} [options]
     * @param {String} [options.container]
     * @param {String} [options.title]
     * @param {String} [options.labelOk]
     * @param {String} [options.labelClose]
     * @param {Function} [options.onOk]
     * @param {Function} [options.onClose]
     *
     * @returns {*|jQuery.fn.init|jQuery|HTMLElement}
     */
    static show(options)
    {
        options = options || {};

        let template = $(options['container'] || '.js-confirm-dialog-template').html(),
            title = options['title'] || 'confirmation',
            content = options['content'] || 'Are you sure you want to perform this action?',
            labelOk = options['labelOk'] || 'Ok',
            labelClose = options['labelClose'] || 'Close';

        template = template
            .replace(/\{title\}/gi, title)
            .replace(/\{content\}/gi, content)
            .replace(/\{labelOk\}/gi, labelOk)
            .replace(/\{labelClose\}/gi, labelClose);

        template = $(template);

        template.on('click', '.js-btn-ok', function() {
            if (options['onOk'] instanceof Function) {
                options['onOk'].apply(this, arguments);
            }
        });

        template.on('click', '.js-btn-close', function() {
            if (options['onClose'] instanceof Function) {
                options['onClose'].apply(this, arguments);
            }
            template.remove();
        });

        $(document.body).append(template);

        template.addClass('in');
        template.show();

        return template;
    }
}

export {Confirmation};