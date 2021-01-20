/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./www/js/app/routes/plan.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./www/js/app/components/Alert.js":
/*!****************************************!*\
  !*** ./www/js/app/components/Alert.js ***!
  \****************************************/
/*! exports provided: Alert, messageTypes */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Alert\", function() { return Alert; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"messageTypes\", function() { return messageTypes; });\nconst alertClassTypes = {\n    ERROR: 'bg--error',\n    SUCCESS: 'bg--success',\n    INFO: 'bg--primary',\n    WARNING: 'bg--warning'\n};\n\nconst messageTypes = {\n    ERROR: -1,\n    CLEAR: 0,\n    SUCCESS: 1,\n    COMPLETE: 2\n};\n\nclass Alert\n{\n    static getTemplate()\n    {\n        return $('.js-alert-template').html();\n    }\n\n    /**\n     * @param {string} message\n     * @param {number} [messageType=messageType.ERROR]\n     * @param {jQuery} container\n     * @param {{}} options\n     */\n    static showMessage(message, messageType, container = $('.js-container-alert'), options = {})\n    {\n        if (messageType === undefined) {\n            messageType = messageTypes.ERROR;\n        }\n\n        let alertClass = messageTypes.ERROR;\n\n        switch (messageType) {\n            case messageTypes.ERROR:\n                alertClass = alertClassTypes.ERROR;\n                $('.' + alertClassTypes.ERROR).remove();\n                break;\n            case messageTypes.SUCCESS:\n                alertClass = alertClassTypes.SUCCESS;\n                $('.' + alertClassTypes.SUCCESS).fadeOut();\n                break;\n        }\n\n        let template = Alert.getTemplate();\n\n        template = template\n            .replace(/\\{type\\}/gi, alertClass)\n            .replace(/\\{message\\}/gi, message);\n        template = $(template);\n\n\n        container.append(template);\n\n        options = options || {};\n        if (options['visibleTime'] !== 'notTimeout') {\n            let visibleTime = options['visibleTime'] || 5000;\n\n            setTimeout(function () {\n                template.fadeOut(function () {\n                    template.remove();\n                    if (options.onHide instanceof Function) {\n                        options.onHide();\n                    }\n                });\n            }, visibleTime);\n        }\n\n        if (options['close'] === false) {\n            template.find($('.close')).hide();\n        }\n\n    };\n}\n\n\n\n//# sourceURL=webpack:///./www/js/app/components/Alert.js?");

/***/ }),

/***/ "./www/js/app/components/VisualComponent.js":
/*!**************************************************!*\
  !*** ./www/js/app/components/VisualComponent.js ***!
  \**************************************************/
/*! exports provided: VisualComponent */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"VisualComponent\", function() { return VisualComponent; });\n/* harmony import */ var _libraries_EventManager__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../libraries/EventManager */ \"./www/js/app/libraries/EventManager.js\");\n/* harmony import */ var _Alert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Alert */ \"./www/js/app/components/Alert.js\");\n\n\n\n\n\nconst config = {\n    lockedClass: 'disabled'\n};\n\nclass VisualComponent {\n    /**\n     * @param {jQuery|string} container\n     */\n    constructor(container) {\n        this.container = $(container);\n        this._locked = 0;\n\n        this.alert = new _Alert__WEBPACK_IMPORTED_MODULE_1__[\"Alert\"]();\n\n        this.elements = {};\n\n        /** @member {EventManager} */\n        this.eventManager = new _libraries_EventManager__WEBPACK_IMPORTED_MODULE_0__[\"EventManager\"]();\n    }\n\n    /**\n     * @param {jQuery} [element]\n     */\n    lock(element) {\n        if (element instanceof jQuery) {\n            element.addClass(config.lockedClass);\n            return;\n        }\n\n        this._locked++;\n        this._refreshLock();\n    };\n\n    /**\n     * @param {boolean|jQuery} [hard=false]\n     */\n    unlock(hard) {\n        if (hard instanceof jQuery) {\n            hard.removeClass(config.lockedClass);\n            return;\n        }\n\n        if (this._locked < 1) {\n            return;\n        }\n\n        if (hard === undefined) {\n            hard = false;\n        }\n\n        if (hard === true) {\n            this._locked = 0;\n        } else {\n            this._locked--;\n        }\n\n        this._refreshLock();\n    };\n\n    /**\n     * @return {boolean}\n     */\n    checkLock() {\n        return this._locked === 0;\n    };\n\n    _refreshLock() {\n        if (this.container instanceof jQuery) {\n            if (this._locked === 0) {\n                this.container.removeClass(config.lockedClass);\n                this.afterUnlock();\n            } else {\n                this.container.addClass(config.lockedClass);\n                this.afterLock();\n            }\n        }\n    };\n\n    afterLock()\n    {\n    }\n\n    afterUnlock()\n    {\n    }\n\n    /**\n     * @param {string} message\n     * @param {number} [messageType=messageType.ERROR]\n     * @param {string} container\n     * @param {{}} options\n     */\n    static showMessage(message, messageType, container, options) {\n        _Alert__WEBPACK_IMPORTED_MODULE_1__[\"Alert\"].showMessage(message, messageType, container, options);\n    };\n\n    /**\n     * @param {string} event\n     * @param {*} [data]\n     */\n    trigger(event, data) {\n        this.eventManager.trigger(event, data, this);\n    };\n\n    /**\n     * @param {string} event\n     * @param {*} [data]\n     */\n    globalTrigger(event, data) {\n        _libraries_EventManager__WEBPACK_IMPORTED_MODULE_0__[\"EventManager\"].global.trigger(event, data, this);\n    };\n\n    /**\n     * @param {string} event\n     * @param {function} callback\n     * @returns {CallbackHandler}\n     */\n    on(event, callback) {\n        return this.eventManager.listen.apply(this.eventManager, arguments);\n    };\n\n    /**\n     * @param {string} event\n     * @param {function} callback\n     * @returns {CallbackHandler}\n     */\n    static globalOn(event, callback) {\n        return _libraries_EventManager__WEBPACK_IMPORTED_MODULE_0__[\"EventManager\"].global.listen(event, callback);\n    };\n\n    /**\n     * @param {CallbackHandler} callbackHandler\n     */\n    off(callbackHandler) {\n        this.eventManager.detach.apply(this.eventManager, arguments);\n    };\n\n    /**\n     * @param {CallbackHandler} callbackHandler\n     */\n    static globalOff(callbackHandler) {\n        _libraries_EventManager__WEBPACK_IMPORTED_MODULE_0__[\"EventManager\"].global.detach(callbackHandler);\n    };\n}\n\n\n\n//# sourceURL=webpack:///./www/js/app/components/VisualComponent.js?");

