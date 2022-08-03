import './sass/controls.scss';

import 'select2';
import 'flatpickr';

( function( $, api ) {

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
			const control = this;

			const $input= control.container.find('.nscu-date-time-input');

			const disableDate = $input.data('disable-date');
			const disableTime = $input.data('disable-time');

			let dateFormat = 'Y-m-d H:i';
			let enableTime = true;
			let time_24hr = true;
			let noCalendar = false;

			if ( true == disableDate ) {
				dateFormat = 'H:i';
				noCalendar = true;
			}

			if ( true == disableTime ) {
				dateFormat = 'Y-m-d';
				enableTime = false;
			}

			const pickerArgs = { dateFormat, enableTime, noCalendar, time_24hr };

			this.container.find( '.nscu-date-time-input' ).flatpickr( pickerArgs );
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

			control.container.on( 'click', '.dimension-reset', function(e) {
				e.preventDefault();
				const dimensionNumber = $(this).data('default-dimension-number');
				const dimensionUnit = $(this).data('default-dimension-unit');
				control.container.find( '.dimension-slider' ).val( dimensionNumber );
				control.container.find( '.dimension-number' ).val( dimensionNumber );
				control.container.find( '.dimension-unit' ).val( dimensionUnit );
				control.setting.set( dimensionNumber + dimensionUnit );
			} );
		},
	} );

	api.controlConstructor['nscu-dropdown-taxonomies'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'select', control.container ).select2({width: 260, minimumResultsForSearch: 10}).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );

	api.controlConstructor['nscu-dropdown-google-fonts'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'select', control.container ).select2({width: 260, minimumResultsForSearch: 10}).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
	} );

	api.controlConstructor[ 'nscu-editor' ] = api.Control.extend( {
		ready() {
			const control = this;

			const element = control.container.find( 'textarea' );
			const id      = 'nscu-editor-' + control.id.replace( '[', '' ).replace( ']', '' );

			const choices = control.params.choices;

			let editorParams = {
	      quicktags: ( choices.tabs == 'both' || choices.tabs == 'text' ) ? true : false,
	      mediaButtons: choices.media_buttons
	    };

	    if ( choices.tabs == 'both' || choices.tabs == 'visual' ) {
	    	let toolbarButtons = '';

	    	if ( choices.toolbar == 'default' ) {
	    		toolbarButtons = 'bold italic bullist numlist link';
	    	} else if ( choices.toolbar == 'minimal' ) {
	    		toolbarButtons = 'bold italic link';
	    	} else if ( choices.toolbar == 'advance' ) {
	    		toolbarButtons = 'formatselect bold italic | bullist numlist | alignleft aligncenter alignright | link';
	    	}

	    	if ( choices.toolbar == 'custom' ) {
	    		toolbarButtons = ( choices.toolbar_buttons != '' ) ? choices.toolbar_buttons : 'bold italic bullist numlist link';
	    	}

	    	editorParams.tinymce = {
	    		wpautop: true,
	    		toolbar1: toolbarButtons
	    	}
	    } else {
	    	editorParams.tinymce = false;
	    }

	    // Initialize editor.
	    if ( wp.editor && wp.editor.initialize ) {
	      wp.editor.initialize( id, editorParams );
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

	api.controlConstructor['nscu-select'] = api.Control.extend( {
		ready: function() {
			var control = this;

			$( 'select', control.container ).select2({width: 260, minimumResultsForSearch: 10}).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		}
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

	api.controlConstructor[ 'nscu-switcher' ] = api.Control.extend( {

		ready() {
			const control = this;

			this.container.on( 'change', 'input:checkbox', function() {
				const value = this.checked ? true : false;
				control.setting.set( value );
			} );
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
		attachEvents: function () {},

		isContextuallyActive: function () {
			return true;
		}
	} );

	api.sectionConstructor[ 'nscu-header' ] = api.Section.extend( {
		attachEvents() {},

		isContextuallyActive() {
			return true;
		},
	} );

	api.sectionConstructor['nscu-upsell'] = api.Section.extend( {
		attachEvents: function () {},

		isContextuallyActive: function () {
			return true;
		}
	} );

}( jQuery, wp.customize ) );

