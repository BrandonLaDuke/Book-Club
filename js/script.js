function openLogin() {
  var login = document.getElementById("login");
  login.classList.add("open");
}
function openAcctMenu() {
  var login = document.getElementById("login");
  login.classList.add("open");
}
function updateGoal() {

  var updateGoal = document.getElementById('updategoal-window');


  updateGoal.classList.add("updategoalshow");

}
function closeUpdateGoal() {
  var updateGoal = document.getElementById('updategoal-window');


  updateGoal.classList.remove("updategoalshow");
}
function openCommentArea(postID) {
  var commentFieldID = "comment" + postID;
  console.log(commentFieldID);
  var commentField = document.getElementById(commentFieldID);
  commentField.classList.add("openComment");
}
document.querySelectorAll('textarea').forEach(el => {
  el.style.height = el.setAttribute('style', 'height: ' + el.scrollHeight + 'px');
  el.classList.add('auto');
  el.addEventListener('input', e => {
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight) + 'px';
  });
});
