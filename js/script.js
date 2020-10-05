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
function openPostOptions(postID) {
  var postOptionsID = "postOptions" + postID;
  console.log(postOptionsID);
  var postOptionsPanel = document.getElementById(postOptionsID);
  postOptionsPanel.classList.add("postbox_open");
}
function closePostOptions(postID) {
  var postOptionsID = "postOptions" + postID;
  console.log(postOptionsID);
  var postOptionsPanel = document.getElementById(postOptionsID);
  postOptionsPanel.classList.remove("postbox_open");
}

function copyToClipboard(text) {
  var dummy = document.createElement("textarea");
  // to avoid breaking orgain page when copying more words
  // cant copy when adding below this code
  // dummy.style.display = 'none'
  document.body.appendChild(dummy);
  //Be careful if you use texarea. setAttribute('value', value), which works with "input" does not work with "textarea". – Eduard
  dummy.value = text;
  console.log(text);
  dummy.select();
  document.execCommand("copy");
  document.body.removeChild(dummy);
  alert("Post link copied to clipboard");
}
function editPost(postID) {
  var postEditID = "editPostBoxC" + postID;
  var editPost = document.getElementById(postEditID);
  editPost.classList.add("showFlex");
}
function closePostEdit(postID) {
  var postEditID = "editPostBoxC" + postID;
  console.log(postEditID);
  var postEditPanel = document.getElementById(postEditID);
  postEditPanel.classList.remove("showFlex");
}
function cancelPostDelete(postID) {
  var postDeleteID = "deletePostBoxC" + postID;
  console.log(postDeleteID);
  var postDeletePanel = document.getElementById(postDeleteID);
  postDeletePanel.classList.remove("showFlex");
}
function deletePost(postID) {
  var postDeleteID = "deletePostBoxC" + postID;
  var deletePost = document.getElementById(postDeleteID);
  deletePost.classList.add("showFlex");
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
function editBookCP(bookId) {
  var bookEditID = "bookID-" + bookId;
  console.log(bookEditID);
  var bookEditor = document.getElementById(bookEditID);
  bookEditor.classList.add("edituserOpen");
}
function deleteBookCP(bookId) {
  var deleteBookID = "deleteBookID-" + bookId;
  console.log(deleteBookID);
  var bookDeletor = document.getElementById(deleteBookID);
  bookDeletor.classList.add("userDeleteOpen");
}
function cancelDeleteBookCP(bookId) {
  var userBookID = "bookID-" + bookId;
  var deleteBookID = "deleteBookID-" + bookId;
  console.log(deleteBookID);
  var bookDeletor = document.getElementById(deletebookID);
  var bookEditor = document.getElementById(bookEditID);
  bookDeletor.classList.remove("bookDeleteOpen");
  bookEditor.classList.remove("edituserOpen");
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


tinymce.init({
  selector: '#mce',
  height: 400,
  menubar: false,
  skin: 'oxide-dark',
  content_css:"dark",
  browser_spellcheck: true,
  plugins: 'lists advlist emoticons',
  toolbar_mode: 'scrolling',
  toolbar: 'undo redo | styleselect bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | forecolor | numlist bullist | outdent indent | emoticons | removeformat'
});
