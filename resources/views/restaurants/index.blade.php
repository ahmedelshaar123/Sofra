@extends('layouts.app')

@section('page_title')
    Restaurants
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">



        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of restaurants</h3>

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
                                <th class="text text-center">Name</th>
                                <th class="text text-center">District/th>
                                <th class="text text-center">Email</th>
                                <th class="text text-center">Min Charge</th>
                                <th class="text text-center">Delivery Fees</th>
                                <th class="text text-center">Phone</th>
                                <th class="text text-center">Whatsapp</th>
                                <th class="text text-center">Image</th>
                                <th class="text text-center">Activation</th>
                                <th class="text text-center">Availability</th>
                                <th class="text text-center">Activate/Disactivate</th>
                                <th class="text text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td class="text text-center">{{$loop->iteration}}</td>
                                    <td class="text text-center">{{$record->name}}</td>
                                    <td class="text text-center">{{optional($record->district)->name}}</td>
                                    <td class="text text-center">{{$record->email}}</td>
                                    <td class="text text-center">{{$record->min_charge}}</td>
                                    <td class="text text-center">{{$record->delivery_fees}}</td>
                                    <td class="text text-center">{{$record->phone}}</td>
                                    <td class="text text-center">{{$record->whatsapp}}</td>
                                    <td class="text text-center">
                                        <img src="{{asset($record->image)}}" style="width:200px; height:100px">
                                    </td>

                                    <td class="text text-center">{{$record->is_active}}</td>
                                    <td class="text text-center">{{$record->availability}}</td>
                                    <td class="text text-center"> @if($record->is_active)
                                            <a href="restaurant/{{$record->id}}/desactivate" class="btn btn-xs btn-danger"><i class="fa fa-close"></i> Disactivate</a>
                                        @else
                                            <a href="restaurant/{{$record->id}}/activate" class="btn btn-xs btn-success"><i class="fa fa-check"></i> Activate</a>
                                        @endif
                                    </td>

                                    <td class="text text-center">
                                        {!! Form::open([
                                            'action'=>['RestaurantController@destroy', $record->id],
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
