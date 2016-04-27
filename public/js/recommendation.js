$( document ).ready(function() {
	populateReccomendations();
});

function populateReccomendations() {
	$.get('/api/recommendation')
		.done(function(data) {
			console.log(data);
			$.get("https://omdbapi.com/", {"i":data.movie})
				.done(function(value){
					
					var year = value.Year;
					var title = value.Title;

					var header = title + " (" + year + ")"
					console.log(value);
					$("#recDisplay").text(header);
					$("#recDisplay").click(function(event) {
						window.location.href = '/movie?id=' + value.imdbID;
					});
				});
		});
}