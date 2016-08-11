function StatusInput(namespaceId, statuses) {
	this.namespaceId = namespaceId;
	this.statuses = JSON.parse(statuses);

	this.input = document.getElementById(this.namespaceId);
	this.active = this.input.value;
	this.activeLi = null;

	if (this.active === '') {
		for (var i = 0; i < this.statuses.length; i++) {
			if (this.statuses[i].default) {
				this.active = this.statuses[i].handle;
				break;
			}
		}

		if (this.active === '') this.active = this.statuses[0].handle;
	}

	this.input.value = this.active;

	document.getElementById(namespaceId + '-field').style.display = 'none';

	this.createInput();
}

StatusInput.prototype.createInput = function () {
	var self = this,
		settingsPane = document.getElementById('settings');
	if (!settingsPane) return;

	var input = document.createElement('ul');
	input.className = 'pane custom-statuses';

	for (var i in this.statuses) {
		if (!this.statuses.hasOwnProperty(i)) continue;

		var li = document.createElement('li');
		li.textContent = this.statuses[i].name;
		li.handle = this.statuses[i].handle;

		var s = document.createElement('div');
		s.className = 'status on';
		s.style.backgroundColor = this.statuses[i].color;
		li.appendChild(s);

		li.addEventListener('click', function () {
			if (self.active === this.handle) return;

			this.className = 'sel';
			self.activeLi.className = '';
			self.activeLi = this;
			self.active = this.handle;
			self.input.value = this.handle;
		});

		if (this.statuses[i].handle === this.active) {
			li.className = 'sel';
			this.activeLi = li;
		}

		input.appendChild(li);
	}

	settingsPane.parentNode.insertBefore(input, settingsPane.nextElementSibling);
};