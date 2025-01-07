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

    <div class="container-fluid col-lg-12 mt-4 mb-4" style="background: white; padding: 3%; border-radius: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        
        <div class="row">
            <div class="col text-left">
                <h1 class="fw-bolder mb-3">Upload an Excel File</h1>
            </div>
        </div>

        <form action="{{ route('uploadData.index') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mt-4">
                <label for="excel_file" class="mr-2 fw-bold">Choose Excel File</label>
                <input type="file" name="excel_file" id="excel_file" required>
            </div>

            <div class="d-flex justify-content-start mt-4">
                <button type="submit"
                        class="btn btn-custom border-0 fs-6 fw-bolder"
                        style="color: #ffffff; background-color: #043681; width: 200px;"
                        onmouseout="this.style.color='#ffffff'; this.style.backgroundColor='#043681';"
                        onmouseover="this.style.color='#313131'; this.style.backgroundColor='#c0c0c0';"
                        >
                    Upload
                </button>
            </div>
        </form>
    </div>


</div>

@endsection
