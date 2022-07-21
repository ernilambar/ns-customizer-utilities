( function( $, api ) {
	api.sectionConstructor[ 'nifty-cs-header' ] = api.Section.extend( {

		// No events for this type of section.
		attachEvents() {},

		// Always make the section active.
		isContextuallyActive() {
			return true;
		},
	} );

	api.controlConstructor[ 'nifty-cs-toggle' ] = api.Control.extend( {

		ready() {
			const control = this;

			if ( 'off' === control.params.value ) {
				this.container.find( 'input:checkbox' ).prop( 'checked', false );
			}

			this.container.on( 'change', 'input:checkbox', function() {
				const value = this.checked ? 'on' : '';
				control.setting.set( value );
			} );
		},
	} );

	api.controlConstructor[ 'nifty-cs-date-time' ] = api.Control.extend( {

		ready() {
			this.container.find( '.nifty-cs-date-time-input' ).flatpickr( {
				dateFormat: 'Y-m-d H:i',
				enableTime: true,
				time_24hr: true,
			} );
		},
	} );

	api.controlConstructor[ 'nifty-cs-range' ] = api.Control.extend( {

		ready() {
			const control = this;

			control.container.on( 'input change', 'input.range-input', function() {
				control.container.find( '.range-number' ).val( $( this ).val() );
			} );
			control.container.on( 'input change', 'input.range-number', function() {
				control.setting.set( $( this ).val() );
			} );
		},
	} );

	api.controlConstructor[ 'nifty-cs-dimension' ] = api.Control.extend( {

		ready() {
			const control = this;

			control.container.on( 'input change', 'input.dimension-slider', function() {
				const currentValue = control.container.find( '.dimension-slider' ).val() + control.container.find( '.dimension-unit option' ).filter( ':selected' ).val();
				control.container.find( '.dimension-number' ).val( control.container.find( '.dimension-slider' ).val() );
				control.setting.set( currentValue );
			} );
			control.container.on( 'input change', 'input.dimension-number', function() {
				const currentValue = $( this ).val() + control.container.find( '.dimension-unit option' ).filter( ':selected' ).val();
				control.container.find( '.dimension-slider' ).val( $( this ).val() );
				control.setting.set( currentValue );
			} );
			control.container.on( 'change', 'select.dimension-unit', function() {
				const currentValue = control.container.find( '.dimension-slider' ).val() + control.container.find( '.dimension-unit option' ).filter( ':selected' ).val();
				control.setting.set( currentValue );
			} );
		},
	} );

	api.controlConstructor[ 'nifty-cs-radio-image' ] = api.Control.extend( {
		ready() {
			const control = this;

			$( 'input:radio', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		},
	} );

	api.controlConstructor[ 'nifty-cs-sortable' ] = api.Control.extend( {

		ready() {
			'use strict';

			const control = this;

			// Set the sortable container.
			control.sortableContainer = control.container.find( 'ul.sortable' ).first();

			// Init sortable.
			control.sortableContainer.sortable( {

				// Update value when we stop sorting.
				stop() {
					control.updateValue();
				},
			} ).disableSelection().find( 'li' ).each( function() {
				jQuery( this ).find( 'i.visibility' ).click( function() {
					jQuery( this ).toggleClass( 'dashicons-visibility-faint' ).parents( 'li:eq(0)' ).toggleClass( 'invisible' );
				} );
			} ).click( function() {
				// Update value on click.
				control.updateValue();
			} );
		},

		// Updates the sorting list.
		updateValue() {
			'use strict';

			const control = this,
				newValue = [];

			this.sortableContainer.find( 'li' ).each( function() {
				if ( ! jQuery( this ).is( '.invisible' ) ) {
					newValue.push( jQuery( this ).data( 'value' ) );
				}
			} );

			control.setting.set( newValue );
		},
	} );
}( jQuery, wp.customize ) );
