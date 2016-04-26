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
			})
		});
	console.log(query);
}

function getURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1].replace(/\+/g, " ");
        }
    }
    return;
}

function renderTableRow(title, year, imdbid, posterSrc) {
	var tableRowFormat = '<tr><td>title</td><td>year</td>';
	tableRowFormat = tableRowFormat.replace("title", title);
	tableRowFormat = tableRowFormat.replace("year", year);

	var $row = $($.parseHTML(tableRowFormat))
	
	$row.click(function(event) {
		window.location.href = '/movie/' + imdbid;

	})

	return $row;
}