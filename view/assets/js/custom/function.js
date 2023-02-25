var General = (function () {
	return {
		insert_head: function (params, condition = 0) {
			var script,
				array_script = document.getElementsByTagName("script");
			let check = 0;
			for (let index = 0; index < array_script.length; index++) {
				if (array_script[index].getAttribute("src") == params) {
					check++;
				}
			}
			if (check == 0) {
				if ((condition = 1)) {
					script = document.createElement("link");
					script.href = params;
					script.rel = "stylesheet";
					script.type = "text/css";
				} else {
					script = document.createElement("script");
					script.src = params;
				}
				document.head.appendChild(script);
			}
		},
	};
})();
