@extends('admin.partials.master')

@section('content')
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h3>Edit Page</h3>
                        </div>
                    </div>
                </div>
            </div>

            <form class="forms-sample" action="{{ url('admin/pages/update') }}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                <input type="hidden" value="{{ $page->id }}" name="id">
                <!-- <input type="hidden" value="{{ $page->slug }}" name="slug"> -->
                @php
                    $builderRows = json_decode($page->builder_rows ?? '[]', true);
                    $builderRows = is_array($builderRows) ? $builderRows : [];
                @endphp

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <a target="_blank" href="javascript:void(0)"
                                    onclick="previewDraft('{{ URL('admin/pages/preview/' . $page->id) }}')">Click here to
                                    preview page</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.content-en-form')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.content-ar-form')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @if ($page->id == 16)
                                    <input type="hidden" name="page_id" value="15">
                                @elseif($page->id == 17)
                                    <input type="hidden" name="page_id" value="15">
                                @else
                                    @include('admin.partials.pages.parent-page-form')
                                @endif
                                @include('admin.partials.pages.status')
                                @include('admin.partials.pages.template-page-form')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.featured-images-list')
                                @include('admin.partials.pages.featured-image-form')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.additional-content-form')
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                @include('admin.partials.pages.additional-content-ar-form')
                            </div>
                        </div>
                    </div>
                </div>

                @if ($page->slug == 'venues-and-times')
                    {{-- <h2>//////Start venues</h2> --}}

                    @include('admin.partials.pages.additional2_content')

                    {{-- <h2>//////End venues</h2> --}}
                @endif
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Publish date</label>
                                    <?php
                                    $date = \Carbon\Carbon::now()->format('m/d/y');
                                    
                                    if (isset($page)) {
                                        if ($page->created_at) {
                                            $date = $page->created_at->format('m/d/y');
                                        }
                                    }
                                    ?>
                                    <input type="text" class="form-control datetimepicker" readonly placeholder=""
                                        name="created_at" value="{{ $date }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div
                                    style="display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
                                    <h4 class="card-title" style="margin:0;">Page Rows Builder</h4>
                                    <button type="button" class="btn btn-outline-primary" data-toggle="collapse"
                                        data-target="#pageRowsBuilderCollapse" aria-expanded="false"
                                        aria-controls="pageRowsBuilderCollapse">
                                        Toggle Builder
                                    </button>
                                </div>

                                <div id="pageRowsBuilderCollapse" class="collapse" style="margin-top: 10px;">
                                    <p style="margin-bottom: 10px;">Add rows and choose row type. Available now:
                                        <strong>boxes</strong>.
                                    </p>
                                    <div id="builder-rows"></div>
                                    <script type="application/json" id="builder-rows-initial">@json($builderRows)</script>
                                    <div class="mt-2" style="margin-top: 10px;">
                                        <button type="button" id="add-builder-row" class="btn btn-primary">Add New
                                            Row</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <button type="submit" class="btn btn-success mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('public/admin/js/file-upload.js') }}"></script>
    <script>
        (function() {
            var container = document.getElementById('builder-rows');
            var addRowButton = document.getElementById('add-builder-row');
            var initialElement = document.getElementById('builder-rows-initial');

            if (!container || !addRowButton) {
                return;
            }

            var initialRows = [];

            try {
                initialRows = JSON.parse(initialElement ? initialElement.textContent : '[]');
                if (!Array.isArray(initialRows)) {
                    initialRows = [];
                }
            } catch (e) {
                initialRows = [];
            }

            function escapeHtml(value) {
                return String(value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function rowTemplate(row) {
                var type = (row && row.type) ? row.type : 'boxes';
                var collapseId = 'collapse-items-' + Math.random().toString(36).substr(2, 9);

                return '<div class="card builder-row shadow-sm" style="margin-bottom: 25px; border: 1px solid #ced4da; border-radius: 8px; overflow: hidden;">' +
                    '<div class="card-header" style="background-color: #f8f9fa; color: #333; border-bottom: 1px solid #ced4da; display:flex; justify-content:space-between; align-items:center; padding: 12px 20px;">' +
                    '<h4 style="margin:0; font-weight: bold; font-size: 16px;">Row Configuration</h4>' +
                    '<button type="button" class="btn btn-sm btn-danger remove-row" style="border-radius: 4px; padding: 5px 10px;">&times; Remove Row</button>' +
                    '</div>' +
                    '<div class="card-body bg-light" style="padding: 25px;">' +
                    '<div class="row">' +
                    '<div class="col-md-4"><div class="form-group"><label style="font-weight: 600;">Row Layout Type</label>' +
                    '<select class="form-control row-type form-control-lg" data-field="type" style="border-radius: 6px; border: 1px solid #ccc;">' +
                    '<option value="boxes"' + (type === 'boxes' ? ' selected' : '') + '>Boxes Grid</option>' +
                    '</select></div></div>' +
                    '<div class="col-md-4"><div class="form-group"><label style="font-weight: 600;" class="text-primary">Main Title (AR)</label><input type="text" class="form-control" data-field="title_ar" placeholder="عنوان القسم" value="' +
                    escapeHtml(row && row.title_ar) + '"></div></div>' +
                    '<div class="col-md-4"><div class="form-group"><label style="font-weight: 600;" class="text-primary">Main Title (EN)</label><input type="text" class="form-control" data-field="title_en" placeholder="Section Title" value="' +
                    escapeHtml(row && row.title_en) + '"></div></div>' +
                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Sub Title (AR)</label><input type="text" class="form-control" data-field="subtitle_ar" placeholder="العنوان الفرعي" value="' +
                    escapeHtml(row && row.subtitle_ar) + '"></div></div>' +
                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Sub Title (EN)</label><input type="text" class="form-control" data-field="subtitle_en" placeholder="Sub Title" value="' +
                    escapeHtml(row && row.subtitle_en) + '"></div></div>' +
                    '</div>' +
                    '<hr style="border-top: 2px dashed #d1d5db; margin: 30px 0;">' +
                    '<div style="display:flex;justify-content:space-between;align-items:center; margin-bottom: 20px;">' +
                    '<button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold" data-toggle="collapse" data-target="#' +
                    collapseId + '" style="border-radius: 4px;">&#x25BC; Toggle Row Items (Boxes)</button>' +
                    '<button type="button" class="btn btn-success btn-sm add-item" style="border-radius: 4px; padding: 6px 15px;">+ Add New Item</button>' +
                    '</div>' +
                    '<div class="collapse" id="' + collapseId + '">' +
                    '<div class="row-items"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
            }

            function itemTemplate(item) {
                var imagePath = escapeHtml(item && item.image);
                var dateEn = escapeHtml((item && (item.date_en || item.date)) || '');
                var dateAr = escapeHtml((item && (item.date_ar || item.date)) || '');
                var previewStyle = imagePath ? '' : 'display:none;';

                return '<div class="card row-item shadow-sm" draggable="true" style="margin-bottom:20px; border: 1px solid #ced4da; border-radius: 8px; cursor: move;">' +
                    '<div class="card-body" style="padding: 20px;">' +
                    '<div style="display:flex;justify-content:space-between;align-items:center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f3f4f6;">' +
                    '<h5 style="margin:0; font-weight: bold; color: #374151; font-size: 15px;">Item Entry (Drag to Reorder)</h5>' +
                    '<button type="button" class="btn btn-outline-danger btn-sm remove-item" style="border-radius: 4px;">&times; Remove Item</button>' +
                    '</div>' +
                    '<div class="row">' +

                    '<div class="col-md-4">' +
                    '<div class="form-group"><label style="font-weight: 600;">Upload Image</label>' +
                    '<input type="hidden" data-item-field="image" value="' + imagePath + '">' +
                    '<input type="file" class="form-control mb-2" data-item-upload="image" accept="image/*" style="padding: 6px; cursor: pointer; height: auto;">' +
                    '<div class="text-center preview-container" style="background: #f9fafb; border: 2px dashed #d1d5db; border-radius: 8px; padding: 10px; min-height: 140px; display:flex; align-items:center; justify-content:center;">' +
                    '<span class="text-muted small no-image-text" style="' + (imagePath ? 'display:none;' : '') +
                    '">No Image Selected</span>' +
                    '<img data-item-preview="image" src="' + (imagePath ? ('{{ url('public') }}/' + imagePath) : '') +
                    '" style="max-width:100%; max-height:130px; border-radius:6px; box-shadow:0 2px 4px rgba(0,0,0,0.1); ' +
                    previewStyle + '">' +
                    '</div>' +
                    '</div>' +
                    '</div>' + // end col-md-4

                    '<div class="col-md-8">' +
                    '<div class="row">' +
                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;" class="text-primary">Item Title (AR)</label><input type="text" class="form-control" data-item-field="title_ar" placeholder="عنوان العنصر" value="' +
                    escapeHtml(item && item.title_ar) + '"></div></div>' +
                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;" class="text-primary">Item Title (EN)</label><input type="text" class="form-control" data-item-field="title_en" placeholder="Item Title" value="' +
                    escapeHtml(item && item.title_en) + '"></div></div>' +

                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Sub Title (AR)</label><input type="text" class="form-control" data-item-field="subtitle_ar" placeholder="نبذة قصيرة" value="' +
                    escapeHtml(item && item.subtitle_ar) + '"></div></div>' +
                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Sub Title (EN)</label><input type="text" class="form-control" data-item-field="subtitle_en" placeholder="Short Subtitle" value="' +
                    escapeHtml(item && item.subtitle_en) + '"></div></div>' +

                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Redirect URL (Link)</label><input type="url" class="form-control" data-item-field="url" placeholder="https://example.com" value="' +
                    escapeHtml(item && item.url) + '"></div></div>' +
                    '<div class="col-md-3"><div class="form-group"><label style="font-weight: 600;">Date (EN)</label><input type="text" class="form-control" data-item-field="date_en" placeholder="e.g. 14-04-2026" value="' +
                    dateEn + '"></div></div>' +
                    '<div class="col-md-3"><div class="form-group"><label style="font-weight: 600;">Date (AR)</label><input type="text" class="form-control" data-item-field="date_ar" placeholder="مثال: 14-04-2026" value="' +
                    dateAr + '"></div></div>' +
                    '</div>' +
                    '</div>' + // end col-md-8

                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Description (AR)</label><textarea class="form-control" rows="3" data-item-field="description_ar" placeholder="التفاصيل كاملة هنا...">' +
                    escapeHtml(item && item.description_ar) + '</textarea></div></div>' +
                    '<div class="col-md-6"><div class="form-group"><label style="font-weight: 600;">Description (EN)</label><textarea class="form-control" rows="3" data-item-field="description_en" placeholder="Full Details here...">' +
                    escapeHtml(item && item.description_en) + '</textarea></div></div>' +

                    '</div>' + // end inner row
                    '</div>' +
                    '</div>';
            }

            function addRow(rowData) {
                var wrapper = document.createElement('div');
                wrapper.innerHTML = rowTemplate(rowData || {});
                container.appendChild(wrapper.firstChild);

                var rowEl = container.lastChild;
                var itemsContainer = rowEl.querySelector('.row-items');
                var existingItems = (rowData && Array.isArray(rowData.items)) ? rowData.items : [];

                if (existingItems.length === 0) {
                    itemsContainer.insertAdjacentHTML('beforeend', itemTemplate({}));
                } else {
                    existingItems.forEach(function(item) {
                        itemsContainer.insertAdjacentHTML('beforeend', itemTemplate(item));
                    });
                }
            }

            function refreshFieldNames() {
                var rows = container.querySelectorAll('.builder-row');

                rows.forEach(function(rowEl, rowIndex) {
                    rowEl.querySelectorAll('[data-field]').forEach(function(input) {
                        var field = input.getAttribute('data-field');
                        input.setAttribute('name', 'builder_rows[' + rowIndex + '][' + field + ']');
                    });

                    var items = rowEl.querySelectorAll('.row-item');
                    items.forEach(function(itemEl, itemIndex) {
                        itemEl.querySelectorAll('[data-item-field]').forEach(function(input) {
                            var field = input.getAttribute('data-item-field');
                            input.setAttribute('name', 'builder_rows[' + rowIndex +
                                '][items][' + itemIndex + '][' + field + ']');
                        });

                        itemEl.querySelectorAll('[data-item-upload]').forEach(function(input) {
                            input.setAttribute('name', 'builder_rows_uploads[' + rowIndex +
                                '][' + itemIndex + ']');
                        });
                    });
                });
            }

            function getDragAfterElement(itemsContainer, y) {
                var draggableItems = Array.prototype.slice.call(itemsContainer.querySelectorAll(
                    '.row-item:not(.dragging)'));

                return draggableItems.reduce(function(closest, child) {
                    var box = child.getBoundingClientRect();
                    var offset = y - box.top - box.height / 2;

                    if (offset < 0 && offset > closest.offset) {
                        return {
                            offset: offset,
                            element: child
                        };
                    }

                    return closest;
                }, {
                    offset: Number.NEGATIVE_INFINITY,
                    element: null
                }).element;
            }

            addRowButton.addEventListener('click', function() {
                addRow({
                    type: 'boxes',
                    items: [{}]
                });
                refreshFieldNames();
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-row')) {
                    e.target.closest('.builder-row').remove();
                    refreshFieldNames();
                }

                if (e.target.classList.contains('add-item')) {
                    var rowEl = e.target.closest('.builder-row');
                    var itemsContainer = rowEl.querySelector('.row-items');
                    itemsContainer.insertAdjacentHTML('beforeend', itemTemplate({}));
                    refreshFieldNames();
                }

                if (e.target.classList.contains('remove-item')) {
                    var itemEl = e.target.closest('.row-item');
                    var rowItems = itemEl.closest('.row-items');
                    itemEl.remove();

                    if (rowItems.querySelectorAll('.row-item').length === 0) {
                        rowItems.insertAdjacentHTML('beforeend', itemTemplate({}));
                    }

                    refreshFieldNames();
                }
            });

            container.addEventListener('change', function(e) {
                if (!e.target.matches('[data-item-upload]')) {
                    return;
                }

                var itemEl = e.target.closest('.row-item');
                if (!itemEl) {
                    return;
                }

                var preview = itemEl.querySelector('[data-item-preview="image"]');
                var noImageText = itemEl.querySelector('.no-image-text');
                if (!preview) {
                    return;
                }

                var file = e.target.files && e.target.files[0] ? e.target.files[0] : null;
                if (!file) {
                    return;
                }

                var previewUrl = URL.createObjectURL(file);
                preview.src = previewUrl;
                preview.style.display = '';
                if (noImageText) {
                    noImageText.style.display = 'none';
                }
            });

            container.addEventListener('dragstart', function(e) {
                var itemEl = e.target.closest('.row-item');
                if (!itemEl) {
                    return;
                }

                itemEl.classList.add('dragging');
                if (e.dataTransfer) {
                    e.dataTransfer.effectAllowed = 'move';
                }
            });

            container.addEventListener('dragover', function(e) {
                var itemsContainer = e.target.closest('.row-items');
                var draggingItem = container.querySelector('.row-item.dragging');

                if (!itemsContainer || !draggingItem) {
                    return;
                }

                e.preventDefault();
                var afterElement = getDragAfterElement(itemsContainer, e.clientY);

                if (!afterElement) {
                    itemsContainer.appendChild(draggingItem);
                } else {
                    itemsContainer.insertBefore(draggingItem, afterElement);
                }
            });

            container.addEventListener('dragend', function(e) {
                var itemEl = e.target.closest('.row-item');
                if (!itemEl) {
                    return;
                }

                itemEl.classList.remove('dragging');
                refreshFieldNames();
            });

            if (initialRows.length > 0) {
                initialRows.forEach(function(row) {
                    addRow(row);
                });
            } else {
                addRow({
                    type: 'boxes',
                    items: [{}]
                });
            }

            refreshFieldNames();
        })();
    </script>
@endsection
