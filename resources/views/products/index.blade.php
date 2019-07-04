@extends('layouts.app')

@section('page_title')
    Products
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">



        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of products</h3>

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
                                <th class="text text-center">Preparing Time</th>
                                <th class="text text-center">Image</th>
                                <th class="text text-center">Restaurant</th>
                                <th class="text text-center">State</th>
                                <th class="text text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td class="text text-center">{{$loop->iteration}}</td>
                                    <td class="text text-center">{{$record->name}}</td>
                                    <td class="text text-center">{{$record->description}}</td>
                                    <td class="text text-center">{{{$record->price}}}</td>
                                    <td class="text text-center">{{$record->preparing_time}}</td>
                                    <td class="text text-center">
                                        <img src="{{asset($record->image)}}" style="width:200px; height:100px">
                                    </td>
                                    <td class="text text-center">{{optional($record->restaurant)->name}}</td>
                                    <td class="text text-center">
                                        {!!  ($record->disabled) ? 'Disabled' : 'Enabled' !!}
                                    </td>
                                    <td class="text text-center">
                                        {!! Form::open([
                                            'action'=>['ProductController@destroy', $record->id],
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
