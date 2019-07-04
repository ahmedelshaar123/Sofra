@extends('layouts.app')

@section('page_title')
    Offers
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">



        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of offers</h3>

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
                                <th class="text text-center">Description</th>
                                <th class="text text-center">Price</th>
                                <th class="text text-center">Starting at</th>
                                <th class="text text-center">Ending at</th>
                                <th class="text text-center">Image</th>
                                <th class="text text-center">Availability</th>
                                <th class="text text-center">Restaurant</th>
                                <th class="text text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td class="text text-center">{{$loop->iteration}}</td>
                                    <td class="text text-center">{{$record->name}}</td>
                                    <td class="text text-center">{{$record->description}}</td>
                                    <td class="text text-center">{{$record->price}}</td>
                                    <td class="text text-center">{{$record->starting_at->format('Y-m-d')}}</td>
                                    <td class="text text-center">{{$record->ending_at->format('Y-m-d')}}</td>
                                    <td class="text text-center">
                                        <img src="{{asset($record->image)}}" style="width:200px; height:100px">
                                    </td>
                                    <td class="text-center">{!!  ($record->available) ? '<i class="fa fa-2x fa-check text-green"></i>' : '<i class="fa fa-2x fa-close text-red"></i>' !!}</td>
                                    <td class="text text-center">{{optional($record->restaurant)->name}}</td>
                                    <td class="text text-center">
                                        {!! Form::open([
                                            'action'=>['OfferController@destroy', $record->id],
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