/***/ }),

/***/ "./www/js/app/components/dialog/Confirmation.js":
/*!******************************************************!*\
  !*** ./www/js/app/components/dialog/Confirmation.js ***!
  \******************************************************/
/*! exports provided: Confirmation */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Confirmation\", function() { return Confirmation; });\n/* harmony import */ var _VisualComponent__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../VisualComponent */ \"./www/js/app/components/VisualComponent.js\");\n\n\nclass Confirmation extends _VisualComponent__WEBPACK_IMPORTED_MODULE_0__[\"VisualComponent\"]\n{\n    /**\n     * @param {{}} [options]\n     * @param {String} [options.container]\n     * @param {String} [options.title]\n     * @param {String} [options.labelOk]\n     * @param {String} [options.labelClose]\n     * @param {Function} [options.onOk]\n     * @param {Function} [options.onClose]\n     *\n     * @returns {*|jQuery.fn.init|jQuery|HTMLElement}\n     */\n    static show(options)\n    {\n        options = options || {};\n\n        let template = $(options['container'] || '.js-confirm-dialog-template').html(),\n            title = options['title'] || 'confirmation',\n            content = options['content'] || 'Are you sure you want to perform this action?',\n            labelOk = options['labelOk'] || 'Ok',\n            labelClose = options['labelClose'] || 'Close';\n\n        template = template\n            .replace(/\\{title\\}/gi, title)\n            .replace(/\\{content\\}/gi, content)\n            .replace(/\\{labelOk\\}/gi, labelOk)\n            .replace(/\\{labelClose\\}/gi, labelClose);\n\n        template = $(template);\n\n        template.on('click', '.js-btn-ok', function() {\n            if (options['onOk'] instanceof Function) {\n                options['onOk'].apply(this, arguments);\n            }\n        });\n\n        template.on('click', '.js-btn-close', function() {\n            if (options['onClose'] instanceof Function) {\n                options['onClose'].apply(this, arguments);\n            }\n            template.remove();\n        });\n\n        $(document.body).append(template);\n\n        template.addClass('in');\n        template.show();\n\n        return template;\n    }\n}\n\n\n\n//# sourceURL=webpack:///./www/js/app/components/dialog/Confirmation.js?");

/***/ }),

/***/ "./www/js/app/libraries/EventManager.js":
/*!**********************************************!*\
  !*** ./www/js/app/libraries/EventManager.js ***!
  \**********************************************/
