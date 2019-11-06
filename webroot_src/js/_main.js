/**
 * Bliss Javascript
 */
var SE = {
  // Global settings/variables.
  // (For the sake of good development: try to add as little variables here as possible).
  settings: {
    $html: $('html'),
    $body: $('body'),
    $window: $(window),
    $document: $(document)
  },

  /**
   * Initialize the app
   */
  init: function () {
    // Let developers know that this file is loaded properly!
    console.debug("javascript is locked and loaded!");
  }
};

module.exports = SE;