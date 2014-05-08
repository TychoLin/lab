function Tool() {
	var cb_mam_elem, parent_elem;
	var group_elems = [];

	this.init = function(cb_mam_id, parent_id, group_name) {
		cb_mam_elem = document.getElementById(cb_mam_id);
		parent_elem = document.getElementById(parent_id);
		var objs = parent_elem.getElementsByTagName("input");
		for (var i = 0; i < objs.length; i++) {
			if ((objs[i].type == "checkbox") && (objs[i].name == group_name)) {
				group_elems.push(objs[i]);
			}
		}

		cb_mam_elem.onchange = function() {
			for (var i = 0; i < group_elems.length; i++) {
				group_elems[i].checked = cb_mam_elem.checked;
			}
		};
		
		for (var i = 0; i < group_elems.length; i++) {
			group_elems[i].onchange = function() {
				for (var i = 0; i < group_elems.length; i++) {
					if (!group_elems[i].checked) {
						cb_mam_elem.checked = false;
						return;
					}
				}
				cb_mam_elem.checked = true;
			};
		}
	};
	
	this.getUserId = function() {
		var user_id = [];
		for (var i = 0; i < group_elems.length; i++) {
			if (group_elems[i].checked) {
				user_id.push(group_elems[i].id.split("_")[1]);
			}
		}
		
		if (user_id.length == 0) {
			return "";
		} else {
			return user_id.toString();
		}
	};
}

window.onload = function() {
	var myCheckBox = new Tool();
	myCheckBox.init("cb_mam", "index", "item");
	
	document.getElementById("index").onsubmit = function() {
		var user_id = myCheckBox.getUserId();
		if (user_id != "") {
			document.getElementById("user_id").value = user_id;
		} else {
			alert("no item checked");
			return false;
		}
	};
};