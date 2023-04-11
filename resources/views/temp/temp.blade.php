{{ asset('backend/') }}

@foreach ($customers as $customer)
<tr>
    <td>{{ $customer->id }}</td>
    <td>{{ $customer->customertype }}</td>
    <td>{{ $customer->taxid }}</td>
    @if($customer->customertype == 'company')<td>{{ $customer->company}}</td>
    @else <td> {{ $customer->firstname." ".$customer->lastname }}</td>
    @endif
    <td>
        <form action="{{ route('customer.delete',$customer->id) }}" method="Post">
            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.show',$customer->id) }}" target="_blank" title="Show">
                <i class="fas fa-eye"></i>
            </a>
            <a class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.edit',$customer->id) }}" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </a>
            @csrf
            @method('DELETE')
            <a type="submit" class="btn btn-outline-secondary btn-sm edit" href="{{ route('customer.delete' ,$customer->id) }}" title="Delete">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </a>
        </form>
    </td>
</tr>
@endforeach

<form action="'.route('file.delete',$row->id).'" method="Post">
    <div class="row">
    <div class="col-md-4">
    <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.show',$row->file_id).'" target="_blank" title="Show">
        <i class="fas fa-eye"></i>
    </a>
    </div>
    <div class="col-md-4">
    <a class="btn btn-outline-secondary btn-sm edit" href="'.route('file.edit',$row->file_id).'" title="Edit">
        <i class="fas fa-pencil-alt"></i>
    </a>
    </div>
    <div class="col-md-4">
    <a type="submit" class="btn btn-danger btn-sm edit" href="'.route('file.delete' ,$row->id).'" title="Delete">
        <i class="fa fa-trash" aria-hidden="true"></i>
    </a>
    </div>
    </div>
</form>