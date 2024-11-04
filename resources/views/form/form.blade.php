@extends('layouts.app')

@section('content')
<style>
    .container-form {
        padding: 15px;
        margin: 15px;
        background-color: #ffffff;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .steps {
        display: flex;
        flex-direction: column;
        position: relative;
        padding-left: 20px;
    }

    /* Connector line */
    .steps::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 30px;
        bottom: 0;
        width: 2px;
        background-color: #b0bec5;
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
    }

    .step::before {
        content: '';
        width: 20px;
        height: 20px;
        border: 2px solid #b0bec5;
        border-radius: 50%;
        margin-right: 10px;
        transition: background-color 0.3s, border-color 0.3s;
        position: relative;
        z-index: 1;
    }

    .step.completed {
        color: #ffcccc;
    }

    .step.completed::before {
        background-color: #ffcccc;
        border-color: #ffcccc;
    }

    .step.active::before {
        background-color: red;
        border-color: red;
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
        margin-bottom: 10px;
    }

    form input, form select, form button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1em;
    }

    form button {
        background-color: #007bff;
        color: white;
        border: none;
        cursor: pointer;
    }

    form button:hover {
        background-color: #0056b3;
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

<div class="container-form">
    <div class="row">
        <!-- Steps section (Sidebar) -->
        <div class="col-md-3 col-12 sidebar">
            <div class="logo-container d-none d-md-flex align-items-center m-3 mb-5">
                <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="Logo" class="img-fluid" style="max-width: 50px; margin-right: 10px;">
                <p class="fw-bold mb-0">
                    ALFC Insurance Agency Inc.
                </p>
            </div>
            <div class="steps mt-3" id="stepsContainer">
                <label class="step active">
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
        <div class="col-md-9 col-12 form-content">
            <!-- Step 1: Personal Information -->
            <div class="form-step active">
                <h3 class="fw-bold">Personal Details</h3>
                <p class="text-muted">Enter assured personal details and information</p>
                <form id="step1">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField1" class="form-label">Input Field 1</label>
                                <input type="text" class="form-control" id="inputField1" placeholder="Enter field 1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField2" class="form-label">Input Field 2</label>
                                <input type="text" class="form-control" id="inputField2" placeholder="Enter field 2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField3" class="form-label">Input Field 3</label>
                                <input type="text" class="form-control" id="inputField3" placeholder="Enter field 3">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField1" class="form-label">Input Field 1</label>
                                <input type="text" class="form-control" id="inputField1" placeholder="Enter field 1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField2" class="form-label">Input Field 2</label>
                                <input type="text" class="form-control" id="inputField2" placeholder="Enter field 2">
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

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField1" class="form-label">Input Field 1</label>
                                <input type="text" class="form-control" id="inputField1" placeholder="Enter field 1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField2" class="form-label">Input Field 2</label>
                                <input type="text" class="form-control" id="inputField2" placeholder="Enter field 2">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField3" class="form-label">Input Field 3</label>
                                <input type="text" class="form-control" id="inputField3" placeholder="Enter field 3">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField1" class="form-label">Input Field 1</label>
                                <input type="text" class="form-control" id="inputField1" placeholder="Enter field 1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="inputField2" class="form-label">Input Field 2</label>
                                <input type="text" class="form-control" id="inputField2" placeholder="Enter field 2">
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
</script>
@endsection
