!function(e){var t={};function i(a){if(t[a])return t[a].exports;var n=t[a]={i:a,l:!1,exports:{}};return e[a].call(n.exports,n,n.exports,i),n.l=!0,n.exports}i.m=e,i.c=t,i.d=function(e,t,a){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:a})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(e,t){if(1&t&&(e=i(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var a=Object.create(null);if(i.r(a),Object.defineProperty(a,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)i.d(a,n,function(t){return e[t]}.bind(null,n));return a},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="/",i(i.s=0)}([function(e,t,i){i(1),e.exports=i(2)},function(e,t){$.widget("ajtarragona.vialerMap",{options:{center:{lat:0,lng:0},zoom:15,geolocate:!0,multiple:!1,readonly:!1,disabled:!1,animation:!1,cluster:!0,fitbounds:!1,clusterMinZoom:15,mapType:"roadmap",method:"get",url:!1,customicons:!1,controls:{zoom:!0,mapType:!1,scale:!1,streetView:!1,rotate:!1,fullscreen:!0},styles:[{featureType:"poi",stylers:[{visibility:"off"}]},{featureType:"transit",stylers:[{visibility:"off"}]}]},_create:function(){var e=this;this.options=$.extend({},this.options,this.element.data()),this.mapoptions={center:this.options.center,zoom:this.options.zoom,mapTypeId:this.options.mapType,zoomControl:this.options.controls.zoom,mapTypeControl:this.options.controls.mapType,mapTypeControlOptions:{position:google.maps.ControlPosition.LEFT_BOTTOM,mapTypeIds:["roadmap","satellite","hybrid","terrain"]},scaleControl:this.options.controls.scale,streetViewControl:this.options.controls.streetView,rotateControl:this.options.controls.rotate,fullscreenControl:this.options.controls.fullscreen,styles:this.options.styles},this.gmap=new google.maps.Map(this.element[0],this.mapoptions),this.infoWindow=new google.maps.InfoWindow({map:this.gmap}),this.options.geolocate?this._geolocate((function(){e._initAll()})):e._initAll()},_initAll:function(){},_geolocate:function(e){var t=this;navigator.geolocation?navigator.geolocation.getCurrentPosition((function(i){t.geoposition=i;var a={lat:i.coords.latitude,lng:i.coords.longitude};t.setCenter(a),executeCallback(e)}),(function(){t._handleLocationError(!0)})):t._handleLocationError(!1)},_handleLocationError:function(e){var t=this;t.infoWindow.setContent(e?"Error: The Geolocation service failed.":"Error: Your browser doesn't support geolocation."),t.infoWindow.setPosition(t.gmap.getCenter()),t.infoWindow.open(t.map)},_isReadonly:function(){return this.options.readonly||this.options.disabled},enable:function(){this.options.readonly=!0},disable:function(){this.options.readonly=!1},setCenter:function(e){this.options.center=e,this.gmap&&this.gmap.setCenter(e)},getCenter:function(){return this.gmap.getCenter()},deleteMarker:function(){this.marker&&(this.marker.setMap(null),this.marker=null,this.element.trigger("vialermap:markerdeleted",this))},setMarkerPosition:function(e,t){var i=this;if((is_int(parseInt(e))||is_float(parseFloat(e)))&&(is_int(parseInt(t))||is_float(parseFloat(t)))){var a={lat:parseFloat(e),lng:parseFloat(t)};this.marker?(this.marker.setPosition(a),this.gmap.getBounds().contains(this.marker.getPosition())||this.setCenter(a)):(this.addMarker(a),setTimeout((function(){i.setCenter(a)}),10))}},getMarkerPosition:function(){return this.marker?this.marker.getPosition():null},addMarker:function(e){var t=this;if(e||(e=this.getCenter()),this.marker)this.setMarkerPosition(e.lat(),e.lng());else{var i={position:e,draggable:!this._isReadonly(),animation:!!this.options.animation&&google.maps.Animation.DROP,map:this.gmap};this.marker=new google.maps.Marker(i),this.marker.addListener("drag",(function(){})),this.marker.addListener("dragend",(function(){t.element.trigger("vialermap:markerchanged",t)})),this.marker.addListener("rightclick",(function(e){t._isReadonly()||t.deleteMarker()}))}},hasMarker:function(){return null!=this.marker}}),$.widget("ajtarragona.vialerField",{options:{},_create:function(){var e=this;al("vialerField",e.element),this.options=$.extend({},this.options,this.element.data()),this.name=this.element.find("input.vialer-value"),this.inputs=this.element.find("input"),this.searchButtons=this.element.find(".search-button"),this.clearButton=this.element.find(".clear-button"),this.parcelaButton=this.element.find(".refcat-button"),this.markerButton=this.element.find(".marker-button"),this.map=this.element.find(".vialer-map"),this.inputVia=this.element.find("input.tt-input"),this.searchButtons.on("click",(function(t){var i=$(this).attr("value");e._search(i)})),this.clearButton.on("click",(function(){e.inputs.val(""),e.inputVia.tgnAutocomplete("clear"),e.map.vialerMap("deleteMarker")})),this.inputs.on("keyup",(function(){e._isReadonly()||e._update()})),this.inputVia.on("tgnautocomplete:change",(function(t,i){al("chained autocomplete changed"),e._setFieldValue("via.tipus",i.item.tipusVia),e._setFieldValue("via.nom",i.item.nomLlarg),e._update()})),this.parcelaButton.on("click",(function(){e._openParcela()})),this.markerButton.on("click",(function(t){e.map.vialerMap("addMarker");var i=e.map.vialerMap("getMarkerPosition");e._setFieldValue("location.lat",i.lat()),e._setFieldValue("location.lng",i.lng()),e._update()})),this.map.vialerMap(),this.map.on("vialermap:markerchanged",(function(t,i){var a=i.getMarkerPosition();e._setFieldValue("location.lat",a.lat()),e._setFieldValue("location.lng",a.lng()),e._update()})),this.map.on("vialermap:markerdeleted",(function(t,i){e._setFieldValue("location.lat",""),e._setFieldValue("location.lng",""),e._update()})),this._updateValue()},_initMap:function(){},_openParcela:function(){var e=this._value(),t=route("vialer.parcela",{refcat:e.refcat});TgnModal.open(t,"get",{},{onsuccess:function(e){},size:"lg",padding:0})},_initModalForm:function(e){var t=this;e.find(".vialer-search-form").on("submit",(function(i){i.preventDefault();var a=$(this),n=a.attr("action"),o=a.attr("method");$("html").stopLoading();var r=a.serializeControls();e.find("#vialer-search-results").startLoading(),$.ajax({url:n,type:o,data:r,dataType:"html",success:function(i){e.find("#vialer-search-results").html($(i).find("#vialer-search-results")).tgnInitAll(),t._initSearchResults(e),e.find("#vialer-search-results").stopLoading()},error:function(t){e.find("#vialer-search-results").stopLoading(),TgnFlash.error(__("Error recuperando domicilios"))}})}))},_search:function(e){var t=this,i=route("vialer.search",{type:e}),a=t._value();TgnModal.open(i,"post",a,{onsuccess:function(e){t._initModalForm(e),t._initSearchResults(e)},size:"lg",padding:0})},_initSearchResults:function(e){var t=this,i=e.find("table").data("numerero");e.find("table tbody tr").on("click",(function(a){i?t._selectNumerero($(this),e):t._recuperaDomicili($(this),e)}))},_selectNumerero:function(e,t){var i=this,a=e.data("rc"),n=e.data("numero"),o=route("vialer.numerero",{rc:a});e.startLoading(),$.ajax({url:o,type:"get",data:{},dataType:"html",success:function(a){t.find(".vialer-search-form input[name=numero]").val(n),t.find(".vialer-search-form input[name=escala]").val(""),t.find(".vialer-search-form input[name=bloc]").val(""),t.find(".vialer-search-form input[name=planta]").val(""),t.find(".vialer-search-form input[name=porta]").val(""),t.find("#vialer-search-results").html(a).tgnInitAll(),i._initSearchResults(t),e.stopLoading()},error:function(t){e.stopLoading(),TgnFlash.error(__("Error recuperando domicilios"))}})},_recuperaDomicili:function(e,t){var i=this,a=e.data("rc"),n=route("vialer.domicili",{rc:a});e.startLoading(),$.ajax({url:n,type:"get",data:{},dataType:"json",success:function(a){t.modal("hide"),e.stopLoading(),a.viaAccede?(i.inputVia.tgnAutocomplete("value",{value:a.viaAccede.codigoIneVia,name:a.viaAccede.codigoTipoVia+" "+a.viaAccede.nombreLargoVia}),i._setFieldValue("via.tipus",a.viaAccede.codigoTipoVia),i._setFieldValue("via.nom",a.viaAccede.nombreLargoVia),i._setFieldValue("via.codi",a.viaAccede.codigoIneVia)):(i.inputVia.tgnAutocomplete("value",{value:a.via.codigoVia,name:a.via.tipoVia+" "+a.via.nombreVia}),i._setFieldValue("via.tipus",a.via.tipoVia),i._setFieldValue("via.nom",a.via.nombreVia),i._setFieldValue("via.codi",a.via.codigoVia)),i._setFieldValue("numero",a.numero),i._setFieldValue("lletra",a.letra),i._setFieldValue("escala",a.escalera),i._setFieldValue("bloc",a.bloque),i._setFieldValue("planta",a.planta),i._setFieldValue("porta",a.puerta),i._setFieldValue("codi_postal",a.codigo_postal),i._setFieldValue("refcat",a.rc.completa),i._setFieldValue("location.lat",a.xy.lat),i._setFieldValue("location.lng",a.xy.lng),i._setFieldValue("provincia",a.provincia),i._setFieldValue("municipi",a.municipi),i._setFieldValue("districte",a.districte),i._setFieldValue("seccio",a.seccio),i._setFieldValue("districte_administratiu",a.districte_administratiu?a.districte_administratiu.toUpperCase():""),i._update(),i._setMapMarker(a.xy.lat,a.xy.lng)},error:function(t){e.stopLoading(),TgnFlash.error(__("Error recuperando domicilio"))}})},_setMapMarker:function(e,t){},_setFieldValue:function(e,t){e="["+e.replace(".","][")+"]";var i=this.element.find('input[name="'+this.options.name+e+'"]');i.length>0&&i.val(t)},_getFieldValue:function(e){},_toJson:function(){return JSON.stringify(this._value(),void 0,4)},_value:function(){return this.element.closest("form").serializeControls()[this.options.name]},_isReadonly:function(){return this.options.readonly||this.options.disabled},_updateValue:function(){var e=this,t=e._toJson();e.element.find("#"+e.options.name+"-value").html(t),e._updateMapMarker(),e._updateParcela()},_update:function(){var e=this;e._updateValue(),al("trigger changed",e.element),e.element.trigger("changed",e)},_updateParcela:function(){var e=this,t=e._value();t.refcat&&t.refcat.length>=14?e.parcelaButton.prop("disabled",!1).removeClass("disabled"):e.parcelaButton.prop("disabled",!0).addClass("disabled")},_updateMapMarker:function(){var e=this,t=e._value();e.map.vialerMap("setMarkerPosition",t.location.lat,t.location.lng),e.map.vialerMap("hasMarker")?e.markerButton.prop("disabled",!0).addClass("disabled"):e._isReadonly()||e.markerButton.prop("disabled",!1).removeClass("disabled")}})},function(e,t){}]);