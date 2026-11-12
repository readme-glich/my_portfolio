/**
 * Music Star Amplify front end scripts.
 *
 * 1. Stage Lights: spotlight that follows the mouse over the header image.
 * 2. Release Countdown: live clock.
 * 3. News Ticker: constant speed whatever the length of the titles.
 * 4. Live Visualizer: reacts to the real music with the Web Audio API.
 *
 * Everything is progressive: without JavaScript the page works normally.
 */
( function () {
	'use strict';

	var root = document.documentElement;
	var reduceMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	/*
	 * 1. Spotlight over the header image.
	 */
	( function () {
		var header = document.querySelector( '.msa-spotlight-on .all-header' );
		if ( ! header || reduceMotion ) {
			return;
		}
		var spot = document.createElement( 'div' );
		spot.className = 'msa-spot';
		spot.setAttribute( 'aria-hidden', 'true' );
		header.appendChild( spot );

		function move( x, y ) {
			spot.style.setProperty( '--msa-x', x + 'px' );
			spot.style.setProperty( '--msa-y', y + 'px' );
		}

		var touch = window.matchMedia && window.matchMedia( '(hover: none)' ).matches;

		if ( ! touch ) {
			header.addEventListener( 'mousemove', function ( event ) {
				var rect = header.getBoundingClientRect();
				move( event.clientX - rect.left, event.clientY - rect.top );
			} );
			header.addEventListener( 'mouseenter', function () {
				spot.classList.add( 'is-active' );
			} );
			header.addEventListener( 'mouseleave', function () {
				spot.classList.remove( 'is-active' );
			} );
			return;
		}

		// Touch screens: the spotlight moves slowly by itself while the header is visible.
		var visible = true;
		if ( 'IntersectionObserver' in window ) {
			new window.IntersectionObserver( function ( entries ) {
				visible = entries[ 0 ].isIntersecting;
			} ).observe( header );
		}
		spot.classList.add( 'is-active' );
		( function sweep( time ) {
			if ( visible ) {
				var w = header.offsetWidth;
				var h = header.offsetHeight;
				move( w / 2 + Math.sin( time / 2300 ) * w * 0.35, h / 2 + Math.sin( time / 1700 ) * h * 0.25 );
			}
			window.requestAnimationFrame( sweep );
		}( 0 ) );
	}() );

	/*
	 * 2. Release Countdown.
	 */
	( function () {
		var boxes = document.querySelectorAll( '.msa-countdown[data-target]' );
		if ( ! boxes.length ) {
			return;
		}

		function pad( n ) {
			return n < 10 ? '0' + n : String( n );
		}

		function tick() {
			var now = Math.floor( Date.now() / 1000 );
			Array.prototype.forEach.call( boxes, function ( box ) {
				var left = Math.max( 0, parseInt( box.getAttribute( 'data-target' ), 10 ) - now );
				var values = {
					d: String( Math.floor( left / 86400 ) ),
					h: pad( Math.floor( ( left % 86400 ) / 3600 ) ),
					m: pad( Math.floor( ( left % 3600 ) / 60 ) ),
					s: pad( left % 60 )
				};
				Array.prototype.forEach.call( box.querySelectorAll( '[data-unit]' ), function ( el ) {
					var value = values[ el.getAttribute( 'data-unit' ) ];
					if ( el.textContent !== value ) {
						el.textContent = value;
					}
				} );
				box.classList.toggle( 'is-done', left === 0 );
			} );
		}

		tick();
		window.setInterval( tick, 1000 );
	}() );

	/*
	 * 3. News Ticker: same speed in pixels per second for any length.
	 */
	( function () {
		var tickers = document.querySelectorAll( '.msa-ticker' );
		var speeds = { slow: 35, normal: 60, fast: 100 };

		// With few or short titles, repeat them so the line is always full.
		function fill( ticker ) {
			var lists = ticker.querySelectorAll( '.msa-ticker-list' );
			var viewport = ticker.querySelector( '.msa-ticker-viewport' );
			if ( lists.length < 2 || ! viewport ) {
				return;
			}
			var originals = Array.prototype.slice.call( lists[ 0 ].children );
			var guard = 0;
			while ( lists[ 0 ].offsetWidth < viewport.offsetWidth && originals.length && guard < 30 ) {
				originals.forEach( function ( item ) {
					Array.prototype.forEach.call( lists, function ( list ) {
						var copy = item.cloneNode( true );
						copy.setAttribute( 'aria-hidden', 'true' );
						var link = copy.querySelector( 'a' );
						if ( link ) {
							link.setAttribute( 'tabindex', '-1' );
						}
						list.appendChild( copy );
					} );
				} );
				guard++;
			}
		}

		function update() {
			Array.prototype.forEach.call( tickers, function ( ticker ) {
				var list = ticker.querySelector( '.msa-ticker-list' );
				var track = ticker.querySelector( '.msa-ticker-track' );
				if ( ! list || ! track ) {
					return;
				}
				fill( ticker );
				var speed = speeds[ ticker.getAttribute( 'data-speed' ) ] || speeds.normal;
				track.style.setProperty( '--msa-ticker-duration', Math.max( 8, list.offsetWidth / speed ) + 's' );
				ticker.classList.add( 'is-ready' );
			} );
		}

		if ( tickers.length ) {
			update();
			window.addEventListener( 'resize', update );
		}
	}() );

	/*
	 * 4. Live Visualizer.
	 */
	( function () {
		var box = document.querySelector( '.msa-viz' );
		if ( ! box ) {
			return;
		}
		var canvas = box.querySelector( 'canvas' );
		var ctx2d = canvas.getContext( '2d' );
		var style = box.getAttribute( 'data-style' ) || 'bars';
		var idle = box.getAttribute( 'data-idle' ) === '1';
		var AudioCtx = window.AudioContext || window.webkitAudioContext;

		var audioCtx = null;
		var analyser = null;
		var freq = null;
		var wave = null;
		var sources = typeof WeakMap === 'function' ? new WeakMap() : null;
		var playing = []; // Media elements that are playing now.
		var levels = [];
		var width = 0;
		var height = 0;
		var running = false;
		var colors = [ '#c36dff', '#ff4f8b' ];

		function readColors() {
			var css = window.getComputedStyle( root );
			colors = [
				( css.getPropertyValue( '--msa-c1' ) || '#c36dff' ).trim(),
				( css.getPropertyValue( '--msa-c2' ) || '#ff4f8b' ).trim()
			];
		}

		function resize() {
			var ratio = window.devicePixelRatio || 1;
			width = box.clientWidth;
			height = box.clientHeight;
			canvas.width = Math.round( width * ratio );
			canvas.height = Math.round( height * ratio );
			ctx2d.setTransform( ratio, 0, 0, ratio, 0, 0 );
			draw( 0 );
		}

		/**
		 * The browser can only analyse audio from the same website (or files
		 * served with CORS). Other files would be muted, so they are not
		 * connected and the visualizer plays a soft animation instead.
		 */
		function canAnalyse( media ) {
			if ( ! AudioCtx ) {
				return false;
			}
			if ( media.crossOrigin ) {
				return true;
			}
			try {
				var src = media.currentSrc || media.src;
				return new URL( src, window.location.href ).origin === window.location.origin;
			} catch ( e ) {
				return false;
			}
		}

		function connect( media ) {
			if ( ! canAnalyse( media ) ) {
				return false;
			}
			try {
				if ( ! audioCtx ) {
					audioCtx = new AudioCtx();
					analyser = audioCtx.createAnalyser();
					analyser.fftSize = 512;
					analyser.smoothingTimeConstant = 0.78;
					analyser.connect( audioCtx.destination );
					freq = new Uint8Array( analyser.frequencyBinCount );
					wave = new Uint8Array( analyser.fftSize );
				}
				if ( audioCtx.state === 'suspended' ) {
					audioCtx.resume();
				}
				if ( sources && ! sources.has( media ) ) {
					var source = audioCtx.createMediaElementSource( media );
					source.connect( analyser );
					sources.set( media, source );
				}
				return true;
			} catch ( e ) {
				// The element is already used by another script: animate without data.
				return false;
			}
		}

		function isMedia( el ) {
			return el && ( el.tagName === 'AUDIO' || el.tagName === 'VIDEO' );
		}

		document.addEventListener( 'play', function ( event ) {
			var media = event.target;
			if ( ! isMedia( media ) ) {
				return;
			}
			media.msaReal = connect( media );
			if ( playing.indexOf( media ) === -1 ) {
				playing.push( media );
			}
			box.classList.add( 'is-playing' );
			start();
		}, true );

		function stopped( event ) {
			var index = playing.indexOf( event.target );
			if ( index !== -1 ) {
				playing.splice( index, 1 );
			}
			if ( ! playing.length ) {
				box.classList.remove( 'is-playing' );
			}
		}
		document.addEventListener( 'pause', stopped, true );
		document.addEventListener( 'ended', stopped, true );

		function realData() {
			for ( var i = 0; i < playing.length; i++ ) {
				if ( playing[ i ].msaReal ) {
					return true;
				}
			}
			return false;
		}

		// Values 0..1 for every bar.
		function targets( count, time ) {
			var out = new Array( count );
			var i;
			if ( playing.length && realData() && analyser ) {
				analyser.getByteFrequencyData( freq );
				// Use the lower 75% of the spectrum, spread on a curve so bass and treble both show.
				var usable = Math.floor( freq.length * 0.75 );
				for ( i = 0; i < count; i++ ) {
					var from = Math.floor( Math.pow( i / count, 1.5 ) * usable );
					var end = Math.max( from + 1, Math.floor( Math.pow( ( i + 1 ) / count, 1.5 ) * usable ) );
					var sum = 0;
					for ( var j = from; j < end; j++ ) {
						sum += freq[ j ];
					}
					// Higher frequencies are naturally quieter: boost them so the whole width moves.
					var boost = 1 + ( i / count ) * 2;
					out[ i ] = Math.min( 1, Math.pow( sum / ( end - from ) / 255, 1.15 ) * boost );
				}
				return out;
			}
			var energy = playing.length ? 0.75 : 0.5;
			var t = time / 1000;
			for ( i = 0; i < count; i++ ) {
				var x = i / count;
				var v = Math.sin( x * 9 + t * 2.1 ) * 0.5 + Math.sin( x * 23 - t * 3.3 ) * 0.3 + Math.sin( x * 4 + t * 1.3 ) * 0.2;
				out[ i ] = ( 0.35 + 0.65 * Math.abs( v ) ) * energy * ( playing.length ? 0.6 + 0.4 * Math.abs( Math.sin( t * 4 + i ) ) : 1 );
			}
			return out;
		}

		function gradient( vertical ) {
			var g = vertical ? ctx2d.createLinearGradient( 0, height, 0, 0 ) : ctx2d.createLinearGradient( 0, 0, width, 0 );
			g.addColorStop( 0, colors[ 0 ] );
			g.addColorStop( 1, colors[ 1 ] );
			return g;
		}

		function draw( time ) {
			ctx2d.clearRect( 0, 0, width, height );
			if ( ! width || ! height || ( ! playing.length && ! idle ) ) {
				return;
			}

			if ( style === 'wave' ) {
				drawWave( time );
				return;
			}

			var barWidth = 8;
			var gap = 4;
			var count = Math.max( 8, Math.floor( width / ( barWidth + gap ) ) );
			var values = targets( count, time );
			var offset = ( width - count * ( barWidth + gap ) + gap ) / 2;
			var mirror = style === 'mirror';

			ctx2d.fillStyle = gradient( true );
			for ( var i = 0; i < count; i++ ) {
				// Smooth movement: fast up, slower down.
				var target = values[ i ] || 0;
				var current = levels[ i ] || 0;
				current += ( target - current ) * ( target > current ? 0.55 : 0.12 );
				levels[ i ] = current;

				var h = Math.max( 2, current * ( height - 4 ) );
				var x = offset + i * ( barWidth + gap );
				var y = mirror ? ( height - h ) / 2 : height - h;
				roundRect( x, y, barWidth, h, Math.min( 3, barWidth / 2 ) );
			}
		}

		function drawWave( time ) {
			var points = [];
			var i;
			if ( playing.length && realData() && analyser ) {
				analyser.getByteTimeDomainData( wave );
				var step = Math.max( 1, Math.floor( wave.length / 128 ) );
				for ( i = 0; i < wave.length; i += step ) {
					// Gain, so quieter songs still give a visible wave.
					points.push( Math.max( -1, Math.min( 1, ( ( wave[ i ] - 128 ) / 128 ) * 2.5 ) ) );
				}
			} else {
				var amp = playing.length ? 0.55 : 0.4;
				var t = time / 1000;
				for ( i = 0; i < 128; i++ ) {
					var x = i / 128;
					points.push( ( Math.sin( x * 12 + t * 3 ) * 0.6 + Math.sin( x * 31 - t * 5 ) * 0.4 ) * amp * Math.sin( x * Math.PI ) );
				}
			}
			ctx2d.lineWidth = 3;
			ctx2d.lineJoin = 'round';
			ctx2d.strokeStyle = gradient( false );
			ctx2d.shadowColor = colors[ 1 ];
			ctx2d.shadowBlur = 12;
			ctx2d.beginPath();
			for ( i = 0; i < points.length; i++ ) {
				var px = ( i / ( points.length - 1 ) ) * width;
				var py = height / 2 + points[ i ] * ( height / 2 - 6 );
				if ( i === 0 ) {
					ctx2d.moveTo( px, py );
				} else {
					ctx2d.lineTo( px, py );
				}
			}
			ctx2d.stroke();
			ctx2d.shadowBlur = 0;
		}

		function roundRect( x, y, w, h, r ) {
			ctx2d.beginPath();
			ctx2d.moveTo( x + r, y );
			ctx2d.lineTo( x + w - r, y );
			ctx2d.quadraticCurveTo( x + w, y, x + w, y + r );
			ctx2d.lineTo( x + w, y + h );
			ctx2d.lineTo( x, y + h );
			ctx2d.lineTo( x, y + r );
			ctx2d.quadraticCurveTo( x, y, x + r, y );
			ctx2d.fill();
		}

		function frame( time ) {
			if ( document.hidden || ( ! playing.length && ! idle ) ) {
				running = false;
				draw( time );
				return;
			}
			draw( time );
			window.requestAnimationFrame( frame );
		}

		function start() {
			if ( reduceMotion ) {
				draw( 0 );
				return;
			}
			if ( ! running ) {
				running = true;
				window.requestAnimationFrame( frame );
			}
		}

		readColors();
		resize();
		window.addEventListener( 'resize', resize );
		document.addEventListener( 'visibilitychange', function () {
			if ( ! document.hidden ) {
				start();
			}
		} );
		if ( idle ) {
			start();
		}
	}() );
}() );
