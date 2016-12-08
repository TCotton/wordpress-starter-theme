/*global clearInterval: false, clearTimeout: false, document: false, event: false, frames: false, history: false, Image: false, location: false, name: false, navigator: false, Option: false, parent: false, screen: false, setInterval: false, setTimeout: false, window: false, XMLHttpRequest: false */

// JavaScript Document
// Starts with Addy Osmani's module / facade
// http://addyosmani.com/resources/essentialjsdesignpatterns/book/#highlighter_436043
var GLOBALNAMESPACE.NEWOBJECT = (function ($) {
    var _private = {
        i: 5,
        get: function () {
            console.log('current value:' + this.i);
        },
        set: function (val) {
            this.i = val;
        },
        run: function () {
            console.log('running');
        },
        jump: function () {
            console.log('jumping');
        }
    };
    return {
        init: function (args) {
            _private.set(args.val);
            _private.get();
            if (args.run) {
                _private.run();
            }
        }
    }
}(jQuery));

window.onload = function () {
    
    GLOBALNAMESPACE.NEWOBJECT.init({
        run: true,
        val: 10
    });
    //outputs current value: 10, running
    
};