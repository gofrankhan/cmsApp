@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        @php
            $broadcast_messages = Illuminate\Support\Facades\DB::table('broadcast_messages')->get();
            $broadcast_messages_count = Illuminate\Support\Facades\DB::table('broadcast_messages')->count();
        @endphp
        @if(($broadcast_messages_count))
        @foreach($broadcast_messages as $broadcast_message)
        <div id="scroll-container">
            <div id="scroll-text">{{$broadcast_message->message}}</div>
        </div>
        @endforeach
        @endif
        @if(isset($card_array))
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Dashboard</h4>
                    <!-- end row -->
                    <div class="col-sm-6 col-md-4 col-xl-3">
                        <div class="my-4 text-center">
                            <button type="button" class="btn btn-outline-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-sm">Add Filter</button>
                            <label for="">{{$card_array['daterange']}}</label>
                        </div>

                        <form action="{{ route('dashboard')}}" id="daterange">
                                @csrf
                            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="mySmallModalLabel">Add Filter</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-form-label">Start Date</label>
                                                <div>
                                                    <input class="form-control" type="date" value="<?= date('Y-m-d') ?>" id="start_date" name="start_date">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="example-date-input" class="col-form-label">End Date</label>
                                                <div>
                                                    <input class="form-control" type="date" value="<?= date('Y-m-d') ?>" id="end_date" name="end_date">
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" class="btn btn-outline-primary waves-effect waves-light">Apply</button>
                                            </div>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                        </form>
                    </div>
                    <!-- end row -->

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">PC Point</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end row -->
        
        <div class="row">
        <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Users</p>
                                <h4 class="mb-2">{{ $card_array['user_count'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-user-3-line font-size-24"></i>  
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Shops</p>
                                <h4 class="mb-2">{{ $card_array['shop_count'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>  
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">File Completed</p>
                                <h4 class="mb-2">{{ $card_array['completed_file'] }}
                                </h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="ri-shopping-cart-2-line font-size-24"></i>  
                                </span>
                            </div>
                        </div>                                            
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Open Files</p>
                                <h4 class="mb-2">{{ $card_array['open_file'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-currency-btc font-size-24"></i>  
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Transactions</p>
                                <h4 class="mb-2">{{ $card_array['transactions'] }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-currency-usd font-size-24"></i>  
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="col-xl-2 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Paid</p>
                                <h4 class="mb-2">{{-($card_array['total_paid']) }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-success rounded-3">
                                    <i class="mdi mdi-currency-btc font-size-24"></i>  
                                </span>
                            </div>
                        </div>                                              
                    </div><!-- end cardbody -->
                </div><!-- end card -->
            </div><!-- end col -->
        </div><!-- end row -->
        <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th>Balance</th>
                    <th>Due</th>
                    <th>Transactions</th>
                    <th>Paid</th>
                    <th>Count</th>
                </tr>
            </thead>
        
        
            <tbody>
                @foreach($totalInvoiceByShop as $invoice)
            <tr>
                <td>{{$invoice->shop_name}}</td>
                @if($invoice->total_invoice < 0)
                <td>{{ -$invoice->total_invoice}}</td>
                <td>----</td>
                @else
                <td>----</td>
                <td>{{$invoice->total_invoice}}</td>
                @endif
                <td>{{$invoice->positive_sum}}</td>
                <td>{{$invoice->negative_sum}}</td>
                <td>{{$invoice->count}}</td>
            </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
    
</div>

@endsection