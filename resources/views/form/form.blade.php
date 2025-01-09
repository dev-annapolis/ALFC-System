@extends('layouts.app')

@section('content')

{{-- <style>

    .container-form {
        /* padding: 15px; */
        background-color: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .alfc-title{
        font-size: 2.25rem; /* equivalent to fs-6 */
        margin-top: 3rem;
    }

    .alfc-logo{

        max-width: 50px;

    }

    .main-title{
        font-family: "Poppins-Bold";
    }


    /* Font size for md and above (768px and up) */
    @media (min-width: 768px) {
        .alfc-title{
            font-size: 0.8rem; /* equivalent to fs-1 */
            margin-top: 0.5rem;
        }
    }

    @media (max-width: 767px) {

        .alfc-logo{

            max-width: 100px;

        }



    }

    .steps {
        display: flex;
        flex-direction: column;
        position: relative;

    }

    /* Connector line */
    .steps::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background-color: #EFEFEF;
        z-index: -1;
        transition: background-color 0.3s;
    }

    .step {
        display: flex;
        align-items: center;
        cursor: pointer;
        margin: 10px 0;
        font-size: 0.85em; /* Smaller font size */
        color: #b0bec5;
        position: relative;
    }

    .step input[type="radio"] {
        display: none;
    }

    .step.active {
        color: black;
        font-weight: bold;
    }

    .form-control:disabled {
        background-color: #bdbdbd;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }

    .step::before {
        content: '';
        width: 20px;
        height: 20px;
        border: 0px solid #EFEFEF;
        border-radius: 50%;
        margin-right: 10px;
        transition: background-color 0.1s, border-color 0.1s;
        position: relative;
        z-index: 1;
        background-color: #EFEFEF;

    }

    .step.completed {
        color: #EFEFEF;
    }

    .step.completed::before {
        background-color: #EFEFEF;
        border-color: #EFEFEF;
    }

    .step.active::before {
        background-color: red;
        border-color: #EFEFEF;
        border-width: 4px;
    }

    .step:hover::before {
        border-color: #007bff;
    }

    .uppercase-input {
        text-transform: uppercase; /* Converts input text to uppercase */
    }

    .uppercase-input::placeholder {
        text-transform: none; /* Ensures the placeholder remains as is */
    }

    .form-content {
        padding: 20px;
        padding-bottom:0;
    }

    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    h3 {
        margin-bottom: 5px;
    }

    form select, form button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1em;
    }

    form input{
        background-color: red;
    }

    form button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }


    .form-control{
        background-color: #f3f3f3;
    }

    .form-control:focus {
        border-color: #8a8a8a4b;
        box-shadow: 0 0 0 0.2rem #8a8a8a4b;
    }



    .button-container {
        margin-top: 170px;
        display: flex;
        justify-content: flex-end; /* Pushes the button to the right */
        right: 20px;       /* Adjust this value as needed */

    }

    .submit-button {
        background-color: red;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 15px; /* Custom border radius */
        font-size: 1em;
        cursor: pointer;
        width: 100px; /* Set desired width */
        height: 25px; /* Set desired height */
        display: flex; /* Add this to make it a flex container */
        align-items: center; /* Centers the text vertically */
        justify-content: center; /* Centers the text horizontally */
    }

    .submit-button:hover {
        background-color: darkred; /* Hover effect */
    }

    .button-container .prev-button {
        background-color: transparent;
        color: #333;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        width: 100px; /* Set desired width */
        height: 25px; /* Set desired height */
        display: flex; /* Add this to make it a flex container */
        align-items: center; /* Centers the text vertically */
        justify-content: center; /* Centers the text horizontally */
    }

    .button-container .next-button {
        background-color: red;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 15px; /* Custom border radius */
        font-size: 1rem;
        cursor: pointer;
        width: 200px; /* Set desired width */
        height: 35px; /* Set desired height */
        display: flex;
        align-items: center; /* Centers the text vertically */
        justify-content: center; /* Centers the text horizontally */
    }

    .button-container .next-button:hover {
        background-color: darkred;
    }

    .button-container .prev-button:hover {
        text-decoration: underline;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {

        .steps {
            flex-direction: row;
            justify-content: space-between;
            padding-left: 0;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .steps::before {
            display: none;
            width: 50px;
            height: 50px;
        }

        .step {
            flex-direction: column;
            text-align: center;
            margin: 0;
            font-size: 1.75rem; /* Even smaller font size for smaller screens */
        }

        .step::before {
            height:30px;
            width:30px;
            margin: 0 auto 5px;
        }



    }

    .select2 {
        width:100%!important;


    }
    .select2-selection {
        height: 2.25rem!important;
        background-color:#f3f3f3!important;
        border: 1px solid #dddddd !important;
        border-radius: 0!important;
        padding-top: 0.125rem;

    }

    .select2-selection__arrow{
        padding-top: 1.95rem;
    }


    input::placeholder {
        font-size: 0.8em;
        color: #6c757d;
    }

    option::placeholder {
        font-size: 0.8em;
        color: #6c757d;
    }

    select::placeholder {
        font-size: 0.8em;
        color: #6c757d;
    }

</style> --}}


<style>
        /* General Container */
    .container-form {
        background-color: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    /* Title Styles */
    .alfc-title {
        font-size: 2.25rem; /* Equivalent to fs-6 */
        margin-top: 3rem;
    }

    .main-title {
        font-family: "Poppins-Bold";
    }

    /* Logo Styles */
    .alfc-logo {
        max-width: 50px;
    }

    @media (max-width: 767px) {
        .alfc-logo {
            max-width: 100px;
        }
    }

    /* Responsive Title */
    @media (min-width: 768px) {
        .alfc-title {
            font-size: 0.8rem; /* Equivalent to fs-1 */
            margin-top: 0.5rem;
        }
    }



    /* Steps Container */
    .steps {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* Connector Line */
    .steps::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background-color: #EFEFEF;
        z-index: -1;
        transition: background-color 0.3s;
    }

    /* Step Styles */
    .step {
        display: flex;
        align-items: center;
        cursor: pointer;
        margin: 10px 0;
        font-size: 0.85em; /* Smaller font size */
        color: #b0bec5;
        position: relative;
    }

    .step input[type="radio"] {
        display: none;
    }

    .step.active {
        color: black;
        font-weight: bold;
    }

    /* Step Circle */
    .step::before {
        content: '';
        width: 20px;
        height: 20px;
        border: 0px solid #EFEFEF;
        border-radius: 50%;
        margin-right: 10px;
        transition: background-color 0.1s, border-color 0.1s;
        position: relative;
        z-index: 1;
        background-color: #EFEFEF;
    }

    .step.completed {
        color: #EFEFEF;
    }

    .step.completed::before {
        background-color: #EFEFEF;
        border-color: #EFEFEF;
    }

    .step.active::before {
        background-color: red;
        border-color: #EFEFEF;
        border-width: 4px;
    }

    .step:hover::before {
        border-color: #007bff;
    }

    /* Form Input Styles */
    .form-control {
        background-color: #f3f3f3;
    }

    .uppercase-input {
        text-transform: uppercase; /* Automatically converts text to uppercase */
    }

    .form-control:disabled {
        background-color: #bdbdbd;
    }

    .form-control:focus {
        border-color: #8a8a8a4b;
        box-shadow: 0 0 0 0.2rem #8a8a8a4b;
    }

    /* Uppercase Input */
    .uppercase-input {
        text-transform: uppercase;
    }

    .uppercase-input::placeholder {
        text-transform: none;
    }

    /* Input Fields */
    form input {
        background-color: red;
    }

    form select,
    form button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1em;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        margin: 0;
    }

    /* Placeholder Styles */
    input::placeholder,
    option::placeholder,
    select::placeholder {
        font-size: 0.8em;
        color: #6c757d;
    }

    /* Button Styles */
    .button-container {
        margin-top: 170px;
        display: flex;
        justify-content: flex-end;
        right: 20px;
    }

    .submit-button,
    .next-button {
        background-color: red;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 15px;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .submit-button {
        width: 100px;
        height: 25px;
    }

    .submit-button:hover {
        background-color: darkred;
    }

    .next-button {
        width: 200px;
        height: 35px;
    }

    .next-button:hover {
        background-color: darkred;
    }

    /* Previous Button */
    .prev-button {
        background-color: transparent;
        color: #333;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        width: 100px;
        height: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .prev-button:hover {
        text-decoration: underline;
    }

    /* Form Step Visibility */
    .form-step {
        display: none;
    }

    .form-step.active {
        display: block;
    }

    /* Form Content */
    .form-content {
        padding: 20px;
        padding-bottom: 0;
    }

    /* Heading */
    h3 {
        margin-bottom: 5px;
    }

    /* Select2 Styles */
    .select2 {
        width: 100% !important;
    }

    .select2-selection {
        height: 2.25rem !important;
        background-color: #f3f3f3 !important;
        border: 1px solid #dddddd !important;
        border-radius: 0 !important;
        padding-top: 0.125rem;
    }

    .select2-selection__arrow {
        padding-top: 1.95rem;
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .steps {
            flex-direction: row;
            justify-content: space-between;
            padding-left: 0;
            padding-top: 2rem;
            padding-bottom: 2rem;
        }

        .steps::before {
            display: none;
            width: 50px;
            height: 50px;
        }

        .step {
            flex-direction: column;
            text-align: center;
            margin: 0;
            font-size: 1.75rem;
        }

        .step::before {
            height: 30px;
            width: 30px;
            margin: 0 auto 5px;
        }
    }



</style>


<!-- Include Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


    <div class="container-form min-vh-100">
        <div class="row px-3">
            <!-- Steps section (Sidebar) -->
            <div class="col-md-2 mt-md-3 col-12 sidebar px-4">

                <div class="logo-container d-md-flex flex-column align-items-center text-center mt-3 mb-5 pt-md-1 pt-md-1 pt-sm-5">
                    <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="Logo" class="img-fluid alfc-logo mb-3">
                    <p class="fw-bold mb-0 alfc-title">
                        ALFC Insurance Agency Inc.
                    </p>
                </div>

                <div class="steps mb-5" id="stepsContainer">
                    <label class="step active fw-bold">
                        <input type="radio" name="step" value="1" checked disabled>
                        Insurance Details
                    </label>
                    <label class="step">
                        <input type="radio" name="step" value="2" disabled>
                        Commissions
                    </label>
                </div>

            </div>

            <!-- Form content section -->
            <div class="col-md-10 col-12 form-content pt-md-5">

                <!-- Step 1: Insurance Information -->
                <div class="form-step active px-md-3 mb-md-5">
                    <h3 class="main-title fw-bold fs-1 mt-md-5">Insurance Details</h3>
                    <p class="sub-main-title text-muted mb-md-5">Input the assured's personal details and information accurately.</p>

                    <form id="step1 mt-md-5 mb-md-5">

                        {{-- Assured Name --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mt-md-3 mt-sm-5">
                                    <label for="assuredNameLabel" class="form-label fw-bold">Client Name / Assured Name</label>
                                    <input type="text"
                                        class="form-control uppercase-input rounded-0 border-1"
                                        id="assuredName"
                                        placeholder="Enter Client's Name"
                                        autocomplete="off"
                                        required>
                                </div>
                                <ul id="suggestions" class="list-group mt-2 w-25" style="display: none; position: absolute; z-index: 1000;">
                                    <!-- Suggestions will appear here -->
                                </ul>
                            </div>
                            <input type="hidden" id="clientId" name="clientId">
                        </div>

                        {{-- Lot Number, Street, and Barangay --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-2 mt-md-3 mt-sm-4">
                                    <label for="unitNoLabel" class="form-label fw-bold">Lot Number</label>
                                    <input type="text" class="form-control rounded-0 border-1 rounded-0 border-1" id="unitNo" placeholder="Enter lot number or unit number" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-2 mt-md-3 mt-sm-4">
                                    <label for="streetLabel" class="form-label fw-bold">Street</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="street" name="street" placeholder="Enter Street" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-2 mt-md-3 mt-sm-4">
                                    <label for="barangayLabel" class="form-label fw-bold">Barangay</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="barangay" placeholder="Enter Barangay" required>
                                </div>
                            </div>
                        </div>

                        {{-- City and Country --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-2 mt-md-2 mt-sm-4">
                                    <label for="cityLabel" class="form-label fw-bold">City</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="city" placeholder="Enter City" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-2 mt-md-2 mt-sm-4">
                                    <label for="countryLabel" class="form-label fw-bold">Country</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="country" placeholder="Enter Country" required>
                                </div>
                            </div>
                            <input type="hidden" id="fullAddress" name="fullAddress">
                        </div>

                        {{-- Address and Contact Number --}}
                        <div class="row ">
                            <div class="col-md-6">
                                <div class="mb-4 mb-md-4 mb-sm-5 mt-md-2">
                                    <label for="assuredEmailLabel" class="form-label fw-bold fw-bold">Email</label>
                                    <input type="text" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="assuredEmail" placeholder="Enter Email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4 mb-md-4 mb-sm-5 mt-md-2">
                                    <label for="assuredContactNumberLabel" class="form-label fw-bold fw-bold">Contact Number</label>
                                    <input type="text" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="assuredContactNumber" placeholder="Enter Assured Address" required>
                                </div>
                            </div>
                        </div>

                        {{-- Issuance Code --}}
                        <div class="row ">
                            <div class="col-md-8">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-5 mt-sm-4">
                                    <label for="sssuanceCodeLabel" class="form-label fw-bold fw-bold">Issuance Code</label>
                                    <input type="text" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="IssuanceCode" placeholder="Enter Issuance Code" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-5 mt-sm-4">
                                    <label for="team-label" class="form-label fw-bold fs-6">Team</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="team" required>
                                        <option value="" selected>Select Team</option>
                                        @foreach($teams as $team)
                                            <option value="{{ $team->id }}">{{ $team->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Team and SA/SM --}}
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-2">
                                    <label for="salesAssociateLabel" class="form-label fw-bold fs-6">SA</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="salesAssociate">
                                        <option value="" selected>SA</option>
                                        @foreach($salesAssociates as $salesAssociate)
                                            <option value="{{ $salesAssociate->id }}">{{ $salesAssociate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-2">
                                    <label for="salesManagerLabel" class="form-label fw-bold fs-6">SM</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="salesManager">
                                        <option value="" selected>SM</option>
                                        @foreach($salesManagers as $salesManager)
                                            <option value="{{ $salesManager->id }}">{{ $salesManager->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
<!-- --------------- ILALAGAY YUNG RM (regional manager) -->
                        </div>

                        {{-- Classification and Sale Status --}}
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-2">
                                    <label for="saleDateLabel" class="form-label fw-bold fw-bold">Sale Date</label>
                                    <input type="date" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="saleDate"  required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-2">
                                    <label for="classificationLabel" class="form-label fw-bold fw-bold fs-6">Classification</label>
                                    <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="classification" required>
                                        <option value="" disabled selected>Select Classification</option>
                                        <option value="New">New</option>
                                        <option value="Renewal">Renewal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-3 mb-sm-4 mt-md-2">
                                    <label for="insuranceTypeLabel" class="form-label fw-bold">Sale/Cancellation/Reinstatement</label>
                                    <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="saleStatus" required>
                                        <option value="" disabled selected>Select Sale Status</option>
                                        <option value="Sale">Sale</option>
                                        <option value="Reinstatement">Reinstatement</option>
                                        <option value="Cancellation">Cancellation</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Product, Sub-Product, and Product Type --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-5 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="productLabel" class="form-label fw-bold fs-6">Product</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="product" required>
                                        <option value="" selected disabled>Select Products</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-5 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="subProductLabel" class="form-label fw-bold fs-6">Sub-Product</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="subProduct" required>
                                        <option value="" disabled selected>Select Sub-Product</option>
                                        @foreach($subproducts as $subproduct)
                                            <option value="{{ $subproduct->id }}">{{ $subproduct->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="mb-5 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="productTypeLabel" class="form-label fw-bold fw-bold fs-6">Product Type</label>
                                    <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="productType">
                                        <option value="" disabled selected>Select Product Type</option>
                                        <option value="refinancing">Refinancing</option>
                                        <option value="financing">Financing</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Source, Source Branch, and If GDFI --}}
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="sourceLabel" class="form-label fw-bold fw-bold fs-6">Source</label>

                                    <select class="form-control rounded-0 border-1 m-0" id="selectSources" required>
                                        <option value="" disabled selected>Select Source</option>
                                        @foreach($sources as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="sourceBranchLabel" class="form-label fw-bold fw-bold fs-6">Affi Branch</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="sourceBranch" required>
                                        <option value="" disabled selected>Select Source Branch</option>
                                        @foreach($sourcebranches as $sourcebranch)
                                            <option value="{{ $sourcebranch->id }}">{{ $sourcebranch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
<!-- ---------------------- IfGDFI change to DIVISION -->
                            <div class="col-md-4" id="gdficol" style="display: none;">
                                <div class="mb-5 mb-md-4 mb-sm-4">
                                    <label for="ifGdfiLabel" class="form-label fw-bold fw-bold fs-6">If GDFI</label> 
                                    <select class="form-control rounded-0 border-1 m-0" id="ifGdfi">
                                        <option value="" disabled selected>Select If GDFI</option>
                                        @foreach($ifGdfis as $ifGdfi)
                                            <option value="{{ $ifGdfi->id }}">{{ $ifGdfi->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Area, Mortagee, and ALFC Branch --}}
                        <div class="row mb-md-5">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="mortgageeLabel" class="form-label fw-bold fw-bold fs-6">Mortagee</label>
                                    <input type="text" class="form-control rounded-0 rounded-0 border-1" id="mortgagee" placeholder="Enter Mortgagee" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="areaLabel" class="form-label fw-bold fw-bold fs-6">Area</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="area">
                                        <option value="" disabled selected>Select Area</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="alfcBranchLabel" class="form-label fw-bold fw-bold fs-6">ALFC Branch</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="alfcBranch">
                                        <option value="" disabled selected>Select ALFC Branch</option>
                                        @foreach($alfcbranches as $alfcbranch)
                                            <option value="{{ $alfcbranch->id }}">{{ $alfcbranch->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="loanAmountLabel" class="form-label fw-bold fw-bold fs-6">Loan Amount</label>
                                    <input type="text" class="form-control formatted-input rounded-0 rounded-0 border-1" id="loanAmount" placeholder="Enter Loan Amount" required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="totalSumInsuredLabel" class="form-label fw-bold fw-bold fs-6">Total Sum Insured </label>
                                    <input type="text" class="form-control formatted-input rounded-0 rounded-0 border-1" id="totalSumInsured" placeholder="Enter Total Sum Insured" required>
                                </div>
                            </div>
                        </div>

                        {{-- Policy Inception Date and Expiry Date --}}
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="mb-5 mb-md-5 mb-sm-4 mt-md-2">

                                    <label for="policyInceptionLabel" class="form-label fw-bold fw-bold fs-6">Policy Inception Date</label>
                                    <input type="date" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="policyInception" placeholder="Enter Policy Inisu" required>

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-5 mb-md-5 mb-sm-4 mt-md-2">
                                    <label for="expiryDateLabel" class="form-label fw-bold fw-bold fs-6">Expiry Date</label>
                                    <input type="date" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="expiryDate" placeholder="Enter Policy Number" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="policyNumberLabel" class="form-label fw-bold fw-bold fs-6">Policy Number</label>
                                    <input type="text" class="form-control rounded-0 rounded-0 border-1" id="policyNumber" placeholder="Enter Policy Number" required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="mb-5 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="plateConductionNumberLabel" class="form-label fw-bold fw-bold fs-6">Plate / Conduction Number</label>
                                    <input type="text" class="form-control rounded-0 rounded-0 border-1" id="plateConductionNumber" placeholder="Enter Plate Conduction Number" required>
                                </div>
                            </div>
                            <div class="col-md-4 ">
                                <div class="mb-5 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="descriptionLabel" class="form-label fw-bold fw-bold fs-6">Description</label>
                                    <input type="text" class="form-control rounded-0 rounded-0 border-1" id="description" placeholder="Enter Description" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 ">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="mopLabel" class="form-label fw-bold fw-bold fs-6">Mode of Payment</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="mop">
                                        <option value="" disabled selected>Select Mode of Payment</option>
                                        @foreach($mops as $mop)
                                            <option value="{{ $mop->id }}">{{ $mop->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="button-container mb-md-5 mb-mt-5">
                            <button type="button" class="prev-button" onclick="cancelStep()">Cancel</button>
                            <button type="button" class="next-button" onclick="nextStep()">Next</button>
                        </div>
                    </form>
                </div>

                <!-- Step 2: Commission Details-->
                <div class="form-step px-3 mb-md-5">
                    <h3 class="main-title fw-bold fs-1 mt-md-5">Commissions</h3>
                    <p class="sub-main-title text-muted mb-md-5">Enter Commissions Details and Information</p>

                    <form id="step2 mt-md-5">
                        {{-- Provider --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="prNumberLabel" class="form-label fw-bold">PR#</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="prNumber" placeholder="Enter PR Number" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="providerlabel" class="form-label fw-bold fw-bold fs-6">Provider</label>
                                    <select class="form-control rounded-0 border-1 m-0" id="provider" required>
                                        <option value="" selected>Select Provider</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Gross Premium, Discount, and Gross Premium, Net of Discount --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="grossPremiumLabel" class="form-label fw-bold">Gross Premium</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="grossPremium" placeholder="Enter Gross Premium" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="discountLabel" class="form-label fw-bold">Discount</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="discount" placeholder="Enter Discount" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-5">
                                    <label for="netOfDiscountLabel" class="form-label fw-bold">Gross Premium, Net of Discount</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="netOfDiscount"  disabled required>
                                </div>
                            </div>
                        </div>

                        {{-- Amount Due to Provider and Full Commission --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="amountDuetoProviderLabel" class="form-label fw-bold">Amount Due to Provider</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="amountDuetoProvider" placeholder="Enter Amount Due to Provider" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="fullCommissionLabel" class="form-label fw-bold">Full Commission</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="fullCommission"  disabled required>
                                </div>
                            </div>
                        </div>

                        <div id="commissionContainer">
                        </div>

                        <div class="row mb-md-5">
                            <div class="col-md-4 mb-5 mb-md-5 mb-sm-5">
                                <button type="button" class="bg-secondary" id="addButton">ADD</button>
                            </div>
                            <div class="col-md-4 mb-5 mb-md-5 mb-sm-5">
                                <!-- Initially hidden remove button -->
                                <button type="button" class="bg-danger" id="removeButton" style="display: none;">REMOVE</button>
                            </div>
                        </div>

                        {{-- Travel Incentives, Offsetting, and Promo --}}
                        <!-- <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="travelIncentivesLabel" class="form-label fw-bold">Travel Incentives</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="travelIncentives" placeholder="Enter Travel Incentives" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="offsettingLabel" class="form-label fw-bold">Offsetting</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="offSetting" placeholder="Enter Offsetting" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-4 mb-sm-4 mt-md-2">
                                    <label for="promoLabel" class="form-label fw-bold">Promo</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="promo" placeholder="Enter Promo Amount" required>
                                </div>
                            </div>
                        </div> -->

                        {{-- Comm Deduct and Total Commission --}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-2 mb-sm-4">
                                    <label for="totalCommissionLabel" class="form-label fw-bold">Total Commission</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="totalCommission" required disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-2 mb-sm-4">
                                    <label for="commDeductLabel" class="form-label fw-bold">Comm Deduct</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="commDeduct" placeholder="Enter Comm Deduct" required>
                                </div>
                            </div>
                        </div>

                        {{-- VAT, Sales Credit, and Sales Credit % --}}
                        <div class="row mt-md-3">
                            <div class="col-md-4">
                                <div class="mb-3 mb-md-5 mb-sm-4">
                                    <label for="vatLabel" class="form-label fw-bold">VAT</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="vatInput" required disabled>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3 mb-md-5 mb-sm-4">
                                    <label for="salesCreditLabel" class="form-label fw-bold">Sales Credit</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="salesCredit" required disabled>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3 mb-md-5 mb-sm-4">
                                    <label for="salesCreditPercentLabel" class="form-label fw-bold">Sales Credit %</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="salesCreditPercent" required disabled>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Terms --}}
                        <div class="row mb-md-1 mt-md-5">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="paymentTermsLabel" class="form-label fw-bold">Payment Terms</label>
                                    <input
                                        type="number"
                                        class="form-control rounded-0 border-1"
                                        id="paymentTerms"
                                        placeholder="Enter Payment Terms"
                                        required
                                        min="1"
                                        max="8"
                                        oninput="validatePaymentTerms()"
                                        onfocus="clearValidation()"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="dueDateStartLabel" class="form-label fw-bold">Due Date Start</label>
                                    <input type="date" class="form-control uppercase-input rounded-0 border-1" id="dueDateStart" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="dueDateEndLabel" class="form-label fw-bold">Due Date End</label>
                                    <input type="date" class="form-control uppercase-input rounded-0 border-1" id="dueDateEnd" required>
                                </div>
                            </div>
                        </div>

                        {{-- Payments --}}
                        <div class="mb-md-3 mt-md-5" id="schedulePaymentTerms">
                        </div>


<!-- --------------- BUBURAHIN SIMULA DITO -->
                        <div class="row mt-md-5">
                            <div class="col-md-4 mt-md-5">
                                <div class="mb-4 mb-md-3 mb-sm-4">
                                    <label for="initialPaymentLabel" class="form-label fw-bold">Initial Payment</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="initialPayment" placeholder="Enter Initial Payment" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-3">
                                    <label for="dateGoodSalesLabel" class="form-label fw-bold">Date of Good as Sales</label>
                                    <input type="date" class="form-control uppercase-input rounded-0 border-1" id="dateGoodSales" placeholder="Enter Date of Good as Sales" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-3">
                                    <label for="forBillingLabel" class="form-label fw-bold">For Billing</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="forBilling" placeholder="Enter For Billing" required>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4 mt-md-3">
                                    <label for="overUnderPaymentLabel" class="form-label fw-bold">Over (Under) Payment</label>
                                    <input type="text" class="form-control formatted-input rounded-0 border-1" id="overUnderPayment" placeholder="Enter Over or Under Payment" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-4 mb-md-4 mb-sm-4">
                                    <label for="statusPaymentLabel" class="form-label fw-bold">Status</label>
                                    <input type="text" class="form-control rounded-0 border-1" id="statusPayment" placeholder="Enter status, e.g., GOOD AS SALES or SJ-GMA092024-1" required>
                                </div>
                            </div>
                        </div>
<!-- --------------- HANGGANG DITO -->

<!-- --------------- IDADAGDAG DITO ADMIN ASST REMARKS-->
<!-- --------------- IDADAGDAG DITO TRACKING NUMBER -->
<!-- --------------- IDADAGDAG DITO MODE OF DELIVERY (POLICY) -->
 
                        <div class="button-container mb-md-5 mb-mt-5">
                            <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                            <button type="button" class="submit-button" onclick="submitForm(event)">Submit</button>
                        </div>


                    </form>
                </div>

            </div>

        </div>
    </div>






<script>

    let currentStep = 0;
    let index = 0;
    const commissions = [];

    const placeholderMap = {
        classification: "Select Classification",
        saleStatus: "Select Sale Status",
        team: "Select Team",
        salesAssociate: "Select Sale Associate",
        salesManager: "Select Sale Manager",
        provider: "Select Provider",
        productType: "Select Product Type",
        subProduct: "Select Sub-Product",
        product: "Select Product",
        selectSources: "Select Source",
        sourceBranch: "Select Source Branch",
        ifGdfi: "Select GDFI",
        area: "Select Area",
        alfcBranch: "Select ALFC Branch",
        mop: "Select Mode of Payment"
    };


    const inputs = document.querySelectorAll('input, select, change');

    const formSteps = document.querySelectorAll('.form-step');
    const stepIndicators = document.querySelectorAll('.sidebar .step');
    const storedData = sessionStorage.getItem('formData');


    //FIRST FORM
    const assuredNameInput = document.getElementById('assuredName');
    const assuredNameID = document.getElementById('clientId');



    const fullAddressInput = document.getElementById('fullAddress');
    const unitNoInput = document.getElementById('unitNo');
    const streetInput = document.getElementById('street');
    const barangayInput = document.getElementById('barangay');
    const cityInput = document.getElementById('city');
    const countryInput = document.getElementById('country');
    const addressFields = [unitNoInput, streetInput, barangayInput, cityInput];

    const assuredEmailInput = document.getElementById('assuredEmail');
    const assuredContactNumberInput = document.getElementById('assuredContactNumber');

    const IssuanceCodeInput = document.getElementById('IssuanceCode');
    const classificationSelect = document.getElementById('classification');
    const saleStatusSelect = document.getElementById('saleStatus');

    const saleDateDateSelect = document.getElementById('saleDate');
    const teamSelect = document.getElementById('team');

    const salesAssociateSelect = document.getElementById('salesAssociate');
    const salesManagerSelect = document.getElementById('salesManager');

    const providerSelect = document.getElementById('provider');
    const policyNumberInput = document.getElementById('policyNumber');


    const plateConductionNumberInput = document.getElementById('plateConductionNumber');
    const descriptionInput = document.getElementById('description');
    const loanAmountInput = document.getElementById('loanAmount');
    const totalSumInsuredInput = document.getElementById('totalSumInsured');
    const mopSelect = document.getElementById('mop');








    const policyInceptionDateSelect = document.getElementById('policyInception');
    const expiryDateSelect = document.getElementById('expiryDate');

    const productSelect = document.getElementById('product');
    const subProductSelect = document.getElementById('subProduct');
    const productTypeSelect = document.getElementById('productType');
    const sourceSelect = document.getElementById('selectSources');
    const sourceBranchSelect = document.getElementById('sourceBranch');
    const ifGdfiSelect = document.getElementById('ifGdfi');
    const mortgageeInput = document.getElementById('mortgagee');
    const areaSelect = document.getElementById('area');
    const alfcBranchSelect = document.getElementById('alfcBranch');

    const selecDropdownIds = document.querySelectorAll('select');


    //SECOND FORM
    const grossPremiumInput = document.getElementById('grossPremium');
    const discountInput = document.getElementById('discount');
    const netOfDiscountInput = document.getElementById('netOfDiscount');
    const amountDuetoProviderInput = document.getElementById('amountDuetoProvider');
    const fullCommissionInput = document.getElementById('fullCommission');

    // const travelIncentivesInput = document.getElementById('travelIncentives');
    // const offSettingInput = document.getElementById('offSetting');
    // const promoInput = document.getElementById('promo');
    const commDeductInput = document.getElementById('commDeduct');

    let fullCommissionValue = 0;
    const totalCommissionInput = document.getElementById('totalCommission');
    let totalCommission = 0;

    const vatInput = document.getElementById('vatInput');
    const salesCreditInput  = document.getElementById('salesCredit');
    const salesCreditPercentInput = document.getElementById('salesCreditPercent');

    let vatValue = 0;
    let salesCredit = 0;
    let salesCreditPercent = 0;


    const paymentTermsInputs = document.getElementById('paymentTerms');
    const dueDateStartInputs = document.getElementById('dueDateStart');
    const dueDateEndInputs = document.getElementById('dueDateEnd');

    const schedulePaymentInputs = document.getElementById('SchedulePayment1');


    const initialPaymentInputs = document.getElementById('initialPayment');
    const dateGoodSalesSelect = document.getElementById('dateGoodSales');
    const forBillingInputs = document.getElementById('forBilling');
    const overUnderPaymentInputs = document.getElementById('overUnderPayment');
    const prNumberInputs = document.getElementById('prNumber');
    const statusPaymentInputs = document.getElementById('statusPayment');





    $(document).ready(function() {

        const savedStep = sessionStorage.getItem('currentStep');
        if (savedStep) {
            currentStep = parseInt(savedStep, 10);
        }

        document.querySelectorAll('.step input[type="radio"]').forEach((radio, index) => {
            radio.addEventListener('change', () => {
                currentStep = index;
                sessionStorage.setItem('currentStep', currentStep);
                showStep(currentStep);
            });
        });

        showStep(currentStep);
        attachRadioChangeHandlers();
        loadFormData();
        checkIfGDFI();


        autoCompletePersonalDetails();

        selecDropdownIds.forEach(select => {
            const id = $(select).attr('id');
            const placeholderText = placeholderMap[id] || "Default Placeholder";

            $(select).select2({
                allowClear: true,
                placeholder: placeholderText,  // Set dynamic placeholder here
                minimumResultsForSearch: 5,
                dropdownPosition: 'below',
                debug: true
            });

            // Handle select change
            $(select).on('select2:select', function() {
                saveFormData();
            });

            // Handle select clear
            $(select).on('select2:unselect', function() {
                saveFormData();  // Ensure session is updated when cleared
            });


        });


        // Handle team selection change
        $('#team').on('select2:select', function(e) {
            const teamId = e.params.data.id; // Get the selected team's ID

            // Get the sales associates and sales managers dropdowns
            const $salesAssociateSelect = $('#salesAssociate');
            const $salesManagerSelect = $('#salesManager');

            // Reset options in sales associate and sales manager dropdowns
            $salesAssociateSelect.empty().append('<option value="" selected>SA</option>');
            $salesManagerSelect.empty().append('<option value="" selected>SM</option>');

            // Filter the sales associates and managers based on the selected team
            const allSalesAssociates = @json($salesAssociates); // Passing PHP array to JS
            const allSalesManagers = @json($salesManagers); // Assuming $salesManagers is passed to JS

            const filteredAssociates = allSalesAssociates.filter(associate => associate.team_id == teamId);
            const filteredManagers = allSalesManagers.filter(manager => manager.team_id == teamId);

            // Add filtered options to the sales associate dropdown
            filteredAssociates.forEach(associate => {
                const newOption = new Option(associate.name, associate.id, false, false);
                $salesAssociateSelect.append(newOption);
            });

            // Add filtered options to the sales manager dropdown
            filteredManagers.forEach(manager => {
                const newOption = new Option(manager.name, manager.id, false, false);
                $salesManagerSelect.append(newOption);
            });

            // Refresh the Select2 plugin for the updated options
            $salesAssociateSelect.trigger('change.select2');
            $salesManagerSelect.trigger('change.select2');
            saveFormData();
        });

        $('#product').on('change', function() {
            const productId = $(this).val(); // Get the selected product ID

            // Get the sub-product dropdown
            const $subProductSelect = $('#subProduct');

            // Reset options in the sub-product dropdown
            $subProductSelect.empty().append('<option value="" disabled selected>Select Sub-Product</option>');

            // Filter the sub-products based on the selected product
            const allSubProducts = @json($subproducts); // Passing PHP array to JS
            const filteredSubProducts = allSubProducts.filter(subProduct => subProduct.product_id == productId);

            // Add filtered options to the sub-product dropdown
            filteredSubProducts.forEach(subProduct => {
                const newOption = new Option(subProduct.name, subProduct.id, false, false);
                $subProductSelect.append(newOption);
            });

            // Refresh the Select2 plugin for the updated options (if using Select2)
            $subProductSelect.trigger('change.select2');
            saveFormData();

        });



        $('#selectSources').on('change', function() {
            checkIfGDFI();
            saveFormData();
        });


        addressFields.forEach(field => {
            field.addEventListener('input', updateFullAddress);
        });


        // Attach event listeners for input and change events
        inputs.forEach(input => {
            input.addEventListener('input', saveFormData);
            input.addEventListener('change', saveFormData);
        });


        //Formatting of of number to put coma and decimal
        document.querySelectorAll('.formatted-input').forEach(input => {
            // Focus event: Show raw value without formatting
            input.addEventListener('focus', function () {
                // Store the raw value to ensure it's available in case the user doesn't modify it
                this.dataset.rawValue = this.dataset.rawValue || this.value.replace(/,/g, '');
                this.value = this.dataset.rawValue;
            });

            // Input event: Capture raw value without commas for calculation
            input.addEventListener('input', function () {
                // Store raw value without commas for calculation
                this.dataset.rawValue = this.value.replace(/,/g, ''); // Store raw value
            });

            // Blur event: Format value with commas and 2 decimal places
            input.addEventListener('blur', function () {
                let rawValue = this.dataset.rawValue || this.value;
                let numberValue = parseFloat(rawValue);

                // If the value is a valid number, format with commas and 2 decimal places
                if (!isNaN(numberValue)) {
                    this.value = numberValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                } else {
                    this.value = '0.00'; // If not a valid number, set it to '0.00'
                }
            });
        });




        // Specific event listeners for individual fields
        grossPremiumInput.addEventListener('input', getNetOfDiscount);
        discountInput.addEventListener('input', getNetOfDiscount);
        grossPremiumInput.addEventListener('input', getFullComm);
        amountDuetoProvider.addEventListener('input', getFullComm);
        discountInput.addEventListener('input', getFullComm);




        // travelIncentivesInput.addEventListener('input', getCommissionsValue);
        // offSettingInput.addEventListener('input', getCommissionsValue);
        // promoInput.addEventListener('input', getCommissionsValue);


        addCommissionsInput();
        clearValidation();


        function formatDateToText(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('en-US', options);
        }


        paymentTermsInputs.addEventListener('change', validatePaymentTerms);
        dueDateStartInputs.addEventListener('change', calculateDueDateEnd);
        paymentTermsInputs.addEventListener('input', calculateSchedulePaymentsAmount);
        calculateDueDateEnd();



        // calculateSchedulePaymentsAmount();

    });




    //STEPS FUNCTIONS
    function showStep(step) {
        formSteps.forEach((formStep, index) => {
            formStep.classList.toggle('active', index === step);
            stepIndicators[index].classList.toggle('active', index === step);

            if (index < step) {
                stepIndicators[index].classList.add('completed');
            } else {
                stepIndicators[index].classList.remove('completed');
            }
            if (index === step) {
                stepIndicators[index].querySelector('input[type="radio"]').checked = true;
            }
        });
    }

    function nextStep(){
        event.preventDefault();

        // if (validateStep(currentStep)) {
            saveFormData(); // Save form data
            if (currentStep < formSteps.length - 1) {
                currentStep++;
                sessionStorage.setItem('currentStep', currentStep);
                showStep(currentStep);

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });


            }
        // }



    }

    function prevStep(){
        event.preventDefault();

        saveFormData(); // Save form data
        if (currentStep > 0) {
            currentStep--;
            sessionStorage.setItem('currentStep', currentStep);
            showStep(currentStep);

            window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });



        }
    }

    function attachRadioChangeHandlers(){
        $('.step input[type="radio"]').each(function(index) {
            $(this).on('change', function() {
                currentStep = index;
                showStep(currentStep);
            });
        });
    }

    function getErrorMessage(input) {
        if (input.validity.valueMissing) {
            return 'This field is required.';
        } else if (input.validity.patternMismatch) {
            return 'Please follow the requested format.';
        } else if (input.validity.tooShort) {
            return `Please enter at least ${input.minLength} characters.`;
        }
        return 'This field is invalid.';
    }

    function validateStep(step) {
        const inputs = formSteps[step].querySelectorAll('input[required], textarea[required], select[required]');
        let isValid = [...inputs].every(input => input.checkValidity());

        inputs.forEach(input => {
            const errorMessage = input.parentNode.querySelector('.error-message');
            if (!input.checkValidity()) {
                if (!errorMessage) {
                    const error = document.createElement('span');
                    error.classList.add('error-message', 'text-danger');
                    error.innerText = getErrorMessage(input);
                    input.parentNode.appendChild(error);
                }
            } else if (errorMessage) {
                errorMessage.remove();
            }
        });

        return isValid;
    }



    //SESSIONS FUNCTIONS
    // Function to save form data to sessionStorage
    function saveFormData() {
        const formData = getFormValues();
        sessionStorage.setItem('formData', JSON.stringify(formData));
    }

    // Get form data to be saved to sessionStorage
    function getFormValues() {

        const formData = {};

        //FIRST FORM
        formData.assuredNameValue = assuredNameInput.value.toUpperCase();
        formData.assuredIdValue = assuredNameID.value;

        formData.fullAddressValue = fullAddressInput.value;
        formData.unitNoValue = unitNoInput.value;
        formData.streetValue = streetInput.value;
        formData.barangayValue = barangayInput.value;
        formData.cityValue = cityInput.value;
        formData.countryValue = countryInput.value;

        formData.assuredEmailValue = assuredEmailInput.value;
        formData.assuredContactNumberValue = assuredContactNumberInput.value;

        formData.IssuanceCodeValue = IssuanceCodeInput.value;
        formData.classificationValue = classificationSelect.value;
        formData.saleStatusValue = saleStatusSelect.value;
        formData.saleDateValue = saleDateDateSelect.value;

        formData.teamValue = teamSelect.value;
        formData.salesAssociateValue = salesAssociateSelect.value;
        formData.salesManagerValue = salesManagerSelect.value;

        formData.providerValue = providerSelect.value;
        formData.policyNumberValue = policyNumberInput.value;
        formData.policyInceptionValue = policyInceptionDateSelect.value;
        formData.expiryDateValue = expiryDateSelect.value;

        formData.productValue = productSelect.value;
        formData.subProductValue = subProductSelect.value;
        formData.productTypeValue = productTypeSelect.value;
        formData.sourceValue = sourceSelect.value;
        formData.sourceBranchValue = sourceBranchSelect.value;
        formData.ifGdfiValue = ifGdfiSelect.value;
        formData.mortgageeValue = mortgageeInput.value;
        formData.areaValue = areaSelect.value;
        formData.alfcBranchValue = alfcBranchSelect.value;



        formData.plateConductionNumberValue = plateConductionNumberInput.value;
        formData.descriptionValue = descriptionInput.value;
        formData.loanAmountValue = removeCommas(loanAmountInput.value);
        formData.totalSumInsuredValue = removeCommas(totalSumInsuredInput.value);
        formData.mopValue = mopSelect.value;





        //SECOND FORM
        formData.grossPremiumValue = removeCommas(grossPremiumInput.value);
        formData.discountValue = removeCommas(discountInput.value);
        formData.netOfDiscountValue = removeCommas(netOfDiscountInput.value);

        formData.amountDuetoProviderValue = removeCommas(amountDuetoProviderInput.value);
        formData.fullCommissionValue = removeCommas(fullCommissionInput.value);

        formData.commissionsSelect = getCommissionsValue();

        // formData.travelIncentivesValues = removeCommas(travelIncentivesInput.value);
        // formData.offSettingValues = removeCommas(offSettingInput.value);
        // formData.promoValues = removeCommas(promoInput.value);

        formData.totalCommissionValues = removeCommas(totalCommissionInput.value);
        formData.commDeductValues = removeCommas(commDeductInput.value);

        formData.vatValues = removeCommas(vatInput.value);
        formData.salesCreditValues = removeCommas(salesCreditInput.value);
        formData.salesCreditPercentValues = salesCreditPercentInput.value;

        formData.paymentTermsDate = getPaymentTerms();


        formData.paymentTermsValues = paymentTermsInputs.value;
        formData.dueDateStartValues = dueDateStartInputs.value;
        formData.dueDateEndValues = dueDateEndInputs.value;



        formData.initialPaymentValues = removeCommas(initialPaymentInputs.value);
        formData.dateGoodSalesValues = dateGoodSalesSelect.value;
        formData.forBillingValues = removeCommas(forBillingInputs.value);
        formData.overUnderPaymentValues = removeCommas(overUnderPaymentInputs.value);
        formData.prNumberValues = prNumberInputs.value;
        formData.statusPaymentValues = statusPaymentInputs.value;







        return formData;
    }

    // Function to load form data from sessionStorage
    function loadFormData() {

        const storedData = sessionStorage.getItem('formData'); // Assuming data is stored under 'formData'

        if (storedData) {
            const formData = JSON.parse(storedData);
            const TermsValue = formData.paymentTermsValues || 0;

            // Load values into form inputs
            //FIRST FORM
            assuredNameInput.value = formData.assuredNameValue || '';
            formData.assuredIdValue = assuredNameID.value;

            fullAddressInput.value = formData.fullAddressValue || '';
            unitNoInput.value = formData.unitNoValue || '';
            streetInput.value = formData.streetValue || '';
            barangayInput.value = formData.barangayValue || '';
            cityInput.value = formData.cityValue || '';
            countryInput.value = formData.countryValue || '';

            assuredEmailInput.value = formData.assuredEmailValue || '';
            assuredContactNumberInput.value = formData.assuredContactNumberValue || '';

            IssuanceCodeInput.value = formData.IssuanceCodeValue || '';
            classificationSelect.value = formData.classificationValue || '';
            saleStatusSelect.value = formData.saleStatusValue || '';
            saleDateDateSelect.value = formData.saleDateValue || '';

            teamSelect.value = formData.teamValue || '';
            salesAssociateSelect.value = formData.salesAssociateValue || '';
            salesManagerSelect.value = formData.salesManagerValue || '';

            providerSelect.value = formData.providerValue || '';
            policyNumberInput.value = formData.policyNumberValue || '';
            policyInceptionDateSelect.value = formData.policyInceptionValue || '';
            expiryDateSelect.value = formData.expiryDateValue || '';

            productSelect.value = formData.productValue || '';
            subProductSelect.value = formData.subProductValue || '';
            productTypeSelect.value = formData.productTypeValue || '';
            sourceSelect.value = formData.sourceValue || '';
            sourceBranchSelect.value = formData.sourceBranchValue || '';
            ifGdfiSelect.value = formData.ifGdfiValue || '';
            mortgageeInput.value = formData.mortgageeValue || '';
            areaSelect.value = formData.areaValue || '';
            alfcBranchSelect.value = formData.alfcBranchValue || '';


            plateConductionNumberInput.value = formData.plateConductionNumberValue || '';
            descriptionInput.value = formData.descriptionValue || '';
            loanAmountInput.value = formatNumberWithCommas(formData.loanAmountValue || '0');
            totalSumInsuredInput.value = formatNumberWithCommas(formData.totalSumInsuredValue || '0');
            mopSelect.value = formData.mopValue || '';







            //SECOND FORM
            grossPremiumInput.value = formatNumberWithCommas(formData.grossPremiumValue || '0');
            discountInput.value = formatNumberWithCommas(formData.discountValue || '0');
            netOfDiscountInput.value = formatNumberWithCommas(formData.netOfDiscountValue || '0');
            amountDuetoProviderInput.value = formatNumberWithCommas(formData.amountDuetoProviderValue || '0');
            fullCommissionInput.value = formatNumberWithCommas(formData.fullCommissionValue || '0');



            if (formData.commissionsSelect && formData.commissionsSelect.length > 0) {
                const container = document.getElementById('commissionContainer');

                formData.commissionsSelect.forEach((commission, index) => {
                    // Create a new div element to hold the commission fields
                    const newSection = document.createElement('div');
                    newSection.classList.add('row', 'mt-md-0');
                    newSection.innerHTML = `
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="commissionsLabel" class="form-label fw-bold">Commissions</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0 commissionSelect" id="commissionSelect${index}">
                                    <option value="" disabled selected>Select Commissions</option>
                                    @foreach($commissioners as $commissioner)
                                        <option value="{{ $commissioner->id }}">{{ $commissioner->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="commissionNameLabel" class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control rounded-0 border-1 commissionName" id="commissionName${index}" placeholder="Enter a Name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="commissionAmountLabel" class="form-label fw-bold">Amount</label>
                                <input type="text" class="form-control rounded-0 border-1 commissionAmount" id="commissionAmount${index}" placeholder="Enter Amount" required>
                            </div>
                        </div>

                    `;

                    // Append the new section to the container
                    container.appendChild(newSection);

                    // Get the newly created select and input elements
                    const commissionAmount = document.getElementById(`commissionAmount${index}`);
                    const commissionName = document.getElementById(`commissionName${index}`);
                    const commissionSelect = document.getElementById(`commissionSelect${index}`);

                    // Populate the newly created fields with data from formData
                    if (commissionAmount && commissionName && commissionSelect) {
                        commissionAmount.value = formatNumberWithCommas(commission.commissionAmount || '0') // Default if not provided
                        commissionName.value = commission.commissionName || ''; // Default if not provided
                        commissionSelect.value = commission.commissionType || '';   // Default if not provided
                    }


                });

                reapplyFormattingListeners();

            }


            // travelIncentivesInput.value = formatNumberWithCommas(formData.travelIncentivesValues || '0');
            // offSettingInput.value = formatNumberWithCommas(formData.offSettingValues || '0');
            // promoInput.value = formatNumberWithCommas(formData.promoValues || '0');

            totalCommissionInput.value = formatNumberWithCommas(formData.totalCommissionValues || '0');
            commDeductInput.value = formatNumberWithCommas(formData.commDeductValues || '0');

            vatInput.value = formatNumberWithCommas(formData.vatValues || '0');
            salesCreditInput.value = formatNumberWithCommas(formData.salesCreditValues || '0');
            salesCreditPercentInput.value = formData.salesCreditPercentValues || '0';

            paymentTermsInputs.value = formData.paymentTermsValues || '';
            dueDateStartInputs.value = formData.dueDateStartValues || '';
            dueDateEndInputs.value = formData.dueDateEndValues || '';



            if (TermsValue > 0 && Array.isArray(formData.paymentTermsDate)) {
                const schedulePaymentContainer = document.getElementById('schedulePaymentTerms');
                schedulePaymentContainer.innerHTML = ''; // Clear any existing fields

                const paymentAmountInputs = [];
                const paymentDateInputs = [];
                const grossPremiumValue = parseFloat(removeCommas(grossPremiumInput.value)) || 0;

                for (let i = 1; i <= TermsValue; i++) {
                    const paymentTerm = formData.paymentTermsDate[i - 1];
                    if (paymentTerm) {
                        const row = document.createElement('div');
                        row.classList.add('row', 'mt-md-2');

                        const colDate = document.createElement('div');
                        colDate.classList.add('col-md-4');
                        colDate.innerHTML = `
                            <div class="mb-3">
                                <label for="paymentDate${i}" class="form-label fw-bold">${i}${getSuffix(i)} Payment Date</label>
                                <input type="date" id="paymentDate${i}" class="form-control uppercase-input rounded-0 border-1" required>
                            </div>
                        `;

                        const colAmount = document.createElement('div');
                        colAmount.classList.add('col-md-4');
                        colAmount.innerHTML = `
                            <div class="mb-3">
                                <label for="paymentAmount${i}" class="form-label fw-bold">${i}${getSuffix(i)} Payment Amount</label>
                                <input type="text" id="paymentAmount${i}" class="form-control rounded-0 border-1" placeholder="Enter ${i}${getSuffix(i)} Payment Amount" step="0.01" required>
                            </div>
                        `;

                        row.appendChild(colDate);
                        row.appendChild(colAmount);
                        schedulePaymentContainer.appendChild(row);

                        const paymentDateInput = document.getElementById(`paymentDate${i}`);
                        const paymentAmountInput = document.getElementById(`paymentAmount${i}`);

                        const dateKey = `${getOrdinal(i)}_payment_schedule_date`;
                        const amountKey = `${getOrdinal(i)}_payment_schedule_amount`;

                        const rawDate = paymentTerm[dateKey];
                        const formattedDate = formatDateToISO(rawDate);

                        paymentDateInput.value = formattedDate || '';
                        // Use formatNumberWithCommas to format the amount value
                        paymentAmountInput.value = formatNumber(paymentTerm[amountKey]) || '';

                        paymentDateInputs.push(paymentDateInput);
                        paymentAmountInputs.push(paymentAmountInput);

                        reapplyFormattingListenersPayments(paymentAmountInput);
                    }
                }

                attachEventListeners();

                function attachEventListeners() {
                    paymentAmountInputs.forEach((input, index) => {
                        input.addEventListener('input', function () {
                            handlePaymentAmountChange(index);
                            saveFormData();
                        });
                    });

                    if (paymentDateInputs.length > 0) {
                        paymentDateInputs[0].addEventListener('change', function () {
                            const firstDate = new Date(this.value);

                            for (let i = 1; i < paymentDateInputs.length; i++) {
                                const nextDate = new Date(firstDate);
                                nextDate.setMonth(firstDate.getMonth() + i);
                                paymentDateInputs[i].value = nextDate.toISOString().split('T')[0];
                            }
                            saveFormData();
                        });
                    }
                }

                // Reapply the formatting listener on the payment amount inputs
                function reapplyFormattingListenersPayments(input) {
                    input.addEventListener('focus', function () {
                        this.dataset.rawValue = this.dataset.rawValue || this.value.replace(/,/g, '');
                        this.value = this.dataset.rawValue;
                    });

                    input.addEventListener('input', function () {
                        this.dataset.rawValue = this.value.replace(/,/g, '');
                    });

                    input.addEventListener('blur', function () {
                        let rawValue = this.dataset.rawValue || this.value;
                        let numberValue = parseFloat(rawValue);
                        if (!isNaN(numberValue)) {
                            this.value = numberValue.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        } else {
                            this.value = '0.00';
                        }
                    });
                }

                function handlePaymentAmountChange(changedIndex) {
                    let totalPaid = 0;

                    for (let i = 0; i <= changedIndex; i++) {
                        totalPaid += parseFloat(paymentAmountInputs[i].value.replace(/,/g, '')) || 0;
                    }

                    const remainingAmount = grossPremiumValue - totalPaid;
                    const remainingTerms = TermsValue - (changedIndex + 1);

                    if (remainingTerms > 0) {
                        const recalculatedPayment = (remainingAmount / remainingTerms).toFixed(2);

                        for (let i = changedIndex + 1; i < paymentAmountInputs.length; i++) {
                            paymentAmountInputs[i].value = formatNumber(recalculatedPayment);
                        }
                    }
                }

                // Helper function to convert MM/DD/YYYY to YYYY-MM-DD
                function formatDateToISO(dateString) {
                    if (!dateString) return '';
                    const [month, day, year] = dateString.split('/');
                    return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                }

                function getSuffix(index) {
                    const suffixes = ['th', 'st', 'nd', 'rd'];
                    const value = index % 100;
                    return (value - 20) % 10 === 0 || value >= 10 && value <= 20 ? suffixes[0] : suffixes[value % 10] || suffixes[0];
                }

                // Helper function to get ordinal names (first, second, etc.)
                function getOrdinal(index) {
                    const ordinals = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth'];
                    return ordinals[index - 1] || `${index}th`; // Fallback to `${index}th` if needed
                }

                // Helper function to format numbers with commas
                function formatNumber(value) {
                    if (value === null || value === undefined || isNaN(value)) return '0.00'; // Return '0.00' for null, undefined, or NaN
                    // Ensure the value is a number, and round to two decimal places
                    value = parseFloat(value).toFixed(2);
                    // Add commas and return the formatted number
                    return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                }
            }



            initialPaymentInputs.value = formatNumberWithCommas(formData.initialPaymentValues || '0');
            dateGoodSalesSelect.value = formData.dateGoodSalesValues || '';
            forBillingInputs.value = formatNumberWithCommas(formData.forBillingValues || '0');
            overUnderPaymentInputs.value = formatNumberWithCommas(formData.overUnderPaymentValues || '0')
            prNumberInputs.value = formData.prNumberValues || '';
            statusPaymentInputs.value = formData.statusPaymentValues || '';





            // calculateSchedulePaymentsAmount();


        }

    }




    //FORMATTING FUNCTIONS
    function autoCompletePersonalDetails() {
        const assuredNameInput = $('#assuredName');
        const suggestionsBox = $('#suggestions');

        assuredNameInput.on('input', function () {
            const query = $(this).val();

            // Clear all fields on any input (edit or deletion)
            clearInputs();

            if (query.length > 1) {
                $.ajax({
                    url: "{{ route('clients.search') }}",
                    method: 'GET',
                    data: { query: query },
                    success: function (data) {
                        suggestionsBox.empty().show();

                        if (data.length === 0) {
                            suggestionsBox.append('<li class="list-group-item">No results found</li>');
                        } else {
                            data.forEach(client => {
                                suggestionsBox.append(`
                                    <li class="list-group-item list-group-item-action" style="cursor: pointer;"
                                        data-client='${encodeURIComponent(JSON.stringify(client))}'>
                                        ${client.name} (${client.city || 'Unknown'})
                                    </li>
                                `);
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error fetching client data:', error);
                    }
                });
            } else {
                suggestionsBox.hide();
            }
        });

        $(document).click(function (e) {
            if (!$(e.target).closest('#suggestions, #assuredName').length) {
                suggestionsBox.hide();
            }
        });

        $(document).on('click', '#suggestions li', function () {
            const client = JSON.parse(decodeURIComponent($(this).data('client')));
            fillInput(client);
            saveFormData();
        });
    }

    // Clear input fields function
    function clearInputs() {
        $('#clientId').val('');
        $('#unitNo').val('');
        $('#street').val('');
        $('#barangay').val('');
        $('#city').val('');
        $('#country').val('');
        $('#assuredEmail').val('');
        $('#assuredContactNumber').val('');
        $('#suggestions').hide();
    }

    // Fill input fields function
    function fillInput(client) {
        $('#clientId').val(client.encrypted_id || '');
        $('#assuredName').val(client.name || '');
        $('#unitNo').val(client.lot_number || '');
        $('#street').val(client.street || '');
        $('#barangay').val(client.barangay || '');
        $('#city').val(client.city || '');
        $('#country').val(client.country || '');
        $('#assuredEmail').val(client.email || '');
        $('#assuredContactNumber').val(client.contact_number || '');
        $('#suggestions').hide();
    }


    function updateFullAddress() {
        const fullAddress = `${unitNoInput.value}, ${streetInput.value}, ${barangayInput.value}, ${cityInput.value}, ${countryInput.value}`;
        fullAddressInput.value = fullAddress;
    }


    function checkIfGDFI() {
        const source = document.getElementById('selectSources').value;
        const ifGdfiSelect = document.getElementById('ifGdfiSelect'); // Ensure this element exists
        const gdficol = document.getElementById('gdficol');

        // Retrieve stored data and parse it or initialize as an empty object
        let storedData = JSON.parse(sessionStorage.getItem('formData')) || {};

        if (source == 2) {
            // Show the div
            gdficol.style.display = "block";
        } else {
            // Hide the div
            gdficol.style.display = "none";
            if (ifGdfiSelect) {
                ifGdfiSelect.value = "";
            }
            storedData.ifGdfiValue = ''; // Safely set the value
        }

        // Save updated data back to sessionStorage
        sessionStorage.setItem('formData', JSON.stringify(storedData));
    }


    function validatePaymentTerms() {
        let value = paymentTermsInputs.value;

        // Allow only numbers between 1 and 8
        if (value === '0' || value === '' || value < 1 || value > 8) {
            // If the value is invalid (either 0, less than 1, or greater than 8), reset the input
            paymentTermsInputs.setCustomValidity('Please enter a number between 1 and 8.');
            paymentTermsInputs.reportValidity(); // Show the error message
            paymentTermsInputs.value = ''; // Clear the invalid input
        } else {
            // Clear custom validity message if input is valid
            paymentTermsInputs.setCustomValidity('');
        }
    }

    // Clear custom validation when the user clicks into the input
    function clearValidation() {
        const paymentTermsInput = document.getElementById('paymentTerms');
        paymentTermsInput.setCustomValidity('');
    }

    function reapplyFormattingListeners() {

        // Apply to commissionAmount inputs
        document.querySelectorAll('.commissionAmount').forEach(input => {
            input.addEventListener('focus', function () {
                this.dataset.rawValue = this.dataset.rawValue || this.value.replace(/,/g, '');
                this.value = this.dataset.rawValue;
            });

            input.addEventListener('input', function () {
                this.dataset.rawValue = this.value.replace(/,/g, '');
            });

            input.addEventListener('blur', function () {
                let rawValue = this.dataset.rawValue || this.value;
                let numberValue = parseFloat(rawValue);
                if (!isNaN(numberValue)) {
                    this.value = numberValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                } else {
                    this.value = '0.00';
                }
            });
        });



    }


    // Function to format number with commas and two decimal places
    function formatNumberWithCommas(value) {
        if (value === null || value === undefined || isNaN(value)) return '0.00'; // Return '0.00' for null, undefined, or NaN
        // Ensure the value is a number, and round to two decimal places
        value = parseFloat(value).toFixed(2);
        // Add commas and return the formatted number
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }


    function removeCommas(value) {
        // Check if value is not undefined or null
        if (!value) return ''; // Handle empty or null values
        return value.replace(/,/g, ''); // Remove commas
    }





    //COMPUTATION FUNCTIONS

    // Function to calculate net of discount
    function getNetOfDiscount() {
        // Get raw values from data attributes
        grossPremiumValue = parseFloat(removeCommas(grossPremiumInput.value)) || 0;
        discountValue = parseFloat(removeCommas(discountInput.value)) || 0;

        // Calculate net value
        netOfDiscountValue = grossPremiumValue - discountValue;

        // Store the result in a data attribute and display it with commas
        netOfDiscountInput.value = netOfDiscountValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        getVatSalesCreditandPercentage();
    }

    // Function to calculate full commission
    function getFullComm() {
        // Get raw values from data attributes
        netOfDiscountValue = parseFloat(removeCommas(netOfDiscountInput.value)) || 0;
        amountDuetoProviderValue = parseFloat(removeCommas(amountDuetoProvider.value)) || 0;

        // Calculate full commission
        fullCommissionValue = netOfDiscountValue - amountDuetoProviderValue;

        // Store the result in a data attribute and display it with commas
        fullCommissionInput.value = fullCommissionValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        // fullCommissionInput.value = fullCommissionValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        getVatSalesCreditandPercentage();
    }




    function addCommissionsInput() {
        let newAmountInput, newnNameInput, newSelectInput;
        let index = 0;

        const existingFields = document.querySelectorAll('.commissionAmount, .commissionSelect');
        const container = document.getElementById('commissionContainer');
        const initialSection = document.createElement('div');
        const addButton = document.getElementById('addButton');
        const removeButton = document.getElementById('removeButton'); // Get the remove button
        const storedData = sessionStorage.getItem('formData');

        const firstRow = container.querySelector('.row');
        // removeButton.style.display = 'none';

        if (firstRow) {
            firstRow.querySelectorAll('.col-md-4').forEach(col => {
                col.classList.add('mt-5');
            });
            removeButton.style.display = 'inline-block'; // Show Remove button when the first row is added

        } else {
            // Create the initial section and add it above the container
            initialSection.innerHTML = `
                <div class="row mt-md-5" id="initialCommissionsTitle">
                    <div class="col-md-4">
                        <label for="commissionsTitle" class="form-label fw-bold">Commissions</label>
                    </div>
                </div>
            `;
            // Append the initialSection above the container
            container.prepend(initialSection);

        }

        // Show the "Remove" button when the page loads, but keep it hidden

        // Event listener for "Add" button click
        addButton.addEventListener('click', function () {
            initialSection.remove();

            // Show the "Remove" button after the first addition
            if (container.querySelectorAll('.row').length === 0) {
                removeButton.style.display = 'inline-block'; // Show Remove button when the first row is added
            }

            // Create a new div element with the same structure
            const newSection = document.createElement('div');

            // Check if it's the first row being added
            if (container.querySelectorAll('.row').length === 0) {
                newSection.classList.add('row', 'mt-5'); // Apply mt-5 to the first row
            } else {
                newSection.classList.add('row'); // No mt-5 for subsequent rows
            }

            // For the newly added row, do not add mt-5
            newSection.innerHTML = `
                <div class="col-md-4">
                    <div class="mb-3 mb-md-4 mb-sm-4">
                        <label for="commissionsLabel" class="form-label fw-bold">Commissions</label>
                        <select class="form-control rounded-0 border-1 rounded-0 m-0 commissionSelect" id="commissionSelect${index}">
                            <option value="" disabled selected>Select Commissions</option>
                            @foreach($commissioners as $commisioner)
                                <option value="{{ $commisioner->id }}">{{ $commisioner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3 mb-md-4 mb-sm-4">
                        <label for="commissionNameLabel" class="form-label fw-bold">Name</label>
                        <input type="text" class="form-control rounded-0 border-1 commissionName" id="commissionName${index}" placeholder="Enter a Name" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3 mb-md-4 mb-sm-4">
                        <label for="commissionAmountLabel" class="form-label fw-bold">Amount</label>
                        <input type="text" class="form-control rounded-0 border-1 commissionAmount" id="commissionAmount${index}" placeholder="Enter Amount" required>
                    </div>
                </div>
            `;

            // Append the new section to the container
            container.appendChild(newSection);

            // Get the newly added elements inside the newSection
            newAmountInput = newSection.querySelector(`#commissionAmount${index}`);
            newnNameInput = newSection.querySelector(`#commissionName${index}`);
            newSelectInput = newSection.querySelector(`#commissionSelect${index}`);
            attachEventListeners();
            reapplyFormattingListeners();

            // Increase the index for the next field
            index++; // Increase the index after the field is added
        });

        // Event listener for "Remove" button
        removeButton.addEventListener('click', function () {
            const rows = container.querySelectorAll('.row');
            if (rows.length > 0) {
                rows[rows.length - 1].remove(); // Remove the last row
            }

            // Hide "Remove" button if no rows remain
            if (container.querySelectorAll('.row').length === 0) {
                removeButton.style.display = 'none';
                initialSection.innerHTML = `
                    <div class="row mt-md-5" id="initialCommissionsTitle">
                        <div class="col-md-4">
                            <label for="commissionsTitle" class="form-label fw-bold">Commissions</label>
                        </div>
                    </div>
                `;
                // Append the initialSection above the container
                container.prepend(initialSection);
            }

            if (storedData) {
                let parsedData = JSON.parse(storedData);
                if (parsedData.commissionsSelect && parsedData.commissionsSelect.length > 0) {
                    parsedData.commissionsSelect.pop(); // Remove the last element from the commissionsSelect array
                    sessionStorage.setItem('formData', JSON.stringify(parsedData)); // Save the updated data
                }
            }
        });

        // Attach event listeners to any commission input fields that already exist or newly added fields
        function attachEventListeners() {
            const amountInputs = document.querySelectorAll('.commissionAmount');
            const nameInputs = document.querySelectorAll('.commissionName');
            const selectInputs = document.querySelectorAll('.commissionSelect');

            // For each of the commissionName inputs
            nameInputs.forEach(input => {
                input.addEventListener('input', function () {
                    saveFormData(); // Save data whenever the input value changes
                });
            });

            // For each of the commissionSelect inputs
            selectInputs.forEach(input => {
                input.addEventListener('change', function () {
                    saveFormData(); // Save data whenever the select value changes
                });
            });

            amountInputs.forEach(input => {
                input.addEventListener('input', function () {
                    getCommissionsValue();
                    saveFormData();
                    getVatSalesCreditandPercentage();
                });
            });
        }

        attachEventListeners();
    }













    // Function to get all values from the commission fields
    function getCommissionsValue() {
        let initialTotalCommission = 0;

        const container = document.getElementById('commissionContainer');
        const commissionSelects = container.querySelectorAll('.commissionSelect');
        const commissionInputs = container.querySelectorAll('.commissionAmount');
        const commissionNames = container.querySelectorAll('.commissionName');

        const commissions = [];
        let totalCommission = initialTotalCommission;

        commissionSelects.forEach((select, index) => {
            const amountInput = commissionInputs[index];
            const nameInput = commissionNames[index]; // Optional

            if (select.value && amountInput && amountInput.value) {
                const commissionAmount = parseFloat(removeCommas(amountInput.value)) || 0; // Safely parse the commission amount

                commissions.push({
                    commissionType: select.value,
                    commissionName: nameInput ? nameInput.value : "", // Default to empty string if no name is provided
                    commissionAmount: commissionAmount
                });

                totalCommission += commissionAmount;
            }
        });

        // Update the total commission input field with the total sum formatted to 2 decimal places
        totalCommissionInput.value = totalCommission.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        getVatSalesCreditandPercentage(); // Call any necessary functions after the calculation
        return commissions;
    }


    function getVatSalesCreditandPercentage() {

        const fullCommission = parseFloat(removeCommas(fullCommissionInput.value)) || 0;
        const totalCommission = parseFloat(removeCommas(totalCommissionInput.value)) || 0;

        vatValue = ((fullCommission - totalCommission) * 0.12) / 1.12;
        vatInput.value = vatValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        salesCreditValue = fullCommission - totalCommission - vatValue;
        salesCreditInput.value = salesCreditValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

        if (fullCommission === 0 || !isFinite(salesCreditValue / fullCommission)) {
            // Handle division by zero or invalid values
            salesCreditPercentValue = 0;
        } else {
            salesCreditPercentValue = (salesCreditValue / fullCommission) * 100;
        }

        const formattedPercent = salesCreditPercentValue.toFixed(2) + '%';
        salesCreditPercentInput.value = formattedPercent;

    }


    function calculateDueDateEnd() {
        const paymentTermsValue = parseInt(paymentTermsInputs.value); // Parse payment terms as an integer
        const dueDateStartValue = new Date(dueDateStartInputs.value); // Convert due date start value to Date object

        // Add payment terms (in months) to the start date
        dueDateStartValue.setMonth(dueDateStartValue.getMonth() + paymentTermsValue);

        // Format the due date end in yyyy-MM-dd format
        const year = dueDateStartValue.getFullYear();
        const month = String(dueDateStartValue.getMonth()).padStart(2, '0'); // Add leading zero if needed
        const day = String(dueDateStartValue.getDate()).padStart(2, '0'); // Add leading zero if needed

        const dueDateEnd = `${year}-${month}-${day}`;

        // Set the due date end value in the input field
        dueDateEndInputs.value = dueDateEnd;
    }


    function calculateSchedulePaymentsAmount() {

        const TermsValue = parseInt(paymentTermsInputs.value); // Number of payment terms
        const schedulePaymentContainer = document.getElementById('schedulePaymentTerms');
        schedulePaymentContainer.innerHTML = ''; // Clear existing inputs
        const paymentInputs = []; // To track all payment inputs
        const paymentDateInputs = []; // To track all date inputs
        grossPremiumValue = parseFloat(removeCommas(grossPremiumInput.value)) || 0;

        // Function to get the correct suffix for the number
        function getSuffix(i) {
            if (i % 10 === 1 && i % 100 !== 11) return 'st';
            if (i % 10 === 2 && i % 100 !== 12) return 'nd';
            if (i % 10 === 3 && i % 100 !== 13) return 'rd';
            return 'th';
        }

        // Function to format input values with commas
        function formatNumberWithCommas(value) {
            if (value === null || value === undefined || isNaN(value)) return '0.00'; // Return '0.00' for null, undefined, or NaN
            // Ensure the value is a number, and round to two decimal places
            value = parseFloat(value).toFixed(2);
            // Add commas and return the formatted number
            return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        // Function to reapply the formatting listeners to the inputs
        function reapplyFormattingListeners(input){
            input.addEventListener('focus', function () {
                this.dataset.rawValue = this.dataset.rawValue || this.value.replace(/,/g, '');
                this.value = this.dataset.rawValue;
            });

            input.addEventListener('input', function () {
                this.dataset.rawValue = this.value.replace(/,/g, '');
            });

            input.addEventListener('blur', function () {
                let rawValue = this.dataset.rawValue || this.value;
                let numberValue = parseFloat(rawValue);
                if (!isNaN(numberValue)) {
                    this.value = numberValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                } else {
                    this.value = '0.00';
                }
            });
        }

        // Create payment fields dynamically
        for (let i = 1; i <= TermsValue; i++) {
            const row = document.createElement('div');
            row.classList.add('row', 'mt-md-2');

            // Payment date input
            const colDate = document.createElement('div');
            colDate.classList.add('col-md-4');
            colDate.innerHTML = `
                <div class="mb-3">
                    <label for="paymentDate${i}" class="form-label fw-bold">${i}${getSuffix(i)} Payment Date</label>
                    <input type="date" id="paymentDate${i}" class="form-control uppercase-input rounded-0 border-1" required>
                </div>
            `;

            // Payment amount input
            const colAmount = document.createElement('div');
            colAmount.classList.add('col-md-4');
            colAmount.innerHTML = `
                <div class="mb-3">
                    <label for="paymentAmount${i}" class="form-label fw-bold">${i}${getSuffix(i)} Payment Amount</label>
                    <input type="text" id="paymentAmount${i}" class="form-control rounded-0 border-1" placeholder="Enter ${i}${getSuffix(i)} Payment Amount" step="0.01" required>
                </div>
            `;

            row.appendChild(colDate);
            row.appendChild(colAmount);
            schedulePaymentContainer.appendChild(row);

            // Store reference to the payment input for event handling
            paymentInputs.push(document.getElementById(`paymentAmount${i}`));
            paymentDateInputs.push(document.getElementById(`paymentDate${i}`));

            // Reapply formatting to the new payment amount input
            reapplyFormattingListeners(paymentInputs[i - 1]);
        }

        // Event listener for the first payment input
        if (paymentInputs.length > 0) {
            paymentInputs[0].addEventListener('input', function () {
                const firstPaymentValue = parseFloat(this.value.replace(/,/g, '')) || 0;

                if (firstPaymentValue === 0 || this.value.trim() === "") {
                    // Clear all fields if first payment is invalid or empty
                    paymentInputs.forEach(input => input.value = "");
                    return;
                }

                // Ensure the first payment does not exceed the gross premium
                if (firstPaymentValue > grossPremiumValue) {
                    alert("First payment cannot exceed the gross premium.");
                    this.value = ''; // Clear the value
                    this.dataset.rawValue = ''; // Clear any stored raw value for formatting
                    initialPaymentInputs.value = '';
                    return;
                }


                // Calculate the remaining amount and update other fields
                const remainingAmount = grossPremiumValue - firstPaymentValue;
                const remainingTerms = TermsValue - 1;
                const monthlyPayment = (remainingAmount / remainingTerms).toFixed(2);

                for (let i = 1; i < paymentInputs.length; i++) {
                    paymentInputs[i].value = formatNumberWithCommas(monthlyPayment);
                }

                initialPaymentInputs.value = firstPaymentValue.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });;
                saveFormData();

            });

            // Add event listeners to dynamically adjust the other payment inputs
            for (let i = 1; i < paymentInputs.length; i++) {
                paymentInputs[i].addEventListener('input', function () {
                    let totalPaid = 0;

                    for (let j = 0; j <= i; j++) {
                        totalPaid += parseFloat(paymentInputs[j].value.replace(/,/g, '')) || 0;
                    }

                    const remainingAmount = grossPremiumValue - totalPaid;
                    const remainingTerms = TermsValue - (i + 1);

                    if (remainingTerms > 0) {
                        const recalculatedPayment = (remainingAmount / remainingTerms).toFixed(2);

                        for (let k = i + 1; k < paymentInputs.length; k++) {
                            paymentInputs[k].value = formatNumberWithCommas(recalculatedPayment);
                        }
                    }
                    saveFormData();
                });
            }
        }

        // Add an event listener to the first payment date input
        if (paymentDateInputs.length > 0) {
            paymentDateInputs[0].addEventListener('change', function () {
                const firstDate = new Date(this.value);

                // Increment and set subsequent payment dates
                for (let i = 1; i < paymentDateInputs.length; i++) {
                    const nextDate = new Date(firstDate);
                    nextDate.setMonth(firstDate.getMonth() + i);
                    paymentDateInputs[i].value = nextDate.toISOString().split('T')[0];
                }
                saveFormData();

            });
        }






    }

    function getPaymentTerms() {
        const paymentTerms = [];
        const paymentInputs = document.querySelectorAll('[id^="paymentAmount"]'); // Get all payment amount inputs
        const paymentDateInputs = document.querySelectorAll('[id^="paymentDate"]'); // Get all payment date inputs

        const ordinalNames = ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth'];

        for (let i = 0; i < paymentInputs.length; i++) {
            const paymentAmount = parseFloat(paymentInputs[i].value.replace(/,/g, '')) || 0;
            const paymentDate = paymentDateInputs[i].value;

            if (paymentAmount > 0 && paymentDate) {
                const paymentObj = {};
                const key = `${ordinalNames[i]}_payment_schedule`;

                // Store both the date and amount in separate keys
                paymentObj[`${key}_date`] = formatDate(paymentDate);
                paymentObj[`${key}_amount`] = paymentAmount.toFixed(2);

                paymentTerms.push(paymentObj);
            }
        }

        return paymentTerms;
    }

    // Function to format date as 'MM/DD/YYYY'
    function formatDate(dateString) {
        const date = new Date(dateString);
        const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
        const day = String(date.getDate()).padStart(2, '0');
        const year = date.getFullYear();
        return `${month}/${day}/${year}`;
    }

    function getSuffix(i) {
        if (i % 10 === 1 && i % 100 !== 11) {
            return 'st';
        } else if (i % 10 === 2 && i % 100 !== 12) {
            return 'nd';
        } else if (i % 10 === 3 && i % 100 !== 13) {
            return 'rd';
        }
        return 'th';
    }


    //SUBMIT FUNCTION
    function submitForm(event) {
        // Prevent the form from submitting (page refresh)
        event.preventDefault();

        const storedData = sessionStorage.getItem('formData');

        if (storedData) {
            const formData = JSON.parse(storedData);
            console.log(formData);

            // Send the form data to the backend (Laravel)
            fetch('/forms/submitForm', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // CSRF token for Laravel
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Form data submitted successfully:', data);
            })
            .catch(error => {
                console.error('Error submitting form:', error);
            });
        }
    }



</script>





@endsection
