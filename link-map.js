var Node = {
	saveRingColor: function(color) {
		if (this.ring_colour && this.ring_colour != color) {
			this.ring_colour = "#000000";
		} else {
			this.ring_colour = color;
		}
	},
	drawGraphic: function(ctx) {
		ctx.save(); //save the old settings

		for(var opt in this.Station.ctxSettings) { ctx[opt] = this.Station.ctxSettings[opt]; }

		ctx.beginPath();
		ctx.arc(this.x, this.y, this.Station.radius, 0, Math.PI*2, true); // Outer circle
		ctx.fill(); //create the inner white fill
		ctx.stroke(); //create the outer black line

		ctx.restore(); //restore the settings as they were before this method
	},
	createLabel: function() {
		var padding_x = (this.label_adjust_down == true && this.label_adjust_right == false ? -8 : 7),
			padding_y = (this.label_adjust_down ? 5 : -14),
			css = {
				left: (parseInt(this.x) + this.Station.radius + padding_x),
				top: (parseInt(this.y) + this.Station.radius + padding_y)
			};

		var label;
		if (this.href) {
			label = $("<a/>").attr('href', this.href).attr('rel', (this.external ? 'external' : null));
		} else {
			label = $("<span/>");
		}
		return label.html(this.name).addClass(this.size).css(css);
	},
	createDragHandle: function() {
		var node = this;
		return $("<span/>").addClass('drag-handle').css({
			left: (parseInt(this.x) - (this.Station.radius * 3/2)),
			top: (parseInt(this.y) - (this.Station.radius * 3/2)),
			width:this.Station.radius * 3.5,
			height:this.Station.radius * 3.5,
			position:'absolute'
		}).draggable({
			containment: 'parent',
			drag:function(event, ui) {
				//console.debug(ui.position.top, ui.position.left);
				node.x = ui.position.left;
				node.y = ui.position.top;
				getStore().put('node_'+node.id, node);
				$(document).trigger('data-loaded');
			},
			stop:function(event, ul) {

			}
		}).bind('dblclick', function() {
			$(this).after(Node.createEditBox.call(node));
		});
	},
	createEditBox: function() {
		return Template.replace(Template.get('#node_edit_tmpl'), this);
	}
};

