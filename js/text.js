/* Inspiration http://dribbble.com/shots/1052225-Webnetix-CMS/attachments/128535 */

$( "#contentText, #contentText2" ).keyup(function() {
  $( "#exitMenuCheckbox" ).prop('checked', true);
});


$( "#bold" ).change(function() {
  if($('#bold').prop('checked')){
    $("#contentText, #contentText2").css("font-weight","bold");
  }else{
    $("#contentText, #contentText2").css("font-weight","normal");
  }
});

$( "#italic" ).change(function() {
  if($('#italic').prop('checked')){
    $("#contentText, #contentText2").css("font-style","italic");
  }else{
    $("#contentText, #contentText2").css("font-style","normal");
  }
});

$( "#underline" ).change(function() {
  if($('#underline').prop('checked')){
    $("#contentText, #contentText2").css("text-decoration","underline");
  }else{
    $("#contentText, #contentText2").css("text-decoration","none");
  }
});

$( "#left" ).click(function() {
  $("#contentText, #contentText2").css("text-align","left");
});
$( "#center" ).click(function() {
  $("#contentText, #contentText2").css("text-align","center");
});
$( "#right" ).click(function() {
  $("#contentText, #contentText2").css("text-align","right");
});
$( "#justify" ).click(function() {
  $("#contentText, #contentText2").css("text-align","justify");
});

$(document).on('scroll', function() {
   $( "#exitMenuCheckbox" ).prop('checked', true);
});

$( "#publish" ).mouseup(function() {
  $("#articleHeaderName").text($("h1").text());
});

$( "#save" ).mouseup(function() {
  $("#articleHeaderName").text($("h1").text()+" (Draft)");
});

$( "#delete" ).mouseup(function() {
  $("#articleHeaderName").text("Create New Article");
  $("h1").text("Simple blog editor - A great way of learning");
  $("#contentText, #contentText2").text("Clered");
});
