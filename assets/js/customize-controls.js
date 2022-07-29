"use strict";

(function ($, api) {
  api.controlConstructor['nscu-buttonset'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      $('input:radio', control.container).change(function () {
        control.setting.set($(this).val());
      });
    }
  });
  api.controlConstructor['nscu-date-time'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      var $input = control.container.find('.nscu-date-time-input');
      var disableDate = $input.data('disable-date');
      var disableTime = $input.data('disable-time');
      var dateFormat = 'Y-m-d H:i';
      var enableTime = true;
      var time_24hr = true;
      var noCalendar = false;

      if (true == disableDate) {
        dateFormat = 'H:i';
        noCalendar = true;
      }

      if (true == disableTime) {
        dateFormat = 'Y-m-d';
        enableTime = false;
      }

      var pickerArgs = {
        dateFormat: dateFormat,
        enableTime: enableTime,
        noCalendar: noCalendar,
        time_24hr: time_24hr
      };
      this.container.find('.nscu-date-time-input').flatpickr(pickerArgs);
    }
  });
  api.controlConstructor['nscu-dimension'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      control.container.on('input change', 'input.dimension-slider', function () {
        var currentValue = control.container.find('.dimension-slider').val() + control.container.find('.dimension-unit option').filter(':selected').val();
        control.container.find('.dimension-number').val(control.container.find('.dimension-slider').val());
        control.setting.set(currentValue);
      });
      control.container.on('input change', 'input.dimension-number', function () {
        var currentValue = $(this).val() + control.container.find('.dimension-unit option').filter(':selected').val();
        control.container.find('.dimension-slider').val($(this).val());
        control.setting.set(currentValue);
      });
      control.container.on('change', 'select.dimension-unit', function () {
        var currentValue = control.container.find('.dimension-slider').val() + control.container.find('.dimension-unit option').filter(':selected').val();
        control.setting.set(currentValue);
      });
      control.container.on('click', '.dimension-reset', function (e) {
        e.preventDefault();
        var dimensionNumber = $(this).data('default-dimension-number');
        var dimensionUnit = $(this).data('default-dimension-unit');
        control.container.find('.dimension-slider').val(dimensionNumber);
        control.container.find('.dimension-number').val(dimensionNumber);
        control.container.find('.dimension-unit').val(dimensionUnit);
        control.setting.set(dimensionNumber + dimensionUnit);
      });
    }
  });
  api.controlConstructor['nscu-dropdown-taxonomies'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      $('select', control.container).change(function () {
        control.setting.set($(this).val());
      });
    }
  });
  api.controlConstructor['nscu-dropdown-google-fonts'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      $('select', control.container).change(function () {
        control.setting.set($(this).val());
      });
    }
  });
  api.controlConstructor['nscu-editor'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      var element = control.container.find('textarea');
      var id = 'nscu-editor-' + control.id.replace('[', '').replace(']', '');
      var choices = control.params.choices;
      var editorParams = {
        quicktags: choices.tabs == 'both' || choices.tabs == 'text' ? true : false,
        mediaButtons: choices.media_buttons
      };

      if (choices.tabs == 'both' || choices.tabs == 'visual') {
        var toolbarButtons = '';

        if (choices.toolbar == 'default') {
          toolbarButtons = 'bold italic bullist numlist link';
        } else if (choices.toolbar == 'minimal') {
          toolbarButtons = 'bold italic link';
        } else if (choices.toolbar == 'advance') {
          toolbarButtons = 'formatselect bold italic | bullist numlist | alignleft aligncenter alignright | link';
        }

        if (choices.toolbar == 'custom') {
          toolbarButtons = choices.toolbar_buttons != '' ? choices.toolbar_buttons : 'bold italic bullist numlist link';
        }

        editorParams.tinymce = {
          wpautop: true,
          toolbar1: toolbarButtons
        };
      } else {
        editorParams.tinymce = false;
      } // Initialize editor.


      if (wp.editor && wp.editor.initialize) {
        wp.editor.initialize(id, editorParams);
      }

      var editor = tinyMCE.get(id);

      if (editor) {
        editor.onChange.add(function (ed) {
          var content;
          ed.save();
          content = editor.getContent();
          element.val(content).trigger('change');
          wp.customize.instance(control.id).set(content);
        });
      }
    }
  });
  api.controlConstructor['nscu-radio-image'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      $('input:radio', control.container).change(function () {
        control.setting.set($(this).val());
      });
    }
  });
  api.controlConstructor['nscu-range'] = api.Control.extend({
    ready: function ready() {
      var control = this;
      control.container.on('input change', 'input.range-input', function () {
        control.container.find('.range-number').val($(this).val());
      });
      control.container.on('input change', 'input.range-number', function () {
        control.setting.set($(this).val());
      });
      control.container.on('click', '.range-reset', function (e) {
        e.preventDefault();
        var resetValue = $(this).data('default');
        control.container.find('.range-number').val(resetValue);
        control.setting.set(resetValue);
      });
    }
  });
  api.controlConstructor['nscu-sortable'] = api.Control.extend({
    ready: function ready() {
      'use strict';

      var control = this; // Set the sortable container.

      control.sortableContainer = control.container.find('ul.sortable').first(); // Init sortable.

      control.sortableContainer.sortable({
        // Update value when we stop sorting.
        stop: function stop() {
          control.updateValue();
        }
      }).disableSelection().find('li').each(function () {
        jQuery(this).find('i.visibility').click(function () {
          jQuery(this).toggleClass('dashicons-visibility-faint').parents('li:eq(0)').toggleClass('invisible');
        });
      }).click(function () {
        // Update value on click.
        control.updateValue();
      });
    },
    // Updates the sorting list.
    updateValue: function updateValue() {
      'use strict';

      var control = this,
          newValue = [];
      this.sortableContainer.find('li').each(function () {
        if (!jQuery(this).is('.invisible')) {
          newValue.push(jQuery(this).data('value'));
        }
      });
      control.setting.set(newValue);
    }
  });
  api.controlConstructor['nscu-toggle'] = api.Control.extend({
    ready: function ready() {
      var control = this;

      if ('off' === control.params.value) {
        this.container.find('input:checkbox').prop('checked', false);
      }

      this.container.on('change', 'input:checkbox', function () {
        var value = this.checked ? 'on' : '';
        control.setting.set(value);
      });
    }
  });
  api.sectionConstructor['nscu-button'] = api.Section.extend({
    attachEvents: function attachEvents() {},
    isContextuallyActive: function isContextuallyActive() {
      return true;
    }
  });
  api.sectionConstructor['nscu-header'] = api.Section.extend({
    attachEvents: function attachEvents() {},
    isContextuallyActive: function isContextuallyActive() {
      return true;
    }
  });
  api.sectionConstructor['nscu-upsell'] = api.Section.extend({
    attachEvents: function attachEvents() {},
    isContextuallyActive: function isContextuallyActive() {
      return true;
    }
  });
})(jQuery, wp.customize);