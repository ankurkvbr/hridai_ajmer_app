// Nikita Lebedev's blog, nazz.me/simple-jquery-popup
(function($) {
  $.fn.simplePopup = function(event) {

    var simplePopup = {

      settings: {
        hashtag: "#/",
        url: "popup",
        event: event || "click"
      },

      // Events
      initialize: function(self) {

        var popup = $(".js__popup");
        var body = $(".js__p_body");
        var close = $(".js__p_close");
        var routePopup = simplePopup.settings.hashtag + simplePopup.settings.url;

        var string = self[0].className;
        var name = string.replace("js__p_", "");

        // We redefine the variables if there is an additional popap
        if ( !(name === "start") ) {
	          var new_url = "bhba";
		var new_url = "ambh_popup";
		var new_url = "asbh_popup";
		var new_url = "bhu_popup";
		var new_url = "haca_popup";
		var new_url = "mich_popup";
		var new_url = "such_popup";
		var new_url = "ltc_popup";
		var new_url = "jaco_popup";
			var new_url = "urvi_popup";
		var new_url = "geetha_popup";
		var new_url = "david_popup";
		var new_url = "ilan_popup";
		var new_url = "michel_popup";
		var new_url = "mauro_popup";
		var new_url = "bina_popup";
		var new_url = "rupak_popup";

			var new_url = "rajib_popup";
		var new_url = "niyaz_popup";
		var new_url = "ratna_popup";
		var new_url = "paul_popup";
		var new_url = "vineta_popup";
		var new_url = "shenaz_popup";
		var new_url = "kajal_popup";
		var new_url = "rajani_popup";
			var new_url = "mariana_popup";
		var new_url = "jaya_popup";
		var new_url = "kanil_popup";
		var new_url = "kswati_popup";
		var new_url = "kvikash_popup";
		var new_url = "mare_popup";
		var new_url = "gora_popup";
		var new_url = "durga_popup";
		var new_url = "venkaiah_popup";
		var new_url = "pradeep_popup";
		var new_url = "baro_popup";
		var new_url = "jasm_popup";
		var new_url = "nila_popup";
		var new_url = "sailesh_popup";

		var new_url = "amar_popup";
		var new_url = "dharitri_popup";
		var new_url = "isidore_popup";
		var new_url = "preeti_popup";
		var new_url = "anjali_popup";
		var new_url = "manu_popup";
		var new_url = "jagan_popup";
		var new_url = "adarsh_popup";
		var new_url = "indu_popup";
		var new_url = "saketh_popup";

		var new_url = "shivani_popup";
		var new_url = "tss_popup";
		var new_url = "vishnu_popup";
		var new_url = "kabir_popup";
		var new_url = "hav_popup";
		var new_url = "peter_popup";
		var new_url = "malathi_popup";


          name = name.replace("_start", "_popup");
          popup = $(".js__" + name);
          routePopup = simplePopup.settings.hashtag + new_url;
        };

        // Call when have event
        self.on(simplePopup.settings.event, function() {
          simplePopup.show(popup, body, routePopup);
          return false;
        });

        $(window).on("load", function() {
          simplePopup.hash(popup, body, routePopup);
        });

        // Close
        body.on("click", function() {
          simplePopup.hide(popup, body);
        });

        close.on("click", function() {
          simplePopup.hide(popup, body);
          return false;
        });

        // Closure of the button "Esc"
        $(window).keyup(function(e) {
          if (e.keyCode === 27) {
            simplePopup.hide(popup, body);
          }
        });

      },

      // Centering method
      centering: function(self) {
        var marginLeft = -self.width()/2;
        return self.css("margin-left", marginLeft);
      },

      // The overall function of the show
      show: function(popup, body, routePopup) {
        simplePopup.centering(popup);
        body.removeClass("js__fadeout");
        popup.removeClass("js__slide_top");
        location.hash = routePopup;
      },

      // The overall function of the hide
      hide: function(popup, body) {
        popup.addClass("js__slide_top");
        body.addClass("js__fadeout");
        location.hash = simplePopup.settings.hashtag;
      },

      // Watch hash in URL
      hash: function(popup, body, routePopup) {
        if (location.hash === routePopup) {
          simplePopup.show(popup, body, routePopup);
        }
      }

    };

    // In loop looking for what is called
    return this.each(function() {
      var self = $(this);
      simplePopup.initialize(self);
    });

  };
})(jQuery);

