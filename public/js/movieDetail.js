$( document ).ready(function() { 
	$("#starRating").rating({"size":"sm",
		"showClear": false,
		"showCaption": false,
		"hoverEnabled": false
	});
	var imdbid = getURLParameter('id')

	fetchMovieDetails(imdbid);
	fillPreviousReview(imdbid);

	$("#reviewForm").submit(function(event) {
		event.preventDefault();
		var params = {
			imdbid: getURLParameter('id'),
			stars: $("#starRating").val(),
			review: $("#review").val()
		};

		console.log(params);
		$.post("api/rating", params);

		window.history.back();
	});
});

function fetchMovieDetails(imdbid) {
	$.get("https://omdbapi.com/", {"i":imdbid})
		.done(function(value){
			
			var year = value.Year;
			var title = value.Title;
			var plot = value.Plot;

			var header = title + " (" + year + ")"
			console.log(value);
			$("#movieTitle").text(header);
			$("#plotWell").text(plot);
		});
}

function fillPreviousReview(imdbid) {
	var params = {	"useTokenForEmail":true,
					"movie":imdbid};
	$.get("/api/rating", params)
		.done(function(data){
			console.log(data);

			var stars = data[0].stars;
			var review = data[0].review;

			$('#starRating').rating('update', stars);
			$('#review').val(review);
			
		});
}
