(function () {
	var General = (function () {
		var check_length = function (selector) {
			if ($(selector).length != 0) {
				return $(selector).val().length == 0 ? false : true;
			}
		};
		return {
			check_append: function (selector_append, selector, content, validate) {
				let check = validate
					? check_length(selector_append)
					: !check_length(selector_append);
				let nex_select = $(selector_append).next("." + selector); //Phần tử selector kếp tiếp nex_sel

<<<<<<< HEAD
				if (check == true) {
					nex_select.remove();
					if (selector == "text_commnent") {
						$("button#Submit_Comment").trigger("click");
					}
				} else {
					if ($(selector_append).next("div").length != 0) {
=======
				if (check && validate == true) {
					nex_select.remove();
				} else {
					if ($(selector_append).next("." + selector).length != 0) {
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
						nex_select.html(content);
					} else {
						$(selector_append).after(
							`<div class="${selector}">${content}</div>`
						);
					}
				}
			},
		};
	})();

	$(document).on("click", "button#Submit_Comment", function () {
		let selector_content = "textarea#comment_news";
		let get_content = $(selector_content).val();
		content = `<input type="text" disabled  value="${get_content}"/>`;
<<<<<<< HEAD

=======
		console.log(content);
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
		General.check_append(
			selector_content,
			"error",
			"Bình luận không được để trống",
			true
		);
<<<<<<< HEAD

=======
>>>>>>> 0e133387dca52c7ccb8a8ad1bc5816e4a6b64f95
		General.check_append(selector_content, "text_commnent", content, false);
	});
})();
