/**
 * Product Gallery
 *
 * Handles thumbnail click to swap main image.
 * Prepares data attributes for lightbox integration.
 *
 * @since 1.0.0
 */
( function () {
	'use strict';

	const gallery = {
		mainImage: null,
		thumbnails: null,

		init() {
			this.mainImage = document.getElementById( 'product-main-image' );
			this.thumbnails = document.querySelectorAll(
				'.product-gallery__thumbnail'
			);

			if ( ! this.mainImage || ! this.thumbnails.length ) {
				return;
			}

			this.bindThumbnails();
		},

		bindThumbnails() {
			this.thumbnails.forEach( ( thumb ) => {
				thumb.addEventListener( 'click', ( e ) => {
					e.preventDefault();
					this.swapImage( thumb );
				} );
			} );
		},

		swapImage( thumb ) {
			const largeSrc = thumb.dataset.largeSrc;
			const fullSrc = thumb.dataset.fullSrc;

			if ( ! largeSrc ) {
				return;
			}

			this.mainImage.src = largeSrc;
			this.mainImage.dataset.fullSrc = fullSrc || largeSrc;

			this.thumbnails.forEach( ( t ) => t.classList.remove( 'active' ) );
			thumb.classList.add( 'active' );
		},
	};

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', () => gallery.init() );
	} else {
		gallery.init();
	}
} )();