/*! exports provided: EventManager, Event, CallbackHandler */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"EventManager\", function() { return EventManager; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"Event\", function() { return Event; });\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"CallbackHandler\", function() { return CallbackHandler; });\n\n\n/**\n * @param {string} event\n * @param {number} callbackId\n * @constructor\n */\nfunction CallbackHandler(event, callbackId)\n{\n    this.event = event;\n    this.callbackId = callbackId;\n}\n\n/**\n * @param {string} eventType\n * @param {Object} target\n * @param {*} data\n * @param {number} counter\n * @constructor\n */\nfunction Event(eventType, target, data, counter)\n{\n    this.eventType = eventType;\n    this.target = target;\n    this.data = data;\n    this.counter = counter;\n}\n\nclass EventManager\n{\n    constructor()\n    {\n        this.listeners = {};\n        this.triggerCounter = {};\n    }\n\n    /**\n     * @param {string} eventType\n     * @param {Object} [data]\n     * @param {Object} [target]\n     * @returns {boolean|null}\n     */\n    trigger(eventType, data, target)\n    {\n        let event = new Event(\n            eventType, target, data, this._addTriggerCounter(eventType)\n        );\n\n        if (\n            (this.listeners.hasOwnProperty('*') === true) &&\n            (eventType !== '*')\n        ) {\n            this._addTriggerCounter('*');\n            EventManager._triggerProcess(this.listeners['*'], event);\n        }\n\n        if (this.listeners.hasOwnProperty(eventType) === false) {\n            return null;\n        }\n\n        return EventManager._triggerProcess(this.listeners[eventType], event);\n    };\n\n    /**\n     * @param {string} event\n     * @param {function} callback\n     * @returns {CallbackHandler}\n     */\n    listen(event, callback)\n    {\n        if (this.listeners.hasOwnProperty(event) === false) {\n            this.listeners[event] = [];\n        }\n\n        let callbackId = this.listeners[event].push(callback);\n        return new CallbackHandler(event, callbackId);\n    };\n\n    /**\n     * @param {CallbackHandler} callbackHandler\n     */\n    detach(callbackHandler)\n    {\n        delete this.listeners[callbackHandler.event][callbackHandler.callbackId];\n    };\n\n    /**\n     * @param {string} event\n     * @return {number|boolean}\n     */\n    checkEvent(event)\n    {\n        return this.triggerCounter.hasOwnProperty(event) ? this.triggerCounter[event] : false;\n    };\n\n    /**\n     * @param {string} event\n     * @return {number}\n     */\n    _addTriggerCounter(event)\n    {\n        let tg = this.triggerCounter;\n\n        if (tg.hasOwnProperty(event) === false) {\n            tg[event] = 0;\n        }\n\n        return ++tg[event];\n    }\n\n    /**\n     * @param {Function} callbacks\n     * @param {Event} event\n     * @returns {boolean}\n     */\n    static _triggerProcess(callbacks, event)\n    {\n        let i, r, response = true;\n\n        for (i = 0; i < callbacks.length; i++) {\n            if (callbacks[i] !== undefined) {\n                r = callbacks[i](event.data, event);\n                if (r !== undefined) {\n                    response = response && r;\n                }\n            }\n        }\n\n        return response;\n    }\n}\n\nEventManager.global = new EventManager();\n\n\n\n//# sourceURL=webpack:///./www/js/app/libraries/EventManager.js?");

/***/ }),

/***/ "./www/js/app/routes/plan.js":
/*!***********************************!*\
  !*** ./www/js/app/routes/plan.js ***!
  \***********************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _components_dialog_Confirmation__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../components/dialog/Confirmation */ \"./www/js/app/components/dialog/Confirmation.js\");\n\n\n$(function() {\n\n    if (!window.sma.user.plan_id) {\n        return;\n    }\n\n    let acceptSubmit = false;\n\n    $('#form-plan-base').on('submit', function() {\n        let form = this;\n\n        if (acceptSubmit) {\n            return true;\n        }\n\n        _components_dialog_Confirmation__WEBPACK_IMPORTED_MODULE_0__[\"Confirmation\"].show({\n            title: 'Change plan to Basic.',\n            content: 'Do you really want to change the plan?',\n            onOk: function() {\n                acceptSubmit = true;\n                form.submit();\n            },\n        });\n\n        return false;\n    });\n\n    $('#form-plan-advanced').on('submit', function() {\n        let form = this;\n\n        if (acceptSubmit) {\n            return true;\n        }\n\n        _components_dialog_Confirmation__WEBPACK_IMPORTED_MODULE_0__[\"Confirmation\"].show({\n            title: 'Change plan to Advanced.',\n            content: 'Do you really want to change the plan?',\n            onOk: function() {\n                acceptSubmit = true;\n                form.submit();\n            },\n        });\n\n        return false;\n    });\n});\n\n//# sourceURL=webpack:///./www/js/app/routes/plan.js?");

/***/ })

/******/ });