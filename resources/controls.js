import './sass/controls.scss';

import 'select2';
import 'flatpickr';

import './js/color-alpha';

( function( $, api ) {
	api.nscuBasicControl = api.Control.extend( {
		ready() {
			const control = this;

			api.Control.prototype.ready.call( control );

			control.initBaseControl();
		},

		initBaseControl( control ) {
			control = control || this;

			control.container.on( 'change keyup paste click', 'input', function() {
				control.setting.set( jQuery( this ).val() );
			} );
		},
	} );

	api.nscuSelectControl = api.Control.extend( {
		ready() {
			const control = this;

			api.Control.prototype.ready.call( control );

			control.initSelectControl();
		},

		initSelectControl( control ) {
			control = control || this;

			$( 'select', control.container ).select2( { width: 260, minimumResultsForSearch: 10 } ).change(
				function() {
					control.setting.set( $( this ).val() );
				}
			);
		},
	} );

	api.nscuCheckboxControl = api.Control.extend( {
		ready() {
			const control = this;

			api.Control.prototype.ready.call( control );

			control.initCheckboxControl();
		},

		initCheckboxControl( control ) {
			control = control || this;

			control.container.on( 'change', 'input:checkbox', function() {
				const value = this.checked ? true : false;
				control.setting.set( value );
			} );
		},
	} );

	api.controlConstructor[ 'nscu-accordion' ] = api.Control.extend( {
		ready() {
			const control = this;

			control.container.on( 'click', '.customize-control-title', function() {
				$( this ).toggleClass( 'acc-active' );
				control.container.find( '.customize-control-description' ).fadeToggle();
			} );
		},
	} );

	api.controlConstructor[ 'nscu-buttonset' ] = api.nscuBasicControl.extend( {} );

	api.controlConstructor[ 'nscu-checkbox' ] = api.nscuCheckboxControl.extend( {} );

	api.controlConstructor[ 'nscu-checkbox-multiple' ] = api.Control.extend( {
		ready() {
			const control = this;

			// Save the value
			control.container.on( 'change', 'input', function() {
				const value = [];
				let i = 0;

				jQuery.each( control.params.choices, function( key ) {
					if ( control.container.find( 'input[value="' + key + '"]' ).is( ':checked' ) ) {
						control.container.find( 'input[value="' + key + '"]' ).parent().addClass( 'checked' );
						value[ i ] = key;
						i++;
					} else {
						control.container.find( 'input[value="' + key + '"]' ).parent().removeClass( 'checked' );
					}
				} );

				control.setting.set( value );
			} );
		},
	} );

	api.controlConstructor[ 'nscu-date-time' ] = api.Control.extend( {
		ready() {
			const control = this;

			const $input = control.container.find( '.date-time-input' );

			const disableDate = $input.data( 'disable-date' );
			const disableTime = $input.data( 'disable-time' );

			let dateFormat = 'Y-m-d H:i';
			let enableTime = true;
			const time24hr = true;
			let noCalendar = false;

			if ( true === disableDate ) {
				dateFormat = 'H:i';
				noCalendar = true;
			}

			if ( true === disableTime ) {
				dateFormat = 'Y-m-d';
				enableTime = false;
			}

			const pickerArgs = { dateFormat, enableTime, noCalendar, time_24hr: time24hr };

			this.container.find( '.date-time-input' ).flatpickr( pickerArgs );
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

			control.container.on( 'click', '.dimension-reset', function( e ) {
				e.preventDefault();
				const dimensionNumber = $( this ).data( 'default-dimension-number' );
				const dimensionUnit = $( this ).data( 'default-dimension-unit' );
				control.container.find( '.dimension-slider' ).val( dimensionNumber );
				control.container.find( '.dimension-number' ).val( dimensionNumber );
				control.container.find( '.dimension-unit' ).val( dimensionUnit );
				control.setting.set( dimensionNumber + dimensionUnit );
			} );
		},
	} );

	api.controlConstructor[ 'nscu-dropdown-taxonomies' ] = api.nscuSelectControl.extend( {} );

	api.controlConstructor[ 'nscu-dropdown-posts' ] = api.nscuSelectControl.extend( {} );

	api.controlConstructor[ 'nscu-dropdown-google-fonts' ] = api.nscuSelectControl.extend( {} );

	api.controlConstructor[ 'nscu-editor' ] = api.Control.extend( {
		ready() {
			const control = this;

			const id = 'nscu-editor-' + control.id.replace( '[', '' ).replace( ']', '' );

			const choices = control.params.choices;

			let toolbarButtons = '';

			if ( choices.tabs === 'both' || choices.tabs === 'visual' ) {
				if ( choices.toolbar === 'default' ) {
					toolbarButtons = 'bold italic bullist numlist link';
				} else if ( choices.toolbar === 'minimal' ) {
					toolbarButtons = 'bold italic link';
				} else if ( choices.toolbar === 'advance' ) {
					toolbarButtons = 'formatselect bold italic | bullist numlist | alignleft aligncenter alignright | link';
				}

				if ( choices.toolbar === 'custom' ) {
					toolbarButtons = ( choices.toolbar_buttons !== '' ) ? choices.toolbar_buttons : 'bold italic bullist numlist link';
				}
			}

			let tinymce = {
				wpautop: true,
				browser_spellcheck: true,
				wp_autoresize_on: true,
				toolbar1: toolbarButtons,
				setup( editor ) {
					editor.on( 'change', function() {
						editor.save();
						jQuery( `#${ id }` ).trigger( 'change' );
					} );
				},
			};

			if ( ! ( choices.tabs === 'both' || choices.tabs === 'visual' ) ) {
				tinymce = false;
			}

			wp.editor.initialize( id, {
				tinymce,
				mediaButtons: choices.media_buttons,
				quicktags: ( choices.tabs === 'both' || choices.tabs === 'text' ) ? true : false,
			} );
		},
	} );

	api.controlConstructor[ 'nscu-media' ] = api.Control.extend( {
		ready() {
			const control = this;

			let nscuFileFrame = '';

			const stateId = _.uniqueId( 'nscu-state-' );

			const fieldUpload = control.container.find( '.field-upload' );
			const fieldRemove = control.container.find( '.field-remove' );
			const fieldInput = control.container.find( '.field-input' );
			const fieldPreview = control.container.find( '.field-preview' );
			const previewWrap = control.container.find( '.preview-wrap' );

			const mimeType = fieldUpload.data( 'mime_type' );
			const uploaderTitle = fieldUpload.data( 'uploader_title' );
			const uploaderButtonText = fieldUpload.data( 'uploader_button_text' );

			// Setup modal.
			const nscuMediaState = wp.media.controller.Library.extend( {
				defaults: _.defaults( {
					id: stateId,
					title: uploaderTitle,
					allowLocalEdits: false,
					displaySettings: false,
					displayUserSettings: false,
					multiple: false,
					library: wp.media.query( { type: mimeType } ),
				}, wp.media.controller.Library.prototype.defaults ),
			} );

			// Create the media frame.
			nscuFileFrame = wp.media.frames.nscuFileFrame = wp.media( {
				button: {
					text: uploaderButtonText,
				},
				state: stateId,
				states: [
					new nscuMediaState(),
				],
				multiple: false,
			} );

			nscuFileFrame.on( 'select', () => {
				const selectedAttachment = nscuFileFrame.state( stateId ).get( 'selection' ).first();

				const attachmentUrl = selectedAttachment.toJSON().url;

				fieldInput.val( attachmentUrl ).trigger( 'change' );

				if ( 'image' === mimeType ) {
					fieldPreview.attr( 'src', attachmentUrl );
					previewWrap.addClass( 'preview-on' );
				}
				if ( '' !== attachmentUrl ) {
					fieldRemove.removeClass( 'hide' );
				}
			} );

			fieldUpload.on( 'click', function( e ) {
				e.preventDefault();
				nscuFileFrame.open();
			} );

			fieldRemove.on( 'click', function( e ) {
				e.preventDefault();
				previewWrap.removeClass( 'preview-on' );
				fieldInput.val( '' ).trigger( 'change' );
				fieldRemove.addClass( 'hide' );
			} );

			fieldInput.on( 'change keyup paste click', function() {
				const value = jQuery( this ).val();
				control.setting.set( value );

				if ( '' !== value ) {
					fieldPreview.attr( 'src', value );
					previewWrap.addClass( 'preview-on' );
				} else {
					previewWrap.removeClass( 'preview-on' );
				}
			} );
		},
	} );

	api.controlConstructor[ 'nscu-radio' ] = api.nscuBasicControl.extend( {} );

	api.controlConstructor[ 'nscu-radio-image' ] = api.nscuBasicControl.extend( {} );

	api.controlConstructor[ 'nscu-range' ] = api.Control.extend( {
		ready() {
			const control = this;

			control.container.on( 'input change', 'input.range-input', function() {
				control.container.find( '.range-number' ).val( $( this ).val() );
			} );
			control.container.on( 'input change', 'input.range-number', function() {
				control.setting.set( $( this ).val() );
			} );
			control.container.on( 'click', '.range-reset', function( e ) {
				e.preventDefault();
				const resetValue = $( this ).data( 'default' );
				control.container.find( '.range-number' ).val( resetValue );
				control.setting.set( resetValue );
			} );
		},
	} );

	api.controlConstructor[ 'nscu-select' ] = api.nscuSelectControl.extend( {} );

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

	api.controlConstructor[ 'nscu-switcher' ] = api.nscuCheckboxControl.extend( {} );

	api.controlConstructor[ 'nscu-textarea' ] = api.nscuBasicControl.extend( {} );

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

	api.nscuDummySection = api.Section.extend( {
		attachEvents() {},

		isContextuallyActive() {
			return true;
		},
	} );

	api.sectionConstructor[ 'nscu-button' ] = api.nscuDummySection.extend( {} );
	api.sectionConstructor[ 'nscu-header' ] = api.nscuDummySection.extend( {} );
	api.sectionConstructor[ 'nscu-upsell' ] = api.nscuDummySection.extend( {} );
}( jQuery, wp.customize ) );
