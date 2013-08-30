$(document).ready(function() {
  var $curr = $(".right-pos").filter(":first");
  var $next = $curr.next();
  $curr.fadeIn(500);
  setInterval(function() {
    if($next.length == 0)
      $next = $(".right-pos").filter(":first");
    $curr.fadeOut(500);
    $next.fadeIn(500);
    $curr = $next;
    $next = $curr.next();
  }, 7000);
  $("#clock").stdCountdown();
  setInterval(function() {
    $("#sect-top").apiCall2({
      method: 'Get',
      type: 'Team',
      params: {action: 'LeaderBoard', pos: 'One'},
      apply: true
    });
    $("#sect-restone").apiCall2({
      method: 'Get',
      type: 'Team',
      params: {action: 'LeaderBoard', pos: 'Two'},
      apply: true
    });
    $("#sect-resttwo").apiCall2({
      method: 'Get',
      type: 'Team',
      params: {action: 'LeaderBoard', pos: 'Three'},
      apply: true
    });
    $("#sect-restthree").apiCall2({
      method: 'Get',
      type: 'Team',
      params: {action: 'LeaderBoard', pos: 'Four'},
      apply: true
    });
  $("#sect-restfour").apiCall2({
      method: 'Get',
      type: 'Team',
      params: {action: 'LeaderBoard', pos: 'Five'},
      apply: true
    });
  }, 10000);
  setInterval(function() {
    $("#apicall").apiCall2({
      method: 'Get',
      type:   'Team',
      params: {action: 'Podium'},
      apply: true
    }, function() {
      $("#clock").stdCountdown();
    });
  }, 15000);
});