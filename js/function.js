$(document).ready(function () {
	//=================================== top and down  ===================================//
	var topBtn = $('#return_top');	
	topBtn.hide();
	$(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
			topBtn.fadeIn();
		} else {
			topBtn.fadeOut();
		}
	});
	topBtn.click(function () {
		$('body,html').animate({scrollTop:0}, 1000);
		return false;
	});
	$('header a[href*=#]').click(function (e) {
		var scrollTarget = $(this.hash).offset().top;
		if(scrollTarget)
			e.preventDefault();
		if(parseInt(scrollTarget) !== parseInt($(window).scrollTop()))
			$('html,body').animate({scrollTop:scrollTarget}, 1000);
	});

	//=================================== slider  ===================================//
	$('#mainSlider .carousel').carousel({
		interval : false,
	});

	//=================================== form forms =================================//
	$('#contact-form').submit(function() {
		var elem = $(this);
		var urlTarget = $(this).attr("action");
		var _data = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "post.php",
			dataType: "text",
			data: _data,
			success: function(data) {
				var tmp = data.split(',');
				if(tmp[0] == "ok" ) {
					elem.append("<div class='loading alert' id='tip-success'><a class='close' data-dismiss='alert'>&times;</a>提交成功！你是第 " + tmp[1] + " 个同学！</div>");
					elem.find("input, textarea").val("");
					setTimeout(function() {
						$("#tip-success").remove();
					}, 3000);
				}
			},
			error: function(){
				alert("好像哪里出了问题...");     
			}
		});
		return false;
	});
});
