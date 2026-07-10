@extends('backend.layouts.app')

@section('content')
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12 d-flex justify-content-between">
                <h5>Deals & Combos Management</h5>
                <a href="{{ route('admin.deals.create') }}" class="btn btn-primary btn-sm">+ Add New Deal</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                {{-- Success Message --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Deal Name</th>
                                <th>Price</th>
                                <th>Items Included</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deals as $deal)
                                <tr>
                                    <td><strong>{{ $deal->name }}</strong></td>
                                    <td>Rs. {{ number_format($deal->price, 2) }}</td>
                                    <td>
                                        {{-- Items array ko loop karke names dikhana --}}
                                        @if($deal->items && is_array($deal->items))
                                            @foreach($deal->items as $itemId)
                                                @php 
                                                    $menuItem = \App\Models\MenuItem::find($itemId);
                                                @endphp
                                                <span class="badge bg-light-primary text-primary">
                                                    {{ $menuItem->name ?? 'Item Removed' }}
                                                </span>
                                            @endforeach
                                        @else
                                            <small class="text-muted">{{ $deal->description }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $deal->status == 'Active' ? 'success' : 'warning' }}">
                                            {{ $deal->status ?? 'Active' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.deals.destroy', $deal->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light-danger">
                                                <i class="feather icon-trash-2"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No deals found. Start by creating one!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection