@extends('layouts.main')
@section('links')
    
@endsection
@section('content')
    <div class="container bg-light" style="height: 100vh; margin-top: 7.4rem;">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h6 class="inclettitle">My Cart</h6>
                    <hr>

                    <form action="" method="post" class="cart-items" style="margin-top: 5rem;">
                        <div class="border rounded">
                            <div class="row bg-white">
                                <div class="col-md-3 pl-0">
                                    <img src="{{ asset('storage/imgsHomePage/eventoarte.jpg') }}" alt="Image" class="img-fluid">
                                </div>
                                <div class="col-md-6">
                                    <h5 class="pt-2 my-md-3" style="font-size: 2em;">Product 1</h5>
                                    <small class="text-secondary" style="font-size: 1.5em;"> Teste  </small>
                                    <h5 class="pt-2">$599</h5>
                                    <button type="submit" class="btn btn-warning"> Save for later </button>
                                    <button type="submit" class="btn btn-danger mx-2" name="remove"> Remove </button>
                                </div>
                                <div class="col-md-3" style="margin-top: 6%;">
                                    <div class="">
                                        <button type="button" class="btn bg-light border rounded-circle mr-2"><i class="fas fa-minus"></i></button>
                                        <input type="text" name="" id="" value="1" class="form-control w-25 d-inline">
                                        <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 offset-md-1 mt-5 border rounded white h-25">
                <div class="pt-4">
                    <h6 class="inclettitle">Price Details</h6>
                    <hr>
                    <div class="row price-details">
                        <div class="col-md-6">
                            <h6 class="incletbody" >Price (3 items)</h6>
                            <h6 class="incletbody" >Delievery charges</h6>
                            <hr>
                            <h6 class="incletbody" >Amount payable</h6>
                        </div>
                        <div class="col-md-6">
                            <h6 class="incletbody">150$</h6>
                            <h6 class="text-success incletbody">FREE</h6>
                            <hr>
                            <h6 class="incletbody">150$</h6>    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="{{ asset('js/bootstrap/bootstrap4.3.1.min.js') }}"  ></script>
@endsection