$( document ).ready(function() {
	populateAccountList();
});

function populateAccountList() {
	$.get("/api/account")
		.done(function(data) {
			renderAccountList(data);
		})
}

function renderAccountList(data) {
	$.each(data, function(index, user) {
		var email = user.email;
		var name = user.name;
		var banned = user.status == "banned"
		
		var $row = renderAccountRow(email, name, banned);

		$("#accountList").append($row)
	});
}

function renderAccountRow(email, name, banned) {
	var tableRowFormat = '<tr><td>email</td><td>name</td><td><input type="checkbox" checked></td></tr>';
	tableRowFormat = tableRowFormat.replace("email", email);
	tableRowFormat = tableRowFormat.replace("name", name);
	if (!banned) {
		tableRowFormat = tableRowFormat.replace("checked", "");
	}

	var $row = $($.parseHTML(tableRowFormat))

	$row.find("input").click(function(event) {
		var newStatus = ($(this).is(':checked')) ? "banned" : "active";

		$.post("/api/account", {"email":email, "status":newStatus})
	});

	

	return $row;
}