@extends('layouts.app')

@section('content')

<style>

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
            font-size: 1rem; /* equivalent to fs-1 */
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
        margin-top: 50px;
        display: flex;
        justify-content: flex-end; /* Pushes the button to the right */
        bottom: 20px;      /* Adjust this value as needed */
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
        }

        .steps::before {
            display: none;
        }

        .step {
            flex-direction: column;
            text-align: center;
            margin: 0;
            font-size: 0.85em; /* Even smaller font size for smaller screens */
        }

        .step::before {
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



</style>




<!-- Include Select2 CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<div class="container-form min-vh-100">
    <div class="row px-4">
        <!-- Steps section (Sidebar) -->
        <div class="col-md-3 mt-md-3 col-12 sidebar px-4">


            <div class="logo-container d-md-flex align-items-center text-center mt-3 mb-5 pt-md-3">
                <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="Logo" class="img-fluid alfc-logo" style="margin-right: 10px;">
                <p class="fw-bold mb-0 alfc-title">
                    ALFC Insurance Agency Inc.
                </p>
            </div>

            {{-- <div class="logo-container d-md-flex align-items-center justify-content-sm-center text-sm-center text-md-start m-3 mb-5 bg-danger">
                <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="Logo" class="img-fluid mb-2 mb-md-0" style="max-width: 50px;">
                <p class="fw-bold mb-0 ms-md-2">
                    ALFC Insurance Agency Inc.
                </p>
            </div> --}}



            <div class="steps mb-5" id="stepsContainer">
                <label class="step active fw-bold">
                    <input type="radio" name="step" value="1" checked disabled>
                    Personal Details
                </label>
                <label class="step">
                    <input type="radio" name="step" value="2" disabled>
                    Insurance
                </label>
                <label class="step">
                    <input type="radio" name="step" value="3" disabled>
                    Product
                </label>
                <label class="step">
                    <input type="radio" name="step" value="4" disabled>
                    Commission
                </label>
                <label class="step">
                    <input type="radio" name="step" value="5" disabled>
                    Payment
                </label>
            </div>
        </div>

        <!-- Form content section -->
        <div class="col-md-9 col-12 form-content pt-md-5">

            <!-- Step 1: Personal Information -->
            <div class="form-step active px-2">
                <h3 class="main-title fw-bold fs-1 mt-md-5">Personal Details</h3>
                <p class="sub-main-title text-muted mb-md-5">Input the assured's personal details and information accurately.</p>

                <form id="step1 mt-md-5">

                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-4 mb-sm-4 mt-md-3">
                                <label for="lastName" class="form-label fw-bold fw-bold">Last Name</label>
                                <input type="text" class="form-control uppercase-input rounded-0 rounded-0 border-1" id="lastName" placeholder="Enter Last Name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4 mt-md-3">
                                <label for="firstName" class="form-label fw-bold">First Name</label>
                                <input type="text" class="form-control uppercase-input rounded-0 border-1 rounded-0" id="firstName" placeholder="Enter First Name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4 mt-md-3">
                                <label for="middleName" class="form-label fw-bold">Middle Name</label>
                                <input type="text" class="form-control uppercase-input rounded-0 border-1 rounded-0" id="middleName" placeholder="Enter Middle Name (Optional)">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="unitNo" class="form-label fw-bold">Lot Number</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0 border-1" id="unitNo" placeholder="Enter lot number or unit number" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="street" class="form-label fw-bold">Street</label>
                                <input type="text" class="form-control rounded-0 border-1" id="street" name="street" placeholder="Enter Street" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="barangay" class="form-label fw-bold">Barangay</label>
                                <input type="text" class="form-control rounded-0 border-1" id="barangay" placeholder="Enter Barangay" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="city" class="form-label fw-bold">City</label>
                                <input type="text" class="form-control rounded-0 border-1" id="city" placeholder="Enter City" required>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="fullAddress" name="fullAddress">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="natureOfBusinessLabel" class="form-label fw-bold">Nature of Business</label>
                                <input type="text" class="form-control rounded-0 border-1" id="natureOfBusiness" placeholder="Enter Nature of Business" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="otherAssetLabel" class="form-label fw-bold">Other Asset</label>
                                <input type="text" class="form-control rounded-0 border-1" id="otherAsset" placeholder="Enter Other Asset" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="phoneNumber" class="form-label fw-bold">Phone Number</label>
                                <input type="text" class="form-control rounded-0 border-1" id="phoneNumber" placeholder="Enter Phone Number" name="phoneNumber"
                                       pattern="\d{11}" title="Please enter exactly 11 digits" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="viberNumber" class="form-label fw-bold">Viber Number</label>
                                <input type="text" class="form-control rounded-0 border-1" id="viberNumber" placeholder="Enter Viber Number"
                                       pattern="\d{11}" title="Please enter exactly 11 digits" required maxlength="11" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="otherContact" class="form-label fw-bold">Other Contact Number</label>
                                <input type="text" class="form-control rounded-0 border-1" id="otherContact" placeholder="Enter Other Contact Number"
                                       oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="emailLabel" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control rounded-0 border-1" id="email" placeholder="Enter Email Account URL "> </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="facebookAccount" class="form-label fw-bold">Facebook Account</label>
                                <input type="text" class="form-control rounded-0 border-1" id="facebookAccount" placeholder="Enter Facebook Profile Account URL "
                                       title="Please enter your Facebook account link or username">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="remarksPersonalDetailsLabel" class="form-label fw-bold">Remarks</label>
                                <textarea class="form-control rounded-0 border-1" id="remarksPersonalDetails" rows="5" placeholder="Enter your remarks here..." required></textarea>
                            </div>
                        </div>
                    </div>




                    <div class="button-container">
                        <button type="button " class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>

            </div>

            <!-- Step 2: Insurance -->
            <div class="form-step px-2">
                <h3 class="main-title fw-bold fs-1 mt-md-5">Insurance</h3>
                <p class="sub-main-title text-muted mb-md-5">Enter Insurance Details and Information</p>

                <form id="step2 mt-md-5">

                    <div class="row ">





                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4 mt-md-3">
                                <label for="issuanceCodeLabel" class="form-label fw-bold">Issuance Code</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="issuanceCode" placeholder="Enter the Issuance Code" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4 mt-md-3">
                                <label for="salesDateLabel" class="form-label fw-bold">Sale Date</label>
                                <input type="date" class="form-control rounded-0 border-1 rounded-0" id="salesDate" placeholder="Select the Sale Date" required>
                            </div>
                        </div>

                    </div>

                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="classificationLabel" class="form-label fw-bold fw-bold fs-6">Classification</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="classification" required>
                                    <option value="" disabled selected>Select Classification</option>
                                    <option value="new">New</option>
                                    <option value="renewal">Renewal</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="insuranceTypeLabel" class="form-label fw-bold">Insurance Type</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="insuranceType" required>
                                    <option value="" disabled selected>Select Insurance Type</option>
                                    <option value="sale">Sale</option>
                                    <option value="cancellation">Cancellation</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="salesStatusLabel" class="form-label fw-bold">Sale Status</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="salesStatus" required>
                                    <option value="" disabled selected>Select Sale Status</option>
                                    <option value="sale">Sale</option>
                                    <option value="cancellation">Cancellation</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="reinstatement">Reinstatement</option>
                                    <option value="reinstated">Reinstated</option>

                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4 mt-md-3">
                                <label for="team-label" class="form-label fw-bold fs-6">Team</label>
                                <select class="form-control rounded-0 border-1 m-0" id="team" required>
                                    <option value="" selected>Select Team</option>
                                    @foreach($teams as $team)
                                        <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4 mt-md-3">
                                <label for="salesAssocManager-label" class="form-label fw-bold fs-6">SA/SM</label>
                                <select class="form-control rounded-0 border-1 m-0" id="salesAssocManager" required>
                                    <option value="" selected>Select SA or SM</option>
                                    @foreach($salesAssociates as $salesAssociate)
                                        <option value="{{ $salesAssociate->id }}">{{ $salesAssociate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row ">

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="branchManagerLabel-label" class="form-label fw-bold fs-6">Branch Manage</label>
                                <select class="form-control rounded-0 border-1 m-0" id="branchManager" required>
                                    <option value="" selected>Select Branch Manager</option>
                                    @foreach($branchManagers as $branchManager)
                                        <option value="{{ $branchManager->id }}">{{ $branchManager->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="collectionGmLabel" class="form-label fw-bold">Collection GM</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="collectionGm" placeholder="Enter Collection GM Name" required>
                            </div>
                        </div>



                    </div>


                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="legalRepLabel" class="form-label fw-bold fw-bold fs-6">Legal Representative</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="legalRep" placeholder="Enter Legal Rep. Name">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="legalSupervisorLabel" class="form-label fw-bold">Legal Supervisor</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="legalSupervisor" placeholder="Enter Legal Supervisor Name">
                            </div>
                        </div>

                    </div>


                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="assignAtty1Label" class="form-label fw-bold fw-bold fs-6">Assigned Attorney (1)</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="assignAtty1" placeholder="Enter Attorney's Name">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="assignAtty2Label" class="form-label fw-bold">Assigned Attorney (2)</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="assignAtty2" placeholder="Enter Attorney's Name">
                            </div>
                        </div>

                    </div>



                    <div class="button-container">
                        <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>
            </div>


            <!-- Step 3: Product -->
            <div class="form-step px-2">
                <h3 class="main-title fw-bold fs-1 mt-md-5">Product</h3>
                <p class="sub-main-title text-muted mb-md-5">Enter product details and information</p>

                <form id="step3 mt-md-5">

                    <div class="row ">
                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
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

                    <div class="row mt-md-3">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="productLabel" class="form-label fw-bold fw-bold fs-6">Product</label>
                                <select class="form-control rounded-0 border-1 m-0" id="product" required>
                                    <option value="" selected>Select Products</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="subProductLabel" class="form-label fw-bold fw-bold fs-6">Sub-Product</label>

                                <select class="form-control rounded-0 border-1 m-0" id="subProduct" required>
                                    <option value="" disabled selected>Select Sub-Product</option>
                                    @foreach($subproducts as $subproduct)
                                        <option value="{{ $subproduct->id }}">{{ $subproduct->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="productTypeLabel" class="form-label fw-bold fw-bold fs-6">Product Type</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="productType">
                                    <option value="" disabled selected>Select Product Type</option>
                                    <option value="refinancing">Refinancing</option>
                                    <option value="financing">Financing</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
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
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="sourceBranchLabel" class="form-label fw-bold fw-bold fs-6">Source Branch</label>

                                <select class="form-control rounded-0 border-1 m-0" id="sourceBranch" required>
                                    <option value="" disabled selected>Select Source Branch</option>
                                    @foreach($sourcebranches as $sourcebranch)
                                        <option value="{{ $sourcebranch->id }}">{{ $sourcebranch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4" id="gdficol">
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

                    <div class="row ">
                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="mortgageeLabel" class="form-label fw-bold fw-bold fs-6">Mortagee</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="mortgagee" placeholder="Enter Mortgagee" required>
                            </div>
                        </div>
                    </div>


                    <div class="row mt-md-3">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="areaLabel" class="form-label fw-bold fw-bold fs-6">Area</label>
                                <select class="form-control rounded-0 border-1 m-0" id="area">
                                    <option value="" disabled selected>Select Area</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
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


                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="policyNumberLabel" class="form-label fw-bold fw-bold fs-6">Policy Number</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="policyNumber" placeholder="Enter Policy Number" required>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="expiryDateLabel" class="form-label fw-bold fw-bold fs-6">Expiry Date</label>
                                <input type="date" class="form-control rounded-0 rounded-0 border-1" id="expiryDate" placeholder="Enter Policy Number" required>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">

                                <label for="policyInceptionLabel" class="form-label fw-bold fw-bold fs-6">Policy Inception Date</label>
                                <input type="date" class="form-control rounded-0 rounded-0 border-1" id="policyInception" placeholder="Enter Policy Inisu" required>

                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="plateConductionNumberLabel" class="form-label fw-bold fw-bold fs-6">Plate / Conduction Number</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="plateConductionNumber" placeholder="Enter Plate Conduction Number" required>
                            </div>
                        </div>


                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="descriptionLabel" class="form-label fw-bold fw-bold fs-6">Description</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="description" placeholder="Enter Description" required>
                            </div>
                        </div>


                    </div>


                    <div class="row">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="loanAmountLabel" class="form-label fw-bold fw-bold fs-6">Loan Amount</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="loanAmount" placeholder="Enter Loan Amount" required>
                            </div>
                        </div>


                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="totalSumInsuredLabel" class="form-label fw-bold fw-bold fs-6">Total Sum Insured </label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="totalSumInsured" placeholder="Enter Total Sum Insured" required>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
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



                    <div class="row mt-md-3">

                        {{-- <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="policyExpirationAgingLabel" class="form-label fw-bold fw-bold fs-6">Policy Expiration Aging</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1 disabled" id="policyExpirationAging" disabled value="test">
                            </div>
                        </div> --}}

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="bookNumberLabel" class="form-label fw-bold fw-bold fs-6">Book Number</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="bookNumber" placeholder="Enter Book Number" required>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="filingNumberLabel" class="form-label fw-bold fw-bold fs-6">Filing Number</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="filingNumber" placeholder="Enter Filing Number" required>
                            </div>
                        </div>

                    </div>


                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="pidReceivedDateLabel" class="form-label fw-bold fw-bold fs-6">PID Received Date</label>
                                <input type="date" class="form-control rounded-0 rounded-0 border-1" id="pidReceivedDate" required>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="pidCompletionDateLabel" class="form-label fw-bold fw-bold fs-6">PID Completion Date</label>
                                <input type="date" class="form-control rounded-0 rounded-0 border-1" id="pidCompletionDate" required>
                            </div>
                        </div>



                    </div>


                    <div class="row mt-md-5">
                        <div class="col-md-12">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="remarksProductsLabel" class="form-label fw-bold">Remarks</label>
                                <textarea class="form-control rounded-0 border-1" id="remarksProducts" rows="5" placeholder="Enter your remarks here..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>
            </div>


            <!-- Step 4: Commission -->
            <div class="form-step px-2">
                <h3 class="main-title fw-bold fs-1 mt-md-5">Commision</h3>
                <p class="sub-main-title text-muted mb-md-5">Enter Commission details and information</p>



                <form id="step4 mt-md-5">

                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="provisionReceiptLabel" class="form-label fw-bold">Provision Receipt</label>
                                <input type="text" class="form-control rounded-0 border-1" id="provisionReceipt" placeholder="Enter Provision Receipt" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="grossPremiumLabel" class="form-label fw-bold">Gross Premium</label>
                                <input type="text" class="form-control rounded-0 border-1" id="grossPremium" placeholder="Enter Gross Premium" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="discountLabel" class="form-label fw-bold">Discount</label>
                                <input type="text" class="form-control rounded-0 border-1" id="discount" placeholder="Enter Discount" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="netOfDiscountLabel" class="form-label fw-bold">Net of Discount</label>
                                <input type="text" class="form-control rounded-0 border-1" id="netOfDiscount"  disabled required>
                            </div>
                        </div>

                    </div>


                    <div class="row">


                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="amountDuetoProviderLabel" class="form-label fw-bold">Amount Due to Provider</label>
                                <input type="text" class="form-control rounded-0 border-1" id="amountDuetoProvider" placeholder="Enter Amount Due to Provider" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="fullCommissionLabel" class="form-label fw-bold">Full Commission</label>
                                <input type="text" class="form-control rounded-0 border-1" id="fullCommission"  disabled required>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="marketingFundLabel" class="form-label fw-bold">Marketing Fund</label>
                                <input type="text" class="form-control rounded-0 border-1" id="marketingFund" placeholder="Enter Marketing Fund" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="offsettingLabel" class="form-label fw-bold">Offsetting</label>
                                <input type="text" class="form-control rounded-0 border-1" id="offsetting" placeholder="Enter Offsetting" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="promoLabel" class="form-label fw-bold">Promo</label>
                                <input type="text" class="form-control rounded-0 border-1" id="promo" placeholder="Enter Promo Amount" required>
                            </div>
                        </div>

                    </div>




                    <div id="commissionContainer">
                    </div>

                    <div class="row mb-md-5">
                        <div class="col-md-4 mb-5 mb-md-5 mb-sm-5">
                            <button type="button" class="bg-secondary" id="addButton">ADD</button>
                        </div>
                    </div>

                    <div class="row mt-md-5">


                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="commDeductLabel" class="form-label fw-bold">Comm Deduct</label>
                                <input type="text" class="form-control rounded-0 border-1" id="commDeduct" placeholder="Enter Comm Deduct" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="totalCommissionLabel" class="form-label fw-bold">Total Commission</label>
                                <input type="text" class="form-control rounded-0 border-1" id="totalCommission" required disabled>
                            </div>
                        </div>


                    </div>



                    <div class="row mt-md-3 mb-md-5">

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-5 mb-sm-5">
                                <label for="vatLabel" class="form-label fw-bold">VAT</label>
                                <input type="text" class="form-control rounded-0 border-1" id="vatInput" required disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-4 mb-sm-5">
                                <label for="salesCreditLabel" class="form-label fw-bold">Sales Credit</label>
                                <input type="text" class="form-control rounded-0 border-1" id="salesCredit" required disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-5 mb-sm-5">
                                <label for="salesCreditPercentLabel" class="form-label fw-bold">Sales Credit %</label>
                                <input type="text" class="form-control rounded-0 border-1" id="salesCreditPercent" required disabled>
                            </div>
                        </div>


                    </div>




                    <div class="button-container mt-md-5">
                        <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>

            </div>


            <!-- Step 5: Payment -->
            <div class="form-step px-2">
                <h3 class="main-title fw-bold fs-1 mt-md-5">Payment</h3>
                <p class="sub-main-title text-muted mb-md-5">Enter Payment details and information</p>

                <form id="step5 mt-md-5">


                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
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
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="dueDateStartLabel" class="form-label fw-bold">Due Date Start</label>
                                <input type="date" class="form-control rounded-0 border-1" id="dueDateStart" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="dueDateEndLabel" class="form-label fw-bold">Due Date End</label>
                                <input type="date" class="form-control rounded-0 border-1" id="dueDateEnd" required>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-md-3 mt-md-3" id="schedulePaymentTerms">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-3 mb-sm-4">
                                <label for="SchedulePayment1" class="form-label fw-bold">1st Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="SchedulePayment1" placeholder="Enter Schedule of 1st Payment" required>
                            </div>
                        </div>



                    </div>






                    <div class="row mt-md-5">


                        <div class="col-md-4">
                            <div class="mb-4 mb-md-4 mb-sm-4">
                                <label for="initialPaymentLabel" class="form-label fw-bold">Initial Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="initialPayment" placeholder="Enter Initial Payment" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-4 mb-sm-4">
                                <label for="forBillingLabel" class="form-label fw-bold">For Billing</label>
                                <input type="text" class="form-control rounded-0 border-1" id="forBilling" placeholder="Enter For Billing" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-4 mb-sm-4">
                                <label for="overUnderPaymentLabel" class="form-label fw-bold">Over (Under) Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="overUnderPayment" placeholder="Enter Over or Under Payment" required>
                            </div>
                        </div>



                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="dateGoodSalesLabel" class="form-label fw-bold">Date of Good as Sales</label>
                                <input type="date" class="form-control rounded-0 border-1" id="dateGoodSales" placeholder="Enter Date of Good as Sales" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="statusPaymentLabel" class="form-label fw-bold">Status</label>
                                <input type="text" class="form-control rounded-0 border-1" id="statusPayment" placeholder="Enter Status" required>
                            </div>
                        </div>


                    </div>





                </form>


                <div class="button-container">
                    <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                    <button type="submit" class="submit-button">Submit</button>
                </div>
            </div>




        </div>

    </div>
</div>



<script>
    let currentStep = 0;
    let index = 0;  // Initialize index counter

    const commissions = [];

    const formSteps = document.querySelectorAll('.form-step');
    const stepIndicators = document.querySelectorAll('.sidebar .step');

    const storedData = sessionStorage.getItem('formData');


    const grossPremiumInput = document.getElementById('grossPremium');
    const discountInput = document.getElementById('discount');
    const netOfDiscountInput = document.getElementById('netOfDiscount');
    const amountDuetoProviderInput = document.getElementById('amountDuetoProvider');
    const fullCommissionInput = document.getElementById('fullCommission');


    const marketingFundInput = document.getElementById('marketingFund');
    const offSettingInput = document.getElementById('offsetting');
    const promoInput = document.getElementById('promo');
    const commDeductInput = document.getElementById('commDeduct');

    const totalCommissionInput = document.getElementById('totalCommission');


    const vatInput = document.getElementById('vatInput');
    let vatValue = 0;


    const salesCreditInput  = document.getElementById('salesCredit');
    let salesCredit = 0;

    const salesCreditPercentInput = document.getElementById('salesCreditPercent');
    let salesCreditPercent = 0;


    const paymentTermsInputs = document.getElementById('paymentTerms');
    const dueDateStartInputs = document.getElementById('dueDateStart');
    const dueDateEndInputs = document.getElementById('dueDateEnd');


    let isFieldsAdded = false;  // Flag to check if fields have already been added
    const schedulePaymentInputs = document.getElementById('SchedulePayment1');

    const initialPaymentInputs = document.getElementById('initialPayment');
    const forBillingInputs = document.getElementById('forBilling');
    const overUnderPaymentInputs = document.getElementById('overUnderPayment');



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

    // Move to the next step, validating first
    function nextStep() {
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

    // Move to the previous step
    function prevStep() {
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

    function validateStep(step) {
        const inputs = formSteps[step].querySelectorAll('input[required], textarea[required], select[required]');
        let isValid = true;

        inputs.forEach(input => {
            // Get the error text element (if it exists)
            const errorText = input.nextElementSibling;

            // Remove the error message if it exists and input is valid
            input.addEventListener('input', () => {
                const errorMessage = input.parentNode.querySelector('.error-message');



                if (input.checkValidity()) {
                    // Remove error message if input is valid
                    if (errorMessage) {
                        errorMessage.remove();
                    }
                } else {
                    // If input is invalid, display the error message
                    if (!errorMessage) {
                        const errorMessage = document.createElement('span');
                        errorMessage.classList.add('error-message', 'text-danger');
                        errorMessage.innerText = getErrorMessage(input);
                        input.parentNode.appendChild(errorMessage);
                    }
                }
            });

            // If input is invalid at initial validation, add error message
            if (!input.checkValidity()) {
                isValid = false;
                const existingErrorMessage = input.parentNode.querySelector('.error-message');
                if (!existingErrorMessage) {
                    const errorMessage = document.createElement('span');
                    errorMessage.classList.add('error-message', 'text-danger');
                    errorMessage.innerText = getErrorMessage(input);
                    input.parentNode.appendChild(errorMessage);
                }
            }
        });

        return isValid;
    }

    // Get the appropriate error message based on input validation
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

    // Function to save form data to sessionStorage
    function saveFormData() {
        const formData = getFormValues();
        sessionStorage.setItem('formData', JSON.stringify(formData));
    }

    // Function to load form data from sessionStorage
    function loadFormData() {

        if (storedData) {
            const formData = JSON.parse(storedData);

            // PERSONAL INFORMATION first step
            document.getElementById('lastName').value = formData.lastName || '';
            document.getElementById('firstName').value = formData.firstName || '';
            document.getElementById('middleName').value = formData.middleName || '';
            document.getElementById('unitNo').value = formData.unitNo || '';
            document.getElementById('street').value = formData.street || '';
            document.getElementById('barangay').value = formData.barangay || '';
            document.getElementById('city').value = formData.city || '';
            document.getElementById('fullAddress').value = formData.fullAddress || '';
            document.getElementById('natureOfBusiness').value = formData.natureOfBusiness || '';
            document.getElementById('otherAsset').value = formData.otherAsset || '';
            document.getElementById('phoneNumber').value = formData.phoneNumber || '';
            document.getElementById('viberNumber').value = formData.viberNumber || '';
            document.getElementById('otherContact').value = formData.otherContact || '';
            document.getElementById('facebookAccount').value = formData.facebookAccount || '';
            document.getElementById('email').value = formData.email || '';
            document.getElementById('remarksPersonalDetails').value = formData.remarksPersonalDetails || '';

            // INSURANCE INFORMATION
            document.getElementById('salesAssocManager').value = formData.salesAssocManager || '';
            document.getElementById('classification').value = formData.classification || '';
            document.getElementById('insuranceType').value = formData.insuranceType || '';
            document.getElementById('salesStatus').value = formData.salesStatus || '';
            document.getElementById('branchManager').value = formData.branchManager || '';
            document.getElementById('issuanceCode').value = formData.issuanceCode || '';
            document.getElementById('salesDate').value = formData.salesDate || '';
            document.getElementById('collectionGm').value = formData.collectionGm || '';
            document.getElementById('legalRep').value = formData.legalRep || '';
            document.getElementById('legalSupervisor').value = formData.legalSupervisor || '';
            document.getElementById('assignAtty1').value = formData.assignAtty1 || '';
            document.getElementById('assignAtty2').value = formData.assignAtty2 || '';

            // PRODUCT INFORMATION
            document.getElementById('provider').value = formData.provider || '';
            document.getElementById('product').value = formData.product || '';
            document.getElementById('subProduct').value = formData.subProduct || '';
            document.getElementById('productType').value = formData.productType || '';
            document.getElementById('selectSources').value = formData.selectSources || '';
            document.getElementById('sourceBranch').value = formData.sourceBranch || '';
            document.getElementById('ifGdfi').value = formData.ifGdfi || '';
            document.getElementById('mortgagee').value = formData.mortgagee || '';
            document.getElementById('area').value = formData.area || '';
            document.getElementById('alfcBranch').value = formData.alfcBranch || '';
            document.getElementById('policyNumber').value = formData.policyNumber || '';
            document.getElementById('expiryDate').value = formData.expiryDate || '';
            document.getElementById('policyInception').value = formData.policyInception || '';
            document.getElementById('plateConductionNumber').value = formData.plateConductionNumber || '';
            document.getElementById('description').value = formData.description || '';
            document.getElementById('loanAmount').value = formData.loanAmount || '';
            document.getElementById('totalSumInsured').value = formData.totalSumInsured || '';
            document.getElementById('mop').value = formData.mop || '';
            document.getElementById('bookNumber').value = formData.bookNumber || '';
            document.getElementById('filingNumber').value = formData.filingNumber || '';
            document.getElementById('pidReceivedDate').value = formData.pidReceivedDate || '';
            document.getElementById('pidCompletionDate').value = formData.pidCompletionDate || '';
            document.getElementById('remarksProducts').value = formData.remarksProducts || '';



            //COMMISSION INFORMATION
            document.getElementById('provisionReceipt').value = formData.provisionReceipt || '';
            grossPremiumInput.value = formData.grossPremium || '';
            discountInput.value = formData.discount || '';
            netOfDiscountInput.value = formData.netOfDiscount || '';
            amountDuetoProviderInput.value = formData.amountDuetoProvider || '';
            fullCommissionInput.value = formData.fullCommission || '';
            marketingFundInput.value = formData.marketingFund || '';
            offSettingInput.value = formData.offsetting || '';
            promoInput.value = formData.promo || '';

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
                                    @foreach($commisioners as $commisioner)
                                        <option value="{{ $commisioner->id }}">{{ $commisioner->name }}</option>
                                    @endforeach
                                </select>
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
                    const commissionSelect = document.getElementById(`commissionSelect${index}`);

                    // Populate the newly created fields with data from formData
                    if (commissionAmount && commissionSelect) {
                        commissionAmount.value = commission.commissionAmount || ''; // Default if not provided
                        commissionSelect.value = commission.commissionType || '';   // Default if not provided
                    }


                });
            }

            totalCommissionInput.value =  formData.totalCommissionInput || '';
            commDeductInput.value = formData.commDeduct || '';


            vatInput.value = formData.vat || '';
            salesCreditInput.value = formData.salesCredit || '';
            salesCreditPercentInput.value = formData.salesCreditPercent || '';




            //PAYMMENTS INFORMATIONS
            paymentTermsInputs.value = formData.paymentTerms || '';
            dueDateStartInputs.value = formData.dueDateStart || '';
            dueDateEndInputs.value = formData.dueDateEnd || '';
            // schedulePaymentInputs.value = formData.firstPayment || '';
            initialPaymentInputs.value = formData.initialPayment || '';

            forBillingInputs.value = formData.forBilling || '';
            overUnderPaymentInputs.value = formData.overUnderPayment || '';


        }

    }


    // Get form data to be saved to sessionStorage
    function getFormValues() {

        const formData = {};

        // PERSONAL INFORMATION first step
        // if (currentStep == 0) {
            formData.lastName = document.getElementById('lastName').value;
            formData.firstName = document.getElementById('firstName').value;
            formData.middleName = document.getElementById('middleName').value;
            formData.unitNo = document.getElementById('unitNo').value;
            formData.street = document.getElementById('street').value;
            formData.barangay = document.getElementById('barangay').value;
            formData.city = document.getElementById('city').value;
            formData.fullAddress = document.getElementById('fullAddress').value;
            formData.natureOfBusiness = document.getElementById('natureOfBusiness').value;
            formData.otherAsset = document.getElementById('otherAsset').value;
            formData.phoneNumber = document.getElementById('phoneNumber').value;
            formData.viberNumber = document.getElementById('viberNumber').value;
            formData.otherContact = document.getElementById('otherContact').value;
            formData.facebookAccount = document.getElementById('facebookAccount').value;
            formData.email = document.getElementById('email').value;
            formData.remarksPersonalDetails = document.getElementById('remarksPersonalDetails').value;
        // }


        // INSURANCE INFORMATION second step
            formData.salesAssocManager = document.getElementById('salesAssocManager').value;
            formData.classification = document.getElementById('classification').value;
            formData.insuranceType = document.getElementById('insuranceType').value;
            formData.salesStatus = document.getElementById('salesStatus').value;
            formData.branchManager = document.getElementById('branchManager').value;
            formData.issuanceCode = document.getElementById('issuanceCode').value;
            formData.salesDate = document.getElementById('salesDate').value;
            formData.collectionGm = document.getElementById('collectionGm').value;
            formData.legalRep = document.getElementById('legalRep').value;
            formData.legalSupervisor = document.getElementById('legalSupervisor').value;
            formData.assignAtty1 = document.getElementById('assignAtty1').value;
            formData.assignAtty2 = document.getElementById('assignAtty2').value;
        // }


        // if (currentStep == 2) {

            formData.provider = document.getElementById('provider').value;
            formData.product = document.getElementById('product').value;
            formData.subProduct = document.getElementById('subProduct').value;
            formData.productType = document.getElementById('productType').value;
            formData.selectSources = document.getElementById('selectSources').value;
            formData.sourceBranch = document.getElementById('sourceBranch').value;
            formData.ifGdfi = document.getElementById('ifGdfi').value;
            formData.mortgagee = document.getElementById('mortgagee').value;
            formData.area = document.getElementById('area').value;
            formData.alfcBranch = document.getElementById('alfcBranch').value;
            formData.policyNumber = document.getElementById('policyNumber').value;
            formData.expiryDate = document.getElementById('expiryDate').value;
            formData.policyInception = document.getElementById('policyInception').value;
            formData.plateConductionNumber = document.getElementById('plateConductionNumber').value;
            formData.description = document.getElementById('description').value;
            formData.loanAmount = document.getElementById('loanAmount').value;
            formData.totalSumInsured = document.getElementById('totalSumInsured').value;
            formData.mop = document.getElementById('mop').value;
            formData.bookNumber = document.getElementById('bookNumber').value;
            formData.filingNumber = document.getElementById('filingNumber').value;
            formData.pidReceivedDate = document.getElementById('pidReceivedDate').value;
            formData.pidCompletionDate = document.getElementById('pidCompletionDate').value;
            formData.remarksProducts = document.getElementById('remarksProducts').value;
        // }


        // if (currentStep == 3) {

            formData.provisionReceipt = document.getElementById('provisionReceipt').value;
            formData.grossPremium = grossPremium.value;
            formData.discount = discount.value;
            formData.netOfDiscount = netOfDiscountInput.value;
            formData.amountDuetoProvider = amountDuetoProviderInput.value;
            formData.fullCommission = fullCommissionInput.value;
            formData.marketingFund = marketingFundInput.value;
            formData.offsetting = offSettingInput.value;
            formData.promo = promoInput.value;

            formData.commissionsSelect = getCommissionsValue();

            formData.totalCommissionInput = document.getElementById('totalCommission').value;

            formData.commDeduct = commDeductInput.value;


            formData.vat = vatInput.value;
            formData.salesCredit = salesCreditInput.value;
            formData.salesCreditPercent = salesCreditPercentInput.value;



        //}


        // if (currentStep == 4) {

            formData.paymentTerms = paymentTermsInputs.value;
            formData.dueDateStart = dueDateStartInputs.value;
            formData.dueDateEnd = dueDateEndInputs.value;
            formData.firstPayment = schedulePaymentInputs.value;
            formData.initialPayment = initialPaymentInputs.value;

            formData.forBilling = forBillingInputs.value;

            formData.overUnderPayment = overUnderPaymentInputs.value;


        //}



        // console.log(formData);
        return formData;
    }


    // Function to check and unhide the div based on the selected source
    function checkIfGDFI() {
        const source = document.getElementById('selectSources').value;

        // Check if the selected source is 2
        if (source == 2) {
            document.getElementById('gdficol').style.visibility = "visible";
        }
        else {
            document.getElementById('gdficol').style.visibility = "hidden";
        }
    }

    // Function to calculate and update netOfDiscount
    function getNetOfDiscount() {
        const grossPremium = parseFloat(grossPremiumInput.value) || 0;  // Default to 0 if empty or invalid
        const discount = parseFloat(discountInput.value) || 0;  // Default to 0 if empty or invalid

        // Calculate netOfDiscount and update the netOfDiscount input field
        const netOfDiscount = grossPremium - discount;
        netOfDiscountInput.value = netOfDiscount.toFixed(2);  // Format to two decimal places

        getVatSalesCredit();

    }

    function getFullComm(){
        const netOfDiscount = parseFloat(netOfDiscountInput.value) || 0;
        const amountDuetoProvider = parseFloat(amountDuetoProviderInput.value) || 0;


        console.log(netOfDiscount);
        console.log(amountDuetoProvider);

        const fullCommission = netOfDiscount - amountDuetoProvider;
        fullCommissionInput.value = fullCommission.toFixed(2);

        getVatSalesCredit();


    }

    // Function to get all values from the commission fields
    function getCommissionsValue() {

            let initialTotalCommission = 0;

            const container = document.getElementById('commissionContainer');
            const commissionSelects = container.querySelectorAll('select');
            const commissionInputs = container.querySelectorAll('input');


            // Convert input values to numbers
            let marketingFundValue = parseFloat(marketingFundInput.value) || 0;
            let offsettingValue = parseFloat(offSettingInput.value) || 0;
            let promoValue = parseFloat(promoInput.value) || 0;

            // Calculate the total commission
            initialTotalCommission = marketingFundValue + offsettingValue + promoValue;



            const commissions = [];
            let totalCommission = 0 + initialTotalCommission; // Initialize total commission

            commissionSelects.forEach((select, index) => {
                // Only capture values if the corresponding input exists
                const amountInput = commissionInputs[index];
                if (select.value && amountInput && amountInput.value) {
                    const commissionAmount = parseFloat(amountInput.value) || 0; // Safely parse the commission amount

                    commissions.push({
                        commissionType: select.value,
                        commissionAmount: commissionAmount
                    });

                    totalCommission += commissionAmount; // Add to the total commission
                }
            });

            // Update the total commission input field with the total sum formatted to 2 decimal places
            totalCommissionInput.value = totalCommission.toFixed(2); // Format to 2 decimal places
            getVatSalesCredit();

            return commissions;

    }

    function addCommissions() {
        let newAmountInput, newSelectInput;
        let index = 0;

        const existingFields = document.querySelectorAll('.commissionAmount, .commissionSelect');
        const container = document.getElementById('commissionContainer');
        const initialSection = document.createElement('div');

        const firstRow = container.querySelector('.row');
        if (firstRow) {
            firstRow.querySelectorAll('.col-md-4').forEach(col => {
                col.classList.add('mt-5');
                console.log("existing")

            });
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

        // Event listener for "Add" button click
        document.getElementById('addButton').addEventListener('click', function () {
            initialSection.remove();

            // Create a new div element with the same structure
            const newSection = document.createElement('div');

            // Check if it's the first row being added
            if (container.querySelectorAll('.row').length === 0) {
                newSection.classList.add('row', 'mt-5');  // Apply mt-5 to the first row
            } else {
                newSection.classList.add('row');  // No mt-5 for subsequent rows
            }




            // For the newly added row, do not add mt-5
            newSection.innerHTML = `
                <div class="col-md-4">
                    <div class="mb-3 mb-md-4 mb-sm-4">
                        <label for="commissionsLabel" class="form-label fw-bold">Commissions</label>
                        <select class="form-control form-select rounded-0 border-1 rounded-0 m-0 commissionSelect" id="commissionSelect${index}">
                            <option value="" disabled selected>Select Commissions</option>
                            @foreach($commisioners as $commisioner)
                                <option value="{{ $commisioner->id }}">{{ $commisioner->name }}</option>
                            @endforeach
                        </select>
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
            newSelectInput = newSection.querySelector(`#commissionSelect${index}`);

            // Immediately save the form data after adding the new fields
            saveFormData();

            // Attach event listeners to the newly added elements
            newAmountInput.addEventListener('input', function () {
                saveFormData(); // Save data whenever the input value changes
                getVatSalesCredit();
            });

            newSelectInput.addEventListener('change', function () {
                saveFormData(); // Save data whenever the select value changes
                getVatSalesCredit();
            });

            // Increase the index for the next field
            index++;  // Increase the index after the field is added
        });

    }


    function getVatSalesCredit() {
        const fullCommissionValue = parseFloat(fullCommissionInput.value) || 0;
        const totalCommissionValue = parseFloat(totalCommissionInput.value) || 0;



        const vatValue = ((fullCommissionValue - totalCommissionValue) * 0.12) / 1.12;
        vatInput.value = vatValue.toFixed(2);


        const salesCreditValue = fullCommissionValue - totalCommissionValue - vatValue;
        salesCreditInput.value = salesCreditValue.toFixed(2);



        if (fullCommissionValue === 0 || !isFinite(salesCreditValue / fullCommissionValue)) {
            // Handle division by zero or invalid values
            salesCreditPercentValue = 0;
        } else {
            salesCreditPercentValue = (salesCreditValue / fullCommissionValue) * 100;
        }
        const formattedPercent = salesCreditPercentValue.toFixed(2) + '%';
        salesCreditPercentInput.value = formattedPercent;


    }


    function validatePaymentTerms() {
        const paymentTermsInput = document.getElementById('paymentTerms');
        let value = paymentTermsInput.value;

        // Allow only numbers between 1 and 8
        if (value === '0' || value === '' || value < 1 || value > 8) {
            // If the value is invalid (either 0, less than 1, or greater than 8), reset the input
            paymentTermsInput.setCustomValidity('Please enter a number between 1 and 8.');
            paymentTermsInput.reportValidity(); // Show the error message
            paymentTermsInput.value = ''; // Clear the invalid input
        } else {
            // Clear custom validity message if input is valid
            paymentTermsInput.setCustomValidity('');
        }
    }

    // Clear custom validation when the user clicks into the input
    function clearValidation() {
        const paymentTermsInput = document.getElementById('paymentTerms');
        paymentTermsInput.setCustomValidity('');
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
        if (storedData) {
            const formData = JSON.parse(storedData);

            const grossPremiumValue = formData.grossPremium; // Get gross premium value
            const TermsValue = parseInt(paymentTermsInputs.value); // Get terms (number of payments)
            const FirstPaymentValue = parseFloat(schedulePaymentInputs.value); // Get first payment value
            const remainingAmount = grossPremiumValue - FirstPaymentValue; // Calculate remaining amount after first payment
            const remainingTerms = TermsValue - 1; // Remaining terms excluding the first one

            if (TermsValue === 1) {
                schedulePaymentInputs.value = grossPremiumValue; // Automatically set to gross premium if only one term
            }
            initialPayment.value = schedulePaymentInputs.value;


            // Calculate the monthly payment for the remaining terms
            const monthlySchedulePayment = remainingAmount / remainingTerms;

            console.log("Monthly Payment: " + monthlySchedulePayment);
            console.log("Total Terms: " + TermsValue);

            // Get the container for the payment terms
            const schedulePaymentContainer = document.getElementById('schedulePaymentTerms');

            // Get all current input fields for payments
            const currentFields = schedulePaymentContainer.querySelectorAll('input[id^="SchedulePayment"]');

            if (FirstPaymentValue > 0) {

                if (currentFields.length > TermsValue) {
                    for (let i = currentFields.length; i > TermsValue; i--) {
                        const fieldToRemove = currentFields[i - 1];
                        if (fieldToRemove.id !== "SchedulePayment1") { // Keep the first payment intact
                            fieldToRemove.parentElement.parentElement.remove();
                        }
                    }
                }

                if (currentFields.length < TermsValue) {
                    for (let i = currentFields.length + 1; i <= TermsValue; i++) {
                        const colDiv = document.createElement('div');
                        colDiv.classList.add('col-md-4');

                        const mbDiv = document.createElement('div');
                        mbDiv.classList.add('mb-4', 'mb-md-3', 'mb-sm-4');

                        const label = document.createElement('label');
                        label.setAttribute('for', 'SchedulePayment' + i);
                        label.classList.add('form-label', 'fw-bold');

                        if (i === 2) {
                            label.textContent = '2nd Payment';
                        } else if (i === 3) {
                            label.textContent = '3rd Payment';
                        } else if (i === 4) {
                            label.textContent = '4th Payment';
                        } else {
                            label.textContent = i + 'th Payment';
                        }

                        const input = document.createElement('input');
                        input.type = 'text';
                        input.classList.add('form-control', 'rounded-0', 'border-1');
                        input.id = 'SchedulePayment' + i;

                        input.placeholder = label.textContent;
                        input.value = monthlySchedulePayment.toFixed(2);
                        input.required = true;

                        mbDiv.appendChild(label);
                        mbDiv.appendChild(input);
                        colDiv.appendChild(mbDiv);
                        schedulePaymentContainer.appendChild(colDiv);
                    }
                }

                for (let i = 2; i <= TermsValue; i++) {
                    const input = document.getElementById('SchedulePayment' + i);
                    if (input) {
                        input.value = monthlySchedulePayment.toFixed(2); // Update the payment amount
                    }
                }

            }
        }
    }



    $(document).ready(function() {
        // Initialize form step
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

        document.getElementById('selectSources').addEventListener('change', function() {
            checkIfGDFI();
        });

        loadFormData();
        checkIfGDFI();
        showStep(currentStep);

        // Attach event listeners for form inputs
        const inputs = document.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', saveFormData);
            input.addEventListener('change', saveFormData);
            input.addEventListener('select', saveFormData);

        });

        // Get address input fields
        const unitNoField = document.getElementById('unitNo');
        const streetField = document.getElementById('street');
        const barangayField = document.getElementById('barangay');
        const cityField = document.getElementById('city');
        const fullAddressField = document.getElementById('fullAddress');

        // Function to update the full address input
        function updateFullAddress() {
            const fullAddress = `${unitNoField.value}, ${streetField.value}, ${barangayField.value}, ${cityField.value}`;
            fullAddressField.value = fullAddress;
        }

        unitNoField.addEventListener('input', updateFullAddress);
        streetField.addEventListener('input', updateFullAddress);
        barangayField.addEventListener('input', updateFullAddress);
        cityField.addEventListener('input', updateFullAddress);


        // computations
        grossPremiumInput.addEventListener('input', getNetOfDiscount);
        discountInput.addEventListener('input', getNetOfDiscount);
        amountDuetoProvider.addEventListener('input', getFullComm);


        marketingFundInput.addEventListener('input', getCommissionsValue);
        offSettingInput.addEventListener('input', getCommissionsValue);
        promoInput.addEventListener('input', getCommissionsValue);

        amountDuetoProvider.addEventListener('input', getVatSalesCredit);



        const selectIds = [
            '#team',
            '#salesAssocManager',
            '#branchManager',
            '#provider',
            '#product',
            '#subProduct',
            '#selectSource',
            '#sourceBranch',
            '#ifGdfi',
            '#area',
            '#alfcBranch',
            '#mop',
        ];

        selectIds.forEach(function(id) {
            $(id).select2({
                allowClear: true,
                minimumResultsForSearch: 0 // Shows the search box even if there are few results
            });
        });




        addCommissions();
        validatePaymentTerms();
        clearValidation();


        function formatDateToText(date) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(date).toLocaleDateString('en-US', options);
        }


        paymentTermsInputs.addEventListener('change', calculateDueDateEnd);
        dueDateStartInputs.addEventListener('change', calculateDueDateEnd);
        calculateDueDateEnd();


        // Add event listeners to both paymentTermsInputs and schedulePaymentInputs
        paymentTermsInputs.addEventListener('input', calculateSchedulePaymentsAmount);
        schedulePaymentInputs.addEventListener('input', calculateSchedulePaymentsAmount);

    });



</script>




@endsection



