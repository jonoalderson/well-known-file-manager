/**
 * Well Known Manager Admin JavaScript
 */
(function($) {
    'use strict';

    window.WellKnownFileManager = window.WellKnownFileManager || {};

    $.extend(window.WellKnownFileManager, {
        constructor() {
            this.nonce = window.WellKnownFileManager.nonce;
            this.bindEvents();
        },

        bindEvents() {
            $('.well-known-file-mode').on('change', this.handleModeChange.bind(this));
            $('.save-file-content').on('click', this.handleSave.bind(this));
            $('.restore-default-content').on('click', this.handleRestore.bind(this));
            $('.well-known-file-content textarea').on('input', this.handleContentChange.bind(this));
            $('.redirect-url-input').on('input', this.handleRedirectUrlChange.bind(this));
            $('.well-known-file-link').on('mouseover focus', this.handleFileLinkClick.bind(this));
            $('.well-known-file-link').on('mouseout blur', this.handleFileLinkMouseOut.bind(this));
        },

        handleContentChange(e) {
            const $textarea = $(e.target);
            const $card = $textarea.closest('.well-known-file-card');
        },

        handleRedirectUrlChange(e) {
            const $input = $(e.target);
            const $card = $input.closest('.well-known-file-card');
        },

        handleFileLinkClick(e) {
            // Add timestamp to preview links to prevent caching.
            const $link = $(e.target);
            const originalHref = $link.data('original-href') || $link.attr('href');
            
            // Store original href if not already stored.
            if (!$link.data('original-href')) {
                $link.data('original-href', originalHref);
            }
            
            // Add timestamp to prevent caching.
            const timestampedUrl = originalHref + (originalHref.includes('?') ? '&' : '?') + '_t=' + Date.now();
            $link.attr('href', timestampedUrl);
        },

        handleFileLinkMouseOut(e) {
            // Remove timestamp and restore original href.
            const $link = $(e.target);
            const originalHref = $link.data('original-href');
            
            if (originalHref) {
                $link.attr('href', originalHref);
            }
        },

        showSaveNotice($card, message) {
            // Remove any existing save notices
            $card.find('.card-notice.save').remove();
            
            // Create new notice
            const $notice = $('<div>', {
                class: 'card-notice success save'
            });
            
            // Add message text
            $notice.append($('<span>', { text: message }));
            
            // Add dismiss button
            const $dismissBtn = $('<button>', {
                class: 'card-notice-dismiss',
                type: 'button',
                'aria-label': 'Dismiss notice'
            });
            
            $notice.append($dismissBtn);
            
            // Add to card
            $card.append($notice);
            
            // Handle dismiss click
            $dismissBtn.on('click', function() {
                $notice.fadeOut(300, function() {
                    $(this).remove();
                });
            });
            
            // Remove after 3 seconds
            setTimeout(() => {
                if ($notice.parent().length) {
                    $notice.fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            }, 3000);
        },

        isModeEnabled(mode) {
            return mode === 'enabled';
        },

        applyCardModeUi($card, mode) {
            const enabled = this.isModeEnabled(mode);
            const $content = $card.find('.well-known-file-content textarea');
            const $redirectInput = $card.find('.redirect-url-input');
            const $buttons = $card.find('.button');

            $card.toggleClass('disabled', !enabled);
            $card.toggleClass('masked', mode === 'masked');

            $content.prop('disabled', !enabled);
            $redirectInput.prop('disabled', !enabled);
            $buttons.prop('disabled', !enabled);
        },

        getCardMode($card) {
            return $card.find('.well-known-file-mode').val() || 'disabled';
        },

        handleSave(e) {
            const $button = $(e.target).closest('.save-file-content');
            const $card = $button.closest('.well-known-file-card');
            const mode = this.getCardMode($card);
            const $responseCode = $card.find('.well-known-file-response-code-input');
            const fileId = $card.data('file-id');
            
            // Prevent multiple clicks while processing
            if ($card.hasClass('saving')) {
                return;
            }
            
            // Add saving state
            $card.addClass('saving');
            $button.prop('disabled', true);
            
            // Check if this is a redirect file
            const $redirectInput = $card.find('.redirect-url-input');
            if ($redirectInput.length > 0) {
                // This is a redirect file
                const redirectUrl = $redirectInput.val();
                this.saveRedirectFile(fileId, redirectUrl, mode)
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
            } else {
                // This is a content file
                const $content = $card.find('.well-known-file-content textarea');
                const currentContent = $content.val();
                
                // Save the content
                this.saveFileContent(fileId, currentContent, mode, $responseCode.val())
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
            }
        },

        handleModeChange(e) {
            const $select = $(e.target);
            const $card = $select.closest('.well-known-file-card');
            const mode = $select.val();
            const $responseCode = $card.find('.well-known-file-response-code-input');
            const fileId = $card.data('file-id');

            if ($card.hasClass('saving')) {
                return;
            }

            $card.addClass('saving');
            $select.prop('disabled', true);
            this.applyCardModeUi($card, mode);

            const $redirectInput = $card.find('.redirect-url-input');
            const onComplete = () => {
                $card.removeClass('saving');
                $select.prop('disabled', false);
            };

            if ($redirectInput.length > 0) {
                this.saveRedirectFile(fileId, $redirectInput.val(), mode)
                    .then(onComplete)
                    .catch(onComplete);
            } else {
                const $content = $card.find('.well-known-file-content textarea');
                this.saveFileContent(fileId, $content.val(), mode, $responseCode.val())
                    .then(onComplete)
                    .catch(onComplete);
            }
        },

        handleRestore(e) {
            const $button = $(e.target).closest('.restore-default-content');
            const $card = $button.closest('.well-known-file-card');
            const fileId = $card.data('file-id');
            
            // Prevent multiple clicks while processing
            if ($card.hasClass('saving')) {
                return;
            }
            
            // Add saving state
            $card.addClass('saving');
            $button.prop('disabled', true);
            
            // Check if this is a redirect file
            const $redirectInput = $card.find('.redirect-url-input');
            if ($redirectInput.length > 0) {
                // This is a redirect file - restore default URL
                const defaultUrl = WellKnownFileManager.lostPasswordUrl || '/wp-login.php?action=lostpassword';
                $redirectInput.val(defaultUrl);
                
                // Save the restored redirect URL
                console.log('Restoring redirect file:', fileId, 'with URL:', defaultUrl);
                this.saveRedirectFile(fileId, defaultUrl, 'enabled')
                    .then((response) => {
                        console.log('Redirect file restore success:', response);
                        this.showSaveNotice($card, 'Default redirect URL restored and saved.');
                        // Remove saving state on success
                        $card.removeClass('saving');
                        $button.prop('disabled', false);
                    })
                    .catch((error) => {
                        console.error('Redirect file restore error:', error);
                        this.showCardNotice($card, 'error', 'Failed to save restored redirect URL.');
                        // Remove saving state on error
                        $card.removeClass('saving');
                        $button.prop('disabled', false);
                    });
            } else {
                // This is a content file
                const $content = $card.find('.well-known-file-content textarea');
                
                // Get the default content
                $.ajax({
                    url: WellKnownFileManager.ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'wkfm_get_default_content',
                        file_id: fileId,
                        nonce: WellKnownFileManager.nonce
                    },
                    success: (response) => {
                        if (response.success) {
                            // Update the content
                            $content.val(response.data.content);
                                
                            // Save the restored content
                            this.saveFileContent(fileId, response.data.content, 'enabled', response.data.response_code)
                                .then(() => {
                                    this.showSaveNotice($card, 'Default content restored and saved.');
                                })
                                .catch(() => {
                                    this.showCardNotice($card, 'error', 'Failed to save restored content.');
                                });
                        } else {
                            this.showCardNotice($card, 'error', 'Failed to restore default content.');
                        }
                    },
                    error: () => {
                        this.showCardNotice($card, 'error', 'Failed to restore default content.');
                    },
                    complete: () => {
                        // Remove saving state
                        $card.removeClass('saving');
                        $button.prop('disabled', false);
                    }
                });
            }
        },

        saveRedirectFile(fileId, redirectUrl, mode) {
            return $.ajax({
                url: WellKnownFileManager.ajaxurl,
                type: 'POST',
                data: {
                    action: 'wkfm_save_redirect_file',
                    nonce: WellKnownFileManager.nonce,
                    file: fileId,
                    redirect_url: redirectUrl,
                    status: mode
                }
            }).then((response) => {
                if (response.success) {
                    const $card = $(`.well-known-file-card[data-file-id="${fileId}"]`);
                    const savedMode = response.data.mode || mode;
                    $card.find('.well-known-file-mode').val(savedMode);
                    this.applyCardModeUi($card, savedMode);
                    this.showSaveNotice($card, response.data.message);
                    return response;
                }
                throw new Error(response.data.message);
            });
        },

        saveFileContent(fileId, content, mode, responseCode) {
            return $.ajax({
                url: WellKnownFileManager.ajaxurl,
                type: 'POST',
                data: {
                    action: 'wkfm_save_file',
                    nonce: WellKnownFileManager.nonce,
                    file: fileId,
                    content: content,
                    status: mode,
                    response_code: responseCode
                }
            }).then((response) => {
                if (response.success) {
                    const $card = $(`.well-known-file-card[data-file-id="${fileId}"]`);
                    const savedMode = response.data.mode || mode;
                    $card.find('.well-known-file-mode').val(savedMode);
                    this.applyCardModeUi($card, savedMode);
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
                class: `card-notice ${type}`
            });
            
            // Add message text
            $notice.append($('<span>', { text: message }));
            
            // Add dismiss button
            const $dismissBtn = $('<button>', {
                class: 'card-notice-dismiss',
                type: 'button',
                'aria-label': 'Dismiss notice'
            });
            
            $notice.append($dismissBtn);
            
            // Add the notice to the card
            $card.append($notice);
            
            // Handle dismiss click
            $dismissBtn.on('click', function() {
                $notice.fadeOut(300, function() {
                    $(this).remove();
                });
            });
            
            // Remove the notice after 3 seconds
            setTimeout(() => {
                if ($notice.parent().length) {
                    $notice.fadeOut(300, function() {
                        $(this).remove();
                    });
                }
            }, 3000);
        },

        showNotice(type, message) {
            const noticeDiv = document.createElement('div');
            noticeDiv.className = `notice notice-${type} is-dismissible`;
            noticeDiv.innerHTML = `<p>${message}</p>`;
            
            const adminPage = document.querySelector('.well-known-file-manager-admin');
            if (adminPage) {
                adminPage.insertBefore(noticeDiv, adminPage.firstChild);
                
                // Auto-dismiss after 5 seconds
                setTimeout(() => {
                    if (noticeDiv.parentNode) {
                        noticeDiv.remove();
                    }
                }, 5000);
            }
        }
    });

    function init() {
        window.WellKnownFileManager.constructor();
    }

    $(document).ready(init);

})(jQuery); 