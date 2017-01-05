// JavaScript Document
// Starts with Addy Osmani's module / facade
// http://addyosmani.com/resources/essentialjsdesignpatterns/book/#highlighter_436043

const GLOBALNAMESPACE = {};

GLOBALNAMESPACE.NEWOBJECT = (function NEWOBJECT($) {

  const fauxPrivate = {
    i: 5,
    get: function get() {

      console.log(`current value:${this.i}`);

    },
    set: function set(val) {

      this.i = val;

    },
    run: function run() {

      console.log('running');

    },
    jump: function jump() {

      console.log('jumping');

    }
  };
  return {
    init: function init(args) {

      fauxPrivate.set(args.val);
      fauxPrivate.get();
      if (args.run) {

        fauxPrivate.run();

      }
      if (args.run) {

        fauxPrivate.jump();

      }

    }

  };

}(jQuery));

class NewClass {

  constructor() {

  }

}

window.onload = function onload() {

  GLOBALNAMESPACE.NEWOBJECT.init({
    run: true,
    val: 10
  });
  // outputs current value: 10, running

};
