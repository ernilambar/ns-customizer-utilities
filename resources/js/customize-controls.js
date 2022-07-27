( function( $, api ) {

		api.controlConstructor[ 'nscu-editor' ] = api.Control.extend( {
		ready() {
			const control = this;

			const element = control.container.find( 'textarea' );
			const id      = 'nscu-editor-' + control.id.replace( '[', '' ).replace( ']', '' );

			let defaultParams = {
	      tinymce: {
	        wpautop: true
	      },
	      quicktags: true,
	      mediaButtons: true
	    };

	    // Overwrite the default paramaters if choices is defined.
	    if ( wp.editor && wp.editor.initialize ) {
	      wp.editor.initialize( id, jQuery.extend( {}, defaultParams, control.params.choices ) );
	    }

	    const editor = tinyMCE.get( id );

	    if ( editor ) {
	      editor.onChange.add( function( ed ) {
	        var content;

	        ed.save();
	        content = editor.getContent();
	        element.val( content ).trigger( 'change' );
	        wp.customize.instance( control.id ).set( content );
	      } );
	    }
		},
	} );

	api.controlConstructor[ 'nscu-buttonset' ] = api.Control.extend( {
		ready() {
			const control = this;

			$( 'input:radio', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		},
	} );

	api.controlConstructor[ 'nscu-date-time' ] = api.Control.extend( {

		ready() {
			this.container.find( '.nscu-date-time-input' ).flatpickr( {
				dateFormat: 'Y-m-d H:i',
				enableTime: true,
				time_24hr: true,
			} );
		},
	} );

	api.controlConstructor[ 'nscu-dimension' ] = api.Control.extend( {

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


	api.controlConstructor[ 'nscu-radio-image' ] = api.Control.extend( {
		ready() {
			const control = this;

			$( 'input:radio', control.container ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		},
	} );

	api.controlConstructor[ 'nscu-range' ] = api.Control.extend( {

		ready() {
			const control = this;

			control.container.on( 'input change', 'input.range-input', function() {
				control.container.find( '.range-number' ).val( $( this ).val() );
			} );
			control.container.on( 'input change', 'input.range-number', function() {
				control.setting.set( $( this ).val() );
			} );
			control.container.on( 'click', '.range-reset', function(e) {
				e.preventDefault();
				const resetValue = $(this).data('default');
				control.container.find( '.range-number' ).val( resetValue );
				control.setting.set( resetValue );
			} );
		},
	} );

	api.controlConstructor[ 'nscu-sortable' ] = api.Control.extend( {

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

	api.controlConstructor[ 'nscu-toggle' ] = api.Control.extend( {

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

	api.sectionConstructor['nscu-button'] = api.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	api.sectionConstructor[ 'nscu-header' ] = api.Section.extend( {

		// No events for this type of section.
		attachEvents() {},

		// Always make the section active.
		isContextuallyActive() {
			return true;
		},
	} );

}( jQuery, wp.customize ) );
