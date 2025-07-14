@extends('layouts.main')

@section('title', 'Product Management')

@push('styles')
<style>
    /* --- General Form Styling --- */
    .form-group label {
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    .form-control.is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    /* --- Multi-Color Picker Styling --- */
    .color-picker-container {
        margin-top: 10px;
    }
    .color-input-group {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .color-input {
        width: 80px;
        height: 40px;
        padding: 0;
        border: none;
        cursor: pointer;
    }
    .color-preview {
        width: 30px;
        height: 30px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        display: inline-block;
        margin-left: 10px;
        vertical-align: middle;
    }
    .add-color-btn {
        margin-left: 10px;
        padding: 5px 10px;
        font-size: 0.9rem;
    }
    .remove-color-btn {
        margin-left: 5px;
        padding: 2px 6px;
        font-size: 0.8rem;
        color: #dc3545;
        border: 1px solid #dc3545;
        background: transparent;
    }
    .remove-color-btn:hover {
        background: #dc3545;
        color: #fff;
    }

    /* --- Preview Card Styling --- */
    .preview-container {
        display: flex;
        justify-content: center;
        padding: 10px;
    }
    .preview-card {
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        background: #fff;
        width: 100%;
        max-width: 250px;
    }
    .preview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    .preview-image-container {
        width: 100%;
        height: 180px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-bottom: 1px solid #eee;
    }
    .preview-image-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    .preview-no-image {
        color: #6c757d;
        text-align: center;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }
    .preview-no-image .fa-image {
        margin-bottom: 10px;
    }
    .preview-card .card-body {
        padding: 15px;
    }
    .preview-card .card-title {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        text-align: center;
    }
    .preview-card .card-text {
        font-size: 0.85rem;
        color: #555;
        margin-bottom: 0.25rem;
        text-align: center;
    }
    .preview-color-list {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
        display: flex;
        justify-content: center;
        gap: 5px;
    }
    .preview-color-swatch {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        border: 1px solid rgba(0,0,0,0.2);
        display: inline-block;
    }
    .line-through {
        text-decoration: line-through;
    }
</style>
@endpush

@section('content')
<div class="panel-header bg-primary-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="text-white pb-2 fw-bold">Management Products</h2>
                <h5 class="text-white op-7 mb-2">Manage Products Konter</h5>
            </div>
        </div>
    </div>
</div>
<br><br>

<div class="page-inner mt--5">
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ (request('tab', 'list') === 'list') ? 'active' : '' }}"
                id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list"
                aria-selected="{{ (request('tab', 'list') === 'list') ? 'true' : 'false' }}">
                <i class="fa fa-list"></i> List Produk
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request('tab') === 'create') ? 'active' : '' }}"
                id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create"
                aria-selected="{{ (request('tab') === 'create') ? 'true' : 'false' }}">
                <i class="fa fa-plus"></i> Tambah Produk Baru
            </a>
        </li>
        @if(isset($editProduct) && request('tab') === 'edit')
            <li class="nav-item">
                <a class="nav-link active" id="edit-tab" data-toggle="tab" href="#edit" role="tab"
                    aria-controls="edit" aria-selected="true">
                    <i class="fa fa-edit"></i> Edit Produk
                </a>
            </li>
        @endif
    </ul>

    <!-- Tab Content -->
    <div class="tab-content mt-2" id="productTabsContent">
        <!-- List Tab Content -->
        <div class="tab-pane fade {{ (request('tab', 'list') === 'list') ? 'show active' : '' }}" id="list" role="tabpanel" aria-labelledby="list-tab">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Semua Produk</h4>
                        <form class="ml-auto" action="{{ route('admin.products') }}" method="GET">
                            <input type="hidden" name="tab" value="list">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari produk..." value="{{ request('search') }}">
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
                                    <th>Merk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Harga Asli</th>
                                    <th>Stok</th>
                                    <th>Warna</th>
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
                                        <td>{{ ucfirst($product->brand) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $product->category == 'handphone' ? 'primary' : 'info' }}">
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
                                        <td>
                                            @if($product->colors)
                                                @foreach(json_decode($product->colors, true) as $color)
                                                    <span class="color-swatch" style="background-color: {{ $color }};"></span>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.products') }}?tab=edit&id={{ $product->id }}" class="btn btn-sm btn-warning mx-1">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-info mx-1" data-toggle="modal" data-target="#viewProductModal{{ $product->id }}">
                                                    <i class="fa fa-eye"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger mx-1" data-toggle="modal" data-target="#deleteProductModal{{ $product->id }}">
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
                                                                            @if(count($images) > 1)
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
                                                                            <th>Brand</th>
                                                                            <td>{{ ucfirst($product->brand) }}</td>
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
                                                                            <th>Warna</th>
                                                                            <td>
                                                                                @if($product->colors)
                                                                                    @foreach(json_decode($product->colors, true) as $color)
                                                                                        <span class="color-swatch" style="background-color: {{ $color }};"></span>
                                                                                    @endforeach
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
                                    <tr>
                                        <td colspan="10" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Tab Content -->
        <div class="tab-pane fade {{ (request('tab') === 'create') ? 'show active' : '' }}" id="create" role="tabpanel" aria-labelledby="create-tab">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Produk Baru</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h5>Preview Card:</h5>
                                    <div id="create-preview-container" class="preview-container"></div>
                                    <small class="form-text text-muted mt-2 text-center">Ini tampilan perkiraan di halaman pembeli.</small>
                                </div>
                                <div class="col-md-6"></div>
                            </div>
                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="create-product-form">
                                @csrf

                                <div class="form-group">
                                    <label for="create_name">Nama Produk <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="create_name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="create_brand">Merk <span class="text-danger">*</span></label>
                                    <select class="form-control @error('brand') is-invalid @enderror" id="create_brand" name="brand" required>
                                        <option value="" disabled {{ old('brand') ? '' : 'selected' }}>Pilih Merk</option>
                                        <option value="samsung" {{ old('brand') == 'samsung' ? 'selected' : '' }}>Samsung</option>
                                        <option value="apple" {{ old('brand') == 'apple' ? 'selected' : '' }}>Apple</option>
                                        <option value="xiaomi" {{ old('brand') == 'xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                                        <option value="oppo" {{ old('brand') == 'oppo' ? 'selected' : '' }}>OPPO</option>
                                        <option value="vivo" {{ old('brand') == 'vivo' ? 'selected' : '' }}>Vivo</option>
                                        <option value="realme" {{ old('brand') == 'realme' ? 'selected' : '' }}>Realme</option>
                                        <option value="other" {{ old('brand') == 'other' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('brand')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="create_description">Deskripsi</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="create_description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="create_price">Harga (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="create_price" name="price" value="{{ old('price') }}" min="0" step="1000" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="create_original_price">Harga Asli (Rp)</label>
                                            <input type="number" class="form-control @error('original_price') is-invalid @enderror" id="create_original_price" name="original_price" value="{{ old('original_price') }}" min="0" step="1000">
                                            @error('original_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="create_category">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-control @error('category') is-invalid @enderror" id="create_category" name="category" required>
                                                <option value="handphone" {{ old('category') == 'handphone' ? 'selected' : '' }}>Handphone</option>
                                                <option value="accessory" {{ old('category') == 'accessory' ? 'selected' : '' }}>Accessory</option>
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="create_stock">Stok <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="create_stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group color-picker-container">
                                    <label>Pilih Warna</label>
                                    <div id="create-color-inputs">
                                        <div class="color-input-group">
                                            <input type="color" class="color-input" name="colors[]" value="{{ old('colors.0', '#000000') }}">
                                            <span class="color-preview" data-index="0" style="background-color: {{ old('colors.0', '#000000') }};"></span>
                                            <button type="button" class="remove-color-btn" style="display: none;">Hapus</button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary add-color-btn" id="add-color-btn">Tambah Warna</button>
                                    @error('colors.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Pilih warna untuk produk (maksimum 5 warna).</small>
                                </div>

                                <div class="form-group">
                                    <label for="create_image">Foto Produk 1</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="create_image" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                                </div>

                                <div class="form-group">
                                    <label for="create_image2">Foto Produk 2</label>
                                    <input type="file" class="form-control @error('image2') is-invalid @enderror" id="create_image2" name="image2" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    @error('image2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                                </div>

                                <div class="form-group">
                                    <label for="create_image3">Foto Produk 3</label>
                                    <input type="file" class="form-control @error('image3') is-invalid @enderror" id="create_image3" name="image3" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    @error('image3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="create_is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="create_is_featured">Produk Unggulan</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Tambahkan Produk</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Tab Content -->
        @if(isset($editProduct) && request('tab') === 'edit')
            <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Produk</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h5>Preview Card:</h5>
                                        <div id="edit-preview-container" class="preview-container"></div>
                                        <small class="form-text text-muted mt-2 text-center">Ini tampilan perkiraan di halaman pembeli.</small>
                                    </div>
                                    <div class="col-md-6"></div>
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
                                        <label for="edit_brand">Merk <span class="text-danger">*</span></label>
                                        <select class="form-control @error('brand') is-invalid @enderror" id="edit_brand" name="brand" required>
                                            <option value="" disabled>Pilih Merk</option>
                                            <option value="samsung" {{ old('brand', $editProduct->brand) == 'samsung' ? 'selected' : '' }}>Samsung</option>
                                            <option value="apple" {{ old('brand', $editProduct->brand) == 'apple' ? 'selected' : '' }}>Apple</option>
                                            <option value="xiaomi" {{ old('brand', $editProduct->brand) == 'xiaomi' ? 'selected' : '' }}>Xiaomi</option>
                                            <option value="oppo" {{ old('brand', $editProduct->brand) == 'oppo' ? 'selected' : '' }}>OPPO</option>
                                            <option value="vivo" {{ old('brand', $editProduct->brand) == 'vivo' ? 'selected' : '' }}>Vivo</option>
                                            <option value="realme" {{ old('brand', $editProduct->brand) == 'realme' ? 'selected' : '' }}>Realme</option>
                                            <option value="other" {{ old('brand', $editProduct->brand) == 'other' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        @error('brand')
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

                                    <div class="form-group color-picker-container">
                                        <label>Pilih Warna</label>
                                        <div id="edit-color-inputs">
                                            @php
                                                $existingColors = old('colors', json_decode($editProduct->colors, true) ?: ['#000000']);
                                                foreach ($existingColors as $index => $color) {
                                                    $color = $color ?: '#000000';
                                            @endphp
                                            <div class="color-input-group">
                                                <input type="color" class="color-input" name="colors[]" value="{{ $color }}">
                                                <span class="color-preview" data-index="{{ $index }}" style="background-color: {{ $color }};"></span>
                                                <button type="button" class="remove-color-btn {{ $index == 0 ? 'd-none' : '' }}">Hapus</button>
                                            </div>
                                            @php } @endphp
                                        </div>
                                        <button type="button" class="btn btn-primary add-color-btn" id="add-color-btn">Tambah Warna</button>
                                        @error('colors.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Pilih warna untuk produk (maksimum 5 warna).</small>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_image">Foto Produk 1</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="edit_image" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                                        @if($editProduct->image)
                                            <div class="mt-3">
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
                                        <input type="file" class="form-control @error('image2') is-invalid @enderror" id="edit_image2" name="image2" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                        @error('image2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                                        @if($editProduct->image2)
                                            <div class="mt-3">
                                                <img src="{{ asset('storage/' . $editProduct->image2) }}" alt="{{ $editProduct->name }}" class="product-detail-image">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_image3">Foto Produk 3</label>
                                        <input type="file" class="form-control @error('image3') is-invalid @enderror" id="edit_image3" name="image3" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                        @error('image3')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                                        @if($editProduct->image3)
                                            <div class="mt-3">
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

<!-- Create Product Modal -->
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
                    </div>

                    <div class="form-group">
                        <label for="modal_create_brand">Merk <span class="text-danger">*</span></label>
                        <select class="form-control" id="modal_create_brand" name="brand" required>
                            <option value="" disabled selected>Pilih Merk</option>
                            <option value="samsung">Samsung</option>
                            <option value="apple">Apple</option>
                            <option value="xiaomi">Xiaomi</option>
                            <option value="oppo">OPPO</option>
                            <option value="vivo">Vivo</option>
                            <option value="realme">Realme</option>
                            <option value="other">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modal_create_description">Deskripsi</label>
                        <textarea class="form-control" id="modal_create_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_price">Harga (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal_create_price" name="price" min="0" step="1000" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_original_price">Harga Asli (Rp)</label>
                                <input type="number" class="form-control" id="modal_create_original_price" name="original_price" min="0" step="1000">
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
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_stock">Stok <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal_create_stock" name="stock" value="0" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group color-picker-container">
                        <label>Pilih Warna</label>
                        <div id="modal-create-color-inputs">
                            <div class="color-input-group">
                                <input type="color" class="color-input" name="colors[]" value="#000000">
                                <span class="color-preview" data-index="0" style="background-color: #000000;"></span>
                                <button type="button" class="remove-color-btn" style="display: none;">Hapus</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary add-color-btn" id="modal-add-color-btn">Tambah Warna</button>
                        <small class="form-text text-muted">Pilih warna untuk produk (maksimum 5 warna).</small>
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image">Foto Produk 1</label>
                        <input type="file" class="form-control" id="modal_create_image" name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image2">Foto Produk 2</label>
                        <input type="file" class="form-control" id="modal_create_image2" name="image2" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image3">Foto Produk 3</label>
                        <input type="file" class="form-control" id="modal_create_image3" name="image3" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                        <small class="form-text text-muted">Ukuran rekomendasi: 400x400 pixels (JPG, JPEG, PNG)</small>
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
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    // DataTable initialization
    $('#basic-datatables').DataTable({
        pageLength: 10,
        searching: false,
        ordering: true,
        serverSide: false,
        paging: true,
        lengthChange: false,
        info: true,
        language: {
            paginate: {
                previous: '<i class="fa fa-angle-left"></i>',
                next: '<i class="fa fa-angle-right"></i>'
            }
        }
    });

    // Preview logic
    function formatPrice(price) {
        const num = parseFloat(price);
        if (isNaN(num) || num < 0) {
            return '0';
        }
        try {
            return new Intl.NumberFormat('id-ID').format(num);
        } catch (e) {
            console.error('Error formatting price:', e);
            return num.toString();
        }
    }

    function createPreviewCardHtml(data) {
        let imageHtml;
        if (data.imageFile) {
            imageHtml = `<div class="preview-image-container">
                            <img src="${data.imageFile}" alt="${data.name || 'Product Image'}" class="preview-image">
                          </div>`;
        } else if (data.imageUrl) {
            imageHtml = `<div class="preview-image-container">
                            <img src="${data.imageUrl}" alt="${data.name || 'Product Image'}" class="preview-image">
                          </div>`;
        } else {
            imageHtml = `<div class="preview-image-container preview-no-image">
                            <i class="fa fa-image" style="font-size: 2rem;"></i>
                            <p class="mb-0 mt-1 text-muted">No Image</p>
                          </div>`;
        }

        const currentPrice = parseFloat(data.price);
        const originalPrice = parseFloat(data.originalPrice);
        const formattedPrice = 'Rp ' + formatPrice(currentPrice);
        const hasOriginalPrice = !isNaN(originalPrice) && originalPrice > 0 && originalPrice > currentPrice;
        const formattedOriginalPrice = hasOriginalPrice ? 'Rp ' + formatPrice(originalPrice) : null;

        let colorsHtml = '';
        if (data.colors && data.colors.length > 0) {
            colorsHtml = '<p class="card-text text-muted text-sm mb-1 preview-color-list">';
            data.colors.forEach(color => {
                colorsHtml += `<span class="preview-color-swatch" style="background-color: ${color};"></span>`;
            });
            colorsHtml += '</p>';
        }

        return `
            <div class="preview-card card">
                ${imageHtml}
                <div class="card-body">
                    <h5 class="card-title text-truncate">${data.name || 'Nama Produk'}</h5>
                    <p class="card-text text-muted text-sm">${data.brand || 'Unknown'}</p>
                    ${colorsHtml}
                    <p class="card-text text-dark font-weight-bold mb-0">${formattedPrice}</p>
                    ${hasOriginalPrice ? `<p class="card-text text-muted line-through text-sm mt-0">${formattedOriginalPrice}</p>` : ''}
                    <div class="d-flex mt-2">
                        <a href="#" class="btn btn-primary btn-sm mr-1 flex-fill disabled"><i class="fa fa-shopping-cart"></i> Keranjang</a>
                        <a href="#" class="btn btn-success btn-sm flex-fill disabled"><i class="fa fa-money-bill-alt"></i> Beli</a>
                    </div>
                </div>
            </div>
        `;
    }

    function updateCreatePreview() {
        const name = $('#create_name').val();
        const brand = $('#create_brand').val();
        const price = $('#create_price').val();
        const originalPrice = $('#create_original_price').val();
        const category = $('#create_category').val();
        const colors = $('#create-color-inputs .color-input').map(function() {
            return $(this).val();
        }).get();

        const fileInput = document.getElementById('create_image');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#create-preview-container').html(createPreviewCardHtml({
                    name: name, brand: brand, price: price, originalPrice: originalPrice, category: category, colors: colors, imageFile: e.target.result, imageUrl: null
                }));
            };
            reader.onerror = function(e) {
                console.error('Error reading file for create preview:', e);
                $('#create-preview-container').html(createPreviewCardHtml({
                    name: name, brand: brand, price: price, originalPrice: originalPrice, category: category, colors: colors, imageFile: null, imageUrl: null
                }));
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            $('#create-preview-container').html(createPreviewCardHtml({
                name: name, brand: brand, price: price, originalPrice: originalPrice, category: category, colors: colors, imageFile: null, imageUrl: null
            }));
        }
    }

    function updateEditPreview() {
        const name = $('#edit_name').val();
        const brand = $('#edit_brand').val();
        const price = $('#edit_price').val();
        const originalPrice = $('#edit_original_price').val();
        const category = $('#edit_category').val();
        const colors = $('#edit-color-inputs .color-input').map(function() {
            return $(this).val();
        }).get();

        let existingImageUrl = $('#edit_image').siblings('.mt-3').find('img').attr('src');

        const fileInput = document.getElementById('edit_image');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#edit-preview-container').html(createPreviewCardHtml({
                    name: name, brand: brand, price: price, originalPrice: originalPrice, category: category, colors: colors, imageUrl: null, imageFile: e.target.result
                }));
            };
            reader.onerror = function(e) {
                console.error('Error reading file for edit preview:', e);
                $('#edit-preview-container').html(createPreviewCardHtml({
                    name: name, brand: brand, price: price, originalPrice: originalPrice, category: category, colors: colors, imageFile: null, imageUrl: existingImageUrl
                }));
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            $('#edit-preview-container').html(createPreviewCardHtml({
                name: name, brand: brand, price: price, originalPrice: originalPrice, category: category, colors: colors, imageUrl: existingImageUrl, imageFile: null
            }));
        }
    }

    // Color picker management
    function addColorInput(containerId, maxColors = 5) {
        const container = $(containerId);
        const colorGroups = container.find('.color-input-group');
        if (colorGroups.length >= maxColors) return;

        const newIndex = colorGroups.length;
        const newColorInput = $(
            `<div class="color-input-group">
                <input type="color" class="color-input" name="colors[]" value="#000000">
                <span class="color-preview" data-index="${newIndex}" style="background-color: #000000;"></span>
                <button type="button" class="remove-color-btn">Hapus</button>
            </div>`
        );
        container.append(newColorInput);

        newColorInput.find('.color-input').on('input', function() {
            const index = $(this).parent().find('.color-preview').data('index');
            container.find(`.color-preview[data-index="${index}"]`).css('background-color', $(this).val());
            if (containerId === '#create-color-inputs') updateCreatePreview();
            else if (containerId === '#edit-color-inputs') updateEditPreview();
        });

        newColorInput.find('.remove-color-btn').on('click', function() {
            if (colorGroups.length > 1) {
                $(this).parent().remove();
                if (containerId === '#create-color-inputs') updateCreatePreview();
                else if (containerId === '#edit-color-inputs') updateEditPreview();
                renumberPreviews(container);
            }
        });
    }

    function renumberPreviews(container) {
        container.find('.color-input-group').each(function(index) {
            $(this).find('.color-preview').data('index', index).attr('data-index', index);
        });
    }

    $('#add-color-btn').on('click', function() { addColorInput('#create-color-inputs'); updateCreatePreview(); });
    $('#modal-add-color-btn').on('click', function() { addColorInput('#modal-create-color-inputs'); });

    // Initial color input update
    $('.color-input').on('input', function() {
        const index = $(this).parent().find('.color-preview').data('index');
        $(this).parent().find('.color-preview').css('background-color', $(this).val());
        if ($(this).closest('#create-color-inputs').length) updateCreatePreview();
        else if ($(this).closest('#edit-color-inputs').length) updateEditPreview();
        else if ($(this).closest('#modal-create-color-inputs').length) {
            // Update modal preview if implemented
        }
    });

    $('.remove-color-btn').on('click', function() {
        if ($(this).closest('.color-picker-container').find('.color-input-group').length > 1) {
            $(this).parent().remove();
            if ($(this).closest('#create-color-inputs').length) updateCreatePreview();
            else if ($(this).closest('#edit-color-inputs').length) updateEditPreview();
            renumberPreviews($(this).closest('.color-picker-container').find('#create-color-inputs'));
            renumberPreviews($(this).closest('.color-picker-container').find('#edit-color-inputs'));
        }
    });

    // Tab activation
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    const defaultTab = 'list';
    const targetTabId = tabParam && $(`#productTabs a[href="#${tabParam}"]`).length ? tabParam : defaultTab;
    $(`#productTabs a[href="#${targetTabId}"]`).tab('show');

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        const tabId = $(e.target).attr('href').substring(1);
        const previousTabId = $(e.relatedTarget).attr('href') ? $(e.relatedTarget).attr('href').substring(1) : null;

        if (previousTabId !== tabId) {
            const url = new URL(window.location);
            url.searchParams.set('tab', tabId);
            if (tabId !== 'edit') {
                url.searchParams.delete('id');
            }
            if (tabId === 'list') {
                const currentSearch = $('#list form input[name="search"]').val();
                if (currentSearch) {
                    url.searchParams.set('search', currentSearch);
                } else {
                    url.searchParams.delete('search');
                }
            } else {
                url.searchParams.delete('search');
            }
            window.history.pushState({}, '', url);
        }

        if (tabId === 'create') {
            updateCreatePreview();
        } else if (tabId === 'edit') {
            updateEditPreview();
        }
    });

    // Modal handling
    $('#createProductModal').on('shown.bs.modal', function() {
        $('#modal-create-product-form')[0].reset();
        $('#modal-create-color-inputs').html(
            `<div class="color-input-group">
                <input type="color" class="color-input" name="colors[]" value="#000000">
                <span class="color-preview" data-index="0" style="background-color: #000000;"></span>
                <button type="button" class="remove-color-btn" style="display: none;">Hapus</button>
            </div>`
        );
    });

    $('#modal-create-submit').click(function() {
        $('#modal-create-product-form').submit();
    });

    // Input change listeners
    $('#create_name, #create_brand, #create_price, #create_original_price, #create_category').on('input change', updateCreatePreview);
    $('#create_image').on('change', updateCreatePreview);
    $('#edit_name, #edit_brand, #edit_price, #edit_original_price, #edit_category').on('input change', updateEditPreview);
    $('#edit_image').on('change', updateEditPreview);

    updateCreatePreview();
    updateEditPreview();
});
</script>
@endpush
