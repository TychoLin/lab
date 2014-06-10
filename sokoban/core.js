function forEachIn(obj, func) {
	for (var name in obj) {
		if (obj.hasOwnProperty(name))
			func(name, obj[name]);
	}
}

function createHtmlElement(tagName, attributes) {
	var node = document.createElement(tagName);
	forEachIn(attributes, function (name, value) {
		node.setAttribute(name, value);
	});
	
	if (typeof arguments[2] == "string") {
		var child = document.createTextNode(arguments[2]);
		node.appendChild(child);
	}
	
	return node;
}

function removeElement(node) {
	if (node.parentNode)
		node.parentNode.removeChild(node);
}

function Point(x, y) {
	this.x = x;
	this.y = y;
}

Point.add = function (p1, p2) {
	return new Point(p1.x + p2.x, p1.y + p2.y);
};

function Square(symbol, tableCell) {
	this.symbol = /[#0@* ]/.test(symbol) ? symbol : null;
	this.tableCell = tableCell;
	
	var symbol = this.symbol;
	var type = null;
	if (symbol == "#") {
		type = "wall";
	} else if (symbol == "0") {
		type = "boulder";
	} else if (symbol == "@") {
		type = "player";
	} else if (symbol == "*") {
		type = "exit";
	} else if (symbol == " ") {
		type = "empty";
	}
	this.type = type ? type : null;
	this.tableCell.className = /wall|exit|empty/i.test(this.type) ? this.type : "empty";
	
	if (/player|boulder/i.test(this.type)) {
		var image = createHtmlElement("img", {src: "img/" + this.type + ".gif"});
		this.tableCell.appendChild(image);
	}
}

Square.prototype.isPlayer = function () {
	return this.type == "player";
};

Square.prototype.isBoulder = function () {
	return this.type == "boulder";
};

Square.prototype.isEmpty = function () {
	return this.type == "empty";
};

Square.prototype.isExit = function () {
	return this.type == "exit";
};

Square.prototype.moveContent = function (target) {
	target.tableCell.appendChild(this.tableCell.firstChild);
	var symbol = target.symbol;
	var type = target.type;
	target.symbol = this.symbol;
	target.type = this.type;
	this.symbol = symbol;
	this.type = type;
};

Square.prototype.clearContent = function (exitSquare) {
	exitSquare.tableCell.appendChild(this.tableCell.firstChild);
	this.symbol = " ";
	this.type = "empty";
	
	var image = exitSquare.tableCell.firstChild;
	var size = 100;
	var width = 32;
	var animate = setInterval(function () {
		size -= 10;
		image.style.width = size + "%";
		image.style.height = size + "%";
		totalLeft = (32 - width * size / 100) / 2;
		image.style.marginLeft = totalLeft + "px";
		
		if (size < 40) {
			clearInterval(animate);
			exitSquare.tableCell.removeChild(image);
		}
	}, 70);
};

function SokobanField(map) {
	this.matrix = [];
	var tbody = createHtmlElement("tbody");
	this.leftBoulders = map.leftBoulders;
	
	map.field.forEach(function (elem, i) {
		var matrixRow = [];
		var tableRow = createHtmlElement("tr");
		for (var j = 0; j < elem.length; j++) {
			var tableCell = createHtmlElement("td");
			var square =  new Square(elem[j], tableCell);
			matrixRow.push(square);
			tableRow.appendChild(tableCell);
			
			if (square.isPlayer()) this.playerPos = new Point(i, j);
		}
		this.matrix.push(matrixRow);
		tbody.appendChild(tableRow);
	}, this);
	
	var table = createHtmlElement("table", {"class": "sokoban"});
	table.appendChild(tbody);
	this.table = table;
	this.createScore();
}

SokobanField.prototype.getSquare = function (pos) {
	return this.matrix[pos.x][pos.y];
};

SokobanField.prototype.move = function (direction) {
	var destPos = Point.add(this.playerPos, direction);
	var destSquare = this.getSquare(destPos);
	
	if (destSquare.isBoulder()) {
		var pushPos = Point.add(destPos, direction);
		var pushSquare = this.getSquare(pushPos);
		if (pushSquare.isEmpty())  {
			this.changeSquarePosition(destPos, pushPos);
		} else if (pushSquare.isExit()) {
			destSquare.clearContent(pushSquare);
			this.leftBoulders--;
			this.updateScore();
		}
	}
	
	if (destSquare.isEmpty()) {
		this.changeSquarePosition(this.playerPos, destPos);
		this.playerPos = destPos;
	}
};

SokobanField.prototype.changeSquarePosition = function (fromPos, toPos) {
	var fromSquare = this.getSquare(fromPos);
	var toSquare = this.getSquare(toPos);
	fromSquare.moveContent(toSquare);
};

SokobanField.prototype.isWin = function () {
	return this.leftBoulders <= 0;
};

SokobanField.prototype.createScore = function () {
	this.scoreContainer = createHtmlElement("div", {id: "scoreContainer"});
	this.score = createHtmlElement("span", {id: "score"}, String(this.leftBoulders));
	var text = document.createTextNode("boulders left");
	this.scoreContainer.appendChild(this.score);
	this.scoreContainer.appendChild(text);
}

SokobanField.prototype.updateScore = function () {
	var size = 100;
	var left = 0;
	var bottom = 0;
	this.score.innerHTML = this.leftBoulders;
	var animate = window.setInterval(action.bind(this), 100);
	
	function action() {
		this.score.style.fontSize = size + "%";
		bottom = -50 * Math.pow(0.01 * left - 2, 2) + 200;
		this.score.style.left = left + "px";
		this.score.style.bottom = bottom + "px";
		size += 30;
		left += 10;
		
		if (bottom >= 200) {
			window.clearInterval(animate);
			this.score.style.fontSize = 100 + "%";
			this.score.style.left = 0 + "px";
			this.score.style.bottom = 0 + "px";
		}
	}
};

SokobanField.prototype.place = function (where) {
	where.appendChild(this.table);
	where.appendChild(this.scoreContainer);
};

SokobanField.prototype.remove = function () {
	removeElement(this.table);
	removeElement(this.scoreContainer);
};

SokobanField.prototype.toString = function () {
	var debugArr = [];
	this.matrix.forEach(function (matrixRow) {
		var arr = [];
		matrixRow.forEach(function (elem) {
			arr.push(elem.symbol);
		});
		debugArr.push(arr.join(""));
	});
	
	console.log(debugArr.join("\n"));
	return debugArr.join("\n");
};

var arrowKeyCodes = {
	37: new Point(0, -1), // left
	38: new Point(-1, 0), // up
	39: new Point(0, 1),  // right
	40: new Point(1, 0)   // down
};

function SokobanGame() {
	this.level = 0;
	this.field = new SokobanField(sokobanMaps[this.level]);
	document.addEventListener("keydown", keyDown.bind(this), false);
	
	this.fieldContainer = createHtmlElement("div");
	this.field.place(this.fieldContainer);
	this.gameUI = createHtmlElement("div", {id: "gameUI"});
	this.createReset();
	this.createLevelSelect();
	document.body.appendChild(this.fieldContainer);
	document.body.appendChild(this.gameUI);
	
	function keyDown(event) {
		event.stopPropagation();
		event.preventDefault();
		var direction = arrowKeyCodes[event.keyCode];
		if (direction instanceof Point) this.field.move(direction);
		
		if (this.field.isWin()) {
			alert("Great");
		}
	}
}

SokobanGame.prototype.createReset = function () {
	var button = createHtmlElement("button", {id: "reset"}, "reset");
	this.gameUI.appendChild(button);
	button.addEventListener("click", this.reset.bind(this), false);
};

SokobanGame.prototype.createLevelSelect = function () {
	var select = createHtmlElement("select", {id: "level"});
	sokobanMaps.forEach(function (elem, index) {
		var text = "level " + (index + 1) + " has " + elem.leftBoulders + " boulders";
		var option = createHtmlElement("option", {value: index}, text);
		select.appendChild(option);
	});
	this.gameUI.appendChild(select);
	select.addEventListener("change", this.changeLevel.bind(this), false);
};

SokobanGame.prototype.reset = function () {
	this.field.remove();
	this.field = new SokobanField(sokobanMaps[this.level]);
	this.field.place(this.fieldContainer);
};

SokobanGame.prototype.changeLevel = function (event) {
	this.level = event.srcElement.value;
	this.reset();
};