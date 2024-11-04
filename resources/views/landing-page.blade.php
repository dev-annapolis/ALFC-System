@extends('layouts.app')
@section('content')

<style>
    h1, h4 {
        font-family: 'Times New Roman';
        color: var(--lightest-grey);
    }

    h5 {
        font-family: 'Times-New-Roman-Italic';
    }


    body{
        background-color: var(--primary-color-red-bg)
    }

     /* Small (sm): ≥576px */
     @media (max-width: 767.98px) {


        .alfc-sub-title{
            font-size: 30px;;
        }

        .alfc-logo{
            height: 100px;
            width: 95px;
        }

        .motto{
            margin-top: 10px;
        }

    }

    /* Medium (md): ≥768px */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .alfc-title{
            font-size: 50px;;
        }

        .alfc-sub-title{
            font-size: 35px;;
        }

        .alfc-logo{
            height: 100px;
        }

        .alfc-logo{
            height: 130px;
            width: 130px;
        }
    }

    /* Large (lg): ≥992px */
    @media (min-width: 992px) and (max-width: 1199.98px) {
        .alfc-title{
            font-size: 60px;;
        }

        .alfc-sub-title{
            font-size: 40px;;
        }

        .alfc-logo{
            height: 150px;
            width: 200px;
        }
    }

    /* Extra large (xl): ≥1200px */
    @media (min-width: 1200px) and (max-width: 1399.98px) {

        .alfc-title{
            font-size: 70px;;
        }

        .alfc-sub-title{
            font-size: 40px;;
        }
        /* Styles for extra large screens go here */
        .alfc-logo{
            height: 200px;
            width: 200px;
        }
    }

    /* Extra extra large (xxl): ≥1400px */
    @media (min-width: 1400px) {

        .alfc-title{
            font-size: 80px;;
        }

        .alfc-sub-title{
            font-size: 40px;;
        }
        /* Styles for extra extra large screens go here */
        .alfc-logo{
            height: 180px;
            width: 180px;
        }
    }

</style>

<div class="container-fluid d-flex justify-content-center align-items-center" style="min-height: 100vh; min-width: 100vw;">

    <div class="row justify-content-center">

        <div class="col-9 col-sm-9 mb-0 mt-md-5">

            <div class="d-flex flex-column flex-md-row align-items-center">

                <div class="col-md-4 col-sm-6  d-flex justify-content-center p-4">
                    <img class="alfc-logo img-fluid" src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="ALFC Logo">
                </div>


                <div class="col-md-10 col-lg-9 col-sm-12 d-flex flex-column">
                    <h1 class="alfc-title display-2 text-center text-md-start mb-0 fw-bold">ALFC</h1>

                    <h1 class="alfc-sub-title display-4  text-center text-md-start mt-0">Insurance Agency Corporation</h1>

                    <h5 class="motto fs-3 text-center text-lg-end text-md-start text-white ">Geared to secure</h5>
                </div>

            </div>

        </div>

        <div class="col-md-7 col-sm-10 mt-5 mb-5 d-flex justify-content-center">
            <a href="#" class="btn btn-light mt-3 fw-bold bg-white fs-5 w-50 w-md-25" style="color: var(--primary-color-red)">
                 Get Started
            </a>
        </div>

    </div>

</div>


@endsection
