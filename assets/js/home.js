$(document).ready(()=>{

	// Display Navigation
	let navState = false;
	$(".nav-btn").click(()=>{
		if (navState == false) {
			$(".side-bar").addClass('show-nav');
			$('.nav-btn').html("<i class='fas fa-times'></i>");
			navState = true;
		}
		else {
			$(".side-bar").removeClass('show-nav');
			$('.nav-btn').html("<i class='fas fa-bars'></i>");
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
				if (data.count > 0) {
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
				}
				else {
					output = "<tr><td colspan='3'>No Items To Display!</td></tr>";
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
		if (item == "" || price == "") {
			alertUser("All Fields Are Required!");
		}
		else{
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
						$(".add-item-form")[0].reset();
					}
					else{
						alertUser(data.msg);
					}
				},
				error: function () {
					console.log("err wd add item req");
				}
			});
		}
		
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