function StatusSettings () {
	StatusSettings.updateColourInputs();
	
	document.addEventListener("mouseup", StatusSettings.updateColourInputs);
}

StatusSettings.updateColourInputs = function (e) {
	if (e && e.target && e.target.previousElementSibling &&
	    e.target.previousElementSibling.tagName.toLowerCase() === "table") {
		setTimeout(function () {
			StatusSettings.updateColourInputs();
		}, 15);
	}
	
	[].slice.call(document.querySelectorAll("td[class*='status-color']")).map(cell => {
		const ta = cell.firstElementChild;
		if (ta.tagName.toLowerCase() === "input") return;
		
		const name  = ta.getAttribute("name")
			, value = ta.value;
		const cl = document.createElement("input");
		cl.setAttribute("type", "color");
		cl.setAttribute("name", name);
		cl.value = value;
		cell.removeChild(ta);
		cell.appendChild(cl);
	});
};