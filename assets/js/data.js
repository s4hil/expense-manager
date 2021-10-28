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

	// Load data on click
	$("#load-data").click((e)=>{
		e.preventDefault();

		let year = $("#year").val();
		let month = $("#month").val();
		const data = JSON.stringify({year:year, month:month});

		let output = "";

		$.ajax({
			url: "assets/php/api/customFetch.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				x = data['data'];
				if (data.status == true) {
					if (data.count === 0) {
						output = "<tr><td colspan=3>No records found!</td></tr>";
					}
					else {
						count = 0;
						for(let i = 0; i < x.length; i++){
							count++;
							output += `
								<tr>
									<td>`+ count +`</td>
									<td>`+ x[i].item_name +`</td>
									<td>
										<button class='edit-btn btn btn-info p-1' item-id='`+ x[i].id +`'><i class='fas fa-edit'></i> Edit</button>
										<button class='del-btn btn btn-danger p-1' item-id='`+ x[i].id +`'><i class='fas fa-trash-alt'></i> Delete</button>
									</td>
								</tr>
							`;
						}
					}
					$("#items-table").html(output);
				}
			},
			error: function () {
				console.log("err wd fetch items req!");
			}
		});
	});

	// Displaying notifications
	function alertUser(msg) {
		$("#msg").html("<div class='alert alert-warning'><i class='fas fa-info-circle'></i> "+ msg +"</div>");
	}

	// Fetch item details for editing
	$("#items-table").on('click', '.edit-btn', function () {
		let id = $(this).attr('item-id');
		const data = JSON.stringify({ item_id:id });

		$.ajax({
			url: "assets/php/api/fetchItemDetails.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				if (data.status == true) {
					x = data['data'];

					// Fill form with details
					$("#item-id").val(x.id);
					$("#item-date").val(x.date);
					$("#item-name").val(x.item_name);
					$("#item-price").val(x.price);

					$("#update-item").prop('disabled', false);
				}
				else {
					alertUser(data.msg);
				}
			},
			error: function () {
				console.log("err wd fetch item details req!");
			}
		});
	});	

	// Update item details after editing
	$("#update-item").click((e)=>{
		e.preventDefault();

		let item_id = $("#item-id").val();
		let date = $("#item-date").val();
		let name = $("#item-name").val();
		let price = $("#item-price").val();

		const data = JSON.stringify({ id:item_id, date:date, name:name, price:price });
		$.ajax({
			url: "assets/php/api/updateItemDetails.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				if (data.status == true) {
					alertUser(data.msg+" Load Again.");
					$("#edit-item-form")[0].reset();
				}
				else {
					alertUser(data.msg);
				}
			},
			error: function () {
				console.log("err wd update item details req!");
			}
		});
	});

	// Delete Item
	$("#items-table").on('click', '.del-btn', function () {
		let id = $(this).attr('item-id');
		const data = JSON.stringify({ item_id:id });

		$.ajax({
			url: "assets/php/api/deleteItem.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				if (data.status == true) {
					alertUser(data.msg);
				}
				else {
					alertUser(data.msg);
				}
			},
			error: function () {
				console.log("err wd fetch item details req!");
			}
		});
	});	

	// Generating months report
	$("#gen-report").click((e)=>{
		e.preventDefault();

		let year = $("#year").val();
		let month = $("#month").val();

		const data = JSON.stringify({ year:year, month:month });
		let output = "";
		$.ajax({
			url: "assets/php/api/fetchMonthReport.php",
			method: "POST",
			data: data,
			dataType: "json",
			success: function (data) {
				x = data['data'];
				for(let i = 0; i < x.length; i++){
					output += "<li>"+ x[i].date +" => "+ x[i].item_name +" ("+ x[i].price +")</li>";
				}
				$(".modal-title").text("Month: "+data.date);
				$("#totalAmount").text("Total: "+ data.total);
				$("#month-items").html(output);
				$("#month-report-modal").modal('show');
			},
			error: function () {
				console.log("err wd fetch month report!");
			}
		});
	});

	// Hide Report modal
	$("#hide-report-modal").click(()=>{
		$("#month-report-modal").modal('hide');
	});


}); // main