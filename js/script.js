function openLogin() {
  var login = document.getElementById("login");
  login.classList.add("open");
}
function openAcctMenu() {
  var login = document.getElementById("login");
  login.classList.add("open");
}
function updateGoal() {
  var updategoalbtn = document.getElementById('updategoalbtn');
  var pgnumGoal = document.getElementById('pgnumGoal');
  var chapterGoal = document.getElementById('chapterGoal');
  var customGoal = document.getElementById('customGoal');
  updategoalbtn.classList.add("upgoalbtnhide");
  pgnumGoal.classList.add("updategoalshow");
  chapterGoal.classList.add("updategoalshow");
  customGoal.classList.add("updategoalshow");
}
