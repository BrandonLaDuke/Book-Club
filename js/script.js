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

$(document).ready(function(){
    // Check Radio-box
    $(".rating input:radio").attr("checked", false);

    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });
});
