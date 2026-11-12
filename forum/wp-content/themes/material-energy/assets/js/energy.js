/**
 * Material Energy — the behaviour behind the header and banner.
 *
 * Carried over from Material AI Pro so the two themes behave identically,
 * minus the carousel: the banner here is a single static Cover block. jQuery
 * comes from the Material AI parent, which enqueues it on every page, so
 * nothing extra is loaded.
 */
( function () {
	'use strict';

	var $ = window.jQuery;

	if ( ! $ ) {
		return;
	}

	/* --------------------------------------------- mobile menu ---------- */

	/* Core's overlay gives a panel and a close button; the design also wants
	   the site's logo at the head of it, and sub-menus that stay folded until
	   they are tapped. The sub-menu toggle is a real button so it works from
	   the keyboard too. */
	$( function () {
		var header = $( '.materialai-header-02' );

		if ( ! header.length ) {
			return;
		}

		var labels = window.materialEnergyMenu || {};
		var submenuCount = 0;

		function addPanelHead( $dialog ) {
			if ( ! $dialog.length || $dialog.children( '.mai-menu-head' ).length ) {
				return;
			}

			var $head = $( '<div class="mai-menu-head"></div>' );
			var $branding = header.find( '.materialai-branding-02' ).first();

			if ( $branding.length ) {
				var $copy = $branding.clone();

				$copy.removeClass( 'materialai-branding-02' ).addClass( 'mai-menu-logo' );
				$copy.find( '[id]' ).removeAttr( 'id' );
				$head.append( $copy );
			} else {
				$head.append( '<span></span>' );
			}

			$head.append( $dialog.children( '.wp-block-navigation__responsive-container-close' ) );
			$dialog.prepend( $head );
		}

		function addSubmenuToggles( $overlay ) {
			$overlay.find( '.wp-block-navigation-item.has-child' ).each( function () {
				var item = this;
				var submenu = item.querySelector( ':scope > .wp-block-navigation__submenu-container' );
				var content = item.querySelector( ':scope > .wp-block-navigation-item__content' );

				if ( ! submenu || ! content || item.querySelector( ':scope > .mai-submenu-toggle' ) ) {
					return;
				}

				if ( ! submenu.id ) {
					submenuCount += 1;
					submenu.id = 'mai-submenu-' + submenuCount;
				}

				var toggle = document.createElement( 'button' );

				toggle.type = 'button';
				toggle.className = 'mai-submenu-toggle';
				toggle.setAttribute( 'aria-expanded', 'false' );
				toggle.setAttribute( 'aria-controls', submenu.id );
				toggle.setAttribute(
					'aria-label',
					( labels.submenu || 'Show submenu of %s' ).replace( '%s', content.textContent.trim() )
				);

				content.insertAdjacentElement( 'afterend', toggle );
			} );
		}

		function setUpOverlay() {
			var $overlay = header.find( '.wp-block-navigation__responsive-container' );

			if ( ! $overlay.length ) {
				return;
			}

			addPanelHead( $overlay.find( '.wp-block-navigation__responsive-dialog' ).first() );
			addSubmenuToggles( $overlay );
		}

		header.on( 'click', '.wp-block-navigation__responsive-container-open', setUpOverlay );

		header.on( 'click', '.mai-submenu-toggle', function ( event ) {
			event.preventDefault();

			var $toggle = $( this );
			var open = $toggle.attr( 'aria-expanded' ) === 'true';

			$toggle.attr( 'aria-expanded', open ? 'false' : 'true' );
			$toggle.closest( '.wp-block-navigation-item' ).toggleClass( 'mai-open', ! open );
		} );

		/* Fold everything back up when the panel closes, so it opens fresh. */
		header.on( 'click', '.wp-block-navigation__responsive-container-close', function () {
			header.find( '.wp-block-navigation-item.mai-open' ).removeClass( 'mai-open' );
			header.find( '.mai-submenu-toggle' ).attr( 'aria-expanded', 'false' );
		} );

		/* Only build the panel's furniture when the overlay is actually in
		   use. Running this on every load puts the cloned branding inside the
		   container that doubles as the inline navbar on wide screens. */
		if ( header.find( '.wp-block-navigation__responsive-container-open:visible' ).length ) {
			setUpOverlay();
		}
	} );
}() );

/* ------------------------------------------------------ hero tuck
   The hero runs up behind the whole header, top bar included, and the
   header's height changes as the top bar wraps. Its real height goes into
   --mai-header-h for the stylesheet. */
(function () {
    var header = document.querySelector('.materialai-header-spa');

    if (!header || !document.querySelector('.materialai-hero-spa')) {
        return;
    }

    function measure() {
        document.documentElement.style.setProperty(
            '--mai-header-h',
            Math.round(header.getBoundingClientRect().height) + 'px'
        );
    }

    measure();

    if (window.ResizeObserver) {
        new ResizeObserver(measure).observe(header);
    } else {
        window.addEventListener('resize', measure, { passive: true });
    }
})();

/* The cart count reads as two digits ("01"), as in the comp.
   WooCommerce rewrites the badge whenever the cart changes, so it is padded
   again each time; a count that already has two digits is left alone, which
   also stops the observer from answering its own change. */
(function () {
	var header = document.querySelector('.materialai-header-spa');
	if (!header || !window.MutationObserver) {
		return;
	}

	function pad(badge) {
		var count = badge.textContent.trim();
		if (/^[1-9]$/.test(count)) {
			badge.textContent = '0' + count;
		}
	}

	header.querySelectorAll('.wc-block-mini-cart__badge').forEach(function (badge) {
		pad(badge);
		new MutationObserver(function () {
			pad(badge);
		}).observe(badge, { childList: true, characterData: true, subtree: true });
	});
})();

