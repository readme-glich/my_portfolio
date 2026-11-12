/* Material AI - theme info page tabs. */
( function () {
	'use strict';

	function init() {
		var tabs = document.querySelectorAll( '.materialai-info-tabs [data-materialai-tab]' );

		if ( ! tabs.length ) {
			return;
		}

		function activate( name ) {
			tabs.forEach( function ( tab ) {
				tab.classList.toggle( 'nav-tab-active', tab.getAttribute( 'data-materialai-tab' ) === name );
			} );

			document.querySelectorAll( '.materialai-info-tab' ).forEach( function ( panel ) {
				panel.classList.toggle( 'is-active', panel.id === 'materialai-tab-' + name );
			} );
		}

		tabs.forEach( function ( tab ) {
			tab.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				activate( tab.getAttribute( 'data-materialai-tab' ) );
				if ( window.history && window.history.replaceState ) {
					window.history.replaceState( null, '', tab.getAttribute( 'href' ) );
				}
			} );
		} );

		if ( window.location.hash ) {
			var name = window.location.hash.replace( '#', '' );
			if ( document.getElementById( 'materialai-tab-' + name ) ) {
				activate( name );
			}
		}
	}

	if ( 'loading' === document.readyState ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();

/* Directory filtering and accessible pagination. */
( function () {
	'use strict';
	function initDirectory() {
		var grid = document.getElementById( 'materialai-child-grid' );
		if ( ! grid ) { return; }
		var search = document.getElementById( 'materialai-child-search' );
		var filter = document.getElementById( 'materialai-child-filter' );
		var pager = document.getElementById( 'materialai-child-pager' );
		var empty = document.getElementById( 'materialai-child-no-results' );
		var cards = Array.prototype.slice.call( grid.querySelectorAll( '.materialai-child-card' ) );
		var page = 1;
		var perPage = 9;
		function render() {
			var query = search.value.toLocaleLowerCase().trim();
			var status = filter.value;
			var matches = cards.filter( function ( card ) {
				return card.dataset.name.indexOf( query ) !== -1 && ( status === 'all' || card.dataset.installed === status );
			} );
			var pages = Math.max( 1, Math.ceil( matches.length / perPage ) );
			page = Math.min( page, pages );
			cards.forEach( function ( card ) { card.hidden = true; } );
			matches.slice( ( page - 1 ) * perPage, page * perPage ).forEach( function ( card ) { card.hidden = false; } );
			empty.hidden = matches.length !== 0;
			pager.replaceChildren();
			if ( pages <= 1 ) { return; }
			function button( label, next, disabled, active ) {
				var el = document.createElement( 'button' );
				el.type = 'button'; el.textContent = label; el.disabled = disabled;
				if ( active ) { el.setAttribute( 'aria-current', 'page' ); }
				el.addEventListener( 'click', function () { page = next; render(); grid.scrollIntoView( { behavior: 'smooth', block: 'start' } ); } );
				pager.appendChild( el );
			}
			button( '‹', page - 1, page === 1, false );
			for ( var i = Math.max( 1, page - 2 ); i <= Math.min( pages, page + 2 ); i++ ) {
				button( String( i ), i, false, page === i );
			}
			button( '›', page + 1, page === pages, false );
		}
		search.addEventListener( 'input', function () { page = 1; render(); } );
		filter.addEventListener( 'change', function () { page = 1; render(); } );
		render();
	}
	if ( document.readyState === 'loading' ) { document.addEventListener( 'DOMContentLoaded', initDirectory ); }
	else { initDirectory(); }
} )();
