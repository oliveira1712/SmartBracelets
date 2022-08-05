@extends('layouts.main')
@section('links')
    
@endsection
@section('content')
    <div class="container" style="height: 100vh; margin-top: 7.4rem;">
        <div class="row text-center py-5 justify-content-center">
            <div class="col-md-9 col-sm-6 my-3 my-md-0">
                <form action="" method="post">
                    <div class="card shadow">
                        <div class="">
                            <img src="storage/imgsHomePage/bracelet1.jpg" alt="Image1" id="imgbilheteevento" class="img-fluid card-img-top" style="height: 500px">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                Product1
                            </h5>
                            <h6>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </h6>
                            <p class="card-text">
                                Some quick example text to build on the card.
                            </p>
                            <h5>
                                <small><s class="text-secondary">$519</s></small>
                                <span class="price">
                                    $599
                                </span>
                            </h5>

                            <button type="submit" class="btn btn-warning my-3" name="add">Add to cart <i class="fas fa-shopping-cart"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
@endsection

@section('scripts')
<script src="{{ asset('js/bootstrap/bootstrap4.3.1.min.js') }}"  ></script>
@endsection