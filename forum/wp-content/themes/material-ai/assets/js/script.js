document.querySelectorAll('.progress').forEach(progress => {
  const value = parseInt(
    progress.querySelector('p').textContent
    );

  progress.style.setProperty('--progress', `${value * 3.6}deg`);
});

// blog
( function ( $ ) {
  function maiInitBlogCarousel() {
    var $list = $( '.mai-blog .mai-blog__list' );

    if ( ! $list.length || typeof $list.owlCarousel !== 'function' ) {
      return;
    }

    $list.owlCarousel( {
      loop: true,
      margin: 20,
      nav: true,
      dots: true,
      autoplay: true,
      autoplayTimeout: 4500,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 1
        },
        900: {
          items: 2
        }
      }
    } );
  }

  $( document ).ready( maiInitBlogCarousel );
} )( jQuery );
jQuery(window).on('load', function () {
  setTimeout(function () {
    jQuery('.Preloader').fadeOut(200);
  }, 600);
});

(function () {
  'use strict';

  function initBackToTop() {

    const buttons = document.querySelectorAll(
      '.materialai-back-to-top__button'
      );

    if (!buttons.length) {
      return;
    }
    buttons.forEach(function (button) {

      function toggleButton() {

        if (window.scrollY > 250) {
          button.style.display = 'flex';
        } else {
          button.style.display = 'none';
        }
      }

      button.addEventListener(
        'click',
        function (event) {

          event.preventDefault();

          window.scrollTo({
            top: 0,
            behavior: 'smooth'
          });
        }
        );

      toggleButton();
    });


    window.addEventListener(
      'scroll',
      function () {

        buttons.forEach(function (button) {

          if (window.scrollY > 250) {
            button.style.display = 'flex';
          } else {
            button.style.display = 'none';
          }

        });

      },
      {
        passive: true
      }
      );
  }
  if (
    document.readyState === 'loading'
    ) {

    document.addEventListener(
      'DOMContentLoaded',
      initBackToTop
      );

} else {

  initBackToTop();

}

})();
jQuery(document).ready(function ($) {
  var header = $('.materialai-nav-wrap');
  $(window).on('scroll', function () {
    if ($(this).scrollTop() > 100) {
      header.addClass('sticky');
    } else {
      header.removeClass('sticky');
    }
  });
});
document.addEventListener("DOMContentLoaded", function () {
  const buttons = document.querySelectorAll(".wp-block-navigation-submenu__toggle");

  buttons.forEach(function (button) {
    const submenu = button.parentElement;

    button.addEventListener("click", function () {
      submenu.classList.toggle("show");
    });
  });
});
/* Initialize WOW scroll animations when the library is available. */
if ( typeof WOW === 'function' ) {
  new WOW( { live: false } ).init();
}

/* WooCommerce mini-cart: open the drawer after add-to-cart and bump the badge. */
(function () {
	var openDrawer = function () {
		var btn = document.querySelector('.wc-block-mini-cart__button');
		if (btn) {
			btn.click();
		}
	};
	var bumpBadge = function () {
		var badge = document.querySelector('.wc-block-mini-cart__badge');
		if (badge) {
			badge.classList.remove('is-bumping');
			void badge.offsetWidth;
			badge.classList.add('is-bumping');
		}
	};
	var onAdded = function () {
		bumpBadge();
		openDrawer();
	};
	if (window.jQuery) {
		window.jQuery(document.body).on('added_to_cart', onAdded);
	}
	document.body.addEventListener('wc-blocks_added_to_cart', onAdded);
})();

/* Mini-cart graceful fallback: if WooCommerce's script has not hydrated the
   button shortly after load, enable it as a plain link to the cart page. */
setTimeout(function () {
	var wrap = document.querySelector('.materialai-header-minicart');
	if (!wrap) {
		return;
	}
	wrap.style.visibility = 'visible';
	wrap.removeAttribute('aria-hidden');
	var btn = wrap.querySelector('.wc-block-mini-cart__button');
	if (btn && btn.disabled) {
		btn.disabled = false;
		btn.addEventListener('click', function () {
			if (window.materialaiWoo && window.materialaiWoo.cartUrl) {
				window.location.href = window.materialaiWoo.cartUrl;
			}
		});
	}
}, 900);

/* Clear Cart button (cart template): set nonce URL and show only while the cart has items. */
(function () {
	var wrap = document.querySelector('.materialai-woo-clear-cart');
	if (!wrap) {
		return;
	}
	var link = wrap.querySelector('.materialai-woo-clear-cart-btn');
	if (link && window.materialaiWoo && window.materialaiWoo.clearCartUrl) {
		link.href = window.materialaiWoo.clearCartUrl;
	}
	var page = document.querySelector('.materialai-woo-cart') || document.body;
	var sync = function () {
		var hasItems = !!page.querySelector('.wc-block-cart-items .wc-block-cart-items__row, .wc-block-cart-items tbody tr');
		wrap.hidden = !hasItems || !(window.materialaiWoo && window.materialaiWoo.clearCartUrl);
	};
	sync();
	if (window.MutationObserver) {
		new MutationObserver(sync).observe(page, { childList: true, subtree: true });
	}
})();
