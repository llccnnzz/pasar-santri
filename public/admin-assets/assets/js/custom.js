(function($) {
	'use strict';

	/**<<=== Preloader JS ==>>**/
	$(window).on('load', function() {
		$('.preloader').addClass('preloader-deactivate');
	})

	$(window).on('scroll', function() {
		// Header Sticky JS
		if ($(this).scrollTop() >150){  
			$('.header-area').addClass("is-sticky");
		}
		else{
			$('.header-area').removeClass("is-sticky");
		};

		// Go To Top JS
		var scrolled = $(window).scrollTop();
		if (scrolled > 300) $('.go-top').addClass('active');
		if (scrolled < 300) $('.go-top').removeClass('active');
	});

	
	/**<<=== Go To Top Click JS JS ==>>**/
	$('.go-top').on('click', function() {
		$("html, body").animate({ scrollTop: "0" },  50);
	});
    
	
	/**<<=== Sidebar Menu JS ==>>**/
    $('#metismenu').metisMenu();


	/**<<=== Feather Icon JS ==>>**/
    feather.replace()

  
	/**<<=== Webpage FullScreen JS ==>>**/
	$("#fullscreen-button").on("click", function toggleFullScreen() {
		if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
			if (document.documentElement.requestFullScreen) {
				document.documentElement.requestFullScreen();
			} else if (document.documentElement.mozRequestFullScreen) {
				document.documentElement.mozRequestFullScreen();
			} else if (document.documentElement.webkitRequestFullScreen) {
				document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
			} else if (document.documentElement.msRequestFullscreen) {
				document.documentElement.msRequestFullscreen();
			}
		} else {
			if (document.cancelFullScreen) {
				document.cancelFullScreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		}
	});
	$('.fullscreen-btn').on('click', function() {
		$(this).toggleClass('active');
	});

    
	/**<<=== Burger Menu JS ==>>**/
	$('.burger-menu').on('click', function() {
		$(this).toggleClass('active');
		$('.main-content-area').toggleClass('hide-sidemenu-area');
		$('.sidebar-menu-area').toggleClass('toggle-sidemenu-area');
	});
	$('.responsive-burger-menu').on('click', function() {
		$('.responsive-burger-menu').toggleClass('active');
		$('.sidebar-menu-area').toggleClass('active-sidemenu-area');
	});
	 

	/**<<=== js-grid JS ==>>**/
	sortable('.js-grid', {
		forcePlaceholderSize: true,
		placeholderClass: 'border'
	});
	sortable('.o-sortable', {
		forcePlaceholderSize: true,
		placeholderClass: 'border'
	});


	/**<<=== Table Edit JS ==>>**/
	$("#add").on('click',function(){
		var name = $("input[name='name']").val();
		var phone = $("input[name='phone']").val();
		var email = $("input[name='email']").val();
		var account = $("input[name='account']").val();
		var password = $("input[name='password']").val();
		var markup = "<tr><td>" + name + "</td><td>" + phone + "</td><td>" + email + "</td><td>" + account + "</td><td>" + password + "</td><td><button type='button' name='edit' class='edit-item'>Edit</button><button type='button' name='save' class='save-item'>Save</button></td><td><button type='button' name='delete' class='delete-item'>Delete</button></td></tr>";
		$(".table-edit-area .table-wrapper .member .fixed-new .overplay").fadeOut(500);
		$(".table-edit-area .table-wrapper .member .fixed-new .new-account").fadeOut(500);
		$(".table-edit-area .table-wrapper .member table tbody").append(markup);

		//edit
		$('button[name=edit]').click(function(){
			$(this).hide();
			$('td:nth-child(1)').each(function(){
			var content = $(this).html();
			$(this).html('<textarea>' + content + '</textarea>');
			});
			$('td:nth-child(2)').each(function(){
			var content = $(this).html();
			$(this).html('<textarea>' + content + '</textarea>');
			});
			$('td:nth-child(3)').each(function(){
			var content = $(this).html();
			$(this).html('<textarea>' + content + '</textarea>');
			});
			$('td:nth-child(4)').each(function(){
			var content = $(this).html();
			$(this).html('<textarea>' + content + '</textarea>');
			});
			$('td:nth-child(5)').each(function(){
			var content = $(this).html();
			$(this).html('<textarea>' + content + '</textarea>');
			});
			$('button[name=save]').show();
		});
		$('button[name=save]').click(function(){
			$('textarea:nth-child(1)').each(function(){
			var content = $(this).val();//.replace(/\n/g,"<br>");
			$(this).html(content);
			$(this).contents().unwrap();
			});
			$('textarea:nth-child(2)').each(function(){
			var content = $(this).val();//.replace(/\n/g,"<br>");
			$(this).html(content);
			$(this).contents().unwrap();
			});
			$('textarea:nth-child(3)').each(function(){
			var content = $(this).val();//.replace(/\n/g,"<br>");
			$(this).html(content);
			$(this).contents().unwrap();
			});
			$('textarea:nth-child(4)').each(function(){
			var content = $(this).val();//.replace(/\n/g,"<br>");
			$(this).html(content);
			$(this).contents().unwrap();
			});
			$('textarea:nth-child(5)').each(function(){
			var content = $(this).val();//.replace(/\n/g,"<br>");
			$(this).html(content);
			$(this).contents().unwrap();
			});
			$(this).hide();
			$('button[name=edit]').show();
		});
		//delete
		$(".table-edit-area .table-wrapper .member table tbody tr td button[name='delete']").on('click',function(){
			$(this).parent().parent().remove();
		});
	});
	//delete
	$(".table-edit-area .table-wrapper .member table tbody tr td button[name='delete']").on('click',function(){
		var abc = $(this) ;
		$('.table-edit-area .table-wrapper .member .delete').fadeIn(500);
		$('.table-edit-area .table-wrapper .member .delete .choice-delete button[name="cancel-delete"]').on('click',function(){
			$('.table-edit-area .table-wrapper .member .delete').fadeOut(500);
		});
		$('.table-edit-area .table-wrapper .member .delete .choice-delete i').on('click',function(){
			$('.table-edit-area .table-wrapper .member .delete').fadeOut(500);
		});
		$('.table-edit-area .table-wrapper .member .delete .choice-delete button[name="yes-delete"]').on('click',function(){
			$(abc).parent().parent().remove();
			$('.table-edit-area .table-wrapper .member .delete').fadeOut(500);
		});
	});
	//edit
	$('button[name=edit]').click(function(){
		$(this).hide();
		var abc = $(this).parent().siblings(".edit");
		
		$(abc).each(function(){
			var content = $(this).html();
			$(this).html('<textarea>' + content + '</textarea>');
		});
		$(this).parent().find('.save-item').show();
	});
	//save
	$('button[name=save]').click(function(){
		$('textarea').each(function(){
			var content = $(this).val();//.replace(/\n/g,"<br>");
			$(this).html(content);
			$(this).contents().unwrap();
		});
		$(this).hide();
		$(this).parent().find('.edit-item').show();
	});


	/**<<=== Tooltip JS ==>>**/
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


	/**<<=== Textarea Editor Wsyiwyg JS ==>>**/
	$(document).ready(function(evt) {
		// FIXME : enable image & table resize
		document.execCommand("enableAbsolutePositionEditor", false, true)
		document.execCommand("enableInlineTableEditing", false, true)
		document.execCommand("enableObjectResizing", false, true)
		$('.btns button').click(function(evt) {
			let value = null
			if ($(this).hasClass("prompt")) {
				value = prompt('Enter the link here: ', 'http:\/\/');
			}
			execCmd($(this).data('cmd'), value)
		});
		$('.btns select').change(function(evt) {
			execCmd($(this).data('cmd'), $(this).val())
		});
		$('.btns input').change(function(evt) {
			execCmd($(this).data('cmd'), $(this).val())
		});
	})
	function execCmd(cmd, value) {
		document.execCommand(cmd, false, value);
	}
	function getStyle () {
		const colour = document.queryCommandValue("ForeColor");
		const fontSize = document.queryCommandValue("FontSize");
		alert(colour + ", " + fontSize)
	}


	/**<<=== Password JS ==>>**/
	$(".toggle-password").click(function() {
		$(this).toggleClass("ri-eye-off-line");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
		  	input.attr("type", "password");
		}
	});


	/**<<=== Alert JS ==>>**/
	const alertPlaceholder = document.getElementById('liveAlertPlaceholder')
	const appendAlert = (message, type) => {
	const wrapper = document.createElement('div')
		wrapper.innerHTML = [
			`<div class="alert alert-${type} alert-dismissible" role="alert">`,
			`   <div>${message}</div>`,
			'   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
			'</div>'
		].join('')
		alertPlaceholder.append(wrapper)
	}
	const alertTrigger = document.getElementById('liveAlertBtn')
	if (alertTrigger) {
		alertTrigger.addEventListener('click', () => {
			appendAlert('Nice, you triggered this alert message!', 'success')
		})
	}


	/**<<=== Upload Images JS ==>>**/
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imagePreview').css('background-image', 'url('+e.target.result +')');
				$('#imagePreview').hide();
				$('#imagePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
		readURL(this);
	});


	/**<<=== Upload Images JS ==>>**/
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imagePreview2').css('background-image', 'url('+e.target.result +')');
				$('#imagePreview2').hide();
				$('#imagePreview2').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload2").change(function() {
		readURL(this);
	});


	/**<<=== Tags Input JS ==>>**/
	try {
		const tagInput = document.getElementById("tagInput");
		const tagsContainer = document.getElementById("tagsContainer");
		tagInput.addEventListener("keydown", function(event) {
			if (event.key === "Enter" || event.key === ",") {
				event.preventDefault();
				addTag(tagInput.value.trim());
				tagInput.value = "";
			}
		});
		function addTag(tag) {
			if (tag !== "") {
				const tagElement = document.createElement("div");
				tagElement.classList.add("tag");
				tagElement.innerHTML = `
				${tag}
				<span class="tag-remove" onclick="removeTag(this)">×</span>
				`;
				tagsContainer.appendChild(tagElement);
			}
		}
		function removeTag(tagElement) {
			tagsContainer.removeChild(tagElement.parentElement);
		}
	} catch (err) {}


	/**<<=== Add To Cart Input JS ==>>**/
	$(".minus").click(function () {
		var $input = $(this).parent().find(".box");
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		return false;
	});
	$(".plus").click(function () {
		var $input = $(this).parent().find(".box");
		$input.val(parseInt($input.val()) + 1);
		$input.change();
		return false;
	});


	/**<<=== Product Slider JS ==>>**/
	var sync1 = $("#sync1");
	var sync2 = $("#sync2");
	var slidesPerPage = 4;
	var syncedSecondary = true;
	sync1.owlCarousel({
		items: 1,
		slideSpeed: 2000,
		nav: true,
		autoplay: false, 
		dots: false,
		loop: true,
		responsiveRefreshRate: 200,
		navText: [
			"<i class='ri-arrow-left-s-line'></i>",
			"<i class='ri-arrow-right-s-line'></i>",
		],
	}).on('changed.owl.carousel', syncPosition);

	sync2
	.on('initialized.owl.carousel', function() {
		sync2.find(".owl-item").eq(0).addClass("current");
	})
	.owlCarousel({
		items: slidesPerPage,
		dots: false,
		nav: false,
		smartSpeed: 200,
		slideSpeed: 500,
		slideBy: slidesPerPage,
		responsiveRefreshRate: 100,
		margin: 25,
		navText: [
			"<i class='ri-arrow-left-s-line'></i>",
			"<i class='ri-arrow-right-s-line'></i>",
		],
	}).on('changed.owl.carousel', syncPosition2);

	function syncPosition(el) {
		//if you set loop to false, you have to restore this next line
		//var current = el.item.index;

		//if you disable loop you have to comment this block
		var count = el.item.count - 1;
		var current = Math.round(el.item.index - (el.item.count / 2) - .5);

		if (current < 0) {
			current = count;
		}
		if (current > count) {
			current = 0;
		}

		//end block
		sync2
			.find(".owl-item")
			.removeClass("current")
			.eq(current)
			.addClass("current");
		var onscreen = sync2.find('.owl-item.active').length - 1;
		var start = sync2.find('.owl-item.active').first().index();
		var end = sync2.find('.owl-item.active').last().index();

		if (current > end) {
			sync2.data('owl.carousel').to(current, 100, true);
		}
		if (current < start) {
			sync2.data('owl.carousel').to(current - onscreen, 100, true);
		}
	}
	function syncPosition2(el) {
		if (syncedSecondary) {
			var number = el.item.index;
			sync1.data('owl.carousel').to(number, 100, true);
		}
	}
	sync2.on("click", ".owl-item", function(e) {
		e.preventDefault();
		var number = $(this).index();
		sync1.data('owl.carousel').to(number, 300, true);
	});


	/**<<=== Review Rating JS ==>>**/
    const ratings = document.querySelectorAll('.rating');
    ratings.forEach(rating => {
        rating.addEventListener('click', () => {
            // reset all ratings to default state
            ratings.forEach(rating => {
                rating.classList.remove('active');
            });
            
            // add active class to clicked rating and all previous ratings
            rating.classList.add('active');
            let prevRating = rating.previousElementSibling;
            while (prevRating) {
                prevRating.classList.add('active');
                prevRating = prevRating.previousElementSibling;
            }
        });
    });


	/**<<=== Close Open JS ==>>**/
	$("div#panel").show();
    $(".reply_close").click( function() {
        $('#panel').slideToggle();
        $(this).html($(this).html() == 'Closed' ? 'Reply' : 'Closed');                    
    });


	/**<<=== Background Image JS ==>>**/
	$("[data-background]").each(function () {
		$(this).css(
			"background-image",
			"url(" + $(this).attr("data-background") + ")"
		);
	});


	/**<<=== Color Picker JS ==>>**/
	try {
		const body = document.getElementById("pick-color");
		const input = document.getElementById("colorPicker");
		const colorCode = document.getElementById("colorCode");
		setColor();
		input.addEventListener("input", setColor);
		function setColor() {
			body.style.backgroundColor = input.value;
			colorCode.innerHTML = input.value;
		}
	} catch (err) {}


	/**<<=== Needs Validation JS ==>>**/
	// Example starter JavaScript for disabling form submissions if there are invalid fields
	(() => {
		'use strict'

		// Fetch all the forms we want to apply custom Bootstrap validation styles to
		const forms = document.querySelectorAll('.needs-validation')

		// Loop over them and prevent submission
		Array.from(forms).forEach(form => {
			form.addEventListener('submit', event => {
				if (!form.checkValidity()) {
					event.preventDefault()
					event.stopPropagation()
				}

				form.classList.add('was-validated')
			}, false)
		})
	})()

	
	/**<<=== Show Live Toast JS ==>>**/
	const toastTrigger = document.getElementById('liveToastBtn')
	const toastLiveExample = document.getElementById('liveToast')
	if (toastTrigger) {
		const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)
		toastTrigger.addEventListener('click', () => {
			toastBootstrap.show()
		})
	}

	 
	/**<<=== Popover JS ==>>**/
	const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
	const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))


	/**<<=== Data Table JS ==>>**/
	$("#basic_config").DataTable();


	/**<<=== Count Down JS ==>>**/
	var time = $('.count-down');
    if (time.length) {
      var endDate = new Date(time.data("end-date"));
      time.countdown({
        date: endDate,
			render: function (data) {
			$(this.el).html('<div class="cd-row"><div><h1>' + this.leadingZeros(data.days, 3)
				+ '</h1><p>days</p></div><div><h1>'
				+ this.leadingZeros(data.hours, 2)
				+ '</h1><p>hrs</p></div></div><div class="cd-row"><div><h1>'
				+ this.leadingZeros(data.min, 2)
				+ '</h1><p>min</p></div><div><h1>'
				+ this.leadingZeros(data.sec, 2)
				+ '</h1><p>sec</p></div></div>');
			}
      	});
    }

	
	/**<<=== Popup JS ==>>**/
	$('.popup-youtube, .popup-vimeo').magnificPopup({
		disableOn: 300,
		type: 'iframe',
		mainClass: 'mfp-fade',
		fixedContentPos: false,
		removalDelay: 160,
		preloader: false,
	});
	// Gallery
	$('.gallery-popup').each(function() {
		$(this).magnificPopup({
			delegate: '.img', 
			type: 'image',
			gallery: {
			  enabled:true
			}
		});
	});

	
	/**<<=== Sweet Alert JS ==>>**/
	$("#sweetalert_1").click(function(e) {
		Swal.fire("Good job!");
	});

	$("#sweetalert_2").click(function(e) {
		Swal.fire("Here's the title!", "...and here's the text!");
	});
	
	$("#sweetalert_3").click(function(e) {
		Swal.fire("Good job!", "You clicked the button!", "warning");
	});

	$("#sweetalert_4").click(function(e) {
		Swal.fire("Good job!", "You clicked the button!", "error");
	});

	$("#sweetalert_5").click(function(e) {
		Swal.fire("Good job!", "You clicked the button!", "success");
	});

	$("#sweetalert_6").click(function(e) {
		Swal.fire("Good job!", "You clicked the button!", "info");
	});

	$("#sweetalert_7").click(function(e) {
		Swal.fire("Good job!", "You clicked the button!", "question");
	});
	
	$("#sweetalert_8").click(function (e) {
		Swal.fire({
			title: "Good job!",
			text: "You clicked the button!",
			icon: "success",
			buttonsStyling: false,
			confirmButtonText: "Confirm me!",
			customClass: {
				confirmButton: "btn btn-primary"
			}
		});
	});
	
	$("#sweetalert_9").click(function (e) {
		Swal.fire({
			title: "Good job!",
			text: "You clicked the button!",
			icon: "success",
			buttonsStyling: false,
			confirmButtonText: "<i class='la la-headphones'></i> I am game!",
			showCancelButton: true,
			cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
			customClass: {
				confirmButton: "btn btn-danger",
				cancelButton: "btn btn-default"
			}
		});
	});
	
	$("#sweetalert_10").click(function(e) {
		Swal.fire({
			position: "top-right",
			icon: "success",
			title: "Your work has been saved",
			showConfirmButton: false,
			timer: 1500
		});
	});
	
	$('#sweetalert_11').click(function (e) {
		Swal.fire({
			title: 'jQuery HTML example',
			showClass: {
				popup: 'animate__animated animate__fadeInDown'
			},
			hideClass: {
				popup: 'animate__animated animate__fadeOutUp'
			}
		});
	});
	
	$("#sweetalert_12").click(function(e) {
		Swal.fire({
			title: "Are you sure?",
			text: "You won to be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, delete it!"
		}).then(function(result) {
			if (result.value) {
				Swal.fire(
					"Deleted!",
					"Your file has been deleted.",
					"success"
				)
			}
		});
	});
	
	$("#sweetalert_13").click(function(e) {
		Swal.fire({
			title: "Are you sure?",
			text: "You won to be able to revert this!",
			icon: "warning",
			showCancelButton: true,
			confirmButtonText: "Yes, delete it!",
			cancelButtonText: "No, cancel!",
			reverseButtons: true
		}).then(function(result) {
			if (result.value) {
				Swal.fire(
					"Deleted!",
					"Your file has been deleted.",
					"success"
				)
				// result.dismiss can be "cancel", "overlay",
				// "close", and "timer"
			} else if (result.dismiss === "cancel") {
				Swal.fire(
					"Cancelled",
					"Your imaginary file is safe :)",
					"error"
				)
			}
		});
	});
	
	$("#sweetalert_14").click(function(e) {
		Swal.fire({
			title: "Sweet!",
			text: "Modal with a custom image.",
			imageUrl: "https://unsplash.it/400/200",
			imageWidth: 400,
			imageHeight: 200,
			imageAlt: "Custom image",
			animation: false
		});
	});
	
	$("#sweetalert_15").click(function(e) {
		Swal.fire({
			title: "Auto close alert!",
			text: "I will close in 5 seconds.",
			timer: 5000,
			onOpen: function() {
				Swal.showLoading()
			}
		}).then(function(result) {
			if (result.dismiss === "timer") {
				console.log("I was closed by the timer")
			}
		})
	});


	/**<<=== Review Star JS ==>>**/
	try {
		let stars = [],
		starFocus = [];
		let rating = -1;
		let ignorePointer = false;
		let red = '#B71C1C';
		let yellow = 'gold';
		let green = '#519E67';

		for (let i = 0; i < 10; i++) {
			stars.push(document.getElementById("star" + i));
			starFocus.push(false);
		}
		for (let i = 0; i < stars.length; i++) {
			document.getElementById("star" + i).onmouseover = function () {
				for (let j = 0; j <= i; j++) {
					focusStar(j, i);
				}
			};
			document.getElementById("star" + i).onmouseout = function () {
				for (let j = 0; j <= i; j++) {
					if (j >= rating) {
						unfocusStar(j);
					}
				}
			};
			document.getElementById("star" + i).onclick = function () {
				if (!ignorePointer) {
					if (rating == -1) {
						document.getElementById('placeholderFace').style.fontSize = "128px";
						document.getElementById('placeholderFace').style.margin = "16px";
					}
					ignorePointer = true;
					staggeredAnimation(i);
					rating = i + 1;

					setTimeout(() => {
						ignorePointer = false;
					}, 1000);
				}
			};
		}
		function focusFace(face) {
			document.getElementById(face).style.transform = "scale(1.2)";
			document.getElementById(face).style.opacity = "1";
		}
		function unfocusFace(face) {
			document.getElementById(face).style.transform = "scale(1)";
			document.getElementById(face).style.opacity = "0";
		}
		function focusStar(j, vote) {
			if (!starFocus[j]) {
				document.getElementById("star" + j).style.color = (vote < 6) ? red : ((vote >= 6 && vote < 8) ? yellow : green);
				document.getElementById("star" + j).style.transform = "scale(1.2)";
				document.getElementById("star" + j).style.filter = "drop-shadow(0 8px 5px rgba(0, 0, 0, 0.2))";
				starFocus[j] = true;
			}
		}
		function unfocusStar(j) {
			if (starFocus[j]) {
				document.getElementById("star" + j).style.color = "gainsboro";
				document.getElementById("star" + j).style.transform = "scale(1)";
				document.getElementById("star" + j).style.filter = "drop-shadow(0 4px 3px rgba(0, 0, 0, 0.2))";
				starFocus[j] = false;
			}
		}
		function staggeredAnimation(i) {
			/// UNFOCUS ANIMATION
			let k = rating;
			let intervalID2 = setInterval(function () {
				if (k < i + 1) {
					clearInterval(intervalID2);
					if (i < 6) {
						focusFace("sadface");
						unfocusFace("neutralface");
						unfocusFace("happyface");
					} else if (i >= 6 && i < 8) {
						focusFace("neutralface");
						unfocusFace("sadface");
						unfocusFace("happyface");
					} else {
						focusFace("happyface");
						unfocusFace("sadface");
						unfocusFace("neutralface");
					}
					/// WHEN UNFOCUS ANIMATION FINISHES, PULSE ANIMATION STARTS
					let j = 0;
					let intervalID = setInterval(function () {
						if (j > i) {
							clearInterval(intervalID);
						} else {
							pulseEffect(j);
							document.getElementById("star" + j).style.color = (i < 6) ? red : ((i >= 6 && i < 8) ? yellow : green);
							j++;
						}
					}, 100);
				} else {
					unfocusStar(k);
					k--;
				}
			}, 100);
		}
		function pulseEffect(j) {
			document.getElementById("star" + j).style.transform = "scale(1.4)";
			setTimeout(() => {
				document.getElementById("star" + j).style.transform = "scale(1.2)";
			}, 200);
		}

	} catch (err) {}

	
	/**<<=== For Dark & Light Mode JS ==>>**/
	document.querySelector('.dark-light-btn').addEventListener('click', function () {
		let darkThemeEnabled = document.body.classList.toggle('dark-theme');
		localStorage.setItem('dark-theme-enabled', darkThemeEnabled);
	});
	if (JSON.parse(localStorage.getItem('dark-theme-enabled'))) {
		document.body.classList.add('dark-theme');
	}


	/**<<=== Header Dark & Light Mode JS ==>>**/
	document.querySelector('.header-dark-light-btn').addEventListener('click', function () {
		let headerDarkEnabled = document.body.classList.toggle('header-dark');
		localStorage.setItem('header-dark-enabled', headerDarkEnabled);
	});
	if (JSON.parse(localStorage.getItem('header-dark-enabled'))) {
		document.body.classList.add('header-dark');
	}

	/**<<=== Sidebar Dark & Light Mode JS ==>>**/
	document.querySelector('.sidebar-dark-light-btn').addEventListener('click', function () {
		let sidebarDarkEnabled = document.body.classList.toggle('sidebar-dark');
		localStorage.setItem('sidebar-dark-enabled', sidebarDarkEnabled);
	});
	if (JSON.parse(localStorage.getItem('sidebar-dark-enabled'))) {
		document.body.classList.add('sidebar-dark');
	}


	/**<<=== Sidebar Theme Color JS ==>>**/
	document.querySelector('.sidebar-theme-color-btn').addEventListener('click', function () {
		let sidebarsDarkEnabled = document.body.classList.toggle('sidebar-theme-color');
		localStorage.setItem('sidebar-theme-color-enabled', sidebarsDarkEnabled);
	});
	if (JSON.parse(localStorage.getItem('sidebar-theme-color-enabled'))) {
		document.body.classList.add('sidebar-theme-color');
	}


	/**<<=== Footer Dark & Light Mode JS ==>>**/
	document.querySelector('.footer-dark-light-btn').addEventListener('click', function () {
		let footerDarkEnabled = document.body.classList.toggle('footer-dark');
		localStorage.setItem('footer-dark-enabled', footerDarkEnabled);
	});
	if (JSON.parse(localStorage.getItem('footer-dark-enabled'))) {
		document.body.classList.add('footer-dark');
	}

	
	/**<<=== Card Style JS ==>>**/
	document.querySelector('.card-style-btn').addEventListener('click', function () {
		let cardEnabled = document.body.classList.toggle('card-style');
		localStorage.setItem('card-style-enabled', cardEnabled);
	});
	if (JSON.parse(localStorage.getItem('card-style-enabled'))) {
		document.body.classList.add('card-style');
	}


	/**<<=== Card Style JS ==>>**/
	document.querySelector('.card-style-border-btn').addEventListener('click', function () {
		let cardsEnabled = document.body.classList.toggle('card-style-border');
		localStorage.setItem('card-style-border-enabled', cardsEnabled);
	});
	if (JSON.parse(localStorage.getItem('card-style-border-enabled'))) {
		document.body.classList.add('card-style-border');
	}

	/**<<=== Preloader Hidden & Show JS ==>>**/
	document.querySelector('.preloader-btn').addEventListener('click', function () {
		let preloaderEnabled = document.body.classList.toggle('preloader-hidden');
		localStorage.setItem('preloader-hidden-enabled', preloaderEnabled);
	});
	if (JSON.parse(localStorage.getItem('preloader-hidden-enabled'))) {
		document.body.classList.add('preloader-hidden');
	}


	/**<<=== Icon Sidebar JS ==>>**/
	document.querySelector('.icon-sidebar-btn').addEventListener('click', function () {
		let iconsidebarEnabled = document.body.classList.toggle('icon-sidebar');
		localStorage.setItem('icon-sidebar-enabled', iconsidebarEnabled);
	});
	if (JSON.parse(localStorage.getItem('icon-sidebar-enabled'))) {
		document.body.classList.add('icon-sidebar');
	}

	/**<<=== Header Fixed & Sticky JS ==>>**/
	document.querySelector('.header-fixed-sticky-btn').addEventListener('click', function () {
		let headerfixedEnabled = document.body.classList.toggle('header-fixed-sticky');
		localStorage.setItem('header-fixed-sticky-enabled', headerfixedEnabled);
	});
	if (JSON.parse(localStorage.getItem('header-fixed-sticky-enabled'))) {
		document.body.classList.add('header-fixed-sticky');
	}


	/**<<=== Back To Top Hide & Show JS ==>>**/
	document.querySelector('.back-top-btn').addEventListener('click', function () {
		let backtotopEnabled = document.body.classList.toggle('back-top-hide-show');
		localStorage.setItem('back-top-hide-show-enabled', backtotopEnabled);
	});
	if (JSON.parse(localStorage.getItem('back-top-hide-show-enabled'))) {
		document.body.classList.add('back-top-hide-show');
	}


	/**<<=== Layout Width Style JS ==>>**/
	document.querySelector('.layout-width-btn').addEventListener('click', function () {
		let layoutEnabled = document.body.classList.toggle('layout-width');
		localStorage.setItem('layout-width-enabled', layoutEnabled);
	});
	if (JSON.parse(localStorage.getItem('layout-width-enabled'))) {
		document.body.classList.add('layout-width');
	}

})(jQuery);