/*
 *  Project:        Symfony2Admingenerator
 *  Description:    jQuery plugin for GoogleMap form widget
 *  Authors:        loostro <loostro@gmail.com>, Ollie Harridge
 *  License:        MIT
 */

// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, undefined ) {
    
    // undefined is used here as the undefined global variable in ECMAScript 3 is
    // mutable (ie. it can be changed by someone else). undefined isn't really being
    // passed in so we can ensure the value of it is truly undefined. In ES5, undefined
    // can no longer be modified.
    
    // window is passed through as local variable rather than global
    // as this (slightly) quickens the resolution process and can be more efficiently
    // minified (especially when both are regularly referenced in your plugin).

    // Create the defaults once
    var pluginName = 'googleMap',
        document = window.document,
        defaults = {};

    // The actual plugin constructor
    function Plugin( element, options ) {
        this.element = element;
        
        // Plugin-scope helper
        var that = this;

        // jQuery has an extend method which merges the contents of two or
        // more objects, storing the result in the first object. The first object
        // is generally empty as we don't want to alter the default options for
        // future instances of the plugin
        this.options = $.extend({
            'search_input_el':          null,
            'search_action_el':         null,
            'search_error_el':          null,
            'current_position_el':      null,
            'default_lat':              51.5,
            'default_lng':              -0.1245,
            'default_zoom':             5,
            'lat_field':                null,
            'lng_field':                null,
            'callback':                 function (location, gmap) {},
            'error_handler':            function (elem, status) {},
        }, defaults, options);
        
        this._defaults = defaults;
        this._name = pluginName;
        
        // define geocoder
        this.geocoder = new google.maps.Geocoder();
        this._init();
    }
    
    Plugin.prototype = {

        _init: function() {
            // Plugin-scope helper
            var that = this;
            
            // init variables
            var center = new google.maps.LatLng(
                this.options.default_lat,
                this.options.default_lng
            );
            var mapOptions = {
                zoom: this.options.default_zoom,
                center: center,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
			
            // init map with marker on center
            this.map = new google.maps.Map(this.element, mapOptions);
            this.addMarker(center);

            google.maps.event.addListener(this.marker, "dragend", function(event) {
                var point = that.marker.getPosition();
                that.map.panTo(point);
                that.updateLocation(point);
            });

            google.maps.event.addListener(this.map, 'click', function(event) {
                that.insertMarker(event.latLng);
            });

            this.options.search_action_el.click($.proxy(this.searchAddress, this));			
            this.options.current_position_el.click($.proxy(this.currentPosition, this));            
        },

        searchAddress: function(e) {
            e.preventDefault();
			
            // Plugin-scope helper
            var that = this;
            
            var address = this.options.search_input_el.val();
            this.geocoder.geocode({'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    that.map.setCenter(results[0].geometry.location);
                    that.map.setZoom(16);
                    that.insertMarker(results[0].geometry.location);
                } else {
                    if ($.isFunction(that.settings.error_handler) {
                        that.settings.error_handler(that.options.search_error_el, status);
                    }
                }
            });
        },

        currentPosition: function(e){
            e.preventDefault();
			
            // Plugin-scope helper
            var that = this;
			
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition ( 
                    function(position) {
                        var clientPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        that.insertMarker(clientPosition);
                        that.map.setCenter(clientPosition);
                        that.map.setZoom(16);
                    }, 
                    function(error) {
                        if ($.isFunction(that.settings.error_handler) {
                            that.options.error_handler(that.options.search_error_el, error);
                        }
                    }
                );      
            } else {
                if ($.isFunction(that.settings.error_handler) {
                    that.options.error_handler(that.options.search_error_el, 'Your broswer does not support geolocation');
                }
            }
        },

        updateLocation: function(location) {
            this.options.lat_field.val(location.lat());
            this.options.lng_field.val(location.lng());
            this.options.callback(location, this);
        },

        addMarker: function(center) {
            if (this.marker) {
                this.marker.setMap(this.map);
                this.marker.setPosition(center);
            } else {
                this.marker = new google.maps.Marker({
                    map: this.map,
                    position: center,
                    draggable: true
                });
            }
        },

        insertMarker: function(position) {
            this.removeMarker();
            this.addMarker(position);
            this.updateLocation(position);
        },
		
        removeMarker: function() {
            if (this.marker != undefined) {
                this.marker.setMap(null);
            }
        }
    };

    // You don't need to change something below:
    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations and allowing any
    // public function (ie. a function whose name doesn't start
    // with an underscore) to be called via the jQuery plugin,
    // e.g. $(element).defaultPluginName('functionName', arg1, arg2)
    $.fn[pluginName] = function ( options ) {
        var args = arguments;

        // Is the first parameter an object (options), or was omitted,
        // instantiate a new instance of the plugin.
        if (options === undefined || typeof options === 'object') {
            return this.each(function () {

                // Only allow the plugin to be instantiated once,
                // so we check that the element has no plugin instantiation yet
                if (!$.data(this, 'plugin_' + pluginName)) {

                    // if it has no instance, create a new one,
                    // pass options to our plugin constructor,
                    // and store the plugin instance
                    // in the elements jQuery data object.
                    $.data(this, 'plugin_' + pluginName, new Plugin( this, options ));
                }
            });

        // If the first parameter is a string and it doesn't start
        // with an underscore or "contains" the `init`-function,
        // treat this as a call to a public method.
        } else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {

            // Cache the method call
            // to make it possible
            // to return a value
            var returns;

            this.each(function () {
                var instance = $.data(this, 'plugin_' + pluginName);

                // Tests that there's already a plugin-instance
                // and checks that the requested public method exists
                if (instance instanceof Plugin && typeof instance[options] === 'function') {

                    // Call the method of our plugin instance,
                    // and pass it the supplied arguments.
                    returns = instance[options].apply( instance, Array.prototype.slice.call( args, 1 ) );
                }

                // Allow instances to be destroyed via the 'destroy' method
                if (options === 'destroy') {
                  $.data(this, 'plugin_' + pluginName, null);
                }
            });

            // If the earlier cached method
            // gives a value back return the value,
            // otherwise return this to preserve chainability.
            return returns !== undefined ? returns : this;
        }
    };

}(jQuery, window));
