/**
 * Well Known Manager Admin JavaScript
 */
(function($) {
    'use strict';

    const WellKnownManager = {
        nonce: '',

        constructor() {
            this.nonce = wellKnownManager.nonce;
            this.bindEvents();
        },

        bindEvents() {
            $('.well-known-file-toggle').on('change', this.handleToggle.bind(this));
            $('.save-file-content').on('click', this.handleSave.bind(this));
            $('.restore-default-content').on('click', this.handleRestore.bind(this));
            $('.well-known-file-content textarea').on('input', this.handleContentChange.bind(this));
        },

        handleContentChange(e) {
            const $textarea = $(e.target);
            const $card = $textarea.closest('.well-known-file-card');
        },

        showSaveNotice($card, message) {
            // Remove any existing save notices
            $card.find('.card-notice.save').remove();
            
            // Create new notice
            const $notice = $('<div>', {
                class: 'card-notice success save',
                text: message
            });
            
            // Add to card
            $card.append($notice);
            
            // Remove after 3 seconds
            setTimeout(() => {
                $notice.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        },

        handleSave(e) {
            const $button = $(e.target).closest('.save-file-content');
            const $card = $button.closest('.well-known-file-card');
            const $content = $card.find('.well-known-file-content textarea');
            const $toggle = $card.find('.well-known-file-toggle');
            const $responseCode = $card.find('.well-known-file-response-code-input');
            const fileId = $card.data('file-id');
            
            // Prevent multiple clicks while processing
            if ($card.hasClass('saving')) {
                return;
            }
            
            // Add saving state
            $card.addClass('saving');
            $button.prop('disabled', true);
            
            // Get the current content
            const currentContent = $content.val();
            
            // Save the content
            this.saveFileContent(fileId, currentContent, $toggle.is(':checked'), $responseCode.val())
                .then(() => {
                    // Remove saving state on success
                    $card.removeClass('saving');
                    $button.prop('disabled', false);
                })
                .catch(() => {
                    // Remove saving state on error
                    $card.removeClass('saving');
                    $button.prop('disabled', false);
                });
        },

        handleToggle(e) {
            const $toggle = $(e.target);
            const $card = $toggle.closest('.well-known-file-card');
            const $content = $card.find('.well-known-file-content textarea');
            const $responseCode = $card.find('.well-known-file-response-code-input');
            const fileId = $card.data('file-id');
            
            // Prevent multiple clicks while processing
            if ($card.hasClass('saving')) {
                return;
            }
            
            // Add saving state
            $card.addClass('saving');
            $toggle.prop('disabled', true);
            
            // Get the current content before any state changes
            const currentContent = $content.val();
                            
            if ($toggle.is(':checked')) {
                $content.prop('disabled', false);
            } else {
                // Disable the textarea
                $content.prop('disabled', true);
            }

            // Save the current content
            this.saveFileContent(fileId, currentContent, $toggle.is(':checked'), $responseCode.val())
                .then(() => {
                    // Remove saving state on success
                    $card.removeClass('saving');
                    $toggle.prop('disabled', false);
                })
                .catch(() => {
                    // Remove saving state on error
                    $card.removeClass('saving');
                    $toggle.prop('disabled', false);
                });
        },

        handleRestore(e) {
            const $button = $(e.target).closest('.restore-default-content');
            const $card = $button.closest('.well-known-file-card');
            const $content = $card.find('.well-known-file-content textarea');
            const fileId = $card.data('file-id');
            
            // Prevent multiple clicks while processing
            if ($card.hasClass('saving')) {
                return;
            }
            
            // Add saving state
            $card.addClass('saving');
            $button.prop('disabled', true);
            
            // Get the default content
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'well_known_get_default_content',
                    file_id: fileId,
                    nonce: this.nonce
                },
                success: (response) => {
                    if (response.success) {
                        // Update the content
                        $content.val(response.data.content);
                            
                        // Save the restored content
                        this.saveFileContent(fileId, response.data.content, true, response.data.response_code)
                            .then(() => {
                                this.showNotice($card, 'success', 'Default content restored and saved.');
                            })
                            .catch(() => {
                                this.showNotice($card, 'error', 'Failed to save restored content.');
                            });
                    } else {
                        this.showNotice($card, 'error', 'Failed to restore default content.');
                    }
                },
                error: () => {
                    this.showNotice($card, 'error', 'Failed to restore default content.');
                },
                complete: () => {
                    // Remove saving state
                    $card.removeClass('saving');
                    $button.prop('disabled', false);
                }
            });
        },

        saveFileContent(fileId, content, enabled, responseCode) {
            return $.ajax({
                url: wellKnownManager.ajaxurl,
                type: 'POST',
                data: {
                    action: 'well_known_manager_save_file',
                    nonce: this.nonce,
                    file: fileId,
                    content: content,
                    status: enabled,
                    response_code: responseCode
                }
            }).then((response) => {
                if (response.success) {
                    const $card = $(`.well-known-file-card[data-file-id="${fileId}"]`);
                    const $content = $card.find('.well-known-file-content textarea');
                    const $toggle = $card.find('.well-known-file-toggle');
                    const $buttons = $card.find('.button');
                    
                    // Update the card's disabled state
                    if (enabled) {
                        $card.removeClass('disabled');
                        $content.prop('disabled', false);
                        $buttons.prop('disabled', false);
                    } else {
                        $card.addClass('disabled');
                        $content.prop('disabled', true);
                        $buttons.prop('disabled', true);
                    }
                    
                    this.showSaveNotice($card, response.data.message);
                } else {
                    throw new Error(response.data.message);
                }
            });
        },

        showCardNotice($card, type, message) {
            // Remove any existing notices
            $card.find('.card-notice').remove();
            
            // Create the notice element
            const $notice = $('<div>', {
                class: `card-notice ${type}`,
                text: message
            });
            
            // Add the notice to the card
            $card.append($notice);
            
            // Remove the notice after 3 seconds
            setTimeout(() => {
                $notice.fadeOut(300, function() {
                    $(this).remove();
                });
            }, 3000);
        },

        showNotice(message, type = 'success') {
            const notice = document.createElement('div');
            notice.className = `notice notice-${type} is-dismissible`;
            notice.innerHTML = `<p>${message}</p>`;
            
            const container = document.querySelector('.wrap');
            container.insertBefore(notice, container.firstChild);
            
            // Auto-dismiss after 5 seconds.
            setTimeout(() => {
                notice.remove();
            }, 5000);
        }
    };

    function init() {
        WellKnownManager.constructor();
    }

    $(document).ready(init);

})(jQuery); 