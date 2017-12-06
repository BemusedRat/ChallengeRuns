jQuery(function($) {
	$(document).ready(function(){
		$('#addHit').click(function(event) {
			event.preventDefault();
			var hits = $('#Hits');
			hits.html(parseInt(hits.html())+1);
			var url = $(this).attr('href');
			$.ajax(url).fail(function() {
				location.reload();
			});
		});
	});
});