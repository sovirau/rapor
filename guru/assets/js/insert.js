$("#submit2").click(function() {
	$.post($("#id_form").attr("action"), $("#id_form :input").serializeArray(), function(info) { $("#result").html(info); });
	$("#id_form :input").prop("disabled", true);
});

$("#id_form").submit(function(){
	return false;
});