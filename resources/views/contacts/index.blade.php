@extends('layouts.app')

@section('page_title')
    Contacts
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">



        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">List of contacts</h3>

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
                                <th class="text text-center">Body</th>
                                <th class="text text-center">Type</th>
                                <th class="text text-center">Client/Restaurant</th>
                                <th class="text text-center">Email</th>
                                <th class="text text-center">Phone</th>
                                <th class="text text-center">Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td class="text text-center">{{$loop->iteration}}</td>
                                    <td class="text text-center">{{$record->body}}</td>
                                    <td class="text text-center">{{$record->type}}</td>
                                    <td class="text text-center">{{optional($record->contactable)->name}}</td>
                                    <td class="text text-center">{{optional($record->contactable)->email}}</td>
                                    <td class="text text-center">{{optional($record->contactable)->phone}}</td>
                                    <td class="text text-center">
                                        {!! Form::open([
                                            'action'=>['ContactController@destroy', $record->id],
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
