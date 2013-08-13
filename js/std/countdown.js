(function($) {
  $.fn.stdCountdown = function() {
    
    var $this = $(this),
        elems = $this.text().split(":");
    
    setInterval(function() {
      elems = $this.text().split(":");
      elems[2] = parseInt(elems[2]) - 1;
      if(elems[2] == -1) {
        elems[2] = 59;
        elems[1] = parseInt(elems[1]) - 1;
        if(elems[1] == -1) {
          elems[1] = 59;
          elems[0] = parseInt(elems[0]) - 1;
          if(elems[0] == -1) {
            elems[0] = 59;
          }
        }
      }
      /*for(var i in elems) {
        elems[i] = (elems[i].length < 2) ? String("0" + elems[i]) : String(elems[i]);
      }*/
      elems[1] = ($.trim(elems[1]).length < 2) ? String("0" + elems[1]) : String(elems[1]);
      elems[2] = ($.trim(elems[2]).length < 2) ? String("0" + elems[2]) : String(elems[2]);

      $this.text(elems.join(":"));
    }, 1000);
  }
})(jQuery)