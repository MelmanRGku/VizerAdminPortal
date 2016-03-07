"use strict";

class Room{
	constructor(id, image)
	{
		"use strict";
		this.id = id;
		this.image = image;
		this.links = new Array();
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
}