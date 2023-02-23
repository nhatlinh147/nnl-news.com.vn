function run_typehead(param_path, param_link) {
	$("input#Search_Product").typeahead({
		onSelect: function (item) {
			console.log(item);
		},
		ajax: {
			url: param_path,
			method: "get",
			displayField: "Product_Name",
			valueField: "Product_Slug",
			preDispatch: function (query) {
				return {
					query: query,
				};
			},
			preProcess: function (data) {
				return data;
			},
		},
		item: '<li><a href="#" role="option" class="dropdown-item text-wrap"></a></li>',
		select: function (item) {
			var a = this.$menu.find(".active");
			if (a.length) {
				var b = a.attr("data-value"),
					c = this.$menu.find(".active a").text();
				window.location.href = param_link + a.attr("data-value");
				this.$element.val(this.updater(c)).change(),
					this.options.onSelect &&
						this.options.onSelect({
							value: b,
							text: c,
						});
			}
			return this.hide();
		},
		autoSelect: 0,
	});
}
