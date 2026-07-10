@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.deals.index') }}">Deals</a></li>
                    <li class="breadcrumb-item" aria-current="page">Create New Deal</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add New Deal / Combo Pack</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.deals.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Deal Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Family Feast" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Deal Price (Rs.)</label>
                            <input type="number" name="price" class="form-control" placeholder="999" required>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Select Items Included in Deal</label>
                            <select name="item_ids[]" class="form-control" multiple style="height: 180px;" required>
                                @if(isset($items) && $items->count() > 0)
                                    @foreach($items as $item)
                                        {{-- Fix: Using 'name' instead of 'dish_name' based on Tinker result --}}
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }} — (Rs. {{ number_format($item->price, 0) }})
                                        </option>
                                    @endforeach
                                @else
                                    <option disabled>No items found in Menu</option>
                                @endif
                            </select>
                            <small class="text-primary font-weight-bold">💡 Multi-select: Hold **Ctrl** (Windows) or **Command** (Mac) to select multiple items.</small>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description / Items Summary</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="e.g. 2 Pcs Fried Chicken + 1 Drink"></textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Create Deal</button>
                        <a href="{{ route('admin.deals.index') }}" class="btn btn-light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection