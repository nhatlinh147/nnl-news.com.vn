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

				if (check == true) {
					nex_select.remove();
					if (selector == "text_commnent") {
						$("button#Submit_Comment").trigger("click");
					}
				} else {
					if ($(selector_append).next("div").length != 0) {
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

		General.check_append(
			selector_content,
			"error",
			"Bình luận không được để trống",
			true
		);

		General.check_append(selector_content, "text_commnent", content, false);
	});
})();
