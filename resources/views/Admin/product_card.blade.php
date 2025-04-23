@extends('layouts.main')

@section('title', 'Product Management')

@section('content')
<div class="panel-header bg-light-gradient">
    <div class="page-inner py-5">
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
            <div>
                <h2 class="pb-2 fw-bold">Products</h2>
                <h5 class="op-7 mb-2">Manage all products in your store</h5>
            </div>
            <div class="ml-md-auto py-2 py-md-0">
                @if(isset($activeTab) && $activeTab === 'list')
                    <button class="btn btn-white btn-border btn-round mr-2" data-toggle="modal" data-target="#createProductModal">
                        <i class="fa fa-plus"></i> Add New Product
                    </button>
                @else
                    <a href="{{ route('admin.products') }}?tab=list" class="btn btn-white btn-border btn-round mr-2">
                        <i class="fa fa-arrow-left"></i> Back to Products
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
            <a class="nav-link {{ (request('tab', 'list') === 'list') ? 'active' : '' }}" 
                id="list-tab" data-toggle="tab" href="#list" role="tab" aria-controls="list" 
                aria-selected="{{ (request('tab', 'list') === 'list') ? 'true' : 'false' }}">
                <i class="fa fa-list"></i> Product List
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ (request('tab') === 'create') ? 'active' : '' }}" 
                id="create-tab" data-toggle="tab" href="#create" role="tab" aria-controls="create" 
                aria-selected="{{ (request('tab') === 'create') ? 'true' : 'false' }}">
                <i class="fa fa-plus"></i> Add New Product
            </a>
        </li>
        @if(isset($product) && request('tab') === 'edit')
            <li class="nav-item">
                <a class="nav-link active" id="edit-tab" data-toggle="tab" href="#edit" role="tab" 
                    aria-controls="edit" aria-selected="true">
                    <i class="fa fa-edit"></i> Edit Product
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
                        <h4 class="card-title">All Products</h4>
                        <form class="ml-auto" action="{{ route('admin.products') }}" method="GET">
                            <input type="hidden" name="tab" value="list">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
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

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Original Price</th>
                                    <th>Stock</th>
                                    <th>Featured</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products ?? [] as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" width="50">
                                            @else
                                                <span class="badge badge-secondary">No Image</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>
                                            <span class="badge badge-{{ $product->category == 'handphone' ? 'primary' : 'info' }}">
                                                {{ ucfirst($product->category) }}
                                            </span>
                                        </td>
                                        <td>{{ $product->formatted_price }}</td>
                                        <td>{{ $product->formatted_original_price ?? '-' }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>
                                            @if($product->is_featured)
                                                <span class="badge badge-success">Yes</span>
                                            @else
                                                <span class="badge badge-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
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
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    @if($product->image)
                                                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                                                                    @else
                                                                        <div class="text-center p-5 bg-light">
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
                                                                            <td>{{ $product->formatted_original_price ?? 'N/A' }}</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Stock</th>
                                                                            <td>{{ $product->stock }}</td>
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
                                                                <span aria-hidden="true">&times;</span>
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
                                        <td colspan="9" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $products->appends(['tab' => 'list'])->links() ?? '' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Tab -->
        <div class="tab-pane fade {{ (request('tab') === 'create') ? 'show active' : '' }}" id="create" role="tabpanel" aria-labelledby="create-tab">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add New Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="create-product-form">
                                @csrf

                                <div class="form-group">
                                    <label for="create_name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="create_name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="create_description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="create_description" name="description" rows="4">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="create_price">Price (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="create_price" name="price" value="{{ old('price') }}" min="0" step="1000" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="create_original_price">Original Price (Rp)</label>
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
                                            <label for="create_category">Category <span class="text-danger">*</span></label>
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
                                            <label for="create_stock">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="create_stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="create_image">Product Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="create_image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Recommended size: 400x400 pixels</small>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="create_is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="create_is_featured">Featured Product</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Create Product</button>
                                    <button type="button" class="btn btn-info" id="create-preview-btn">Preview</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Live Preview</h4>
                        </div>
                        <div class="card-body" id="create-preview-container">
                            <div class="text-center mt-4 mb-4">
                                <p>Fill out the form to see a live preview</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Tab -->
        @if(isset($editProduct) && request('tab') === 'edit')
        <div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Product</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.products.update', $editProduct->id) }}" method="POST" enctype="multipart/form-data" id="edit-product-form">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label for="edit_name">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name" value="{{ old('name', $editProduct->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="edit_description">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" id="edit_description" name="description" rows="4">{{ old('description', $editProduct->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_price">Price (Rp) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="edit_price" name="price" value="{{ old('price', $editProduct->price) }}" min="0" step="1000" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_original_price">Original Price (Rp)</label>
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
                                            <label for="edit_category">Category <span class="text-danger">*</span></label>
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
                                            <label for="edit_stock">Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="edit_stock" name="stock" value="{{ old('stock', $editProduct->stock) }}" min="0" required>
                                            @error('stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="edit_image">Product Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="edit_image" name="image" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Recommended size: 400x400 pixels</small>
                                    
                                    @if ($editProduct->image)
                                        <div class="mt-2">
                                            <p>Current Image:</p>
                                            <img src="{{ Storage::url($editProduct->image) }}" alt="{{ $editProduct->name }}" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="edit_is_featured" name="is_featured" value="1" {{ old('is_featured', $editProduct->is_featured) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="edit_is_featured">Featured Product</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update Product</button>
                                    <button type="button" class="btn btn-info" id="edit-preview-btn">Preview</button>
                                    <a href="{{ route('admin.products') }}?tab=list" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Live Preview</h4>
                        </div>
                        <div class="card-body" id="edit-preview-container">
                            <!-- Product Card Preview for Edit -->
                            <div class="bg-blue-500 rounded-xl overflow-hidden">
                                @if($editProduct->image)
                                    <img src="{{ Storage::url($editProduct->image) }}" alt="{{ $editProduct->name }}" class="w-full h-64 object-contain">
                                @else
                                    <div class="bg-blue-400 flex items-center justify-center h-64">
                                        <i class="fa fa-image text-white text-5xl"></i>
                                    </div>
                                @endif
                                <div class="p-4 text-white">
                                    <h3 class="font-medium">{{ $editProduct->name }}</h3>
                                    <p class="text-2xl font-bold mt-1">{{ $editProduct->formatted_price }}</p>
                                    @if($editProduct->original_price)
                                        <p class="text-white/70 line-through">{{ $editProduct->formatted_original_price }}</p>
                                    @endif
                                    <div class="flex mt-4 space-x-2">
                                        <a href="#" class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center no-underline">+Keranjang</a>
                                        <a href="#" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                                    </div>
                                </div>
                            </div>
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
                <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="modal-create-product-form">
                    @csrf

                    <div class="form-group">
                        <label for="modal_create_name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="modal_create_name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="modal_create_description">Description</label>
                        <textarea class="form-control" id="modal_create_description" name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_price">Price (Rp) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal_create_price" name="price" min="0" step="1000" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_original_price">Original Price (Rp)</label>
                                <input type="number" class="form-control" id="modal_create_original_price" name="original_price" min="0" step="1000">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_category">Category <span class="text-danger">*</span></label>
                                <select class="form-control" id="modal_create_category" name="category" required>
                                    <option value="handphone">Handphone</option>
                                    <option value="accessory">Accessory</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="modal_create_stock">Stock <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="modal_create_stock" name="stock" value="0" min="0" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="modal_create_image">Product Image</label>
                        <input type="file" class="form-control" id="modal_create_image" name="image" accept="image/*">
                        <small class="form-text text-muted">Recommended size: 400x400 pixels</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="modal_create_is_featured" name="is_featured" value="1">
                            <label class="custom-control-label" for="modal_create_is_featured">Featured Product</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="modal-create-submit">Create Product</button>
            </div>
        </div>
    </div>
</div>
@endsection
    
@endpush
@push('scripts')
<script>
// Enhanced Product Preview JavaScript
$(document).ready(function() {
    // Initialize tabs based on URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab');
    
    if (tabParam) {
        $('#productTabs a[href="#' + tabParam + '"]').tab('show');
    }
    
    // Handle tab navigation
    $('#productTabs a').on('click', function (e) {
        e.preventDefault();
        $(this).tab('show');
        
        // Update URL with the selected tab
        const tabId = $(this).attr('href').substring(1);
        const url = new URL(window.location);
        url.searchParams.set('tab', tabId);
        window.history.pushState({}, '', url);
    });

    // Helper function to format price with commas (Indonesian format)
    function formatPrice(price) {
        return new Intl.NumberFormat('id-ID').format(price);
    }

    // Create a preview card based on form data
    function createPreviewCard(data) {
        let imageHtml;
        
        if (data.imageUrl) {
            // Use existing image
            imageHtml = `<img src="${data.imageUrl}" alt="${data.name}" class="w-full h-64 object-contain">`;
        } else if (data.imageFile) {
            // Use new image selected by file input
            imageHtml = `<img src="${data.imageFile}" alt="${data.name}" class="w-full h-64 object-contain">`;
        } else {
            // No image placeholder
            imageHtml = `
                <div class="bg-blue-400 flex items-center justify-center h-64">
                    <i class="fa fa-image text-white text-5xl"></i>
                </div>
            `;
        }
        
        // Format prices
        const formattedPrice = 'Rp ' + formatPrice(data.price);
        const hasOriginalPrice = data.originalPrice && data.originalPrice > 0;
        const formattedOriginalPrice = hasOriginalPrice ? 'Rp ' + formatPrice(data.originalPrice) : null;
        
        // Build card HTML
        return `
            <div class="bg-blue-500 rounded-xl overflow-hidden">
                ${imageHtml}
                <div class="p-4 text-white">
                    <h3 class="font-medium">${data.name}</h3>
                    <p class="text-2xl font-bold mt-1">${formattedPrice}</p>
                    ${hasOriginalPrice ? `<p class="text-white/70 line-through">${formattedOriginalPrice}</p>` : ''}
                    <div class="flex mt-4 space-x-2">
                        <a href="#" class="bg-white text-blue-500 rounded py-2 px-4 text-sm flex-1 text-center no-underline">+Keranjang</a>
                        <a href="#" class="bg-blue-600 text-white rounded py-2 px-4 text-sm flex-1 text-center no-underline">Beli</a>
                    </div>
                </div>
            </div>
        `;
    }

    // Function to update create preview
    function updateCreatePreview() {
        // Get values from create form
        const name = $('#create_name').val() || 'Product Name';
        const price = parseFloat($('#create_price').val()) || 0;
        const originalPrice = parseFloat($('#create_original_price').val()) || 0;
        const category = $('#create_category').val() || 'handphone';
        
        // Handle image
        let imageFile = null;
        const fileInput = document.getElementById('create_image');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview data
                const data = {
                    name: name,
                    price: price,
                    originalPrice: originalPrice,
                    category: category,
                    imageFile: e.target.result
                };
                
                // Update preview container
                $('#create-preview-container').html(createPreviewCard(data));
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            // Create preview data without image
            const data = {
                name: name,
                price: price,
                originalPrice: originalPrice,
                category: category,
                imageFile: null
            };
            
            // Update preview container
            $('#create-preview-container').html(createPreviewCard(data));
        }
    }

    // Function to update edit preview
    function updateEditPreview() {
        // Get values from edit form
        const name = $('#edit_name').val() || 'Product Name';
        const price = parseFloat($('#edit_price').val()) || 0;
        const originalPrice = parseFloat($('#edit_original_price').val()) || 0;
        const category = $('#edit_category').val() || 'handphone';
        
        // Handle existing image
        let imageUrl = null;
        if ($('.mt-2 img.img-thumbnail').length) {
            imageUrl = $('.mt-2 img.img-thumbnail').attr('src');
        }
        
        // Check if a new file is selected
        let imageFile = null;
        const fileInput = document.getElementById('edit_image');
        if (fileInput && fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create preview data with new image
                const data = {
                    name: name,
                    price: price,
                    originalPrice: originalPrice,
                    category: category,
                    imageUrl: null,
                    imageFile: e.target.result
                };
                
                // Update preview container
                $('#edit-preview-container').html(createPreviewCard(data));
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            // Create preview data with existing image
            const data = {
                name: name,
                price: price,
                originalPrice: originalPrice,
                category: category,
                imageUrl: imageUrl,
                imageFile: null
            };
            
            // Update preview container
            $('#edit-preview-container').html(createPreviewCard(data));
        }
    }

    // Add listeners for create form
    $('#create_name, #create_price, #create_original_price, #create_category').on('input change', function() {
        updateCreatePreview();
    });

    // Add file input listener for create form
    $('#create_image').on('change', function() {
        updateCreatePreview();
    });

    // Add listeners for edit form
    $('#edit_name, #edit_price, #edit_original_price, #edit_category').on('input change', function() {
        updateEditPreview();
    });

    // Add file input listener for edit form
    $('#edit_image').on('change', function() {
        updateEditPreview();
    });

    // Preview button click handlers
    $('#create-preview-btn').click(function(e) {
        e.preventDefault();
        updateCreatePreview();
    });

    $('#edit-preview-btn').click(function(e) {
        e.preventDefault();
        updateEditPreview();
    });

    // Modal create product submit
    $('#modal-create-submit').click(function() {
        $('#modal-create-product-form').submit();
    });

    // Initialize preview on page load
    if (tabParam === 'create') {
        updateCreatePreview();
    } else if (tabParam === 'edit') {
        updateEditPreview();
    }
});
</script>
@endpush