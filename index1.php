<?php
//index.php

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Start your message and some one will reply to you soon </title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <h2 align="center"><a href="#">Start your message and some one will reply to you soon</a></h2>
  <br />
  <div class="container">
   <form method="POST" id="comment_form">
    <div class="form-group">
     <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" />
    </div>
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5"></textarea>
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>
 </body>
</html>

<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url:"add_comment.php",
   method:"POST",
   data:form_data,
   dataType:"JSON",
   success:function(data)
   {
    if(data.error != '')
    {
     $('#comment_form')[0].reset();
     $('#comment_message').html(data.error);
     $('#comment_id').val('0');
     load_comment();
    }
   }
  })
 });

 load_comment();

 function load_comment()
 {
  $.ajax({
   url:"fetch_comment.php",
   method:"POST",
   success:function(data)
   {
    $('#display_comment').html(data);
   }
  })
 }

 $(document).on('click', '.reply', function(){
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id);
  $('#comment_name').focus();
 });
 
});


function deletecomment(id) {

if(confirm("Are you sure you want to delete this comment?")) {

     $.ajax({
     url: "comment-delete.php",
     type: "POST",
     data: 'comment_id='+id,
     success: function(data){
         if (data)
         {
             $("#comment-"+id).remove();
             if($("#count-number").length > 0) {
                 var currentCount = parseInt($("#count-number").text());
                 var newCount = currentCount - 1;
                 $("#count-number").text(newCount)
             }
         }
     }
    });
 }
}

$(document).ready(function() {

 $("#frmComment").on("submit", function(e) {
         $(".error").text("");
     $('#name-info').removeClass("error");
     $('#message-info').removeClass("error");
     e.preventDefault();
     var name = $('#name').val();
     var message = $('#message').val();
     
     if(name == ""){
             $('#name-info').addClass("error");
     }
     if(message == ""){
             $('#message-info').addClass("error");
     }
     $(".error").text("required");
     if(name && message){
             $("#loader").show();
             $("#submit").hide();
              $.ajax({
         
          type:'POST',
          url: 'add_comment.php',
          data: $(this).serialize(),
          success: function(response)
             {
                 $("#frmComment input").val("");
                 $("#frmComment textarea").val("");
                  $('#response').prepend(response);

                  if($("#count-number").length > 0) {
                      var currentCount = parseInt($("#count-number").text());
                      var newCount = currentCount + 1;
                      $("#count-number").text(newCount)
                  }
                  $("#loader").hide();
                  $("#submit").show();
              }
             });
     }
 });
});
</script>
</script>





