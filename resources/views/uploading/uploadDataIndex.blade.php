@extends('layouts.app')
@section('content')

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<div class="container-fluid" style="padding-left: 3%; padding-right: 3%; zoom: 80%;">
    <!-- Loader Overlay -->
    <div id="loaderOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1050;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 24px;">
            UPLOADING...
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                </button>
            </div>
            <div class="modal-body">
                Excel data has been successfully imported.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalButton1">Close</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Upload Error</h5>
                </button>
            </div>
            <div class="modal-body">
                <!-- Dynamic error message will be inserted here -->
                {{ session('errorMessage') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="closeModalButton2">Close</button>
            </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center align-items-center vh-100" style="background: #f8f9fa;">
        <div class="container col-lg-4 p-5" style="background:rgb(255, 255, 255); border-radius: 20px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
            <form action="{{ route('uploadData.index') }}" method="GET">
                @csrf
                <h3 class="text-center fw-bold mb-4">STEP 1</h3>
                <p class="text-center mb-4">DOWNLOAD HEADERS</p>
                <div class="text-center">
                    <button type="submit" class="btn btn-warning w-100">Click here to Download Headers</button>
                </div>
            </form>

            <hr class="my-4">

            <h3 class="text-center fw-bold mb-4">STEP 2</h3>
            <p class="text-center mb-4">FILL UP HEADERS AND SAVE AS XLS or XLSX</p>
            
            <hr class="my-4">

            <form action="{{ route('uploadData.index') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <h3 class="text-center fw-bold mb-4">STEP 3</h3>
                <p class="text-center mb-4">UPLOAD FILE</p>
                <div class="form-group">
                    <!-- <label for="excel_file" class="fw-bold">Choose Excel File</label> -->
                    <input type="file" name="excel_file" id="excel_file" class="form-control" required>
                </div>
                <div class="text-center mt-4">
                    <button type="submit"
                            class="btn btn-custom w-100"
                            style="color: #ffffff; background-color: #043681;"
                            onmouseout="this.style.color='#ffffff'; this.style.backgroundColor='#043681';"
                            onmouseover="this.style.color='#313131'; this.style.backgroundColor='#c0c0c0';">
                        Upload
                    </button>
                </div>
            </form>
        </div>
    </div>


</div>

@endsection
