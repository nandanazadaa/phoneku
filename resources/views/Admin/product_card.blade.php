@extends('layouts.main')

@section('title', 'Product Management')

@push('styles')
{{-- Bootstrap Colorpicker CSS --}}
{{-- Pastikan URL ini benar-benar dapat diakses dan filenya ada --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css">

<style>
     /* Ensure Bootstrap 4+ is loaded for .input-group, .form-control etc. */

    /* --- General Form Styling --- */
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block; /* Ensure label is on its own line */
    }
     /* Style for form-control with error */
     .form-control.is-invalid {
         border-color: #dc3545;
         /* Add padding/background image for validation icon if needed based on your theme */
         /* padding-right: calc(1.5em + 0.75rem); */
         /* background-image: url(...); */
         /* background-repeat: no-repeat; */
         /* background-position: center right calc(0.375em + 0.1875rem); */
         /* background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem); */
     }
     .invalid-feedback {
         display: block; /* Always display if present due to absolute positioning of picker elements or floats */
         width: 100%; /* Take full width */
         margin-top: 0.25rem;
         font-size: 0.875em;
         color: #dc3545;
     }


    /* --- Colorpicker Input Group Styling (The input field + add button) --- */
    /* .colorpicker-element is the wrapper applied by the plugin around the input group */
    .colorpicker-element {
         display: block; /* Ensure it takes up space correctly */
         width: 100%; /* Take full width of parent */
    }
    .colorpicker-element .input-group {
        position: relative; /* Needed for absolute positioning of swatch */
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border-radius: 20px; /* Apply border-radius to the group */
        overflow: hidden; /* Ensures children respect the border-radius */
        display: flex; /* Ensure flex layout */
        align-items: stretch; /* Ensure items stretch to fill height */
        width: 100%; /* Take full width of parent */
    }

    .colorpicker-element .form-control {
        border: 1px solid #ced4da;
        border-right: none; /* Seamless look with append */
        border-radius: 20px 0 0 20px; /* Apply radius only to the left side */
        padding-left: 40px; /* Space for swatch icon */
        background: #f8f9fa;
        transition: box-shadow 0.3s ease, border-color 0.3s ease;
        min-width: 0; /* Allow input to shrink in flex container */
        flex-grow: 1; /* Allow input to take available space */
        height: calc(2.25rem + 2px); /* Match standard Bootstrap input height */
         /* Add border-radius back if input is last element (no append) */
         /* &:last-child { border-radius: 20px; border-right: 1px solid #ced4da; } */
    }
    .colorpicker-element .form-control:focus {
        box-shadow: 0 0 10px rgba(0, 123, 255, 0.3);
        border-color: #007bff;
        z-index: 3; /* Ensure focused input is above siblings */
    }

    /* Style for the swatch icon element (the clickable part to open picker) */
     .colorpicker-element .input-group-prepend {
         /* Use prepend for positioning swatch over input */
         display: flex; /* Needed for correct positioning */
     }

    .colorpicker-element .input-group-prepend .input-group-text {
         /* Style for the span holding the <i> swatch */
        background: transparent; /* No background */
        border: 1px solid #ced4da;
        border-right: none; /* Seamless with input */
        padding: 0;
        width: 35px; /* Slightly wider for padding/centering */
        height: calc(2.25rem + 2px); /* Match input height */
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 4; /* Above input */
        cursor: pointer; /* Indicate it's clickable */
        border-radius: 20px 0 0 20px; /* Match input radius */
        position: absolute; /* Position over the input */
        left: 1px; /* Align with input border */
        top: 0; /* Align with input top */
        bottom: 0; /* Align with input bottom */
        pointer-events: all; /* Ensure clicks are registered */
    }

     /* Hide the default append swatch that Bootstrap Colorpicker might add */
     .colorpicker-element .input-group-append .input-group-text {
         display: none; /* Hide the default swatch element */
     }

    .colorpicker-element .input-group-text i {
        /* The actual color circle */
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.2); /* Slight border for visibility */
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
    }

    /* Eyedropper and Add buttons */
    .colorpicker-element .input-group-append {
         display: flex; /* Needed for buttons in append */
    }
    .colorpicker-element .input-group-append .btn {
        height: calc(2.25rem + 2px); /* Match input height */
        display: flex;
        align-items: center;
        padding: 0 1rem; /* Adjust horizontal padding */
        transition: background-color 0.3s ease, transform 0.1s ease, box-shadow 0.2s ease;
        border: 1px solid #ced4da; /* Standard border */
        border-left: none; /* Seamless look with element before it */
        z-index: 1; /* Below input focus */
    }

    .btn-eyedropper {
        background: #6c757d; /* Secondary color */
        color: #fff;
        border-color: #6c757d;
        border-radius: 0; /* No radius */
    }
     .btn-eyedropper:hover {
         background: #5a6268;
         border-color: #545b62;
     }

    .btn-add-color {
        border-top-right-radius: 20px; /* Apply radius to the right-most button */
        border-bottom-right-radius: 20px;
        background: linear-gradient(45deg, #007bff, #0056b3); /* Primary gradient */
        color: #fff;
        border-color: #007bff;
        border-left: none; /* Ensure no border conflict if eyedropper is present */
    }
    .btn-add-color:hover {
        background: linear-gradient(45deg, #0056b3, #007bff); /* Reverse gradient */
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3); /* Blue shadow */
    }
    .btn-eyedropper:hover, .btn-add-color:hover {
        transform: translateY(0); /* Prevent lift effect here */
        z-index: 2; /* Bring button to front on hover */
    }


    /* --- Selected Colors List --- */
     /* Container for color items */
     .selected-colors-list {
         display: flex;
         flex-wrap: wrap; /* Allow items to wrap */
         gap: 5px; /* Space between items */
     }

    .selected-color-item {
        display: inline-flex; /* Use inline-flex to keep items on the same line and align content */
        align-items: center;
        background: linear-gradient(135deg, #ffffff, #f1f3f5); /* Light gradient */
        border: 1px solid #dee2e6;
        border-radius: 25px; /* Pill shape */
        padding: 6px 12px; /* Padding around content */
        /* margin: 5px; Removed margin from item, replaced with gap in parent */
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        white-space: nowrap; /* Prevent text/items inside from breaking */
        /* Ensure items don't push parent width */
        max-width: 100%; /* Prevent overflow issues */
    }
     /* Style for invalid color items */
     .selected-color-item.text-danger {
         background: linear-gradient(135deg, #f8d7da, #f5c6cb); /* Danger gradient */
         border-color: #dc3545;
     }

    .selected-color-item:hover {
        transform: translateY(-2px); /* Slight lift */
        box-shadow: 0 3px 8px rgba(0,0,0,0.12);
    }
    .selected-color-item .color-swatch {
        width: 18px;
        height: 18px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.2); /* Subtle border */
        margin-right: 8px;
        flex-shrink: 0; /* Prevent swatch from shrinking */
        transition: background-color 0.3s ease; /* Add transition */
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .selected-color-item .color-hex {
        font-weight: 500;
        color: #333;
        margin-right: 8px;
        /* white-space: nowrap; Already on parent */
        overflow: hidden; /* Hide overflowing text if any */
        text-overflow: ellipsis; /* Add ellipsis if text is too long */
    }
     .selected-color-item.text-danger .color-hex {
         color: #dc3545; /* Red color for invalid text */
     }
    .selected-color-item .btn-remove-color {
        background: none;
        border: none;
        color: #dc3545;
        font-size: 1.1rem;
        padding: 0 5px;
        cursor: pointer;
        transition: color 0.2s ease, transform 0.2s ease;
         line-height: 1; /* Prevent extra space around 'x' */
         margin-left: auto; /* Push button to the right */
         flex-shrink: 0; /* Prevent button from shrinking */
    }
    .selected-color-item .btn-remove-color:hover {
        color: #c82333;
        transform: scale(1.2);
    }


    /* --- Preview Card Styling --- */
    .preview-container {
        /* Container for the preview card */
        display: flex; /* Use flex to contain the preview card */
         justify-content: center; /* Center the card within the column */
         padding: 10px; /* Optional padding */
    }

    .preview-card {
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        background: #fff;
        width: 100%; /* Ensure card takes full column width */
        max-width: 250px; /* Smaller max-width more typical for a product card preview */
    }
    .preview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .preview-image-container {
        width: 100%;
        height: 180px; /* Slightly smaller fixed height for preview */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
    }
    .preview-image-container img {
        max-width: 100%;
        max-height: 100%; /* Use max-height to respect the container height */
        object-fit: contain; /* Use contain to show full image without cropping */
    }
    .preview-no-image {
        color: #6c757d;
        text-align: center;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px; /* Add some padding */
    }
     .preview-no-image .fa-image {
         margin-bottom: 10px;
     }
    .preview-card .card-body {
        padding: 15px;
    }
    .preview-card .card-title {
        font-size: 1rem; /* Slightly smaller title in preview */
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-align: center; /* Center title */
    }
    .preview-card .card-text {
        font-size: 0.85rem; /* Smaller text in preview */
        color: #555;
        margin-bottom: 0.25rem; /* Less space between text lines */
         text-align: center; /* Center text */
    }
     .preview-card .card-text:last-child {
         margin-bottom: 0;
     }
     .preview-color-list {
         margin-top: 0.5rem;
         margin-bottom: 0.5rem;
         text-align: center; /* Center the color swatches/text */
     }
    .preview-color-swatch {
        display: inline-block;
        width: 16px; /* Smaller swatches in preview */
        height: 16px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.2);
        margin: 0 3px; /* Adjust margin for spacing */
        vertical-align: middle;
        transition: background-color 0.3s ease, transform 0.2s ease; /* Add transition */
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .preview-color-swatch:hover {
        transform: scale(1.1); /* Smaller scale for swatch */
    }
     .line-through {
         text-decoration: line-through;
     }


    /* --- Bootstrap Colorpicker Dropdown Styling (Cleaned Up) --- */
    /* .colorpicker is the dropdown container appended to the body (with container: true) */
    /* We'll style it like a standard but clean dropdown, not a fixed popup */
    .colorpicker {
        /* Revert fixed positioning, rely on library/bootstrap for absolute positioning */
        position: absolute !important; /* Let Bootstrap handle positioning near the input */
        top: 100% !important; /* Position below the input group */
        left: 0 !important;
        right: auto !important; /* Don't force right position */
        z-index: 1060 !important; /* Standard z-index for modals/dropdowns */

        border-radius: 8px !important; /* Softly rounded corners */
        box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important; /* Standard dropdown shadow */
        background: #fff !important; /* White background */
        overflow: hidden !important; /* Hide potential overflows */
        padding: 15px !important; /* Padding inside */
        border: 1px solid #ced4da !important; /* Subtle border */
        min-width: 250px !important; /* Minimum width */
        max-width: none !important; /* Remove max-width constraint */
        width: auto !important; /* Allow width to adjust */
        height: auto !important; /* Allow height to adjust */
         float: none !important; /* Remove float */
         margin: 5px 0 0 0 !important; /* Space below the input group */

         /* Optional: Add transitions for showing/hiding (Bootstrap usually handles this with fade) */
         /* opacity: 0; */
         /* visibility: hidden; */
         /* transition: opacity 0.15s ease-in-out, visibility 0.15s ease-in-out; */
    }

     /* Style when visible */
     /* .colorpicker.colorpicker-visible { */
     /*     opacity: 1; */
     /*     visibility: visible; */
     /* } */

     /* Hide the default Bootstrap dropdown menu styles */
    /* These styles ensure the picker content takes up space correctly within the .colorpicker parent */
    .colorpicker-bs.dropdown-menu {
         display: block !important; /* Ensure it's block */
         opacity: 1 !important; /* Override Bootstrap fade */
         visibility: visible !important; /* Override Bootstrap fade */
         margin: 0 !important; /* Remove default margin */
         padding: 0 !important; /* Remove default padding */
         border: none !important; /* Remove default border */
         box-shadow: none !important; /* Remove default shadow */
         background: transparent !important; /* Remove default background */
         position: static !important; /* Reset positioning within the main .colorpicker */
         transform: none !important; /* Reset transform */
         top: auto !important; left: auto !important; /* Reset positioning */
         width: 100% !important; /* Take full width of parent .colorpicker */
         float: none !important; /* Remove float */
    }


     /* Specific styling for picker components */
     /* Use !important if necessary to override theme conflicts */
     .colorpicker .colorpicker-saturation,
     .colorpicker .colorpicker-hue {
         border: 1px solid #eee !important; /* Subtle border */
         border-radius: 4px !important; /* Small border radius on components */
         margin: 0 0 12px 0 !important; /* Margin below saturation/hue */
         width: 100% !important; /* Ensure they fill width */
         position: relative !important; /* Needed for internal pointers */
         overflow: hidden !important; /* Prevent gradient bleed */
     }
     .colorpicker .colorpicker-saturation {
         padding-bottom: 60% !important; /* Maintain aspect ratio */
     }
     .colorpicker .colorpicker-hue {
         height: 12px !important; /* Height of the hue slider */
     }

     /* Pointers within saturation/hue area */
     .colorpicker .colorpicker-saturation i,
     .colorpicker .colorpicker-hue i {
         background: none !important; /* Remove background from pointer */
         border: 2px solid #fff !important; /* White border */
         box-shadow: 0 0 0 1px rgba(0,0,0,0.3) !important; /* Small dark outline */
         border-radius: 50% !important;
         width: 14px !important; /* Pointer size */
         height: 14px !important;
         /* Center pointer */
         margin: -7px !important; /* Saturation adjustment */
         margin-top: -7px !important; /* Hue vertical center */
         margin-left: var(--colorpicker-position-x, 0) !important; /* Hue horizontal */
         position: absolute !important;
         pointer-events: none !important; /* Don't block clicks */
     }
      /* Specific positioning for Saturation pointer */
     .colorpicker .colorpicker-saturation i {
          top: var(--colorpicker-position-y, 0) !important;
          left: var(--colorpicker-position-x, 0) !important;
          margin: -7px !important; /* Center */
     }
     /* Specific positioning for Hue pointer */
     .colorpicker .colorpicker-hue i {
          top: 50% !important; /* Center vertically */
          left: var(--colorpicker-position-x, 0) !important; /* Controlled horizontally by JS */
          margin-top: -7px !important; /* Center vertically */
          margin-left: -7px !important; /* Center horizontally */
     }


    .colorpicker .colorpicker-alpha {
        display: none !important; /* Hide alpha slider as we only use hex */
    }

     /* Container for the color display box */
    .colorpicker .colorpicker-color {
        margin: 0 0 12px 0 !important; /* Margin below color display */
         border-radius: 4px !important; /* Match other components */
         overflow: hidden !important; /* Hide gradient overflow */
         height: 25px !important; /* Height of the color display */
         position: relative !important; /* Needed for transparency background */
         /* Transparency checkerboard background */
         background-image: linear-gradient(45deg, #ddd 25%, transparent 25%),
                           linear-gradient(-45deg, #ddd 25%, transparent 25%),
                           linear-gradient(45deg, transparent 75%, #ddd 75%),
                           linear-gradient(-45deg, transparent 75%, #ddd 75%) !important;
        background-size: 10px 10px !important;
        background-position: 0 0, 0 5px, 5px -5px, -5px 0px !important;
         border: 1px solid #eee !important; /* Subtle border */
    }
    .colorpicker .colorpicker-color div {
         /* This div shows the actual selected color */
        border-radius: 4px !important; /* Match container */
        width: 100% !important;
        height: 100% !important;
        position: absolute !important; /* Cover the transparency background */
        top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important;
    }

     /* Swatch selectors area */
     .colorpicker .colorpicker-selectors {
         display: flex !important;
         flex-wrap: wrap !important;
         gap: 6px !important; /* Space between swatches */
         padding: 8px 0 4px 0 !important; /* Vertical padding */
         border-top: 1px solid #eee !important; /* Separator */
         margin-top: 12px !important; /* Margin above swatches */
         justify-content: center !important; /* Center swatches */
     }
    .colorpicker .colorpicker-selector {
        width: 26px !important; /* Swatch size */
        height: 26px !important;
        border-radius: 50% !important; /* Keep round swatches */
        border: 1px solid rgba(0,0,0,0.1) !important; /* Softer border */
        cursor: pointer !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1) !important;
         /* Optional: remove checkerboard if any is inherited */
         background-image: none !important;
         background-color: var(--color) !important; /* Set background based on inline style */
    }
    .colorpicker .colorpicker-selector:hover {
        transform: scale(1.1) !important; /* Pop on hover */
        box-shadow: 0 2px 5px rgba(0,0,0,0.15) !important;
    }

     /* Input field container within the picker dropdown */
    .colorpicker .colorpicker-input {
        margin: 10px 0 0 0 !important; /* Margin above input */
        display: flex !important; /* Use flexbox for label/input alignment */
        align-items: center !important; /* Vertically align items */
        /* width: 100% !important; Redundant with flex and input flex-grow */
         padding: 0 5px; /* Add horizontal padding to the input row */
    }
     /* Label next to hex input (Bootstrap Colorpicker adds this) */
    .colorpicker .colorpicker-input label {
         margin-right: 8px !important; /* Space between label and input */
         font-weight: 500 !important; /* Semi-bold */
         min-width: 35px; /* Give label some minimum width */
         color: #333; /* Darker text color */
         font-size: 0.9rem; /* Slightly smaller font */
    }
     /* Input field within the picker dropdown */
    .colorpicker .colorpicker-input input.form-control {
        border-radius: 4px !important; /* Standard input radius */
        padding: 0.375rem 0.75rem !important; /* Standard Bootstrap padding */
         height: calc(2.25rem + 2px) !important; /* Standard Bootstrap input height */
        text-align: center !important; /* Center hex code */
        font-size: 0.9rem !important;
         flex-grow: 1 !important; /* Allow input to fill space */
         min-width: 0 !important; /* Allow shrinking */
         border: 1px solid #ced4da !important; /* Standard border */
         background: #f8f9fa !important; /* Light background */
         box-shadow: inset 0 1px 2px rgba(0,0,0,0.075) !important; /* Subtle inset shadow */
          /* Ensure default Bootstrap focus styles apply */
     }
     /* .colorpicker .colorpicker-input input.form-control:focus { */
     /*     border-color: #80bdff !important; */
     /*     box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25) !important; */
     /* } */


    /* --- DataTables Integration (Optional, but common) --- */
     #basic-datatables img.product-table-image {
         max-width: 80px;
         height: auto;
         border-radius: 4px;
         border: 1px solid #eee;
     }
     /* Image display for edit form */
     .product-detail-image {
        max-width: 100px;
        height: auto;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 3px;
     }

</style>
@endpush

@section('content')
<div class="panel-header bg-light-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="pb-2 fw-bold">Produk Management</h2>
                <h5 class="op-7 mb-2">Manage Produk yang ada di toko anda!</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                {{-- Adjusted button visibility based on tab --}}
                {{-- The create product modal button should always be visible --}}
                 <button class="btn btn-white btn-border btn-round mr-2" data-toggle="modal" data-target="#createProductModal">
                    <i class="fa fa-plus"></i> Tambah Produk
                 </button>
                 {{-- Back button only makes sense when not on the list tab --}}
                @if(request('tab', 'list') !== 'list') {{-- Show back button if tab is not 'list' --}}
                     <a href="{{ route('admin.products') }}?tab=list" class="btn btn-white btn-border btn-round mr-2">
                         <i class="fa fa-arrow-left"></i> Kembali ke List Produk
                     </a>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="page-inner mt--5">
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item">
            {{-- Use request('tab') for active class logic --}}
            <a class="nav-link {{ (request('tab', 'list') === 'list') ? 'active' : '' }}"
                id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list"
                aria-selected="{{ (request('tab', 'list') === 'list') ? 'true' : 'false' }}">
                <i class="fa fa-list"></i> List Produk
            </a>
        </li>
        {{-- Removed the explicit "Tambah Produk Baru" tab to rely solely on the modal --}}
        {{-- The create form will now only exist within the modal --}}
        @if(isset($editProduct) && request('tab') === 'edit') {{-- Check for editProduct existence and tab --}}
            <li class="nav-item">
                {{-- Edit tab is active only when editProduct is set and tab is 'edit' --}}
                <a class="nav-link active" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
                    aria-controls="edit" aria-selected="true">
                    <i class="fa fa-edit"></i> Edit Produk
                </a>
            </li>
        @endif
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-2" id="productTabsContent">
        <!-- List Tab -->
        <div class="tab-pane fade {{ (request('tab', 'list') === 'list') ? 'show active' : '' }}" id="list" role="tabpanel" aria-labelledby="list-tab">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Semua Produk</h4>
                        <form class="ml-auto" action="{{ route('admin.products') }}" method="GET">
                            <input type="hidden" name="tab" value="list">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari produk..." value="{{ request('search') }}"> {{-- Added form-control-sm --}}
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                     @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto Produk</th>
                                    <th>Nama Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Harga Asli</th>
                                    <th>Stok</th>
                                    <th>Warna</th> {{-- Added Color Header --}}
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products ?? [] as $index => $product)
                                    <tr>
                                        <td>{{ $products->firstItem() + $index }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-table-image" width="100">
                                            @else
                                                <span class="badge badge-secondary">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $product->category == 'handphone' ? 'primary' : ($product->category == 'accessory' ? 'info' : 'secondary') }}">
                                                {{ ucfirst($product->category) }}
                                            </span>
                                        </td>
                                        <td>{{ $product->formatted_price }}</td>
                                        <td>
                                             @if($product->original_price && $product->original_price > $product->price)
                                                <span class="line-through">{{ $product->formatted_original_price }}</span>
                                             @else
                                                 -
                                             @endif
                                        </td>
                                        <td>{{ $product->stock }}</td>
                                        {{-- Display Colors (split by comma if multiple) --}}
                                        <td>
                                            @if($product->color)
                                                @php
                                                    // Split colors by comma, trim whitespace, filter out empty strings
                                                    $colors = array_filter(array_map('trim', explode(',', $product->color)));
                                                @endphp
                                                @forelse($colors as $color)
                                                    @php $hexColor = strtoupper($color); @endphp {{-- Convert to uppercase --}}
                                                    @if(!empty($hexColor) && (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $hexColor)))
                                                        <span style="display: inline-block; width: 15px; height: 15px; background-color: {{ $hexColor }}; border: 1px solid #ccc; vertical-align: middle; margin-right: 3px; border-radius: 50%;"></span>
                                                        {{ $hexColor }}@if(!$loop->last),@endif
                                                    @else
                                                         {{ $color }}@if(!$loop->last),@endif {{-- Display non-hex text if any --}}
                                                    @endif
                                                @empty
                                                     - {{-- Display '-' if colors string was not empty but contained only empty/whitespace items --}}
                                                @endforelse
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                {{-- Link to edit tab --}}
                                                <a href="{{ route('admin.products') }}?tab=edit&id={{ $product->id }}" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewProductModal{{ $product->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteProductModal{{ $product->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>

                                            <!-- View Product Modal -->
                                            <div class="modal fade" id="viewProductModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="viewProductModalLabel{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="viewProductModalLabel{{ $product->id }}">{{ $product->name }}</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @php
                                                                        $images = array_filter([$product->image, $product->image2, $product->image3]);
                                                                    @endphp
                                                                    @if(count($images) > 0)
                                                                        <div id="productCarousel{{ $product->id }}" class="carousel slide" data-ride="carousel">
                                                                            <div class="carousel-inner">
                                                                                @foreach($images as $image)
                                                                                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                                                                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }}" class="d-block w-100">
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                            @if(count($images) > 1) {{-- Show controls only if more than one image --}}
                                                                            <a class="carousel-control-prev" href="#productCarousel{{ $product->id }}" role="button" data-slide="prev">
                                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                                <span class="sr-only">Previous</span>
                                                                            </a>
                                                                            <a class="carousel-control-next" href="#productCarousel{{ $product->id }}" role="button" data-slide="next">
                                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                                <span class="sr-only">Next</span>
                                                                            </a>
                                                                            @endif
                                                                        </div>
                                                                    @else
                                                                        <div class="text-center p-5 bg-light rounded">
                                                                            <i class="fa fa-image fa-3x text-muted"></i>
                                                                            <p class="mt-2">No image available</p>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <td>{{ $product->name }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Category</th>
                                                                            <td>{{ ucfirst($product->category) }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Price</th>
                                                                            <td>{{ $product->formatted_price }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Original Price</th>
                                                                            <td>
                                                                                @if($product->original_price && $product->original_price > $product->price)
                                                                                    <span class="line-through">{{ $product->formatted_original_price }}</span>
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Stock</th>
                                                                            <td>{{ $product->stock }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Warna</th> {{-- Display Color in Modal --}}
                                                                            <td>
                                                                                 @if($product->color)
                                                                                    @php
                                                                                        // Split colors by comma, trim whitespace, filter out empty strings
                                                                                        $colors = array_filter(array_map('trim', explode(',', $product->color)));
                                                                                    @endphp
                                                                                    @forelse($colors as $color)
                                                                                         @php $hexColor = strtoupper($color); @endphp {{-- Convert to uppercase --}}
                                                                                         @if(!empty($hexColor) && (preg_match('/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/', $hexColor)))
                                                                                            <span style="display: inline-block; width: 15px; height: 15px; background-color: {{ $hexColor }}; border: 1px solid #ccc; vertical-align: middle; margin-right: 3px; border-radius: 50%;"></span>
                                                                                            {{ $hexColor }}@if(!$loop->last),@endif
                                                                                        @else
                                                                                             {{ $color }}@if(!$loop->last),@endif {{-- Display non-hex text --}}
                                                                                        @endif
                                                                                    @empty
                                                                                         N/A
                                                                                    @endforelse
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Featured</th>
                                                                            <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Added</th>
                                                                            <td>{{ $product->created_at->format('d M Y H:i') }}</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <div class="mt-3">
                                                                <h6>Description</h6>
                                                                <p>{{ $product->description ?? 'No description available.' }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            {{-- Link to edit tab from modal --}}
                                                            <a href="{{ route('admin.products') }}?tab=edit&id={{ $product->id }}" class="btn btn-primary">Edit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Product Modal -->
                                            <div class="modal fade" id="deleteProductModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteProductModalLabel{{ $product->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteProductModalLabel{{ $product->id }}">Confirm Delete</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Are you sure you want to delete the product <strong>{{ $product->name }}</strong>?</p>
                                                            <p class="text-danger">This action cannot be undone.</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Delete</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    {{-- Updated colspan from 9 to 10 --}}
                                    <tr>
                                        <td colspan="10" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $products->appends(['tab' => 'list', 'search' => request('search')])->links() ?? '' }} {{-- Added search param to pagination --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Removed the "Tambah Produk Baru" tab content as it's now in a modal --}}
        {{-- Keeping the Edit Tab content as it's a full page form --}}

        <!-- Edit Tab -->
        @if(isset($editProduct) && request('tab') === 'edit')
        <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Produk</h4>
                        </div>
                        <div class="card-body">
                            {{-- Add preview area for edit form --}}
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Preview Card:</h5>
                                     <div id="edit-preview-container" class="preview-container"> {{-- Added class for common styling --}}
                                        {{-- Preview card will be injected here by JavaScript --}}
                                    </div>
                                    <small class="form-text text-muted mt-2 text-center">Ini tampilan perkiraan di halaman pembeli.</small> {{-- Centered text --}}
                                </div>
                                <div class="col-md-6">
                                    {{-- Optional: space for other preview elements or instructions --}}
                                </div>
                            </div>

                            <form action="{{ route('admin.products.update', $editProduct->id) }}" method="POST" enctype="multipart/form-data" id="edit-product-form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="edit_name">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" value="{{ old('name', $editProduct->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_description">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="edit_description" name="description" rows="4">{{ old('description', $editProduct->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_price">Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="edit_price" name="price" value="{{ old('price', $editProduct->price) }}" min="0" step="1000" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_original_price">Harga Asli (Rp)</label>
                                            <input type="number" class="form-control @error('original_price') is-invalid @enderror" id="edit_original_price" name="original_price" value="{{ old('original_price', $editProduct->original_price) }}" min="0" step="1000">
                                            @error('original_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_category">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-control @error('category') is-invalid @enderror" id="edit_category" name="category" required>
                                                <option value="handphone" {{ old('category', $editProduct->category) == 'handphone' ? 'selected' : '' }}>Handphone</option>
                                                <option value="accessory" {{ old('category', $editProduct->category) == 'accessory' ? 'selected' : '' }}>Accessory</option>
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_stock">Stok <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="edit_stock" name="stock" value="{{ old('stock', $editProduct->stock) }}" min="0" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Multi-Color Input Section (Edit) --}}
                                <div class="form-group">
                                    <label for="edit_temp_color">Pilih Warna</label> {{-- Label for the temporary picker input --}}
                                    {{-- data-color will set the initial picker value when initialized --}}
                                    {{-- Use old() for the temporary input value, fallback to a default --}}
                                    <div class="input-group colorpicker-element" data-color="{{ old('_edit_temp_color', '#FFFFFF') }}">
                                        <div class="input-group-prepend">
                                            {{-- This span and its <i> icon will be the clickable swatch --}}
                                            <span class="input-group-text colorpicker-color"><i></i></span>
                                        </div>
                                         {{-- This input holds the CURRENTLY SELECTED color in the picker UI --}}
                                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="edit_temp_color" value="{{ old('_edit_temp_color', '#FFFFFF') }}" autocomplete="off">
                                        <div class="input-group-append">
                                             <button class="btn btn-outline-secondary btn-eyedropper" type="button" title="Pick color from screen">
                                                <i class="fa fa-eye-dropper"></i>
                                            </button>
                                            {{-- This button adds the color from the temp input to the list --}}
                                            <button class="btn btn-outline-primary btn-add-color" type="button" data-target="edit">
                                                 <i class="fa fa-plus"></i> Tambah
                                            </button>
                                        </div>
                                    </div>
                                     @error('color') {{-- Validation errors for the hidden 'color' field --}}
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Pilih warna menggunakan pemilih atau masukkan kode hex, lalu klik "Tambah". Tombol pipet hanya berfungsi di browser yang mendukung.</small>

                                     {{-- Display Area for Selected Colors --}}
                                    <div id="selected-colors-list-edit" class="mt-2 selected-colors-list"> {{-- Added class --}}
                                        {{-- Selected colors will be displayed here by JS --}}
                                    </div>

                                    {{-- Hidden Input to Store Comma-Separated VALID Hex Colors for Submission --}}
                                     <input type="hidden" name="color" id="product_colors_input_edit" value="{{ old('color', $editProduct->color ?? '') }}">
                                </div>


                                <div class="form-group">
                                    <label for="edit_image">Foto Produk 1</label>
                                    {{-- Updated accept attribute for common image types --}}
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="edit_image" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small> {{-- Updated info --}}
                                    @if($editProduct->image)
                                        <div class="mt-3">
                                            {{-- Ensure path is correct --}}
                                            <img src="{{ asset('storage/' . $editProduct->image) }}" alt="{{ $editProduct->name }}" class="product-detail-image">
                                        </div>
                                    @else
                                        <div class="mt-3 text-center p-3 bg-light rounded">
                                            <i class="fa fa-image fa-2x text-muted"></i>
                                            <p class="mb-0 mt-1 text-muted">No image uploaded</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="edit_image2">Foto Produk 2</label>
                                     {{-- Updated accept attribute --}}
                                    <input type="file" class="form-control @error('image2') is-invalid @enderror" id="edit_image2" name="image2" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    @error('image2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small> {{-- Updated info --}}
                                     @if($editProduct->image2)
                                        <div class="mt-3">
                                             {{-- Ensure path is correct --}}
                                            <img src="{{ asset('storage/' . $editProduct->image2) }}" alt="{{ $editProduct->name }}" class="product-detail-image">
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="edit_image3">Foto Produk 3</label>
                                     {{-- Updated accept attribute --}}
                                    <input type="file" class="form-control @error('image3') is-invalid @enderror" id="edit_image3" name="image3" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    @error('image3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small> {{-- Updated info --}}
                                     @if($editProduct->image3)
                                        <div class="mt-3">
                                             {{-- Ensure path is correct --}}
                                            <img src="{{ asset('storage/' . $editProduct->image3) }}" alt="{{ $editProduct->name }}" class="product-detail-image">
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="edit_is_featured" name="is_featured" value="1" {{ old('is_featured', $editProduct->is_featured) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="edit_is_featured">Produk Unggulan</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Produk</button>
                                    {{-- Use JS back or route to list with tab param --}}
                                    <a href="{{ route('admin.products') }}?tab=list" class="btn btn-secondary">Batal</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Create Product Modal --}}
<div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createProductModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="modal-create-product-form">
                    @csrf

                    <div class="form-group">
                        <label for="modal_create_name">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_create_name" name="name" required>
                         {{-- No @error here, validation handling via JS/redirect --}}
                    </div>

                    <div class="form-group">
                        <label for="modal_create_description">Deskripsi</label>
                        <textarea class="form-control" id="modal_create_description" name="description" rows="3"></textarea>
                         {{-- No @error here --}}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_price">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal_create_price" name="price" min="0" step="1000" required>
                                 {{-- No @error here --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_original_price">Harga Asli (Rp)</label>
                                <input type="number" class="form-control" id="modal_create_original_price" name="original_price" min="0" step="1000">
                                 {{-- No @error here --}}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_category">Kategori <span class="text-danger">*</span></label>
                                <select class="form-control" id="modal_create_category" name="category" required>
                                    <option value="handphone">Handphone</option>
                                    <option value="accessory">Accessory</option>
                                </select>
                                 {{-- No @error here --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_stock">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal_create_stock" name="stock" value="0" min="0" required>
                                 {{-- No @error here --}}
                            </div>
                        </div>
                    </div>

                    {{-- Multi-Color Input Section (Modal) --}}
                     <div class="form-group">
                        <label for="modal_create_temp_color">Pilih Warna</label> {{-- Label for the temporary picker input --}}
                         {{-- data-color will set the initial picker value when initialized --}}
                         {{-- Use old() for the temporary input value, fallback to a default --}}
                        <div class="input-group colorpicker-element" data-color="{{ old('_modal_create_temp_color', '#FFFFFF') }}">
                             <div class="input-group-prepend">
                                {{-- This span and its <i> icon will be the clickable swatch --}}
                                <span class="input-group-text colorpicker-color"><i></i></span>
                             </div>
                             {{-- This input holds the CURRENTLY SELECTED color in the picker UI --}}
                            <input type="text" class="form-control" id="modal_create_temp_color" value="{{ old('_modal_create_temp_color', '#FFFFFF') }}" autocomplete="off">
                            <div class="input-group-append">
                                 <button class="btn btn-outline-secondary btn-eyedropper" type="button" title="Pick color from screen">
                                     <i class="fa fa-eye-dropper"></i>
                                 </button>
                                {{-- This button adds the color from the temp input to the list --}}
                                <button class="btn btn-outline-primary btn-add-color" type="button" data-target="modal-create">
                                     <i class="fa fa-plus"></i> Tambah
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Pilih warna menggunakan pemilih atau masukkan kode hex, lalu klik "Tambah". Tombol pipet hanya berfungsi di browser yang mendukung.</small>

                         {{-- Display Area for Selected Colors --}}
                        <div id="selected-colors-list-modal-create" class="mt-2 selected-colors-list"> {{-- Added class --}}
                            {{-- Selected colors will be displayed here by JS --}}
                        </div>

                        {{-- Hidden Input to Store Comma-Separated VALID Hex Colors for Submission --}}
                         <input type="hidden" name="color" id="product_colors_input_modal_create" value="{{ old('color', '') }}">
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image">Foto Produk 1</label>
                         {{-- Updated accept attribute --}}
                        <input type="file" class="form-control" id="modal_create_image" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                         {{-- No @error here --}}
                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small> {{-- Updated info --}}
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image2">Foto Produk 2</label>
                         {{-- Updated accept attribute --}}
                        <input type="file" class="form-control" id="modal_create_image2" name="image2" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                         {{-- No @error here --}}
                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small> {{-- Updated info --}}
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image3">Foto Produk 3</label>
                         {{-- Updated accept attribute --}}
                        <input type="file" class="form-control" id="modal_create_image3" name="image3" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                         {{-- No @error here --}}
                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small> {{-- Updated info --}}
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="modal_create_is_featured" name="is_featured" value="1">
                            <label class="custom-control-label" for="modal_create_is_featured">Produk Unggulan</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="modal-create-submit">Tambahkan Produk</button>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
{{-- Bootstrap Colorpicker JS --}}
{{-- Pastikan URL ini benar-benar dapat diakses dan filenya ada --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script>

<script>
$(document).ready(function() {

    // --- State Variables for Selected Colors ---
    // Use arrays to store selected colors for each context (edit tab, create modal).
    // These arrays temporarily hold colors, including potentially invalid ones typed by the user,
    // for display purposes. The hidden input only stores valid hex codes.
    let selectedColorsEdit = [];
    let selectedColorsModalCreate = [];

    // --- Helper Functions ---

    // Check if a string is a valid hex color (#RGB or #RRGGBB), case-insensitive.
    function isHexColor(hex) {
         if (!hex || typeof hex !== 'string') return false;
         // Remove potential leading/trailing whitespace and convert to uppercase for consistent check
         hex = hex.trim().toUpperCase();
        return /^#([A-FA-F0-9]{6}|[A-FA-F0-9]{3})$/.test(hex);
    }

    // Update the visual list of selected colors below the picker input
    // $listElement: The div where the color items are displayed (e.g., #selected-colors-list-edit)
    // colorsArray: The JS array holding the color strings for this context
    // inputId: A string identifier ('edit', 'modal-create') to target the correct remove buttons
    function updateSelectedColorsDisplay($listElement, colorsArray, inputId) {
        $listElement.empty(); // Clear the current list display
        if (!colorsArray || colorsArray.length === 0) {
             return; // Do nothing if the array is empty
        }

        colorsArray.forEach(color => {
            const trimmedColor = color.trim().toUpperCase(); // Trim and uppercase for consistency
            const isValid = isHexColor(trimmedColor);
            // Display the original string input by the user, but add '(Invalid Format)' if not hex
            const displayColor = trimmedColor + (isValid ? '' : ' (Format Invalid)'); // Lebih singkat
            const swatchHtml = isValid ? `<span class="color-swatch" style="background-color: ${trimmedColor};"></span>` : '';
            const itemClass = isValid ? 'selected-color-item' : 'selected-color-item text-danger border-danger'; // Add classes for invalid

            $listElement.append(`
                <span class="${itemClass}">
                    ${swatchHtml}
                    <span class="color-hex">${displayColor}</span>
                    <button type="button" class="btn-remove-color" data-color="${trimmedColor}" data-input-id="${inputId}">×</button>
                </span>
            `);
        });
    }


    // Update the value of the hidden input field for form submission
    // This input MUST only contain valid hex colors separated by commas.
    function updateHiddenColorInput($hiddenInput, colorsArray) {
        // Filter out any potentially invalid colors before joining for submission
        const validColors = colorsArray
                                .map(c => c.trim().toUpperCase()) // Trim and uppercase before checking
                                .filter(isHexColor); // Keep only valid hex codes

        $hiddenInput.val(validColors.join(','));
    }

     // Load colors from the hidden input (existing data or old input) on page/tab/modal load
    function loadInitialColors(inputId) {
        const $hiddenInput = $(`#product_colors_input_${inputId}`);
        const colorsString = $hiddenInput.val();
        let colorsArray = [];
        if (colorsString) {
             // Split by comma, trim whitespace, convert to uppercase.
             // Importantly, we KEEP potentially invalid ones in this temporary array for *display purposes*
             // so the user sees what they (or previous input) entered, even if it's wrong.
            colorsArray = colorsString.split(',')
                                     .map(c => c.trim().toUpperCase())
                                     .filter(c => c.length > 0); // Filter out empty strings from split
        }

        // Update the correct state array based on inputId
        if (inputId === 'edit') {
            selectedColorsEdit = colorsArray;
        } else if (inputId === 'modal-create') {
             selectedColorsModalCreate = colorsArray;
        } else {
             console.error('Invalid inputId for loadInitialColors:', inputId);
             return;
        }

        // Update the display for the current form context
        const $listElement = $(`#selected-colors-list-${inputId}`);
        updateSelectedColorsDisplay($listElement, colorsArray, inputId);

        // Ensure the hidden input ONLY contains valid hex colors after loading.
        // This prevents invalid data from being submitted even if loaded into the display.
        updateHiddenColorInput($hiddenInput, colorsArray);

         // Update preview if applicable after colors are loaded
         if (inputId === 'edit') updateEditPreview();
         // No preview update for modal in this example, but could be added.
    }

    // --- Color Picker Initialization ---

    // Function to initialize a Bootstrap Colorpicker instance on a specific wrapper element (.colorpicker-element)
    function initializeColorPicker($element) {
        // Find the input element within the wrapper
        const $input = $element.find('input[type="text"].form-control');
        // Find the swatch icon element
        const $swatchIcon = $element.find('.input-group-text i');

        // Get the initial color from the input or data-color attribute
        const initialColor = $input.val() || $element.data('color') || '#FFFFFF';

        // Set initial swatch and input value based on a valid hex or default
        if (isHexColor(initialColor)) {
            $input.val(initialColor.toUpperCase());
            $swatchIcon.css('background-color', initialColor);
        } else {
            // If initial value is invalid, set input and swatch to default white
             $input.val('#FFFFFF');
             $swatchIcon.css('background-color', '#FFFFFF');
        }


        // Destroy any existing instance before initializing to prevent duplicates
         if ($element.data('colorpicker')) {
             // console.log('Destroying existing colorpicker instance for', $input.attr('id')); // Debugging
             $element.colorpicker('destroy');
         }

        // console.log('Initializing colorpicker for', $input.attr('id'), 'with initial value:', $input.val()); // Debugging

        $element.colorpicker({
            format: 'hex', // Ensure hex format
            autoInputFallback: false, // Don't auto-fill input on initialization
            useAlpha: false, // Disable alpha channel for simplicity
            inline: false, // Use dropdown mode
            container: true, // Append picker dropdown to the body (recommended for modals/complex layouts)
            // Add some suggested swatches (optional)
            extensions: [{
                name: 'swatches',
                options: {
                    colors: {
                         'Red': '#F44336', 'Pink': '#E91E63', 'Purple': '#9C27B0', 'Deep Purple': '#673AB7',
                         'Indigo': '#3F51B5', 'Blue': '#2196F3', 'Light Blue': '#03A9F4', 'Cyan': '#00BCD4',
                         'Teal': '#009688', 'Green': '#4CAF50', 'Light Green': '#8BC34A', 'Lime': '#CDDC39',
                         'Yellow': '#FFEB3B', 'Amber': '#FFC107', 'Orange': '#FF9800', 'Deep Orange': '#FF5722',
                         'Brown': '#795548', 'Gray': '#9E9E9E', 'Blue Grey': '#607D8B', 'Black': '#000000', 'White': '#FFFFFF'
                    },
                    namesAsValues: false // Use hex values, not names
                }
            }]
        })
         // Bind events for picker interaction
         .on('colorpickerCreate', function(e) {
             // console.log('colorpickerCreate event for', $input.attr('id')); // Debugging
              // This fires after the picker structure is built but before it's shown/hidden
              // The initial color should have already been set before init, but ensure picker's internal state matches input
              const currentValue = $input.val();
              if (isHexColor(currentValue)) {
                  try {
                       // Setting value here ensures the picker UI matches the input initially
                       $element.colorpicker('setValue', currentValue);
                  } catch (err) {
                       console.error('Error setting value on colorpickerCreate:', err);
                  }
              }
         })
        .on('colorpickerChange', function(e) {
            // This fires as the user interacts with the picker UI (sliders, grid, swatches)
            // e.color contains the Color object, e.value contains the formatted string (hex)
            // console.log('colorpickerChange event for', $input.attr('id'), ':', e.value); // Debugging
            const hexColor = e.value ? e.value.toUpperCase() : $input.val().toUpperCase();
             // Update the input field and swatch icon immediately if it's a valid hex provided by the picker
            if (isHexColor(hexColor)) { // Check e.value or the resulting input value
                $input.val(hexColor);
                $swatchIcon.css('background-color', hexColor);
                // No need to set picker value again here, as it originated from picker interaction
            } else {
                // This case shouldn't happen for picker-driven changes with format: 'hex'
                console.warn('colorpickerChange provided invalid hex:', hexColor); // Debugging
            }
        })
         .on('colorpickerHide', function(e) {
              // console.log('colorpickerHide event for', $input.attr('id')); // Debugging
              // This fires when the picker dropdown is closed
              // Ensure the input and swatch reflect the final selected color from the picker
              const finalColor = e.value ? e.value.toUpperCase() : $input.val().toUpperCase();
              if (isHexColor(finalColor)) {
                  $input.val(finalColor); // Ensure input has the final valid hex
                  $swatchIcon.css('background-color', finalColor);
              } else {
                  // If for some reason the final value is invalid (shouldn't happen with format:hex),
                  // revert input/swatch to a default or previous valid state if possible.
                   // Let's default to white if invalid on hide.
                   $input.val('#FFFFFF');
                   $swatchIcon.css('background-color', '#FFFFFF');
                   console.warn('Invalid hex on colorpickerHide, resetting to #FFFFFF:', finalColor);
              }
         });

         // Handle direct input typing - sync swatch and picker's internal value
         // Use .off().on() with namespaced event to prevent multiple bindings if init runs again
         $input.off('input.colorpicker').on('input.colorpicker', function() {
             const typedColor = $(this).val().trim().toUpperCase();
             // console.log('Input typing for', $(this).attr('id'), ':', typedColor); // Debugging

              if (isHexColor(typedColor)) {
                  $swatchIcon.css('background-color', typedColor);
                  // Update the picker's internal value so it opens to this color next time
                   try {
                       $element.colorpicker('setValue', typedColor);
                       // console.log('Picker value set by typing:', typedColor); // Debugging
                   } catch (e) {
                        console.error('Error setting colorpicker value on input:', e);
                   }
              } else {
                   // If typing makes it temporarily invalid, update swatch to default
                   // (or keep the last valid color from the picker if preferred)
                   $swatchIcon.css('background-color', '#FFFFFF'); // Or use a visual indicator of invalidity
              }
         });

         // Handle click on the input itself to open picker
         $input.off('click.colorpicker').on('click.colorpicker', function(e) {
              // console.log('Input clicked for', $(this).attr('id'), ', attempting to show picker.'); // Debugging
              // Prevent default behavior that might interfere
              // e.preventDefault(); // Might interfere with input focus if not needed
              try {
                  // Check if picker is already open to avoid flickering/re-opening
                  if (!$element.hasClass('colorpicker-visible')) {
                       $element.colorpicker('show'); // Call show on the wrapper element
                  } else {
                       // console.log('Picker already visible.'); // Debugging
                  }
              } catch (e) {
                   console.error('Error showing colorpicker on input click:', e);
              }
         });

         // Handle click on swatch icon to open picker
         $element.find('.input-group-text.colorpicker-color').off('click.colorpicker').on('click.colorpicker', function() {
              // console.log('Swatch icon clicked for', $input.attr('id'), ', attempting to show picker.'); // Debugging
              try {
                   // Check if picker is already open
                  if (!$element.hasClass('colorpicker-visible')) {
                      $element.colorpicker('show'); // Call show on the wrapper element
                  } else {
                       // console.log('Picker already visible.'); // Debugging
                  }
              } catch (e) {
                   console.error('Error showing colorpicker on swatch click:', e);
              }
         });

         // After initialization, ensure the picker's internal value matches the input's current value
         // (This is belt-and-suspenders with colorpickerCreate, but helpful)
         const currentValue = $input.val();
         if (isHexColor(currentValue)) {
             try {
                  $element.colorpicker('setValue', currentValue);
             } catch (err) {
                  console.error('Error setting value after init:', err);
             }
         }
    }

    // --- Event Handlers ---

    // Handle "Remove" button click on selected color items (delegated event)
    // Event delegation is necessary because these buttons are added dynamically
    $(document).on('click', '.btn-remove-color', function() {
        // Get the color string exactly as it is displayed/stored in the data attribute
        const colorToRemove = $(this).data('color');
        const inputId = $(this).data('input-id'); // e.g., 'edit', 'modal-create'

        let colorsArray;
        let $listElement;
        let $hiddenInput;

        // Determine which state array and DOM elements to update
        if (inputId === 'edit') {
            colorsArray = selectedColorsEdit;
             $listElement = $('#selected-colors-list-edit');
             $hiddenInput = $('#product_colors_input_edit');
        } else if (inputId === 'modal-create') {
            colorsArray = selectedColorsModalCreate;
             $listElement = $('#selected-colors-list-modal-create');
             $hiddenInput = $('#product_colors_input_modal_create');
        } else {
             console.error('Unknown input ID for remove button:', inputId);
             return;
        }

        // Find the index of the color to remove in the state array
        // We need to match the exact string stored in the array (which might include ' (Invalid Format)')
         const index = colorsArray.indexOf(colorToRemove);

        // If found, remove it from the array
        if (index > -1) {
            colorsArray.splice(index, 1); // Remove the color
        } else {
             console.warn(`Color "${colorToRemove}" not found in state array for ${inputId}`);
             return; // Color not found, shouldn't happen but good check
        }


        // Update the visual display and the hidden input
        updateSelectedColorsDisplay($listElement, colorsArray, inputId); // Display ALL colors including invalid ones
        updateHiddenColorInput($hiddenInput, colorsArray); // Hidden input only gets VALID colors

         // Update the preview for the relevant form
         if (inputId === 'edit') {
             updateEditPreview();
         }
         // No preview update for modal in this example
    });


    // Handle "Add Color" button click
    $('.btn-add-color').on('click', function() {
         const targetId = $(this).data('target'); // 'edit' or 'modal-create'
         let $tempInput; // The input field linked to the color picker
         let colorsArray; // The state array for selected colors
         let $listElement; // The div where selected colors are displayed
         let $hiddenInput; // The hidden input for form submission

         // Determine which set of elements to use based on data-target
         if (targetId === 'edit') {
            $tempInput = $('#edit_temp_color');
            colorsArray = selectedColorsEdit;
            $listElement = $('#selected-colors-list-edit');
            $hiddenInput = $('#product_colors_input_edit');
         } else if (targetId === 'modal-create') {
             $tempInput = $('#modal_create_temp_color');
             colorsArray = selectedColorsModalCreate;
             $listElement = $('#selected-colors-list-modal-create');
             $hiddenInput = $('#product_colors_input_modal_create');
         } else {
             console.error('Unknown target ID for add button:', targetId);
             return;
         }

        const newColor = $tempInput.val().trim().toUpperCase(); // Get the value from the temp input (trimmed, uppercase)

         // Prevent adding empty strings
         if (newColor.length === 0) {
             // alert('Silakan pilih atau masukkan warna.'); // Already handled by required on input
             return;
         }

         // Check if the trimmed/uppercased color string is already in the array
         // This handles checking "#F00" vs "#FF0000", or "invalid" vs "INVALID"
         if (colorsArray.includes(newColor)) {
              alert(`Warna ${newColor} sudah ditambahkan.`);
               return; // Stop here if duplicate
         }

         // Add the new color (trimmed and uppercased) to the state array.
         // We store the potentially invalid format string here for display purposes.
         colorsArray.push(newColor);

        // Update the visual display and the hidden input
        updateSelectedColorsDisplay($listElement, colorsArray, targetId); // Display ALL colors including invalid ones
        updateHiddenColorInput($hiddenInput, colorsArray); // Hidden input only gets VALID colors

        // Optional: Clear the temporary input and reset picker visual after adding IF the color added was valid hex
         if (isHexColor(newColor)) {
              $tempInput.val('#FFFFFF'); // Reset temp input value
              try {
                  // Update the picker's internal state and swatch visual to the default white
                   $tempInput.closest('.colorpicker-element').colorpicker('setValue', '#FFFFFF');
              } catch (e) {
                   console.error('Error setting colorpicker value after adding valid color:', e);
              }
         } else {
             // If an invalid color was added, leave it in the input so the user can correct it
             // Or clear it if you prefer, but leaving it might be more user-friendly for correction.
             // Let's leave it for now.
         }


        // Update the preview for the relevant form
         if (targetId === 'edit') {
            updateEditPreview();
         }
         // No preview update for modal create in this example
    });


    // Handle Eyedropper button click (delegated event)
     $(document).on('click', '.btn-eyedropper', function() {
         // Check if the EyeDropper API is supported by the browser
         if ('EyeDropper' in window) {
             const eyeDropper = new EyeDropper();
             // Find the temporary color input associated with this button
             const $tempInput = $(this).closest('.input-group').find('input[type="text"].form-control');
             const $colorPickerElement = $tempInput.closest('.colorpicker-element');


             eyeDropper.open()
                 .then(result => {
                     const pickedColor = result.sRGBHex.toUpperCase();
                     // Set the input value
                     $tempInput.val(pickedColor);
                     // Update the colorpicker instance value and swatch icon
                     try {
                          $colorPickerElement.colorpicker('setValue', pickedColor);
                     } catch (e) {
                          console.error('Error setting colorpicker value after eyedropper pick:', e);
                     }

                     // Note: The color is NOT automatically added to the list here.
                     // The user must still click the "Tambah" button after picking.
                     // console.log('Eyedropper picked color:', pickedColor); // Debugging
                 })
                 .catch(e => {
                     // Handle cases where the user cancels or picker fails (e.g., security restrictions)
                     console.log('Eyedropper canceled or failed:', e);
                      // Optionally show a message to the user
                 });
         } else {
             // Fallback for browsers that do not support the EyeDropper API
             alert('Fungsionalitas pipet tidak didukung di browser ini. Silakan gunakan pemilih warna atau masukkan kode hex secara manual.');
             console.log('EyeDropper API not supported in this browser.');
         }
     });


    // --- Preview Logic ---
    // Helper function to format price with commas (Indonesian format)
    function formatPrice(price) {
         const num = parseFloat(price);
         if (isNaN(num) || num < 0) {
             return '0'; // Or '-' or handle as needed
         }
         // Use Intl.NumberFormat for locale-aware formatting
        try {
            return new Intl.NumberFormat('id-ID').format(num);
        } catch (e) {
             console.error('Error formatting price:', e);
             return num.toString(); // Fallback to simple string
        }
    }

    // Create the HTML string for a preview card
    function createPreviewCardHtml(data) {
        let imageHtml;

        // Check if imageFile (new upload Base64) exists first
        if (data.imageFile) {
            imageHtml = `<div class="preview-image-container">
                            <img src="${data.imageFile}" alt="${data.name || 'Product Image'}" class="preview-image">
                          </div>`;
        } else if (data.imageUrl) {
            // Use existing image URL if no new file and URL exists
            imageHtml = `<div class="preview-image-container">
                            <img src="${data.imageUrl}" alt="${data.name || 'Product Image'}" class="preview-image">
                          </div>`;
        } else {
            // Placeholder if no image (new file or existing URL)
            imageHtml = `<div class="preview-image-container preview-no-image">
                            <i class="fa fa-image" style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-1 text-muted">No Image</p>
                          </div>`;
        }

        // Format prices
        const currentPrice = parseFloat(data.price);
        const originalPrice = parseFloat(data.originalPrice);
        const formattedPrice = 'Rp ' + formatPrice(currentPrice);
        // Only show original price if it's a number, greater than 0, and greater than current price
        const hasOriginalPrice = !isNaN(originalPrice) && originalPrice > 0 && originalPrice > currentPrice;
        const formattedOriginalPrice = hasOriginalPrice ? 'Rp ' + formatPrice(originalPrice) : null;

        // Display colors if any are selected - show swatches for valid hex
        let colorsHtml = '';
        if (data.colors && data.colors.length > 0) {
            // Filter for only valid hex colors for the preview swatches
            const validHexColors = data.colors
                                    .map(c => c.trim().toUpperCase()) // Trim and uppercase
                                    .filter(isHexColor); // Keep only valid hex

            if (validHexColors.length > 0) {
                colorsHtml = '<p class="card-text text-muted text-sm mb-1 preview-color-list">Warna: ';
                validHexColors.forEach((color, index) => {
                     colorsHtml += `<span class="preview-color-swatch" style="background-color: ${color};"></span>`;
                    // No need to display hex text in swatch preview usually, just the color itself
                    // If you want text, add it: colorsHtml += `${color}`;
                    // if (index < validHexColors.length - 1) {
                    //     colorsHtml += ', '; // Comma between swatches if text is added
                    // }
                });
                colorsHtml += '</p>';
             } else {
                 // If only invalid colors are selected in the list, don't show the "Warna:" line
                  // colorsHtml = ''; // Or a message like '<p class="card-text text-muted text-sm mb-1">Warna: Tidak ada warna valid dipilih</p>';
             }
        }


        // Build the full preview card HTML
        return `
            <div class="preview-card card">
                ${imageHtml}
                <div class="card-body"> {{-- Removed p-3, default card-body padding is fine --}}
                    <h5 class="card-title text-truncate">${data.name || 'Nama Produk'}</h5> {{-- Removed mb-1, card-title has mb --}}
                     ${colorsHtml} {{-- Insert colors HTML here (only valid ones with swatches) --}}
                    <p class="card-text text-dark font-weight-bold mb-0">${formattedPrice}</p>
                    ${hasOriginalPrice ? `<p class="card-text text-muted line-through text-sm mt-0">${formattedOriginalPrice}</p>` : ''}
                    {{-- Optional: Add placeholder buttons --}}
                    <div class="d-flex mt-2">
                        <a href="#" class="btn btn-primary btn-sm mr-1 flex-fill disabled"><i class="fa fa-shopping-cart"></i> Keranjang</a>
                        <a href="#" class="btn btn-success btn-sm flex-fill disabled"><i class="fa fa-money-bill-alt"></i> Beli</a>
                    </div>
                </div>
            </div>
        `;
    }


    // Function to update the preview for the Edit tab
    function updateEditPreview() {
        // Get values from the edit form fields
        const name = $('#edit_name').val();
        const price = $('#edit_price').val();
        const originalPrice = $('#edit_original_price').val();
        const category = $('#edit_category').val();
        // Get the currently selected colors from the state array
        const colors = selectedColorsEdit;

        // Get the existing image URL if it's displayed next to the file input
        // We look for the image tag within the .mt-3 div sibling to the input
        let existingImageUrl = $('#edit_image').siblings('.mt-3').find('img').attr('src');

        const fileInput = document.getElementById('edit_image');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            // If a *new* file is selected, read it for preview (overrides existing)
            const reader = new FileReader();
            reader.onload = function(e) {
                 // Render preview using the *new* image data
                $('#edit-preview-container').html(createPreviewCardHtml({
                    name: name,
                    price: price,
                    originalPrice: originalPrice,
                    category: category,
                    colors: colors, // Use the array
                    imageUrl: null, // New file overrides existing URL for preview
                    imageFile: e.target.result // Use Base64 data
                }));
            };
             reader.onerror = function(e) {
                console.error('Error reading file for edit preview:', e);
                 // Render preview using existing image if new file read fails
                 $('#edit-preview-container').html(createPreviewCardHtml({
                     name: name, price: price, originalPrice: originalPrice, category: category, colors: colors, imageFile: null, imageUrl: existingImageUrl // Fallback to existing
                 }));
            };
            reader.readAsDataURL(fileInput.files[0]); // Read the new file as Base64
        } else {
             // If no new file is selected, render preview using the existing image URL (or null if none)
            $('#edit-preview-container').html(createPreviewCardHtml({
                name: name,
                price: price,
                originalPrice: originalPrice,
                category: category,
                colors: colors, // Use the array
                imageUrl: existingImageUrl, // Use the existing URL
                imageFile: null
            }));
        }
    }


    // --- Tab Activation & Initialization Logic ---

    // Get URL params once on document ready
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');

    // Function to handle tasks needed when a tab's content becomes active/visible
    function handleTabContentInitialized(tabId) {
        // console.log(`handleTabContentInitialized called for tab: "${tabId}"`); // Debugging

        // Initialize form states, color pickers, and previews for the active tab
        if (tabId === 'edit') {
             // console.log('Initializing Edit tab form state.'); // Debugging
             // Load existing/old colors for the edit form
             loadInitialColors('edit'); // Populates selectedColorsEdit & updates hidden input
             // Initialize the color picker for the edit tab
             const $colorPickerElement = $('#edit_temp_color').closest('.colorpicker-element');
             initializeColorPicker($colorPickerElement); // Reads current value from input/data-color
              // Update preview based on loaded state (color + other fields)
             updateEditPreview();
        }
         // No specific setup needed for the 'list' tab beyond its content rendering.
         // Create modal initialization is handled by modal events ('shown.bs.modal').
         // console.log('handleTabContentInitialized finished.'); // Debugging
    }

    // Activate the correct tab based on the URL parameter or default ('list')
    // Use Bootstrap's `tab('show')` which also emits `shown.bs.tab`
     const defaultTab = 'list';
     const targetTabId = tabParam && $(`#productTabs a[href="#${tabParam}"]`).length ? tabParam : defaultTab;

     // Activate the tab programmatically
     $(`#productTabs a[href="#${targetTabId}"]`).tab('show');


    // --- Event Listeners for Tab Activation ---
    // Listen for Bootstrap's 'shown.bs.tab' event
    // This ensures the tab content is visible and in the DOM before initialization
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        const tabId = $(e.target).attr('href').substring(1); // Get the ID of the newly active tab
        const previousTabId = $(e.relatedTarget).attr('href') ? $(e.relatedTarget).attr('href').substring(1) : null; // Get the ID of the previously active tab (if any)

        // Update URL only if the tab changed (excluding initial load where relatedTarget might be null)
        if (previousTabId !== tabId) {
             // console.log(`Tab switched to: ${tabId}`);
             const url = new URL(window.location);
             url.searchParams.set('tab', tabId);

              // Special handling for 'edit' tab: add/keep 'id' param
             if (tabId === 'edit' && !url.searchParams.has('id')) {
                 // If navigating to edit tab and no ID is in URL, maybe remove tab param or show error?
                 // Assuming 'id' is manually added via links from the list table.
                 // If we land on '?tab=edit' without an 'id', this won't automatically show an item.
                 // The server-side check `isset($editProduct)` handles displaying the edit form.
                  console.warn('Navigated to edit tab without an ID parameter.');
             } else if (tabId !== 'edit' && url.searchParams.has('id')) {
                  // If navigating away from edit tab, remove 'id' param
                  url.searchParams.delete('id');
             }

             // Preserve search query only if switching *within* the list context (to/from list)
             // Or if staying on list tab
            if (tabId === 'list') {
                 const currentSearch = $('#list form input[name="search"]').val();
                 if (currentSearch) {
                     url.searchParams.set('search', currentSearch);
                 } else {
                     url.searchParams.delete('search');
                 }
             } else {
                  // Clear search param if switching away from list tab
                  url.searchParams.delete('search');
             }


             window.history.pushState({}, '', url);
        } else {
            // console.log(`Shown event fired for already active tab: ${tabId}`);
        }

         // Now call the initialization handler for the newly active tab
         handleTabContentInitialized(tabId);
    });


    // --- Modal Handling ---

    // When the create modal is shown
    $('#createProductModal').on('shown.bs.modal', function() {
        // console.log('Modal shown. Initializing modal form and colorpicker.'); // Debugging

        // Reset the form inside the modal
        $('#modal-create-product-form')[0].reset();
        // Clear selected colors state and display for the modal
        selectedColorsModalCreate = [];
        $('#selected-colors-list-modal-create').empty();
        $('#product_colors_input_modal_create').val(''); // Clear hidden input

         // Reset the temporary color input and swatch visual state to default white
         $('#modal_create_temp_color').val('#FFFFFF');
         // Need to update the swatch visual separately if resetting the input
         $('#modal_create_temp_color').closest('.colorpicker-element').find('.input-group-text i').css('background-color', '#FFFFFF');


        // Initialize the color picker specifically for the modal form
        // Need to target the element *within* the modal after it's added to the DOM and visible
         const $modalColorPickerElement = $('#modal_create_temp_color').closest('.colorpicker-element');
         initializeColorPicker($modalColorPickerElement);

         // Load any old input colors if validation failed and modal was re-shown
         // Note: This will populate the list with any invalid colors from previous submission attempt
         loadInitialColors('modal-create');

          // console.log('Modal shown handler finished.'); // Debugging
    });

     // When the modal is hidden
    $('#createProductModal').on('hidden.bs.modal', function () {
        // console.log('Modal hidden. Resetting form state.'); // Debugging

        // Reset the form inside the modal
        $('#modal-create-product-form')[0].reset();
        // Clear selected colors state and display for the modal
        selectedColorsModalCreate = [];
        $('#selected-colors-list-modal-create').empty();
        $('#product_colors_input_modal_create').val(''); // Clear hidden input

         // Reset the temporary color input and swatch visual state
         $('#modal_create_temp_color').val('#FFFFFF');
         $('#modal_create_temp_color').closest('.colorpicker-element').find('.input-group-text i').css('background-color', '#FFFFFF');


         // Destroy the colorpicker instance to prevent issues if the modal is shown again
         // This is important if the picker appends elements outside the modal container.
         const $modalColorPickerElement = $('#modal_create_temp_color').closest('.colorpicker-element');
         if ($modalColorPickerElement.data('colorpicker')) {
             $modalColorPickerElement.colorpicker('destroy');
             // console.log('Modal colorpicker destroyed.'); // Debugging
         }
          // console.log('Modal hidden handler finished.'); // Debugging
    });

    // Handle modal submit button click
    $('#modal-create-submit').click(function() {
        // console.log('Modal submit button clicked.'); // Debugging
        // The hidden input for colors (`product_colors_input_modal_create`)
        // should already be updated by add/remove button clicks via updateHiddenColorInput.
        // We just need to submit the form.
        $('#modal-create-product-form').submit();
    });


    // --- Preview Updates on Form Input Change ---

    // Add input/change listeners for edit form fields that affect the preview
    $('#edit_name, #edit_price, #edit_original_price, #edit_category').on('input change', updateEditPreview);
    // Add change listener for edit form image file input
    $('#edit_image').on('change', updateEditPreview);

     // Note: Preview is also updated when colors are added/removed (handled in add/remove click handlers)

    // --- Initial Load ---
    // handleTabContentInitialized is called by the 'shown.bs.tab' listener which is triggered
    // by the initial `tab('show')` call. This covers the first load.


});
</script>
@endpush