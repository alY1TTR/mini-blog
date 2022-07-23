const urlParams = new URLSearchParams(window.location.search);
const id = urlParams.get("id");
const currentUserId = localStorage.getItem("user_id");
const baseurl = document.body.dataset.baseurl;
const authorId = document.body.dataset.authorId;

const comments_div = document.getElementById('comments');
const textarea = document.getElementById('textarea');
const add_comment = document.getElementById('add-comment');

function getComments(){
   axios.get(`${baseurl}/api/comment/list.php?id=${id}`).then(res=>{
      showComments(res.data)
   })
}

function showComments(comments){
   let comment_html = `<div class="com-num"><h2>${comments.length} Комментария</h2></div>`

   for(let i = 0; i < comments.length; i++) {
      let deleteButton = ``;
      if(currentUserId == comments[i]["author_id"] || currentUserId == authorId) {
         deleteButton = `<span class="www" onclick="removeComment(${comments[i]["id"]})"> Удалить </span>`
      }
      comment_html += `
      <div class="com-author">
         <img src="img/blogs/person_avatar.png" alt="">
         <h3>${comments[i]["full_name"]}</h3>
         ${deleteButton}
      </div>
   
      <div class="com-desc">
         <p>${comments[i]["text"]}</p>
      </div>
      
      `
   }

   comments_div.innerHTML = comment_html
}

add_comment.onclick = function(){
   axios.post(`${baseurl}/api/comment/add.php`, {
      text:textarea.value,
      blog_id:id,
      author_id:currentUserId
   }).then(res=>{
      getComments()
      textarea.value = ""
   })
}

function removeComment(id){
   axios.delete(`${baseurl}/api/comment/delete.php?id=${id}`).then(res=>{
      getComments(res.data)
   })
}

getComments()