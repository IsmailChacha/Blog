$('#add').on('submit', function() {
	var that = $(this);
	contents = that.serialize();
	console.log(contents);
	// $.ajax({
	// 	url : "main.php",
	// 	dataType : "json",
	// 	type : "post",
	// 	data : contents,
	// 	success : function(){
	// 		console.log(1);
	// 	}
	// });

	return false;
});