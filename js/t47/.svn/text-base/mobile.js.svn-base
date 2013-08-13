$(document).ready(function() {
  setInterval(function() {
    $("#leaderboard").apiCall2({
      method: 'Get',
      type:   'Team',
      params: {action: 'MobileLeaderBoard'},
      apply: true
    })
  }, 10000);
  setInterval(function() {
    $("#stats").apiCall2({
      method: 'Get',
      type:   'Team',
      params: {action: 'MobileStats'},
      apply: true
    });
  }, 15000);
})