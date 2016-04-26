$( document ).ready(function() {
	fetchProfile();
	
	$("#profileForm").submit(function(event) {
		event.preventDefault();

		console.log($(this).serialize());
		$.post("api/user", $(this).serialize());
	});
});

function fetchProfile() {
	$.when(
		$.get("/api/majors"),
		$.get("/api/user")
	).done(function(majors, profile) {
		var majorsArray = [];
		for (i = 0; i < majors[0].length; i++){
			majorsArray.push(majors[0][i]['major'])
		}
		$("#profileName").val(profile[0].name);
		$("#profileInterests").val(profile[0].interests);
		populateMajorList(majorsArray, profile[0].major);
	});
}

function populateMajorList(majors, selected=null) {
	$select = $("#profileMajor");
	$.each(majors, function(index, major) {
		$select.append(new Option(major, major, false, major == selected));
	});

}

	