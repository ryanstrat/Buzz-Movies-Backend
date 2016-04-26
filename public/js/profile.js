$( document ).ready(function() {
	$.post
	populateMajorList(['Biology', 'Computer Science', 'Electrical Engineering'], 'Computer Science');
});

function populateMajorList(majors, selected) {
	$select = $("#profileMajor");
	$.each(majors, function(index, major) {
		$select.append(new Option(major, major, false, major == selected));
	});

}