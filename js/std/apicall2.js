(function($) {
  $.fn.apiCall2 = function(options, callback) {
    settings = {
      'method'    : 'Get',
      'type'      : 'inPost',
      'params'    : {},
      'id'        : null,
      'throbber'  : $("#throbber"),
      'apply'     : false
    }
    if(options) {
      $.extend(settings, options);
    }
    
    if(!document.apicall)
      document.apicall = {};

    return this.each(function() {
      var response;
      obj = $(this);
      settings.throbber.show();
      /*var data = {F: "json+html", T: settings.type, M: settings.method};
      $.each(settings.params, function(key, val) {
        data['P[' + key + ']'] = val;
      });*/
      if(settings.id)
        var url = "/api/" + settings.method.toLowerCase() + "/" + settings.type.toLowerCase() + "/" + settings.id;
      else
        var url = "/api/" + settings.method.toLowerCase() + "/" + settings.type.toLowerCase();
      xhr = (function() {
        var localObj = obj;
        var localSettings = settings;
          return $.ajax({
          type: "POST",
          async: true,
          url: url,
          dataType: "json",
          data: settings.params,
          error: function(xhr, error) {
            if(localObj.attr('id') == "message") localObj.fadeIn(500);
            localObj.html("Status: " + xhr + " Error thrown: " + error);
            localSettings.throbber.hide();
          },
          success: function(data) {
            document.response = data.D;
            if(data.S != "OK")
              $("#message").text("Error Occurred: " + data.E).fadeIn(500);
            if(localSettings.apply) {
              if(localObj.attr('id') == "message") localObj.fadeIn(500);
              localObj.html(data.D['html'])
            }
            settings.throbber.hide();
            if (typeof callback == 'function')
              callback.call(localObj, data.D);  
        }
        });
      })();
      try {
        document.apicall[settings.type] = xhr;
      } catch(err) {
        
      }
    });
  }
})( jQuery );
