/**
 * Scanbox Admin Panel JavaScript
 * Sidebar toggle, AJAX forms, upload, drag-drop, sortable, auto-slug, flash messages
 */

(function () {
    'use strict';

    // ========== SIDEBAR TOGGLE ==========
    const sidebar = document.getElementById('adminSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });

        // Inchide sidebar la click in afara (mobile)
        document.addEventListener('click', function (e) {
            if (
                sidebar.classList.contains('open') &&
                !sidebar.contains(e.target) &&
                !sidebarToggle.contains(e.target)
            ) {
                sidebar.classList.remove('open');
            }
        });
    }

    // ========== FLASH MESSAGES AUTO-DISMISS ==========
    document.querySelectorAll('.flash').forEach(function (flash) {
        setTimeout(function () {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            flash.style.transition = 'all 0.3s ease';
            setTimeout(function () {
                flash.remove();
            }, 300);
        }, 5000);
    });

    // ========== AUTO-SLUG GENERATION ==========
    var slugSource = document.querySelector('[data-slug-source]');
    var slugTarget = document.querySelector('[data-slug-target]');

    if (slugSource && slugTarget) {
        var manualSlug = slugTarget.value.trim() !== '';

        slugTarget.addEventListener('input', function () {
            manualSlug = true;
        });

        slugSource.addEventListener('input', function () {
            if (!manualSlug) {
                slugTarget.value = generateSlug(this.value);
            }
        });
    }

    function generateSlug(text) {
        var charMap = {
            'ă': 'a', 'â': 'a', 'î': 'i', 'ș': 's', 'ş': 's',
            'ț': 't', 'ţ': 't', 'Ă': 'a', 'Â': 'a', 'Î': 'i',
            'Ș': 's', 'Ş': 's', 'Ț': 't', 'Ţ': 't'
        };

        return text
            .toLowerCase()
            .split('')
            .map(function (ch) { return charMap[ch] || ch; })
            .join('')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .replace(/^-|-$/g, '');
    }

    // ========== GALLERY SLUG FROM NAME ==========
    var galleryName = document.getElementById('gallery_name');
    var gallerySlug = document.getElementById('gallery_slug');

    if (galleryName && gallerySlug) {
        galleryName.addEventListener('input', function () {
            if (!gallerySlug.value.trim()) {
                gallerySlug.value = generateSlug(this.value);
            }
        });
    }

    // ========== CHARACTER COUNTER ==========
    document.querySelectorAll('.char-count').forEach(function (counter) {
        var targetId = counter.getAttribute('data-for');
        var target = document.getElementById(targetId);
        if (target) {
            var maxLen = parseInt(target.getAttribute('maxlength') || '0');

            function updateCount() {
                var current = target.value.length;
                counter.textContent = current + '/' + maxLen;
                if (maxLen > 0 && current > maxLen * 0.9) {
                    counter.style.color = '#EAB308';
                } else {
                    counter.style.color = '#64748B';
                }
            }

            target.addEventListener('input', updateCount);
            updateCount();
        }
    });

    // ========== DRAG-DROP UPLOAD ZONE ==========
    document.querySelectorAll('.upload-zone').forEach(function (zone) {
        var fileInput = zone.querySelector('.upload-input');

        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            zone.classList.add('drag-over');
        });

        zone.addEventListener('dragleave', function (e) {
            e.preventDefault();
            zone.classList.remove('drag-over');
        });

        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            zone.classList.remove('drag-over');

            if (e.dataTransfer.files.length > 0 && fileInput) {
                fileInput.files = e.dataTransfer.files;
                fileInput.dispatchEvent(new Event('change'));
            }
        });
    });

    // ========== FILE UPLOAD PREVIEW ==========
    var galleryFileInput = document.getElementById('galleryFileInput');
    var uploadPreview = document.getElementById('uploadPreview');
    var uploadBtn = document.getElementById('uploadBtn');

    if (galleryFileInput) {
        galleryFileInput.addEventListener('change', function () {
            if (uploadPreview) {
                uploadPreview.innerHTML = '';
            }

            if (this.files.length > 0) {
                if (uploadBtn) uploadBtn.disabled = false;

                if (uploadPreview) {
                    uploadPreview.style.display = 'grid';

                    Array.from(this.files).forEach(function (file) {
                        if (file.type.startsWith('image/')) {
                            var reader = new FileReader();
                            reader.onload = function (e) {
                                var img = document.createElement('img');
                                img.src = e.target.result;
                                img.className = 'upload-preview-item';
                                img.alt = file.name;
                                uploadPreview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                }
            } else {
                if (uploadBtn) uploadBtn.disabled = true;
                if (uploadPreview) uploadPreview.style.display = 'none';
            }
        });
    }

    // General upload input previews (featured image, thumbnail, logo)
    document.querySelectorAll('.upload-zone .upload-input').forEach(function (input) {
        if (input.id === 'galleryFileInput') return;

        input.addEventListener('change', function () {
            var zone = this.closest('.upload-zone');
            var previewContainer = zone.parentElement.querySelector('.preview-image');

            if (this.files.length > 0 && this.files[0].type.startsWith('image/')) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    if (!previewContainer) {
                        previewContainer = document.createElement('div');
                        previewContainer.className = 'preview-image';
                        previewContainer.style.marginTop = '12px';
                        zone.parentElement.appendChild(previewContainer);
                    }
                    previewContainer.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width:100%;border-radius:8px">';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // ========== AJAX UPLOAD ==========
    function uploadFileAjax(file, options) {
        var defaults = {
            url: '/api/upload',
            type: 'gallery',
            galleryId: null,
            title: '',
            altText: '',
            csrfToken: '',
            onProgress: function () {},
            onSuccess: function () {},
            onError: function () {}
        };

        var config = Object.assign({}, defaults, options);

        var formData = new FormData();
        formData.append('file', file);
        formData.append('type', config.type);
        if (config.galleryId) formData.append('gallery_id', config.galleryId);
        if (config.title) formData.append('title', config.title);
        if (config.altText) formData.append('alt_text', config.altText);
        if (config.csrfToken) formData.append('csrf_token', config.csrfToken);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', config.url, true);

        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable) {
                var percent = Math.round((e.loaded / e.total) * 100);
                config.onProgress(percent);
            }
        });

        xhr.addEventListener('load', function () {
            try {
                var response = JSON.parse(xhr.responseText);
                if (xhr.status === 200 && response.success) {
                    config.onSuccess(response.data);
                } else {
                    config.onError(response.message || 'Eroare la upload');
                }
            } catch (e) {
                config.onError('Eroare la procesarea răspunsului');
            }
        });

        xhr.addEventListener('error', function () {
            config.onError('Eroare de conexiune');
        });

        xhr.send(formData);
    }

    // ========== SORTABLE ITEMS ==========
    document.querySelectorAll('.sortable-container').forEach(function (container) {
        var draggedItem = null;
        var placeholder = null;

        function getDraggableItems() {
            return container.querySelectorAll('[data-id]');
        }

        container.addEventListener('dragstart', function (e) {
            var item = e.target.closest('[data-id]');
            if (!item || !e.target.closest('.drag-handle')) return;

            draggedItem = item;
            item.classList.add('dragging');

            placeholder = document.createElement('div');
            placeholder.className = 'drag-placeholder';
            placeholder.style.height = item.offsetHeight + 'px';

            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', item.dataset.id);
        });

        container.addEventListener('dragover', function (e) {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';

            var afterElement = getDragAfterElement(container, e.clientY);

            if (placeholder) {
                if (afterElement) {
                    container.insertBefore(placeholder, afterElement);
                } else {
                    container.appendChild(placeholder);
                }
            }
        });

        container.addEventListener('dragend', function () {
            if (draggedItem) {
                draggedItem.classList.remove('dragging');
            }
            if (placeholder && placeholder.parentNode) {
                if (draggedItem) {
                    container.insertBefore(draggedItem, placeholder);
                }
                placeholder.remove();
            }
            placeholder = null;

            // Salvare ordine noua
            saveNewOrder(container);
            draggedItem = null;
        });

        function getDragAfterElement(container, y) {
            var elements = Array.from(getDraggableItems()).filter(function (el) {
                return el !== draggedItem;
            });

            var result = null;
            var closestOffset = Number.NEGATIVE_INFINITY;

            elements.forEach(function (el) {
                var box = el.getBoundingClientRect();
                var offset = y - box.top - box.height / 2;
                if (offset < 0 && offset > closestOffset) {
                    closestOffset = offset;
                    result = el;
                }
            });

            return result;
        }
    });

    function saveNewOrder(container) {
        var type = container.dataset.type;
        if (!type) return;

        var items = [];
        container.querySelectorAll('[data-id]').forEach(function (el, index) {
            items.push({
                id: parseInt(el.dataset.id),
                order: index + 1
            });
        });

        if (items.length === 0) return;

        var csrfMeta = document.querySelector('input[name="csrf_token"]');
        var csrfToken = csrfMeta ? csrfMeta.value : '';

        fetch('/api/reorder', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                type: type,
                items: items,
                csrf_token: csrfToken
            })
        })
        .then(function (res) { return res.json(); })
        .then(function (data) {
            if (data.success) {
                showFlash('Ordinea a fost actualizată', 'success');
            }
        })
        .catch(function () {
            showFlash('Eroare la salvarea ordinii', 'error');
        });
    }

    // ========== MODAL CONFIRMATIONS ==========
    window.showModal = function (title, message, onConfirm) {
        var overlay = document.createElement('div');
        overlay.className = 'modal-overlay active';

        overlay.innerHTML =
            '<div class="modal">' +
                '<h3>' + escapeHtml(title) + '</h3>' +
                '<p>' + escapeHtml(message) + '</p>' +
                '<div class="modal-actions">' +
                    '<button class="btn btn-secondary modal-cancel">Anulează</button>' +
                    '<button class="btn btn-danger modal-confirm">Confirmă</button>' +
                '</div>' +
            '</div>';

        document.body.appendChild(overlay);

        overlay.querySelector('.modal-cancel').addEventListener('click', function () {
            overlay.remove();
        });

        overlay.querySelector('.modal-confirm').addEventListener('click', function () {
            overlay.remove();
            if (typeof onConfirm === 'function') {
                onConfirm();
            }
        });

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) {
                overlay.remove();
            }
        });

        document.addEventListener('keydown', function handler(e) {
            if (e.key === 'Escape') {
                overlay.remove();
                document.removeEventListener('keydown', handler);
            }
        });
    };

    // ========== FLASH MESSAGES ==========
    function showFlash(message, type) {
        type = type || 'success';

        var existing = document.querySelectorAll('.flash');
        existing.forEach(function (el) { el.remove(); });

        var flash = document.createElement('div');
        flash.className = 'flash flash-' + type;
        flash.textContent = message;

        var main = document.querySelector('.main');
        if (main) {
            main.insertBefore(flash, main.firstChild);
        }

        setTimeout(function () {
            flash.style.opacity = '0';
            flash.style.transform = 'translateY(-10px)';
            flash.style.transition = 'all 0.3s ease';
            setTimeout(function () {
                flash.remove();
            }, 300);
        }, 4000);
    }

    window.showFlash = showFlash;

    // ========== AJAX FORM SUBMISSIONS ==========
    document.querySelectorAll('form[data-ajax]').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            var submitBtn = form.querySelector('[type="submit"]');
            var originalText = submitBtn ? submitBtn.textContent : '';
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Se procesează...';
            }

            var formData = new FormData(form);
            var action = form.getAttribute('action') || window.location.href;
            var method = form.getAttribute('method') || 'POST';

            fetch(action, {
                method: method.toUpperCase(),
                body: formData
            })
            .then(function (res) { return res.json(); })
            .then(function (data) {
                if (data.success) {
                    showFlash(data.message || 'Salvat cu succes!', 'success');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    showFlash(data.message || 'A apărut o eroare.', 'error');
                }
            })
            .catch(function () {
                showFlash('Eroare de conexiune.', 'error');
            })
            .finally(function () {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
            });
        });
    });

    // ========== SELECT ALL CHECKBOX ==========
    var selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function () {
            var checked = this.checked;
            document.querySelectorAll('.row-select').forEach(function (cb) {
                cb.checked = checked;
            });
        });
    }

    // ========== ESCAPE HTML UTILITY ==========
    function escapeHtml(text) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

    // ========== KEYBOARD SHORTCUTS ==========
    document.addEventListener('keydown', function (e) {
        // Ctrl/Cmd + S => Submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            var activeForm = document.querySelector('form:not([data-no-shortcut])');
            if (activeForm) {
                e.preventDefault();
                var submitBtn = activeForm.querySelector('[type="submit"]');
                if (submitBtn) {
                    submitBtn.click();
                }
            }
        }
    });

    // ========== IMAGE URL PREVIEW ==========
    var featuredImageInput = document.getElementById('featured_image');
    if (featuredImageInput) {
        featuredImageInput.addEventListener('change', function () {
            var url = this.value.trim();
            var previewContainer = this.closest('.card').querySelector('.preview-image');

            if (url && (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('/'))) {
                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.className = 'preview-image';
                    previewContainer.style.marginTop = '12px';
                    this.closest('.form-group').after(previewContainer);
                }
                previewContainer.innerHTML = '<img src="' + escapeHtml(url) + '" alt="Preview" style="max-width:100%;border-radius:8px" onerror="this.parentElement.remove()">';
            } else if (previewContainer) {
                previewContainer.remove();
            }
        });
    }

    // ========== TABLE ROW CLICK ==========
    document.querySelectorAll('tr[data-href]').forEach(function (row) {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function (e) {
            if (e.target.closest('a, button, input, .action-buttons')) return;
            window.location.href = this.dataset.href;
        });
    });

})();
