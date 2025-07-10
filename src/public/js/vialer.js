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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./src/resources/assets/js/vialer.js":
/*!*******************************************!*\
  !*** ./src/resources/assets/js/vialer.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$.widget("ajtarragona.vialerMap", {
  options: {
    center: {
      lat: 0,
      lng: 0
    },
    zoom: 15,
    geolocate: true,
    multiple: false,
    readonly: false,
    disabled: false,
    animation: false,
    cluster: true,
    fitbounds: false,
    clusterMinZoom: 15,
    mapType: 'roadmap',
    method: 'get',
    url: false,
    customicons: false,
    controls: {
      zoom: true,
      mapType: false,
      scale: false,
      streetView: false,
      rotate: false,
      fullscreen: true
    },
    styles: [{
      featureType: "poi",
      stylers: [{
        visibility: "off"
      }]
    }, {
      featureType: "transit",
      stylers: [{
        visibility: "off"
      }]
    }]
  },
  _create: function _create() {
    var o = this;
    //al("vialerMap", o.element);
    this.options = $.extend({}, this.options, this.element.data());
    this.mapoptions = {
      center: this.options.center,
      zoom: this.options.zoom,
      mapTypeId: this.options.mapType,
      zoomControl: this.options.controls.zoom,
      mapTypeControl: this.options.controls.mapType,
      mapTypeControlOptions: {
        // style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
        position: google.maps.ControlPosition.LEFT_BOTTOM,
        mapTypeIds: ['roadmap', 'satellite', 'hybrid', 'terrain']
      },
      scaleControl: this.options.controls.scale,
      streetViewControl: this.options.controls.streetView,
      rotateControl: this.options.controls.rotate,
      fullscreenControl: this.options.controls.fullscreen,
      styles: this.options.styles
    };
    this.gmap = new google.maps.Map(this.element[0], this.mapoptions);
    this.infoWindow = new google.maps.InfoWindow({
      map: this.gmap
    });
    if (this.options.geolocate) {
      this._geolocate(function () {
        o._initAll();
      });
    } else {
      o._initAll();
    }
  },
  _initAll: function _initAll() {

    // if(this.options.marker){

    //this.addMarker(this.gmap.getCenter());
    // }
  },
  _geolocate: function _geolocate(callback) {
    var o = this;
    //al("Geolocating");
    // Try HTML5 geolocation.
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function (position) {
        o.geoposition = position;
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        o.setCenter(pos);
        executeCallback(callback);
      }, function () {
        o._handleLocationError(true);
      });
    } else {
      // Browser doesn't support Geolocation
      o._handleLocationError(false);
    }
  },
  _handleLocationError: function _handleLocationError(browserHasGeolocation) {
    var o = this;
    o.infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
    o.infoWindow.setPosition(o.gmap.getCenter());
    o.infoWindow.open(o.map);
  },
  _isReadonly: function _isReadonly() {
    return this.options.readonly || this.options.disabled;
  },
  //Funciones publicas
  enable: function enable() {
    this.options.readonly = true;
  },
  disable: function disable() {
    this.options.readonly = false;
  },
  setCenter: function setCenter(center) {
    //al('setCenter',center);
    //al(this.gmap);
    this.options.center = center;
    if (this.gmap) this.gmap.setCenter(center);
  },
  getCenter: function getCenter() {
    //al('setCenter');
    return this.gmap.getCenter();
  },
  deleteMarker: function deleteMarker() {
    var o = this;
    if (this.marker) {
      this.marker.setMap(null);
      this.marker = null;
      this.element.trigger("vialermap:markerdeleted", this);
    }
  },
  setMarkerPosition: function setMarkerPosition(lat, lng) {
    var o = this;
    if ((is_int(parseInt(lat)) || is_float(parseFloat(lat))) && (is_int(parseInt(lng)) || is_float(parseFloat(lng)))) {
      var center = {
        lat: parseFloat(lat),
        lng: parseFloat(lng)
      };

      //al('setMarkerPosition', center);
      //al(this.marker);
      if (this.marker) {
        this.marker.setPosition(center);
        if (!this.gmap.getBounds().contains(this.marker.getPosition())) {
          this.setCenter(center);
        }
      } else {
        this.addMarker(center);
        //si no no centra bien
        setTimeout(function () {
          o.setCenter(center);
        }, 10);
      }
    }
  },
  getMarkerPosition: function getMarkerPosition() {
    if (this.marker) return this.marker.getPosition();else return null;
  },
  addMarker: function addMarker(coords) {
    var o = this;
    if (!coords) coords = this.getCenter();
    if (this.marker) {
      this.setMarkerPosition(coords.lat(), coords.lng());
    } else {
      //al("addMarker ", coords);

      var markerargs = {
        position: coords,
        draggable: !this._isReadonly(),
        animation: this.options.animation ? google.maps.Animation.DROP : false,
        map: this.gmap
      };
      this.marker = new google.maps.Marker(markerargs);
      this.marker.addListener('drag', function () {
        // al("DRAG");
      });
      this.marker.addListener('dragend', function () {
        // al("marker drooped");
        o.element.trigger("vialermap:markerchanged", o);
      });
      this.marker.addListener('rightclick', function (point) {
        if (!o._isReadonly()) {
          o.deleteMarker();
        }
      });
    }
  },
  hasMarker: function hasMarker() {
    return this.marker != null;
  }
});
$.widget("ajtarragona.vialerField", {
  options: {},
  _create: function _create() {
    var o = this;
    // al("vialerField", o.element);
    this.options = $.extend({}, this.options, this.element.data());
    this.name = this.element.find('input.vialer-value');
    this.inputs = this.element.find('input');
    this.searchButtons = this.element.find('.search-button');
    this.clearButton = this.element.find('.clear-button');
    this.parcelaButton = this.element.find('.refcat-button');
    this.markerButton = this.element.find('.marker-button');
    this.map = this.element.find('.vialer-map');
    this.inputVia = this.element.find('input.tt-input');
    // al(this.inputVia);

    var currentval = this._value();
    // al(currentval);

    // this.inputVia.on('focus',function(e){
    //   al('focus', $(this).prop('readonly'));
    //   if($(this).prop('readonly')){
    //     e.stopPropagation();
    //     e.preventDefault();
    //   }
    // });

    if (currentval && currentval.via && currentval.via.codi && currentval.via.nom && currentval.via.tipus) {
      this._disableInputVia();
    }
    this.searchButtons.on('click', function (e) {
      var type = $(this).attr('value');
      o._search(type);
    });
    this.clearButton.on('click', function () {
      o.inputs.val('');
      o.inputVia.tgnAutocomplete('clear');
      o.map.vialerMap('deleteMarker');
    });
    this.inputs.on('keyup', function () {
      // al('keyup', $(this));
      if (!o._isReadonly()) {
        if ($(this).is(o.inputVia)) {
          var nomcarrer = $(this).val().toUpperCase();
          if (nomcarrer.includes(" ")) {
            var tipus = nomcarrer.substring(0, nomcarrer.indexOf(" "));
            nomcarrer = nomcarrer.substring(nomcarrer.indexOf(" ") + 1);
            o._setFieldValue('via.tipus', tipus);
            o._setFieldValue('via.nom', nomcarrer);
          } else {
            o._setFieldValue('via.nom', nomcarrer);
          }
        }
        o._update();
      }
    });
    this.inputVia.on('tgnautocomplete:change', function (e, ret) {
      // al("chained autocomplete changed");
      // al('selected', ret.item);

      if (ret.item.value) o._disableInputVia();else o._enableInputVia();
      o._setFieldValue('via.tipus', ret.item.tipusVia);
      o._setFieldValue('via.nom', ret.item.nomLlarg);
      // al('tgnautocomplete:change',o.inputVia);
      // setTimeout(function(){
      //   o.inputVia.val(ret.item.nomLlarg);
      // },10);

      o._update();
    });
    this.parcelaButton.on('click', function () {
      o._openParcela();
    });
    this.markerButton.on('click', function (e) {
      o.map.vialerMap('addMarker');
      var pos = o.map.vialerMap('getMarkerPosition');
      o._setFieldValue('location.lat', pos.lat());
      o._setFieldValue('location.lng', pos.lng());
      o._update();
    });
    this.map.vialerMap();
    this.map.on('vialermap:markerchanged', function (e, map) {
      var pos = map.getMarkerPosition();
      o._setFieldValue('location.lat', pos.lat());
      o._setFieldValue('location.lng', pos.lng());
      o._update();
    });
    this.map.on('vialermap:markerdeleted', function (e, map) {
      o._setFieldValue('location.lat', '');
      o._setFieldValue('location.lng', '');
      o._update();
    });

    // this.map.vialerMap('sayhello','hello','world');

    this._updateValue();
  },
  _disableInputVia: function _disableInputVia() {
    this.inputVia.prop('readonly', true).prop('disabled', true);
  },
  _enableInputVia: function _enableInputVia() {
    this.inputVia.prop('readonly', false).prop('disabled', false);
  },
  _initMap: function _initMap() {},
  _openParcela: function _openParcela() {
    var o = this;
    var value = o._value();
    // al(value);
    var modalurl = route('vialer.parcela', {
      'refcat': value.refcat
    }); //baseUrl()+"/backend/entities/componentmodal";
    var params = {};
    TgnModal.open(modalurl, 'get', params, {
      onsuccess: function onsuccess(modal) {},
      size: 'lg',
      padding: 0
    });
  },
  _initModalForm: function _initModalForm(modal) {
    var o = this;
    // al('_initModalForm');
    modal.find('.vialer-search-form').on('submit', function (e) {
      e.preventDefault();
      var form = $(this);
      var url = form.attr('action');
      var method = form.attr('method');
      $('html').stopLoading();
      //   al('submit search',url);
      var params = form.serializeControls();
      //   al(params);
      modal.find('#vialer-search-results').startLoading();
      $.ajax({
        url: url,
        type: method,
        data: params,
        dataType: 'html',
        success: function success(content) {
          //   al(content);
          modal.find('#vialer-search-results').html($(content).find('#vialer-search-results')).tgnInitAll();
          o._initSearchResults(modal);
          modal.find('#vialer-search-results').stopLoading();
        },
        error: function error(xhr) {
          modal.find('#vialer-search-results').stopLoading();
          TgnFlash.error(__("Error recuperando domicilios"));
          // modal.modal('hide');
        }
      });
    });
  },

  _search: function _search(type) {
    var o = this;
    var modalurl = route('vialer.search', {
      'type': type
    }); //baseUrl()+"/backend/entities/componentmodal";
    var params = o._value();
    TgnModal.open(modalurl, 'post', params, {
      onsuccess: function onsuccess(modal) {
        o._initModalForm(modal);
        o._initSearchResults(modal);
      },
      size: 'lg',
      padding: 0
    });
  },
  _initSearchResults: function _initSearchResults(modal) {
    var o = this;
    // al('_initSearchResults',modal);
    var isnumerero = modal.find('table').data('numerero');
    modal.find('table tbody tr').on('click', function (e) {
      // al('click row', $(this).data('id'));
      if (isnumerero) {
        o._selectNumerero($(this), modal);
      } else {
        o._recuperaDomicili($(this), modal);
      }
    });
  },
  _selectNumerero: function _selectNumerero(row, modal) {
    var o = this;
    var rc = row.data('rc');
    var numero = row.data('numero');
    var url = route('vialer.numerero', {
      'rc': rc
    });
    var params = {};
    row.startLoading();
    $.ajax({
      url: url,
      type: 'get',
      data: params,
      dataType: 'html',
      success: function success(content) {
        modal.find('.vialer-search-form input[name=numero]').val(numero);
        modal.find('.vialer-search-form input[name=escala]').val('');
        modal.find('.vialer-search-form input[name=bloc]').val('');
        modal.find('.vialer-search-form input[name=planta]').val('');
        modal.find('.vialer-search-form input[name=porta]').val('');
        modal.find('#vialer-search-results').html(content).tgnInitAll();
        o._initSearchResults(modal);
        // al(content);

        row.stopLoading();
      },
      error: function error(xhr) {
        row.stopLoading();
        TgnFlash.error(__("Error recuperando domicilios"));
        // modal.modal('hide');
      }
    });
  },

  _recuperaDomicili: function _recuperaDomicili(row, modal) {
    var o = this;
    var rc = row.data('rc');
    var url = route('vialer.domicili', {
      'rc': rc
    });
    var params = {};
    row.startLoading();
    $.ajax({
      url: url,
      type: 'get',
      data: params,
      dataType: 'json',
      success: function success(domicili) {
        //al('_recuperaDomicili',domicili);
        modal.modal('hide');
        row.stopLoading();
        if (domicili.viaIris) {
          o.inputVia.tgnAutocomplete('value', {
            value: domicili.viaIris.code,
            name: domicili.viaIris.acronym + ' ' + domicili.viaIris.stname
          });
          o._setFieldValue("via.tipus", domicili.viaIris.acronym);
          o._setFieldValue("via.nom", domicili.viaIris.stname);
          o._setFieldValue("via.codi", domicili.viaIris.code);
        } else {
          o.inputVia.tgnAutocomplete('value', {
            value: domicili.via.codigoVia,
            name: domicili.via.tipoVia + ' ' + domicili.via.nombreVia
          });
          o._setFieldValue("via.tipus", domicili.via.tipoVia);
          o._setFieldValue("via.nom", domicili.via.nombreVia);
          o._setFieldValue("via.codi", domicili.via.codigoVia);
        }
        o._setFieldValue("numero", domicili.numero);
        o._setFieldValue("lletra", domicili.letra);
        o._setFieldValue("escala", domicili.escalera);
        o._setFieldValue("bloc", domicili.bloque);
        o._setFieldValue("planta", domicili.planta);
        o._setFieldValue("porta", domicili.puerta);
        o._setFieldValue("codi_postal", domicili.codigo_postal);
        o._setFieldValue("refcat", domicili.rc.completa);
        o._setFieldValue("location.lat", domicili.xy.lat);
        o._setFieldValue("location.lng", domicili.xy.lng);
        o._setFieldValue("provincia", domicili.provincia);
        o._setFieldValue("municipi", domicili.municipi);
        o._setFieldValue("districte", domicili.districte);
        o._setFieldValue("seccio", domicili.seccio);
        o._setFieldValue("districte_administratiu", domicili.districte_administratiu ? domicili.districte_administratiu.toUpperCase() : '');
        o._update();
        o._setMapMarker(domicili.xy.lat, domicili.xy.lng);

        // modal.modal('hide');
      },

      error: function error(xhr) {
        row.stopLoading();
        TgnFlash.error(__("Error recuperando domicilio"));
        // modal.modal('hide');
      }
    });
  },

  _setMapMarker: function _setMapMarker(lat, lng) {
    //al("Moviendo marcador a "+lat+","+lng);
  },
  _setFieldValue: function _setFieldValue(name, value) {
    name = "[" + name.replace(".", "][") + "]";
    var input = this.element.find('input[name="' + this.options.name + '' + name + '"]');
    if (input.length > 0) input.val(value);
  },
  _getFieldValue: function _getFieldValue(name) {
    //return this.element.find('[name=]);
  },
  _toJson: function _toJson() {
    return JSON.stringify(this._value(), undefined, 4);
  },
  _data_get: function _data_get(obj, string) {
    var parts = string.split('.');
    var newObj = obj[parts[0]];
    if (parts[1]) {
      parts.splice(0, 1);
      var newString = parts.join('.');
      return this._data_get(newObj, newString);
    }
    return newObj;
  },
  _value: function _value() {
    var fields = this.element.closest('form').serializeControls();
    // al('_value', fields);
    var fieldname = this.options.name.replaceAll('[', '.').replaceAll(']', '');
    // al(fieldname);
    var ret = this._data_get(fields, fieldname);
    // al(ret);
    return ret;
  },
  _isReadonly: function _isReadonly() {
    return this.options.readonly || this.options.disabled;
  },
  _updateValue: function _updateValue() {
    var o = this;
    var json = o._toJson();
    // al('_updateValue',json);
    o.element.find('#' + o.options.name + '-value').html(json);
    o._updateMapMarker();
    o._updateParcela();
  },
  _update: function _update() {
    //al("Update");
    var o = this;
    o._updateValue();
    // al('trigger changed',o.element);
    o.element.trigger("changed", o);
  },
  _updateParcela: function _updateParcela() {
    var o = this;
    var value = o._value();
    if (value.refcat && value.refcat.length >= 14) {
      o.parcelaButton.prop('disabled', false).removeClass('disabled');
    } else {
      o.parcelaButton.prop('disabled', true).addClass('disabled');
    }
  },
  _updateMapMarker: function _updateMapMarker() {
    var o = this;
    var value = o._value();
    // al('hasMarker', o.map.vialerMap('hasMarker'));
    o.map.vialerMap('setMarkerPosition', value.location.lat, value.location.lng);
    if (o.map.vialerMap('hasMarker')) {
      o.markerButton.prop('disabled', true).addClass('disabled');
    } else {
      if (!o._isReadonly()) o.markerButton.prop('disabled', false).removeClass('disabled');
    }
  }
});

/***/ }),

/***/ "./src/resources/assets/sass/vialer.scss":
/*!***********************************************!*\
  !*** ./src/resources/assets/sass/vialer.scss ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!*****************************************************************************************!*\
  !*** multi ./src/resources/assets/js/vialer.js ./src/resources/assets/sass/vialer.scss ***!
  \*****************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\xampp\htdocs\laravel\packages\ajtarragona\vialer\src\resources\assets\js\vialer.js */"./src/resources/assets/js/vialer.js");
module.exports = __webpack_require__(/*! C:\xampp\htdocs\laravel\packages\ajtarragona\vialer\src\resources\assets\sass\vialer.scss */"./src/resources/assets/sass/vialer.scss");


/***/ })

/******/ });