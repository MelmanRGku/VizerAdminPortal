"use strict";

class Room{
	constructor(id, name, image)
	{
		"use strict";
		this.id = id;
		this.name = name;
		this.image = image;
		this.firstRoom = false;
		this.links = new Array();
	}

	getDict()
	{
		var dict = {};
		dict["id"] = this.id;
		dict["name"] = this.name;
		dict["image"] = this.image;

		var linksArr = [];

		for(var i = 0; i < this.links.length; i++){
			linksArr.push(  this.links[i].getDict()  );
		}

		dict["links"] = linksArr;

		return dict;
	}
}

class RoomLink{
	constructor(id,theta,phi)
	{
		this.toId = id;
		this.theta = theta;
		this.phi = phi;
		this.circleMesh = null;
		this.linkSprite = null;
	}

	getDict()
	{
		var dict = {};
		dict["toId"] = this.toId;
		dict["theta"] = this.theta;
		dict["phi"] = this.phi;

		return dict;
	}
}