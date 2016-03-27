"use strict";

class Room{
	constructor(id, name, image)
	{
		"use strict";
		this.id = id;
		this.name = name;
		this.image = image;
		this.imageUUID = null;
		this.firstRoom = false;
		this.links = new Array();
		this.bubbles = new Array();
	}

	getDict()
	{
		var dict = {};
		dict["id"] = this.id;
		dict["name"] = this.name;
		dict["firstRoom"] = this.firstRoom;

		var linksArr = [];
		for(var i = 0; i < this.links.length; i++){
			linksArr.push(  this.links[i].getDict()  );
		}
		dict["links"] = linksArr;

		var bubblesArr = [];
		for(var i = 0; i < this.bubbles.length; i++){
			bubblesArr.push(  this.bubbles[i].getDict()  );
		}
		dict["bubbles"] = bubblesArr;

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


class FeatureBubble
{
	constructor( theta, phi, informationText)
	{
		this.theta = theta;
		this.phi = phi;
		this.informationText = informationText;
		this.backgroundSprite = null;
	}

	getDict()
	{
		var dict = {};
		dict["text"] = this.informationText;
		dict["theta"] = this.theta;
		dict["phi"] = this.phi;

		return dict;
	}
}