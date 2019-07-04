@extends('layouts.app')
@inject('client', App\Client)
@inject('restaurant', App\Restaurant)
@inject('category', App\Category)
@inject('product', App\Product)
@inject('offer', App\Offer)
@inject('district', App\District)
@inject('city', App\City)
@inject('review', App\Review)
@inject('contact', App\Contact)
@inject('payment', App\PaymentMethod)
@inject('transaction', App\Transaction)
@inject('order', App\Order)
@section('page_title')
    Dashboard
@endsection
@section('small_title')
    Statistics
@endsection
@section('content')


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Clients</span>
                        <span class="info-box-number">{{$client->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-cutlery"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Restaurants</span>
                        <span class="info-box-number">{{$restaurant->where('is_active', 1)->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-gray"><i class="fa fa-cutlery"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pending restaurants</span>
                        <span class="info-box-number">{{$restaurant->where('is_active', 0)->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-purple"><i class="fa fa-list"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Categories</span>
                        <span class="info-box-number">{{$category->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-blue"><i class="fa fa-product-hunt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Products</span>
                        <span class="info-box-number">{{$product->where('disabled', 0)->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-gray"><i class="fa fa-product-hunt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Pending Products</span>
                        <span class="info-box-number">{{$product->where('disabled', 1)->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>



            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-white"><i class="fa fa-gift"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Offers</span>
                        <span class="info-box-number">{{$offer->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-home"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Districts</span>
                        <span class="info-box-number">{{$district->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="fa fa-flag-o"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Cities</span>
                        <span class="info-box-number">{{$city->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-teal"><i class="fa fa-phone"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Contacts</span>
                        <span class="info-box-number">{{$contact->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-black"><i class="fa fa-book"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Reviews</span>
                        <span class="info-box-number">{{$review->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-fuchsia"><i class="fa fa-money"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Payment Methods</span>
                        <span class="info-box-number">{{$payment->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-navy"><i class="fa fa-credit-card-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Transactions</span>
                        <span class="info-box-number">{{$transaction->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue"><i class="fa fa-tasks"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Completed Orders</span>
                        <span class="info-box-number">{{$order->whereIn('state', ['delivered', 'declined'])->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-gray"><i class="fa fa-tasks"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Non-Completed Orders</span>
                        <span class="info-box-number">{{$order->whereIn('state', ['pending', 'accepted', 'rejected', 'confirmed'])->count()}}</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>

        </div>

        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Title</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                            title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                You are logged in!
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                Footer
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>

@endsection
