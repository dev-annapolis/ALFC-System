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
        font-size: 1em;
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
        font-size: 1em;
        cursor: pointer;
        width: 100px; /* Set desired width */
        height: 25px; /* Set desired height */
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
                <h3 class="main-title fw-bolder fs-3 mt-md-5">Personal Details</h3>
                <p class="sub-main-title text-muted mb-md-5">Enter assured personal details and information</p>

                <form id="step1 mt-md-5">

                    <div class="row ">

                        <div class="col-md-4 ">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="lastName" class="form-label fw-bold fw-bold">Last Name</label>
                                <input type="text" class="form-control rounded-0 rounded-0 border-1" id="lastName" placeholder="Enter last name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="firstName" class="form-label fw-bold">First Name</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="firstName" placeholder="Enter first name" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="middleName" class="form-label fw-bold">Middle Name</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0" id="middleName" placeholder="Enter middle name">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-3 mb-sm-4">
                                <label for="unitNo" class="form-label fw-bold">Lot No.</label>
                                <input type="text" class="form-control rounded-0 border-1 rounded-0 border-1" id="unitNo" placeholder="Enter Lot No." required>
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
                                <label for="natureOfBusiness" class="form-label fw-bold">Nature of Business</label>
                                <input type="text" class="form-control rounded-0 border-1" id="natureOfBusiness" placeholder="Enter Nature of Business" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="otherAsset" class="form-label fw-bold">Other Asset</label>
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
                                <input type="text" class="form-control rounded-0 border-1" id="facebookAccount" placeholder="Enter Facebook Account URL "
                                       title="Please enter your Facebook account link or username">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3 mb-md-5 mb-sm-4">
                                <label for="remarks" class="form-label fw-bold">Remarks</label>
                                <textarea class="form-control rounded-0 border-1" id="remarks" rows="5" placeholder="Enter your remarks here..." required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="button-container">
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>

            </div>

            <!-- Step 2: Education -->
            <div class="form-step">
                <h3>Insurance</h3>
                <p class="text-muted">Enter assured personal details and information</p>
                <form id="step2">

                    <div class="row ">
                        <div class="col-md-4">
                            <div class="mb-3 ">
                                <label for="inputField1" class="form-label fw-bold">Input Field 1</label>
                                <input type="text" class="form-control rounded-0 border-1" id="inputField1" placeholder="Enter field 1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField2" class="form-label fw-bold">Input Field 2</label>
                                <input type="text" class="form-control rounded-0 border-1" id="inputField2" placeholder="Enter field 2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField3" class="form-label fw-bold">Input Field 3</label>
                                <input type="text" class="form-control rounded-0 border-1" id="inputField3" placeholder="Enter field 3">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField1" class="form-label fw-bold">Input Field 1</label>
                                <input type="text" class="form-control rounded-0 border-1" id="inputField1" placeholder="Enter field 1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField2" class="form-label fw-bold">Input Field 2</label>
                                <input type="text" class="form-control rounded-0 border-1" id="inputField2" placeholder="Enter field 2">
                            </div>
                        </div>

                    </div>

                    <div class="button-container">
                        <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Work Experience -->
            <div class="form-step">
                <h3>Product</h3>
                <p>Enter assured personal details and information</p>
                <form id="step3">

                    <div class="button-container">
                        <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>
            </div>

            <!-- Step 4: User Photo -->
            <div class="form-step">
                <h3>Commision</h3>
                <p>Enter assured personal details and information</p>
                <form id="step4">

                    <div class="button-container">
                        <button type="button" class="prev-button" onclick="prevStep()">Back</button>
                        <button type="button" class="next-button" onclick="nextStep()">Next</button>
                    </div>
                </form>
            </div>

            <!-- Step 5: Summary -->
            <div class="form-step">
                <h3>Payment</h3>
                <p>Enter assured personal details and information</p>
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
