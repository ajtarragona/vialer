 
  
  
  $.widget( "ajtarragona.vialerMap", {
    
  
    options: {
      center : {lat:0, lng:0},
      zoom: 15,
      geolocate: true,
      multiple:false,
      readonly:false,
      disabled:false,
      animation:false,
      cluster:true,
      fitbounds:false,
      clusterMinZoom: 15,
      mapType: 'roadmap',
      method:'get',
      url:false,
      customicons:false,
      controls : {
        zoom: true,
        mapType: false,
        scale: false,
        streetView: false,
        rotate: false,
        fullscreen: true,
    
      },
      styles: 
        [
      
          {
            featureType: "poi",
            stylers: [
              {
                visibility: "off"
              }
            ]
          },
          {
            featureType: "transit",
            stylers: [
              {
                visibility: "off"
              }
            ]
          }
      ]
        
    },
  
    _create :  function(){
      var o=this;
      //al("vialerMap", o.element);
      this.options = $.extend({}, this.options, this.element.data()); 
  
      this.mapoptions={
        center: this.options.center,
        zoom: this.options.zoom,
        mapTypeId: this.options.mapType,
        zoomControl: this.options.controls.zoom,
        mapTypeControl: this.options.controls.mapType,
        mapTypeControlOptions: {
          // style: google.maps.MapTypeControlStyle.DROPDOWN_MENU,
          position: google.maps.ControlPosition.LEFT_BOTTOM,
          mapTypeIds: ['roadmap', 'satellite','hybrid','terrain']
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
    if(this.options.geolocate){
        this._geolocate(function(){
          o._initAll();
        });
      }else{
          o._initAll();
      }
  
    },
  
    _initAll :  function(){
      
      // if(this.options.marker){
        
        //this.addMarker(this.gmap.getCenter());
      // }
  
    },
  
    
    _geolocate :  function(callback){
        var o = this;
        //al("Geolocating");
        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            o.geoposition=position;
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
  
            o.setCenter(pos);
            executeCallback(callback);  
  
          }, function() {
            o._handleLocationError(true);
          });
        } else {
          // Browser doesn't support Geolocation
          o._handleLocationError(false);
        }
    },
  
    _handleLocationError : function(browserHasGeolocation) {
        var o = this;
        o.infoWindow.setContent(browserHasGeolocation ?
            'Error: The Geolocation service failed.' :
            'Error: Your browser doesn\'t support geolocation.');
        o.infoWindow.setPosition(o.gmap.getCenter());
        o.infoWindow.open(o.map);
       
    },
    _isReadonly : function(){
      return this.options.readonly || this.options.disabled;
    },
  
   
  
    //Funciones publicas
    enable : function(){
      this.options.readonly=true;
    },
    disable : function(){
      this.options.readonly=false;
    },
  
    setCenter :  function(center){
      //al('setCenter',center);
      //al(this.gmap);
      this.options.center=center;
      if(this.gmap) this.gmap.setCenter(center);
    },
    getCenter :  function(){
      //al('setCenter');
      return this.gmap.getCenter();
    },
  
    deleteMarker : function(){
      var o=this;
      if(this.marker){
        this.marker.setMap(null);
        this.marker=null;
        this.element.trigger("vialermap:markerdeleted", this);
      }
    },
  
    setMarkerPosition : function(lat, lng){
      var o=this;
  
      if( (is_int(parseInt(lat)) || is_float(parseFloat(lat))) && ( is_int(parseInt(lng)) ||  is_float(parseFloat(lng)) )){
        var center = {lat: parseFloat(lat), lng: parseFloat(lng)};
      
        //al('setMarkerPosition', center);
        //al(this.marker);
        if(this.marker){
          this.marker.setPosition(center);
          if(!this.gmap.getBounds().contains(this.marker.getPosition())){
            this.setCenter(center );
          }
        }else{
          this.addMarker(center);
          //si no no centra bien
          setTimeout(function(){
            o.setCenter(center);
          },10);
        }
      }
      
    },
    getMarkerPosition : function(){
      if(this.marker)
        return this.marker.getPosition();
      else return null;
  
    },
  
    addMarker : function(coords){
      var o=this;
      if(!coords) coords=this.getCenter();
      
      if(this.marker){
        this.setMarkerPosition(coords.lat(), coords.lng());
      }else{
        //al("addMarker ", coords);
     
        var markerargs={
          position: coords, 
          draggable: !this._isReadonly(),
          animation: this.options.animation?google.maps.Animation.DROP:false,
          map: this.gmap,
          
        };
  
        this.marker = new google.maps.Marker(markerargs);
  
        this.marker.addListener('drag', function() {
          // al("DRAG");
        });
  
        this.marker.addListener('dragend', function() {
          // al("marker drooped");
          o.element.trigger("vialermap:markerchanged", o);
        });
  
        this.marker.addListener('rightclick', function(point) {
          if(!o._isReadonly()){
            o.deleteMarker();
          }
  
        });
      }
    },
  
    hasMarker: function(){
       return this.marker!=null;
    }
    
  
  });
  
  
  $.widget( "ajtarragona.vialerField", {
  
      options: {
      },
  
      _create: function() {
          var o=this;
          // al("vialerField", o.element);
          this.options = $.extend({}, this.options, this.element.data()); 
          this.name = this.element.find('input.vialer-value');
          this.inputs=this.element.find('input');
          this.searchButtons=this.element.find('.search-button');
          this.clearButton=this.element.find('.clear-button');
          this.parcelaButton=this.element.find('.refcat-button');
          this.markerButton=this.element.find('.marker-button');
          this.map=this.element.find('.vialer-map');
          this.inputVia= this.element.find('input.tt-input');
          // al(this.inputVia);
  
          this.searchButtons.on('click',function(e){
              var type=$(this).attr('value');
              o._search(type);
              
        
          });
  
          this.clearButton.on('click',function(){
              o.inputs.val('');
              o.inputVia.tgnAutocomplete('clear');
              o.map.vialerMap('deleteMarker');
          });
  
          this.inputs.on('keyup',function(){
              if(!o._isReadonly())
                o._update();
          });
  
          this.inputVia.on('tgnautocomplete:change',function(e, ret){
              // al("chained autocomplete changed");
              //al('selected', ret.item);
  
              o._setFieldValue('via.tipus',ret.item.tipusVia);
              o._setFieldValue('via.nom',ret.item.nomLlarg);
              // al('tgnautocomplete:change',o.inputVia);
              // setTimeout(function(){
              //   o.inputVia.val(ret.item.nomLlarg);
              // },10);
  
              o._update();
          });
  
          this.parcelaButton.on('click',function(){
            o._openParcela();
          });
  
          
          this.markerButton.on('click',function(e){
            o.map.vialerMap('addMarker');
            var pos=o.map.vialerMap('getMarkerPosition');
            o._setFieldValue('location.lat',pos.lat());
            o._setFieldValue('location.lng',pos.lng());
            o._update();
          });
  
          this.map.vialerMap();
  
          this.map.on('vialermap:markerchanged',function(e,map){
            var pos=map.getMarkerPosition();
            o._setFieldValue('location.lat',pos.lat());
            o._setFieldValue('location.lng',pos.lng());
            o._update();
          });
  
          this.map.on('vialermap:markerdeleted',function(e,map){
            o._setFieldValue('location.lat','');
            o._setFieldValue('location.lng','');
            o._update();
          });
  
          // this.map.vialerMap('sayhello','hello','world');
  
          this._updateValue();
  
         
      },
  
      
      
      _initMap: function(){
          
      },
      _openParcela: function(){
        var o=this;
        var value=o._value();
        // al(value);
        var modalurl= route('vialer.parcela',{'refcat': value.refcat });//baseUrl()+"/backend/entities/componentmodal";
        var params= {  };
        
        TgnModal.open(modalurl,'get',params,{
          onsuccess: function(modal){
              
          },
          size:'lg',
          padding:0,
        });
      },
  
  
      _initModalForm: function(modal){
        var o=this;
        // al('_initModalForm');
        modal.find('.vialer-search-form').on('submit',function(e){
          e.preventDefault();
          var form=$(this);
          var url=form.attr('action');
          var method=form.attr('method');
          $('html').stopLoading();
        //   al('submit search',url);
          var params=form.serializeControls();
        //   al(params);
          modal.find('#vialer-search-results').startLoading();
          $.ajax({
              url: url,
              type: method,
              data: params,
              dataType: 'html',
              success: function(content){
                //   al(content);
                  modal.find('#vialer-search-results').html($(content).find('#vialer-search-results')).tgnInitAll();
                  o._initSearchResults(modal);
                  modal.find('#vialer-search-results').stopLoading();
  
              },
              error: function(xhr){
                  modal.find('#vialer-search-results').stopLoading();  
                  TgnFlash.error(__("Error recuperando domicilios") );
                  // modal.modal('hide');
              }
          });
        });
      },
  
      _search: function(type){
        var o=this;
        var modalurl= route('vialer.search',{'type': type });//baseUrl()+"/backend/entities/componentmodal";
        var params=o._value();
  
        TgnModal.open(modalurl,'post', params ,{
          onsuccess: function(modal){
              o._initModalForm(modal);
              o._initSearchResults(modal);
          },
          size:'lg',
          padding:0,
        });
      },
  
      _initSearchResults: function(modal){
        var o=this;
       // al('_initSearchResults',modal);
        var isnumerero=modal.find('table').data('numerero');
  
        modal.find('table tbody tr').on('click',function(e){
          // al('click row', $(this).data('id'));
          if(isnumerero){
              o._selectNumerero($(this),modal);
        
          }else{
              o._recuperaDomicili($(this),modal);
        
          }
        });
      },
  
      _selectNumerero: function(row,modal){
          var o=this;
          var rc=row.data('rc');
          var numero=row.data('numero');
          var url = route('vialer.numerero',{'rc': rc });
          var params={};
          row.startLoading();
          $.ajax({
              url: url,
              type: 'get',
              data:params,
              dataType: 'html',
              success: function(content){
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
              error: function(xhr){
                  row.stopLoading();  
                  TgnFlash.error(__("Error recuperando domicilios") );
                  // modal.modal('hide');
              }
          });
      },
      _recuperaDomicili: function(row,modal){
          var o=this;
          var rc=row.data('rc');
          var url = route('vialer.domicili',{'rc': rc });
          var params={};
          row.startLoading();
          $.ajax({
              url: url,
              type: 'get',
              data:params,
              dataType: 'json',
              success: function(domicili){
                  //al('_recuperaDomicili',domicili);
                  modal.modal('hide');
                  row.stopLoading();
                  
                  if(domicili.viaIris){
                    o.inputVia.tgnAutocomplete('value',{
                      value: domicili.viaIris.code, 
                      name: (domicili.viaIris.acronym+' '+domicili.viaIris.stname)
                    });
                    o._setFieldValue("via.tipus", domicili.viaIris.acronym);
                    o._setFieldValue("via.nom", domicili.viaIris.stname);
                    o._setFieldValue("via.codi", domicili.viaIris.code);
                  }else{
                    o.inputVia.tgnAutocomplete('value',{
                      value: domicili.via.codigoVia, 
                      name: (domicili.via.tipoVia+' '+domicili.via.nombreVia)
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
                  o._setFieldValue("location.lat" , domicili.xy.lat);
                  o._setFieldValue("location.lng" , domicili.xy.lng);
                  o._setFieldValue("provincia" , domicili.provincia);
                  o._setFieldValue("municipi" , domicili.municipi);
                  o._setFieldValue("districte" , domicili.districte);
                  o._setFieldValue("seccio" , domicili.seccio);
                  o._setFieldValue("districte_administratiu" , domicili.districte_administratiu?domicili.districte_administratiu.toUpperCase():'');
                  
                  o._update();
                  o._setMapMarker(domicili.xy.lat,domicili.xy.lng);
  
                  // modal.modal('hide');
  
              },
              error: function(xhr){
                  row.stopLoading();  
                  TgnFlash.error(__("Error recuperando domicilio") );
                  // modal.modal('hide');
              }
          });
      },
  
      _setMapMarker: function(lat,lng){
        //al("Moviendo marcador a "+lat+","+lng);
      },
      _setFieldValue: function(name, value){
          name="["+ name.replace(".","][") +"]"
          var input=this.element.find('input[name="'+this.options.name+''+name+'"]');
          if(input.length>0) input.val(value);
  
      },
      _getFieldValue: function(name){
          //return this.element.find('[name=]);
      },
  
      _toJson: function(){
         return JSON.stringify(this._value(),undefined,4);
      },

      _data_get: function (obj,string){
        var parts = string.split('.');
        var newObj = obj[parts[0]];
        if(parts[1]){
            parts.splice(0,1);
            var newString = parts.join('.');
            return this._data_get(newObj,newString);
        }
        return newObj;
      },

      _value: function(){
          var fields=this.element.closest('form').serializeControls();
          // al('_value', fields);
          var fieldname=this.options.name.replaceAll('[','.').replaceAll(']','');
          // al(fieldname);
          var ret= this._data_get(fields,fieldname);
          // al(ret);
          return ret;
      },
  
      _isReadonly : function(){
        return this.options.readonly || this.options.disabled;
      },

      _updateValue: function(){
         var o=this;
          var json= o._toJson();
          o.element.find('#'+o.options.name+'-value').html(json);
          o._updateMapMarker();
          o._updateParcela();
      },
      _update: function(){
          //al("Update");
          var o=this;
          o._updateValue();
          // al('trigger changed',o.element);
          o.element.trigger("changed", o);
          
      },
  
      _updateParcela: function(){
          var o=this;
          var value=o._value();
          if(value.refcat && value.refcat.length>=14){
            o.parcelaButton.prop('disabled',false).removeClass('disabled');
          }else{
            o.parcelaButton.prop('disabled',true).addClass('disabled');
          }
      },
      _updateMapMarker: function(){
          var o=this;
          var value=o._value();
          // al('hasMarker', o.map.vialerMap('hasMarker'));
          o.map.vialerMap('setMarkerPosition',value.location.lat , value.location.lng);
  
          if(o.map.vialerMap('hasMarker')){
            o.markerButton.prop('disabled',true).addClass('disabled');
          }else{
            if(!o._isReadonly())
              o.markerButton.prop('disabled',false).removeClass('disabled');
          }
      }
  });
  
  
      