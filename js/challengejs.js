jQuery(function($) {

		//Refresh info every second
		var timer;
		var seconds = 3; // how often should we refresh the DIV?

		function startActivityRefresh(url) {
		    timer = setInterval(function() {
		        $.ajax({
                url: url,
                cache: false,
                dataType: "html",
                success: function(data) {
                	$("#challengesplits").html(data);
                }
            });
		    }, seconds*1000)
		}

		function cancelActivityRefresh() {
		    clearInterval(timer);
		}


	$(document).ready(function(){


		// Add a hit to the current split
		/*$('#addHit').click(function(event) {
			event.preventDefault();
			var hits = $('#Hits');
			hits.html(parseInt(hits.html())+1);
			var url = $(this).attr('href');
			$.ajax(url).fail(function() {
				location.reload();
			});
		});*/

	var url = window.location.href;     // Returns full URL
	startActivityRefresh(url);

	});
});