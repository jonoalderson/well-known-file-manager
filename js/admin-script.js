(function(window, document) {
    var well_known_manager = {
        init: function() {
            this.toggle_file_visibility();
            this.initialize_textarea_visibility();
            this.add_initialized_class();
        },

        toggle_file_visibility: function() {
            document.querySelectorAll('.toggle-file').forEach(function(toggle) {
                toggle.addEventListener('change', well_known_manager.handle_toggle_change);
            });
        },

        handle_toggle_change: function() {
            var well_known_file = this.closest('.well-known-file');
            var textarea = well_known_file.querySelector('textarea');
            
            if (this.checked) {
                well_known_manager.show_textarea(well_known_file, textarea);
            } else {
                well_known_manager.hide_textarea(well_known_file, textarea, this);
            }
        },

        show_textarea: function(well_known_file, textarea) {
            well_known_file.classList.remove('disabled');
            textarea.disabled = false;
            textarea.style.display = 'block';
            setTimeout(function() {
                textarea.style.maxHeight = '1000px';
                textarea.style.opacity = '1';
            }, 10);
        },

        hide_textarea: function(well_known_file, textarea, toggle) {
            well_known_file.classList.add('disabled');
            textarea.disabled = true;
            textarea.style.maxHeight = '0';
            textarea.style.opacity = '0';
            textarea.addEventListener('transitionend', function handler() {
                if (!toggle.checked) {
                    textarea.style.display = 'none';
                }
                textarea.removeEventListener('transitionend', handler);
            });
        },

        initialize_textarea_visibility: function() {
            document.querySelectorAll('.toggle-file').forEach(function(toggle) {
                var well_known_file = toggle.closest('.well-known-file');
                var textarea = well_known_file.querySelector('textarea');
                
                if (toggle.checked) {
                    well_known_manager.show_textarea(well_known_file, textarea);
                } else {
                    well_known_manager.hide_textarea(well_known_file, textarea, toggle);
                }
            });
        },

        add_initialized_class: function() {
            document.body.classList.add('well-known-manager-initialized');
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        well_known_manager.init();
    });
})(window, document);