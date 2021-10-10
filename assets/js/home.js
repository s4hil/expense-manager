$(document).ready(()=>{

	// Display Navigation
	let navState = false;
	$(".nav-btn").click(()=>{
		if (navState == false) {
			$(".side-bar").addClass('show-nav');
			navState = true;
		}
		else {
			$(".side-bar").removeClass('show-nav');
			navState = false;
		}
	});

	// Load items table
	function loadItemsByMonth(argument) {
		let output = "";
		$.ajax({
			url: "assets/php/api/fetchItemsByMonth.php",
			method: "GET",
			dataType: "json",
			success: function (data) {
				x = data['data'];
				for (let i = 0; i < x.length; i++){
					output += `<tr>
							<td>`+ x[i].date +`</td>
							<td>`+ x[i].item_name +`</td>
							<td>
								<button item-id='`+ x[i].id +`' class='del-item btn btn-danger'><i class='fas fa-trash-alt'></i> Delete</button>
							</td>
						</tr>`;
				}
				$("#items-table").html(output);
			},
			error: function () {
				console.log("err wd load items req!");
			}
		});
	}
	loadItemsByMonth();

	// Displaying notifications
	function alertUser(msg) {
		$("#msg").html("<div class='alert alert-warning'><i class='fas fa-info-circle'></i> "+ msg +"</div>");
	}

	// Add item
	$("#add-item").click((e)=>{
		e.preventDefault();

		let date = $("#date").val();
		let item = $("#item").val();
		let price = $("#price").val();
		const data = JSON.stringify({date:date, item:item, price:price});

		$.ajax({
			url: "assets/php/api/addItem.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				if (data.status == true) {
					loadItemsByMonth();
					alertUser(data.msg);
				}
				else{
					alertUser(data.msg);
				}
			},
			error: function () {
				console.log("err wd add item req");
			}
		});
	});

	// Adding delete item functions
	$("#items-table").on('click', '.del-item', function () {
		let item_id = $(this).attr('item-id');
		const data = JSON.stringify({ item_id:item_id });

		let myThis = this;

		$.ajax({
			url: "assets/php/api/deleteItem.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				if (data.status == true) {
					$(myThis).closest('tr').fadeOut();
					alertUser(data.msg);
				}
				else{
					alertUser(data.msg);
				}
			},
			error: function () {
				console.log("err wd add item req");
			}
		});
	});

}); // Main