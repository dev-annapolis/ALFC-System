@extends('layouts.app')

@section('content')
<style>
    .container-form {
        padding: 15px;
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
</style>

<div class="container-form min-vh-100">
    <div class="row">
        <!-- Steps section (Sidebar) -->
        <div class="col-md-3 mt-md-3 col-12 sidebar px-4">


            <div class="logo-container d-md-flex align-items-center text-center mt-3 mb-5">
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
                <p class="sub-main-title text-muted mb-md-5">Enter assured personal details and information</p>

                <form id="step1 mt-md-5">

                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="lastName" class="form-label fw-bold fw-bold">Last Name</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="lastName" placeholder="Enter Last Name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="firstName" class="form-label fw-bold">First Name</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="firstName" placeholder="Enter First Name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="middleName" class="form-label fw-bold">Middle Name</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="middleName" placeholder="Enter Middle Name (Optional)">
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
                                <input type="text" class="form-control rounded-0 border-1 rounded-0 border-1" id="street" placeholder="Enter Street" required>
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
                                <input type="text" class="form-control rounded-0 border-1" id="phoneNumber" placeholder="Enter Phone Number"
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

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="sa-sm-label" class="form-label fw-bold fw-bold fs-6">SA/SM</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="sa-sm">
                                    <option selected>Select SA or SM</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="issuanceCodeLabel" class="form-label fw-bold">Issuance Code</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="issuanceCode" placeholder="Enter the Issuance Code" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="salesDateLabel" class="form-label fw-bold">Sale Date</label>
                                <input type="date" class="form-control rounded-0 border-1 rounded-0" id="salesDate" placeholder="Select the Sale Date">
                            </div>
                        </div>

                    </div>

                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="classificationLabel" class="form-label fw-bold fw-bold fs-6">Classification</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="classification">
                                    <option selected>Select Classification</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="insuranceTypeLabel" class="form-label fw-bold">Insurance Type</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="insuranceType">
                                    <option selected>Select Insurance Type</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-5 mb-md-5 mb-sm-4">
                                <label for="salesStatusLabel" class="form-label fw-bold">Sale Status</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="salesStatus">
                                    <option selected>Select Sale Status</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="branchManagerLabel" class="form-label fw-bold fw-bold fs-6">Branch Manager</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="branchManager">
                                    <option selected>Select Branch Manager</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
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
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="legalSupervisor" placeholder="Enter Legal Supervisor Name" required>
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
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="assignAtty2" placeholder="Enter Attorney's Name" required>
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
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="provider">
                                    <option selected>Select Provider</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-md-3">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="productLabel" class="form-label fw-bold fw-bold fs-6">Product</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="product">
                                    <option selected>Select Product</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="subProductLabel" class="form-label fw-bold fw-bold fs-6">Sub-Product</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="subProduct">
                                    <option selected>Select Sub-Product</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="productTypeLabel" class="form-label fw-bold fw-bold fs-6">Product Type</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="productType">
                                    <option selected>Select Product Type</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                    </div>


                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="sourceLabel" class="form-label fw-bold fw-bold fs-6">Source</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="source">
                                    <option selected>Select Source</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="sourceBranchLabel" class="form-label fw-bold fw-bold fs-6">Source Branch</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="sourceBranch">
                                    <option selected>Select Source Branch</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="ifGdfiLabel" class="form-label fw-bold fw-bold fs-6">If GDFI</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="ifGdfi">
                                    <option selected>Select If GDFI</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
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
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="area">
                                    <option selected>Select Area</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="alfcBranchLabel" class="form-label fw-bold fw-bold fs-6">ALFC Branch</label>
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="alfcBranch">
                                    <option selected>Select ALFC Branch</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
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
                                <label for="policyInsumptionLabel" class="form-label fw-bold fw-bold fs-6">Policy Insumption Date</label>
                                <input type="date" class="form-control rounded-0 rounded-0 border-1" id="policyInsumption" placeholder="Enter Policy Inisu" required>
                            </div>
                        </div>

                    </div>


                    <div class="row">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="plateConductionNumberLabel" class="form-label fw-bold fw-bold fs-6">Plate Conduction Number</label>
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
                                <select class="form-control form-select rounded-0 border-1 rounded-0 m-0" id="mop">
                                    <option selected>Select Mode of Payment</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                    </div>



                    <div class="row mt-md-5">

                        <div class="col-md-4 ">
                            <div class="mb-5 mb-md-4 mb-sm-4">
                                <label for="policyExpirationAgingLabel" class="form-label fw-bold fw-bold fs-6">Policy Expiration Aging</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1 disabled" id="policyExpirationAging" disabled value="test">
                            </div>
                        </div>

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


                    <div class="row mt-md-5">

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



                    <div class="row mt-md-5">

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="commissionsLabel" class="form-label fw-bold">Commissions</label>
                                <input type="text" class="form-control rounded-0 border-1" id="commissions" placeholder="Enter Name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-4 mb-sm-4">
                                <label for="commissionAmountLabel" class="form-label fw-bold">Amount</label>
                                <input type="text" class="form-control rounded-0 border-1" id="commissionAmount" placeholder="Enter Amount" required>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-md-5">

                        <div class="col-md-4 mb-5 mb-md-5 mb-sm-5">
                            <button type="button" class="bg-secondary"  onclick="">ADD</button>
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
                                <input type="text" class="form-control rounded-0 border-1" id="vat" required disabled>
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
                                <input type="text" class="form-control rounded-0 border-1" id="paymentTerms" placeholder="Enter Payment Terms" required>
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

                    <div class="row mb-md-3 mt-md-5">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-3 mb-sm-4">
                                <label for="ScheduleFirstPaymentLabel" class="form-label fw-bold">Schedule of 1st Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="ScheduleFirstPayment" placeholder="Enter Schedule of 1st Payment" required>
                            </div>
                        </div>


                    </div>


                    <div class="row mt-md-5">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-3 mb-sm-4">
                                <label for="ScheduleFirstPaymentLabel" class="form-label fw-bold">Schedule of 2nd Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="ScheduleFirstPayment" required disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-3 mb-sm-4">
                                <label for="ScheduleFirstPaymentLabel" class="form-label fw-bold">Schedule of 3rd Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="ScheduleFirstPayment" required disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-3 mb-sm-4">
                                <label for="ScheduleFirstPaymentLabel" class="form-label fw-bold">Schedule of 4th Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="ScheduleFirstPayment" required disabled>
                            </div>
                        </div>


                    </div>


                    <div class="row mb-md-5">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="ScheduleFirstPaymentLabel" class="form-label fw-bold">Schedule of 5th Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="ScheduleFirstPayment" required disabled>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="ScheduleFirstPaymentLabel" class="form-label fw-bold">Schedule of 6th Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="ScheduleFirstPayment" required disabled>
                            </div>
                        </div>



                    </div>


                    <div class="row mt-md-5">

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

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-4 mb-sm-4">
                                <label for="initialPaymentLabel" class="form-label fw-bold">Initial Payment</label>
                                <input type="text" class="form-control rounded-0 border-1" id="initialPayment" placeholder="Enter Initial Payment" required>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb-4 mb-md-5 mb-sm-4">
                                <label for="dateGoodSalesLabel" class="form-label fw-bold">Date of Good as Sales</label>
                                <input type="text" class="form-control rounded-0 border-1" id="dateGoodSales" placeholder="Enter Date of Good as Sales" required>
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
    const formSteps = document.querySelectorAll('.form-step');
    const stepIndicators = document.querySelectorAll('.sidebar .step');


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

    function nextStep() {
        if (currentStep < formSteps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    }

    function prevStep() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    }

    document.querySelectorAll('.step input[type="radio"]').forEach((radio, index) => {
            radio.addEventListener('change', () => {
                currentStep = index;
                showStep(currentStep);
            });
        });

        showStep(currentStep);

        document.addEventListener('DOMContentLoaded', () => {
        // Function to update the hidden input field
        function updateFullAddress() {
            const unitNo = document.getElementById('unitNo').value;
            const street = document.getElementById('street').value;
            const barangay = document.getElementById('barangay').value;
            const city = document.getElementById('city').value;

            // Concatenate the address
            const fullAddress = `${unitNo}, ${street}, ${barangay}, ${city}`;

            // Update the hidden input field
            document.getElementById('fullAddress').value = fullAddress;
        }

        // Add event listeners to update the full address when inputs change
        document.getElementById('unitNo').addEventListener('input', updateFullAddress);
        document.getElementById('street').addEventListener('input', updateFullAddress);
        document.getElementById('barangay').addEventListener('input', updateFullAddress);
        document.getElementById('city').addEventListener('input', updateFullAddress);
    });
</script>

@endsection
