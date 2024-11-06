<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="container row ">
            <div class="first-col shadow-lg p-0 d-none col-md-6 d-md-flex justify-content-center align-items-center">
                <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="ALFC Logo Image">
            </div>
            <div class="second-col shadow-lg col-md-6 d-md-flex justify-content-center align-items-center">
                <div class="w-100 col-12 col-md-9">
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <img src="{{ asset('images/frontend/alfc-logo.jpg') }}" alt="ALFC Logo Image">
                    </div>
                    <form method="POST" action="{{ route('register') }}" style="margin-right:15px; margin-left:15px;">
                        @csrf
                        <div class="row">
                            <!-- Last Name -->
                            <div class="form-group col-5 col-md-5 mb-3">
                                <label class="text-secondary" for="last_name">Last Name</label>
                                <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name">
                                
                                @error('last_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            <!-- First Name -->
                            <div class="form-group col-5 col-md-5 mb-3">
                                <label class="text-secondary" for="first_name">First Name</label>
                                <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="given-name">
                                
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                            <!-- Middle Initial -->
                            <div class="form-group col-2 col-md-2 mb-3">
                                <label class="text-secondary" for="middle_initial">M.I</label>
                                <input id="middle_initial" type="text" class="form-control @error('middle_initial') is-invalid @enderror" name="middle_initial" value="{{ old('middle_initial') }}" required maxlength="1" pattern="[A-Za-z]" title="Only one letter is allowed" autocomplete="additional-name">
                                
                                @error('middle_initial')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-6 col-md-6 mb-3">
                                <label class="text-secondary" for="username">User Name</label>
                                <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="email">
                        
                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6 col-md-6 mb-3">
                                <label class="text-secondary" for="email">Email Address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            
                        </div>

                        <div class="row">
                            <div class="form-group col-6 col-md-6 mb-3">
                                <label class="text-secondary" for="viber_number">Viber Number</label>
                                <input 
                                    id="viber_number" 
                                    type="number" 
                                    class="form-control @error('viber_number') is-invalid @enderror" 
                                    name="viber_number" 
                                    value="{{ old('viber_number') }}" 
                                    required 
                                    autocomplete="tel" 
                                   
                                    maxlength="11" 
                                    >
                                
                                @error('viber_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-6 col-md-6 mb-3">
                                <label class="text-secondary" for="role">Role</label>
                                <select 
                                    id="role" 
                                    name="role" 
                                    class="form-control @error('role') is-invalid @enderror" 
                                    required>
                                    <option value="">Select Role</option>
                                    <option value="sales_associate" {{ old('role') == 'sales_associate' ? 'selected' : '' }}>
                                        Sales Associate
                                    </option>
                                    <option value="sales_marketing" {{ old('role') == 'sales_marketing' ? 'selected' : '' }}>
                                        Sales Marketing
                                    </option>
                                    <option value="sales_processor" {{ old('role') == 'sales_processor' ? 'selected' : '' }}>
                                        Sales Processor
                                    </option>
                                    <option value="revenue_assistant" {{ old('role') == 'revenue_assistant' ? 'selected' : '' }}>
                                        Revenue Assistant
                                    </option>
                                    <option value="collection" {{ old('role') == 'collection' ? 'selected' : '' }}>
                                        Collection
                                    </option>
                                    <option value="customer_care" {{ old('role') == 'customer_care' ? 'selected' : '' }}>
                                        Customer Care
                                    </option>
                                    <option value="accounting" {{ old('role') == 'accounting' ? 'selected' : '' }}>
                                        Accounting
                                    </option>
                                    <option value="database" {{ old('role') == 'database' ? 'selected' : '' }}>
                                        Database
                                    </option>
                                </select>
                            
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                       
                    
                        <div class="form-group mb-3">
                            <label class="text-secondary" for="password">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    
                        <div class="form-group mb-3">
                            <label class="text-secondary" for="password-confirm">Confirm Password</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                        <input type="hidden" id="name" name="name" value="">

                        <button type="submit" class="register_button btn w-100 fw-bold">Register</button>
                    
                        <!-- Additional section below the register button -->
                        <div class="text-center mt-5 mb-4">
                            <p>Already have an account? <a href="/login" class="text-decoration-underline text-danger">Login</a></p>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

    <script>
         // Select the form element and the inputs for Last Name, First Name, and Middle Initial
        const form = document.querySelector('form');
        const lastNameInput = document.getElementById('last_name');
        const firstNameInput = document.getElementById('first_name');
        const middleInitialInput = document.getElementById('middle_initial');
        const nameInput = document.getElementById('name');
        const viberInput = document.getElementById('viber_number');

        form.addEventListener('submit', function(event) {
            // Check if the Viber Number field has exactly 11 digits
            if (viberInput.value.length !== 11) {
                event.preventDefault(); // Prevent form submission
                alert('Please enter exactly 11 digits for the Viber Number.'); // Show alert
            }

            // Concatenate Last Name, First Name, and Middle Initial
            const lastName = lastNameInput.value.trim();
            const firstName = firstNameInput.value.trim();
            const middleInitial = middleInitialInput.value.trim();
            
            // Create the full name format
            nameInput.value = `${lastName}, ${firstName} ${middleInitial ? middleInitial + '.' : ''}`;
        });

        // Prevent the user from entering more than 11 digits by using the "input" event
        viberInput.addEventListener('input', function() {
            if (viberInput.value.length > 11) {
                viberInput.value = viberInput.value.slice(0, 11); // Trim to 11 digits
            }
        });


        
    </script>
</body>
</html>


