@extends('layouts/layoutMaster')

@section('title', 'Add Design Template')

@section('vendor-style')
  @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

@section('vendor-script')
  @vite(['resources/assets/vendor/libs/select2/select2.js'])
@endsection

@section('content')
  @php
    $currentType = request('type');
    $pageTitle = $currentType ? $currentType : 'Design Template';
  @endphp

  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Design Templates /</span> Add {{ $pageTitle }}
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

  <form action="{{ route('templates.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($currentType)
      <input type="hidden" name="type" value="{{ $currentType }}">
    @endif
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
              <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                required />
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Categories (Multi-Select) <span class="text-danger">*</span></label>
                <select class="select2 form-select" name="category_id[]" multiple data-placeholder="Select categories...">
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                      {{ in_array($category->id, old('category_id', [])) ? 'selected' : '' }}>{{ $category->name }}
                    </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Type</label>
                @if ($currentType)
                  <input type="text" class="form-control" value="{{ $currentType }}" disabled>
                @else
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
                      <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>{{ $t }}
                      </option>
                    @endforeach
                  </select>
                @endif
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label" for="short_description">Short Description</label>
              <textarea id="short_description" class="form-control" name="short_description" rows="2">{{ old('short_description') }}</textarea>
            </div>

            <div class="mb-3">
              <label class="form-label" for="description">Full Description</label>
              <textarea id="description" class="form-control" name="description" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                <label class="form-label" for="price">Price ($) <small class="text-muted">— Leave 0 for
                    Free</small></label>
                <input type="number" step="0.01" min="0" class="form-control" id="price" name="price"
                  value="{{ old('price', '0.00') }}" />
                {{-- <div class="form-text"><span class="badge bg-success" id="price-badge">FREE</span> <span id="price-badge-text">This template will be free to download</span></div> --}}
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Color Space</label>
                <select class="select2 form-select" name="color_space" data-placeholder="Select..."
                  data-allow-clear="true">
                  <option value=""></option>
                  <option value="RGB" {{ old('color_space') == 'RGB' ? 'selected' : '' }}>RGB</option>
                  <option value="CMYK" {{ old('color_space') == 'CMYK' ? 'selected' : '' }}>CMYK</option>
                </select>
              </div>
              <div class="col-md-4 mb-3">
                <label class="form-label">Orientation</label>
                <select class="select2 form-select" name="orientation" data-placeholder="Select..."
                  data-allow-clear="true">
                  <option value=""></option>
                  <option value="Landscape" {{ old('orientation') == 'Landscape' ? 'selected' : '' }}>Landscape</option>
                  <option value="Portrait" {{ old('orientation') == 'Portrait' ? 'selected' : '' }}>Portrait</option>
                  <option value="Square" {{ old('orientation') == 'Square' ? 'selected' : '' }}>Square</option>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Compatible Tools</label>
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
                    <option value="{{ $tool }}"
                      {{ in_array($tool, old('compatible_tools', [])) ? 'selected' : '' }}>{{ $tool }}</option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Properties</label>
                <select class="select2 form-select" name="properties[]" multiple
                  data-placeholder="Select properties...">
                  <option value="Vector" {{ in_array('Vector', old('properties', [])) ? 'selected' : '' }}>Vector
                  </option>
                  <option value="Layered" {{ in_array('Layered', old('properties', [])) ? 'selected' : '' }}>Layered
                  </option>
                  <option value="Editable" {{ in_array('Editable', old('properties', [])) ? 'selected' : '' }}>Editable
                  </option>
                  <option value="Print Ready" {{ in_array('Print Ready', old('properties', [])) ? 'selected' : '' }}>
                    Print Ready</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Tags</label>
              <select class="select2 form-select" name="tags[]" multiple
                data-placeholder="Type & press enter to add tags..." data-tags="true">
                @if (old('tags'))
                  @foreach (old('tags') as $tag)
                    <option value="{{ $tag }}" selected>{{ $tag }}</option>
                  @endforeach
                @endif
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
            <div id="thumbnail-previews" class="d-flex flex-wrap gap-3 mb-3"></div>
            <input type="file" id="hidden-thumb-input" accept="image/*" multiple style="display:none;" />
            <button type="button" class="btn btn-sm btn-outline-primary w-100" id="btn-add-thumbnail"><i
                class="icon-base ti tabler-plus me-1"></i> Add Thumbnail</button>
            <div class="form-text mt-2">First thumbnail will be the main image.</div>
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
                value="{{ old('preview_url') }}" placeholder="https://..." />
            </div>

            <div class="mb-3">
              <label class="form-label" for="secure_file"><i class="icon-base ti tabler-lock me-1"></i> Secure Source
                File</label>
              <input type="file" class="form-control" id="secure_file" name="secure_file" />
              <div class="form-text">Optional. If not set, download uses the thumbnail. Free templates download directly.
              </div>
            </div>
          </div>
        </div>

        <div class="card mb-4">
          <div class="card-body">
            <div class="form-check form-switch mb-3">
              <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
              <label class="form-check-label fw-bold" for="is_active">Publish Template</label>
            </div>

            <button type="submit" class="btn btn-primary w-100"><i class="icon-base ti tabler-device-floppy me-1"></i>
              Save Template</button>
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
          $('#price-badge-text').text('This template will be free to download');
        } else {
          $('#price-badge').text('$' + price.toFixed(2)).removeClass('bg-success').addClass('bg-primary');
          $('#price-badge-text').text('Paid template — payment required before download');
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

      // ── Multiple Thumbnails with Preview ──
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
