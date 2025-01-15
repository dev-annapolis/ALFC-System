@extends('layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<style>
@keyframes progress {
    0% {
        width: 0%;
    }
    50% {
        width: 50%;
    }
    100% {
        width: 100%;
    }
}
</style>

<div class="container-fluid" style="padding-left: 3%; padding-right: 3%; zoom: 80%;">
    <!-- Loader Overlay -->
    <div id="loaderOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1050;">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
            <!-- Uploading Text -->
            <div style="font-size: 24px; font-weight: bold; margin-bottom: 10px;">
                Uploading...
            </div>
            <!-- Progress Bar -->
            <div style="width: 300px; height: 8px; background: rgba(255, 255, 255, 0.2); border-radius: 4px; overflow: hidden; margin: 0 auto;">
                <div class="progress-bar" style="width: 0%; height: 100%; background: #4caf50; animation: progress 3s infinite;"></div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Excel data has been successfully imported.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Error Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Upload Error</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! session('uploadError') !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

            <form action="{{ route('uploadData.store') }}" method="POST" enctype="multipart/form-data">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session()->has('uploadSuccess') && session('uploadSuccess'))
            console.log('Showing success modal'); // Debug log
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif

        @if(session()->has('uploadError') && session('uploadError'))
            console.log('Showing error modal'); // Debug log
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        @endif

        const uploadForm = document.querySelector('form[action="{{ route('uploadData.store') }}"]');
        uploadForm.addEventListener('submit', function() {
            document.getElementById('loaderOverlay').style.display = 'flex';
            
        });
    });
</script>
@endsection