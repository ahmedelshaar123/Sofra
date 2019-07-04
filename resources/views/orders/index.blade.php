@extends('layouts.app')

@section('page_title')
    Orders
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">



        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of orders</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @include("flash::message")
                @if(count($records))
                    <div class="table table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="text text-center">#</th>
                                <th class="text text-center">Restaurant</th>
                                <th class="text text-center">Notes</th>
                                <th class="text text-center">State</th>
                                <th class="text text-center">Client</th>
                                <th class="text text-center">Payment Methods</th>
                                <th class="text text-center">Cost</th>
                                <th class="text text-center">Delivery Fees</th>
                                <th class="text text-center">Total Price</th>
                                <th class="text text-center">Commission</th>
                                <th class="text text-center">Net</th>
                                <th class="text text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td class="text text-center">{{$loop->iteration}}</td>
                                    <td class="text text-center">{{optional($record->restaurant)->name}}</td>
                                    <td class="text text-center">{{$record->notes}}</td>
                                    <td class="text text-center">{{$record->state}}</td>
                                    <td class="text text-center">{{optional($record->client)->name}}</td>
                                    <td class="text text-center">{{optional($record->paymentMethod)->name}}</td>
                                    <td class="text text-center">{{$record->cost}}</td>
                                    <td class="text-center">{{$record->delivery_fees}}</td>
                                    <td class="text text-center">{{$record->total_price}}</td>
                                    <td class="text text-center">{{$record->commission}}</td>
                                    <td class="text text-center">{{$record->net}}</td>
                                    <td class="text text-center">
                                        {!! Form::open([
                                            'action'=>['OrderController@destroy', $record->id],
                                            'method'=>'delete'
                                        ])!!}
                                        <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</button>
                                        {!! Form::close() !!}



                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        No data
                    </div>
                @endif
            </div>
            <!-- /.box-body -->


        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->

@endsection
