$( document ).ready(function() {
	populateMovieResults(getURLParameter("q"));
});

function populateMovieResults(query) {
	$.get("https://omdbapi.com/", {"s":query})
		.done(function(data){
			$.each(data.Search,function(index, value) {
				var year = value.Year;
				var title = value.Title;
				var imdbid = value.imdbID;

				var $row = renderTableRow(title, year, imdbid);

				$("#movieResults").append($row);
			});
		});
}


function renderTableRow(title, year, imdbid) {
	var tableRowFormat = '<tr><td>title</td><td>year</td></tr>';
	tableRowFormat = tableRowFormat.replace("title", title);
	tableRowFormat = tableRowFormat.replace("year", year);

	var $row = $($.parseHTML(tableRowFormat))
	
	$row.click(function(event) {
		window.location.href = '/movie?id=' + imdbid;

	})

	return $row;
}