var map = {
	getMap: function() {
		this._map = this._map ? this._map : $('#map')[0];
		return this._map;
	},
	getCanvas: function() {
		this._canvas = this._canvas ? this._canvas : $('canvas', this.getMap())[0];
		return this._canvas;
	},
	getContext: function() {
		return map.getCanvas().getContext('2d');
	},
	getOverlay: function() {
		this._overlay = this._overlay ? this._overlay : $('.overlay', this.getMap());
		return this._overlay;
	},

	getNodeSettings: function(key) {
		settings = {
			'default':{
				fillStyle:'#FFFFFF',
				lineWidth:2,
			},
			'large':{
				fillStyle:'#000000',
				strokeStyle:'#000000',
				lineWidth:5
			}
		};
		key = (key in settings) ? key : 'default';
		return settings[key];
	},

	clear: function() {
		var canvas = map.getCanvas(),
			ctx = map.getContext();

		map.nodes = [], map.links = [];

		ctx.clearRect(0,0,canvas.width,canvas.height);
		ctx.fillStyle = "rgba(255, 255, 255, 0.75)";
		ctx.fillRect (0, 0, canvas.width, canvas.height);

		map.getOverlay().html('');
	},

	draw: function() {
		if (map.nodes && map.links) {
			var i = 0, node, link, ctx = map.getContext();

			$.each(map.links, function() {
				this.start = map.getNodeById(this.start_id);
				this.end = map.getNodeById(this.end_id);
				map._drawLink(ctx, this);
			});

			$.each(map.nodes, function() {
				map._drawStation(ctx, this);
			});

			//map.setupOverlay();
		}
	},
	getNodeById: function(id) {
		return map.nodes.filter(function(item){
			return (item.id == id);
		})[0];
	},

	setupOverlay: function() {
		//setup the interactive features

		map.getOverlay().update();
		//draw an extra container for the editing toolbox
		//map.getOverlay().insert('<div id="node_edit" ajaxtriggers="node_edit"></div>');

		//setup click&hold&drag&release handlers
		//behaviours.listenFor.externalLinks(map.getOverlay());
	},

	_drawStation: function(ctx, node) {
		if (!node.name) { return }
		node.Station = {};
		node.Station.radius = 5;
		node.Station.ctxSettings = map.getNodeSettings(node.size);
		node.Station.ctxSettings.strokeStyle = (node.ring_colour ? node.ring_colour : ctx.strokeStyle);

		Node.drawGraphic.call(node, ctx);
		map.getOverlay()
			.append( Node.createLabel.call(node) )
			.append( Node.createDragHandle.call(node) );
	},

	_drawLink: function(ctx, _this) {
		if (_this.start != _this.end && _this.start != undefined && _this.end != undefined) {
			ctx.save();

			ctx.lineWidth = (_this.lineWidth ? _this.lineWidth : 10);
			ctx.strokeStyle = _this.colour_code;
			ctx.lineCap = 'round';
			ctx.lineJoin = 'round';

			//setup the ring colours for later when we print the stations (stations are printed ontop of other drawings)
			Node.saveRingColor.call(_this.start, _this.colour_code);
			Node.saveRingColor.call(_this.end, _this.colour_code);

			_this.start.x = parseInt(_this.start.x);
			_this.start.y = parseInt(_this.start.y);
			_this.end.x = parseInt(_this.end.x);
			_this.end.y = parseInt(_this.end.y);

			if (_this.end.x < _this.start.x) { //force start&end to also be in left&right order
				tmp = _this.end;
				_this.end = _this.start
				_this.start = tmp;
			}

			if (!_this.bends || _this.bends <= 1) {

				ctx.beginPath();
				ctx.moveTo(_this.start.x, _this.start.y);

				if (_this.start.x == _this.end.x) {
					if (_this.start.y < _this.end.y) {
						_this.start.label_adjust_right = true;
					} else {
						_this.end.label_adjust_right = true;
					}
					ctx.lineTo(_this.end.x, _this.end.y);
				} else if (_this.start.y == _this.end.y) {
					if (_this.start.x < _this.end.x) {
						_this.start.label_adjust_down = true;
					} else {
						_this.end.label_adjust_down = true;
					}
					ctx.lineTo(_this.end.x, _this.end.y);
				} else {
					slope = (_this.end.y - _this.start.y) / (_this.end.x - _this.start.x);

					if (_this.flipSlope == true && Math.abs(slope) != 1) {
						if (slope > 1) {
							slope = .2;
						} else if (slope > 0) {
							slope = 1.2;
						} else if (slope > -1) {
							slope = -1.2;
						} else {
							slope = -.2;
						}
					}

					//size of corner cut
					dx = Math.abs(_this.end.x - _this.start.x);
					dy = Math.abs(_this.end.y - _this.start.y);
					if (dx >= dy) {
						dx = dy = (dy > 20 ? dy : 20);
					} else {
						dy = dx = (dx > 20 ? dx : 20);
					}

					if (0 < Math.abs(slope) && Math.abs(slope) < 1) { //shallow slope (go horizontal first)
						if (_this.start.x < _this.end.x) {
							_this.start.label_adjust_down = true;
						}
						if (slope > 0 ) {
							ctx.lineTo(_this.end.x-(dx/2), _this.start.y);
							ctx.lineTo(_this.end.x, _this.start.y+(dy/2));
						} else {
							_this.start.label_adjust_down = true;
							ctx.lineTo(_this.end.x-(dx/2), _this.start.y);
							ctx.lineTo(_this.end.x, _this.start.y-(dy/2));
						}
					} else if (1 < Math.abs(slope)) { //steep slope?
						if (slope > 0 ) {
							if (_this.start.y < _this.end.y) {
								_this.start.label_adjust_right = true;
							} else {
								_this.end.label_adjust_right = true;
							}
							ctx.lineTo(_this.start.x, _this.end.y-(dy/2));
							ctx.lineTo(_this.start.x+(dx/2), _this.end.y);
						} else {
							ctx.lineTo(_this.start.x, _this.end.y+(dy/2));
							ctx.lineTo(_this.start.x+(dx/2), _this.end.y);
						}
					}



					ctx.lineTo(_this.end.x, _this.end.y);
				}
				ctx.stroke();
				ctx.restore();
			} else { //more than one bend
				dx = _this.end.x - _this.start.x;
				dy = _this.end.y - _this.start.y;
				new_node = {x:_this.end.x-(dx/(_this.bends)), y:_this.end.y-(dy/(_this.bends)), name:''};

				map._drawLink(ctx, {
					start: _this.start,
					end: new_node,
					Link: {
						bends: 1,
						flipSlope: _this.flipSlope,
						lineWidth: _this.lineWidth
					},
					Colour: _this.Colour
				});

				map._drawLink(ctx, {
					start: new_node,
					end: _this.end,
					Link: {
						bends: _this.bends-1,
						flipSlope: !parseInt(_this.flipSlope),
						lineWidth: _this.lineWidth
					},
					Colour: _this.Colour,
				});
			}

		}
	}
};
