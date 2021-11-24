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

	// Change Password Request
	$("#changePw").click((e)=>{
		e.preventDefault();

		let oldPw = $("#oldPw").val();
		let newPw = $("#newPw").val();
		let confirmNewPw = $("#confirmNewPw").val();

		if (newPw.length < 4) {
			alert("Password is too short");
		}
		else {
			if (newPw != confirmNewPw) {
				alert("Passwords don't match!");
			}
			else {
				let data = JSON.stringify({ oldPw:oldPw, newPw:newPw });
				$.ajax({
					url: "assets/php/api/changePassword.php",
					method: "POST",
					data: data,
					dataType: "json",
					success: function (data) {
						$(".form")[0].reset();
						$("#msg").html("<div class='alert alert-warning'><i class='fas fa-info-circle'></i> "+ data.msg +"</div>");
					},
					error: function () {
						console.log("err wd change pw req");
					}
				});
			}
		}
	});
});