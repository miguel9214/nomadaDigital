/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

( function( $ ) {

	var $body, masthead, menuToggle, siteNavigation, siteHeaderMenu, mobileNavigation;

	function initMainNavigation( container ) {

		// Add dropdown toggle that display child menu items.
		container.find( '.menu-item-has-children > a' ).after( '<button class="dropdown-toggle" aria-expanded="false">' + screenReaderText.expand + '</button>' );

		// Toggle buttons and submenu items with active children menu items.
		container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
		container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

		// Add menu items with submenus to aria-haspopup="true".
		container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

		container.find( '.dropdown-toggle' ).click(
			function( e ) {
				var _this = $( this );
				e.preventDefault();
				_this.toggleClass( 'toggled-on' );
				_this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

				// jscs:disable
				_this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
				// jscs:enable
				_this.html( _this.html() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
			}
		);
	}

	mobileNavigation = $( '.mobile-navigation' );

	initMainNavigation( mobileNavigation );

	masthead       = $( '#masthead' );
	menuToggle     = $( '#menu-toggle' );
	siteNavigation = $( '.main-navigation' );
	siteHeaderMenu = $( '.site-header-menu' );

	// Enable menuToggle.
	( function() {

		// Return early if menuToggle is missing.
		if ( ! menuToggle ) {
			return;
		}

		// Add an initial values for the attribute.
		menuToggle.add( siteNavigation ).attr( 'aria-expanded', 'false' );

		var defaultButtonclass = 'genericon-menu';

		menuToggle.on(
			'click',
			function() {

				$( this ).add( mobileNavigation ).toggleClass( 'toggled-on' );
				$( this ).add( mobileNavigation ).attr( 'aria-expanded', $( this ).add( mobileNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );

				if ( $( this ).find( 'span.genericon' ).hasClass( 'genericon-close' ) ) {
					$( this ).find( 'span.genericon' ).removeClass( 'genericon-close' ).addClass( defaultButtonclass );
				} else {
					$( this ).find( 'span.genericon' ).removeClass( defaultButtonclass ).addClass( 'genericon-close' );
				}

			}
		);
	} )();

	// Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
	( function() {
		if ( ! siteNavigation || ! siteNavigation.children().length ) {
			return;
		}

		if ( 'ontouchstart' in window ) {
			siteNavigation.find( '.menu-item-has-children > a' ).on(
				'touchstart',
				function( e ) {
					var el = $( this ).parent( 'li' );

					if ( ! el.hasClass( 'focus' ) ) {
						e.preventDefault();
						el.toggleClass( 'focus' );
						el.siblings( '.focus' ).removeClass( 'focus' );
					}
				}
			);
		}

		siteNavigation.find( 'a' ).on(
			'focus blur',
			function() {
				$( this ).parents( '.menu-item' ).toggleClass( 'focus' );
			}
		);
	} )();

	// Add the default ARIA attributes for the menu toggle and the navigations.
	function onResizeARIA() {
		if ( 910 > window.innerWidth ) {
			if ( menuToggle.hasClass( 'toggled-on' ) ) {
				menuToggle.attr( 'aria-expanded', 'true' );
			} else {
				menuToggle.attr( 'aria-expanded', 'false' );
			}

			if ( siteHeaderMenu.hasClass( 'toggled-on' ) ) {
				siteNavigation.attr( 'aria-expanded', 'true' );
			} else {
				siteNavigation.attr( 'aria-expanded', 'false' );
			}

			menuToggle.attr( 'aria-controls', 'site-navigation' );
		} else {
			menuToggle.removeAttr( 'aria-expanded' );
			siteNavigation.removeAttr( 'aria-expanded' );
			menuToggle.removeAttr( 'aria-controls' );
		}
	}

	$( document ).ready(
		function() {
			$body = $( document.body );

			$( window )
			.on( 'load', onResizeARIA )
			.on(
				'resize',
				function() {
					onResizeARIA();
				}
			);
		}
	);
} )( jQuery );
