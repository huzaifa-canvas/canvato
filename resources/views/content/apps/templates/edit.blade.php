@extends('layouts/layoutMaster')

@section('title', 'Edit Design Template')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Design Templates /</span> Edit: {{ $template->title }}
  </h4>

  @if ($errors->any())
    <div class="alert alert-danger alert-dismissible mb-4">
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <form action="{{ route('templates.update', $template->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <!-- Left Column -->
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Basic Information</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label" for="title">Template Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" id="title" name="title"
                value="{{ old('title', $template->title) }}" required />
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Categories (Multi-Select) <span class="text-danger">*</span></label>
                @php $selectedCats = old('category_id', $template->categories->pluck('id')->toArray()); @endphp
                <select class="select2 form-select" name="category_id[]" multiple data-placeholder="Select categories...">
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCats) ? 'selected' : '' }}>
                      {{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Type</label>
                <select class="select2 form-select" name="type" data-placeholder="Select type..."
                  data-allow-clear="true">
                  <option value=""></option>
                  @php
                    $types = [
                        'Printable Templates',
                        'Product Mockups',
                        'Social Media',
                        'Websites',
                        'UX/UI Toolkits',
                        'Infographics',
                        'Logos',
                        'Scene Generators',
                    ];
                  @endphp
                  @foreach ($types as $t)
                    <option value="{{ $t }}" {{ old('type', $template->type) == $t ? 'selected' : '' }}>
                      {{ $t }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="short_description">Short Description</label>
              <textarea id="short_description" class="form-control" name="short_description" rows="2">{{ old('short_description', $template->short_description) }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Full Description</label>
              <textarea id="description" class="form-control" name="description" rows="4">{{ old('description', $template->description) }}</textarea>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label" for="price">Price ($) <small class="text-muted">— Leave 0 for
                    Free</small></label>
                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price"
                  value="{{ old('price', $template->price) }}" />
                {{-- <div class="form-text"><span class="badge bg-success" id="price-badge">FREE</span> <span id="price-badge-text"></span></div> --}}
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Color Space</label>
                <select class="select2 form-select" name="color_space" data-placeholder="Select..."
                  data-allow-clear="true">
                  <option value=""></option>
                  <option value="RGB" {{ old('color_space', $template->color_space) == 'RGB' ? 'selected' : '' }}>RGB
                  </option>
                  <option value="CMYK" {{ old('color_space', $template->color_space) == 'CMYK' ? 'selected' : '' }}>
                    CMYK</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Orientation</label>
                <select class="select2 form-select" name="orientation" data-placeholder="Select..."
                  data-allow-clear="true">
                  <option value=""></option>
                  <option value="Landscape"
                    {{ old('orientation', $template->orientation) == 'Landscape' ? 'selected' : '' }}>Landscape</option>
                  <option value="Portrait"
                    {{ old('orientation', $template->orientation) == 'Portrait' ? 'selected' : '' }}>Portrait</option>
                  <option value="Square" {{ old('orientation', $template->orientation) == 'Square' ? 'selected' : '' }}>
                    Square</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Compatible Tools</label>
                @php $selectedTools = old('compatible_tools', is_array($template->compatible_tools) ? $template->compatible_tools : []); @endphp
                <select class="select2 form-select" name="compatible_tools[]" multiple data-placeholder="Select tools...">
                  @php
                    $tools = [
                        'Adobe Photoshop',
                        'Adobe Illustrator',
                        'Adobe InDesign',
                        'Adobe XD',
                        'Affinity',
                        'Figma',
                        'Sketch',
                        'Canva',
                        'Microsoft Word',
                        'PowerPoint',
                        'Keynote',
                    ];
                  @endphp
                  @foreach ($tools as $tool)
                    <option value="{{ $tool }}" {{ in_array($tool, $selectedTools) ? 'selected' : '' }}>
                      {{ $tool }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Properties</label>
                @php $selectedProps = old('properties', is_array($template->properties) ? $template->properties : []); @endphp
                <select class="select2 form-select" name="properties[]" multiple data-placeholder="Select properties...">
                  <option value="Vector" {{ in_array('Vector', $selectedProps) ? 'selected' : '' }}>Vector</option>
                  <option value="Layered" {{ in_array('Layered', $selectedProps) ? 'selected' : '' }}>Layered</option>
                  <option value="Editable" {{ in_array('Editable', $selectedProps) ? 'selected' : '' }}>Editable
                  </option>
                  <option value="Print Ready" {{ in_array('Print Ready', $selectedProps) ? 'selected' : '' }}>Print
                    Ready</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Tags</label>
              @php $oldTags = old('tags', $template->tags->pluck('name')->toArray()); @endphp
              <select class="select2 form-select" name="tags[]" multiple
                data-placeholder="Type & press enter to add tags..." data-tags="true">
                @foreach ($oldTags as $tag)
                  <option value="{{ $tag }}" selected>{{ $tag }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>

        <!-- Dynamic Properties Card -->
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Dynamic Properties (Meta Data)</h5>
            <button type="button" class="btn btn-sm btn-primary" id="btn-add-property"><i
                class="icon-base ti tabler-plus me-1"></i> Add Property</button>
          </div>
          <div class="card-body" id="dynamic-properties-container">
            @php $dynamicProperties = collect($template->meta_data)->except(['compatible_tools']); @endphp
            @forelse($dynamicProperties as $key => $value)
              <div class="row mb-2 property-row">
                <div class="col-md-5">
                  <input type="text" name="meta_keys[]" class="form-control" value="{{ $key }}"
                    placeholder="Property Name">
                </div>
                <div class="col-md-6">
                  <input type="text" name="meta_values[]" class="form-control"
                    value="{{ is_array($value) ? implode(',', $value) : $value }}" placeholder="Value">
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-icon btn-outline-danger btn-remove-property"><i
                      class="icon-base ti tabler-x"></i></button>
                </div>
              </div>
            @empty
              <div class="row mb-2 property-row">
                <div class="col-md-5">
                  <input type="text" name="meta_keys[]" class="form-control"
                    placeholder="Property Name (e.g. Resolution)">
                </div>
                <div class="col-md-6">
                  <input type="text" name="meta_values[]" class="form-control" placeholder="Value (e.g. 300 DPI)">
                </div>
                <div class="col-md-1">
                  <button type="button" class="btn btn-icon btn-outline-danger btn-remove-property"><i
                      class="icon-base ti tabler-x"></i></button>
                </div>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Thumbnails</h5>
          </div>
          <div class="card-body">
            {{-- Existing thumbnails --}}
            @if ($template->thumbnail && is_array($template->thumbnail) && count($template->thumbnail) > 0)
              <div class="d-flex flex-wrap gap-2 mb-3" id="existing-thumbs">
                @foreach ($template->thumbnail as $idx => $thumb)
                  <div class="position-relative d-inline-block" id="existing_thumb_{{ $idx }}"
                    style="width:80px;height:80px;">
                    <img src="{{ asset('storage/' . $thumb) }}" class="rounded border w-100 h-100"
                      style="object-fit:cover;">
                    <label class="btn btn-xs btn-danger position-absolute"
                      style="top:-6px;right:-6px;padding:0 4px;font-size:10px;line-height:18px;border-radius:50%;cursor:pointer;">
                      <input type="checkbox" name="remove_thumbnails[]" value="{{ $idx }}"
                        class="d-none chk-remove-thumb">
                      &times;
                    </label>
                  </div>
                @endforeach
              </div>
            @endif

            <div id="thumbnail-previews" class="d-flex flex-wrap gap-3 mb-3"></div>
            <input type="file" id="hidden-thumb-input" accept="image/*" multiple style="display:none;" />
            <button type="button" class="btn btn-sm btn-outline-primary w-100" id="btn-add-thumbnail"><i
                class="icon-base ti tabler-plus me-1"></i> Add Thumbnail</button>
            <div id="thumb-files-container"></div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-header">
            <h5 class="mb-0">Files & Links</h5>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <label class="form-label" for="preview_url">Live Preview URL</label>
              <input type="url" class="form-control" id="preview_url" name="preview_url"
                value="{{ old('preview_url', $template->preview_url) }}" placeholder="https://..." />
            </div>

            <div class="mb-3">
              <label class="form-label" for="secure_file"><i class="icon-base ti tabler-lock me-1"></i> Secure Source
                File</label>
              <input type="file" class="form-control" id="secure_file" name="secure_file" />
              <div class="form-text">Optional. Leave empty to keep existing.</div>
              @if ($template->secure_file_path)
                <div class="mt-2 text-success"><i class="icon-base ti tabler-check"></i> Secure file uploaded</div>
              @else
                <div class="mt-2 text-warning"><i class="icon-base ti tabler-info-circle"></i> No secure file — download
                  uses thumbnail</div>
              @endif
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-body">
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                {{ $template->is_active ? 'checked' : '' }}>
              <label class="form-check-label fw-bold" for="is_active">Publish Template</label>
            </div>

            <button type="submit" class="btn btn-primary w-100"><i class="icon-base ti tabler-device-floppy me-1"></i>
              Update Template</button>
            <a href="{{ route('templates.index') }}" class="btn btn-outline-secondary w-100 mt-2">Cancel</a>
          </div>
        </div>
      </div>
    </div>
  </form>
@endsection

@section('page-script')
  <script>
    window.addEventListener('load', function() {
      // ── Select2 Init ──
      $('.select2').each(function() {
        var $el = $(this);
        $el.wrap('<div class="position-relative"></div>').select2({
          dropdownParent: $el.parent(),
          placeholder: $el.data('placeholder') || 'Select...',
          allowClear: !!$el.data('allow-clear'),
          tags: !!$el.data('tags'),
          tokenSeparators: $el.data('tags') ? [','] : []
        });
      });

      // ── Price Badge ──
      function updatePriceBadge() {
        var price = parseFloat($('#price').val()) || 0;
        if (price <= 0) {
          $('#price-badge').text('FREE').removeClass('bg-primary').addClass('bg-success');
          $('#price-badge-text').text('Free to download');
        } else {
          $('#price-badge').text('$' + price.toFixed(2)).removeClass('bg-success').addClass('bg-primary');
          $('#price-badge-text').text('Paid — payment required');
        }
      }
      $('#price').on('input change', updatePriceBadge);
      updatePriceBadge();

      // ── Dynamic Properties ──
      $(document).on('click', '#btn-add-property', function() {
        var row = '<div class="row mb-2 property-row">' +
          '<div class="col-md-5"><input type="text" name="meta_keys[]" class="form-control" placeholder="Property Name"></div>' +
          '<div class="col-md-6"><input type="text" name="meta_values[]" class="form-control" placeholder="Value"></div>' +
          '<div class="col-md-1"><button type="button" class="btn btn-icon btn-outline-danger btn-remove-property"><i class="icon-base ti tabler-x"></i></button></div>' +
          '</div>';
        $('#dynamic-properties-container').append(row);
      });

      $(document).on('click', '.btn-remove-property', function() {
        $(this).closest('.property-row').remove();
      });

      // ── Existing Thumb Remove (toggle strikethrough) ──
      $(document).on('change', '.chk-remove-thumb', function() {
        var parent = $(this).closest('[id^="existing_thumb_"]');
        if ($(this).is(':checked')) {
          parent.css('opacity', '0.3');
        } else {
          parent.css('opacity', '1');
        }
      });

      // ── New Thumbnails with Preview ──
      var fileCounter = 0;

      // ── New Thumbnails with Preview ──
      var fileCounter = 0;

      $('#btn-add-thumbnail').on('click', function() {
        var fileId = 'thumb_' + (fileCounter++);
        var inputHtml = '<input type="file" id="input_' + fileId + '" name="thumbnails[]" accept="image/*" class="d-none thumb-input" data-file-id="' + fileId + '">';
        $('#thumb-files-container').append(inputHtml);
        $('#input_' + fileId).click();
      });

      $(document).on('change', '.thumb-input', function() {
        var input = this;
        var fileId = $(this).data('file-id');

        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function(e) {
            var preview = '<div class="position-relative d-inline-block" id="preview_' + fileId +
              '" style="width:80px;height:80px;">' +
              '<img src="' + e.target.result +
              '" class="rounded border w-100 h-100" style="object-fit:cover;">' +
              '<button type="button" class="btn btn-xs btn-danger position-absolute btn-remove-preview" data-file-id="' +
              fileId +
              '" style="top:-6px;right:-6px;padding:0 4px;font-size:10px;line-height:18px;border-radius:50%;">&times;</button>' +
              '</div>';
            $('#thumbnail-previews').append(preview);
          };
          reader.readAsDataURL(input.files[0]);
        } else {
          $(this).remove();
        }
      });

      $(document).on('click', '.btn-remove-preview', function() {
        var fileId = $(this).data('file-id');
        $('#preview_' + fileId).remove();
        $('#input_' + fileId).remove();
      });
    });
  </script>
@endsection
