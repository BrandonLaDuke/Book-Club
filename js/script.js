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
function showLikes(postID) {
  var postLikesID = "likes" + postID;
  console.log(postLikesID);
  var postLikesPanel = document.getElementById(postLikesID);
  postLikesPanel.classList.add("openLikes");
}
function hideLikes(postID) {
  var postLikesID = "likes" + postID;
  console.log(postLikesID);
  var postLikesPanel = document.getElementById(postLikesID);
  postLikesPanel.classList.remove("openLikes");
}
function editUserCP(userId) {
  var userEditID = "userID-" + userId;
  console.log(userEditID);
  var userEditor = document.getElementById(userEditID);
  userEditor.classList.add("edituserOpen");
}
function deleteUserCP(userId) {
  var deleteUserID = "deleteUserID-" + userId;
  console.log(deleteUserID);
  var userDeletor = document.getElementById(deleteUserID);
  userDeletor.classList.add("userDeleteOpen");
}
function cancelDeleteUserCP(userId) {
  var userEditID = "userID-" + userId;
  var deleteUserID = "deleteUserID-" + userId;
  console.log(deleteUserID);
  var userDeletor = document.getElementById(deleteUserID);
  var userEditor = document.getElementById(userEditID);
  userDeletor.classList.remove("userDeleteOpen");
  userEditor.classList.remove("edituserOpen");
}
document.querySelectorAll('textarea').forEach(el => {
  el.style.height = el.setAttribute('style', 'height: ' + el.scrollHeight + 'px');
  el.classList.add('auto');
  el.addEventListener('input', e => {
    el.style.height = 'auto';
    el.style.height = (el.scrollHeight) + 'px';
  });
});

function openNotifications() {
  // document.getElementById()
  console.log("Hello I will now show you notifications");
}
function clearNotifications() {
  alert("This functionality is coming soon. Stay tuned.");
}
