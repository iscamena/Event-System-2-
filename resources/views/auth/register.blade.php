@extends('layouts.auth')
@section('title', 'Create account')


@section('content')
    <h2>Create your account</h2>
    <p class="sub">Just a few steps to get started.</p>


    <form method="POST" action="{{ route('register') }}"
          enctype="multipart/form-data" novalidate>
        @csrf


        <div class="field {{ $errors->has('name') ? 'has-error' : '' }}">
            <label for="name">Full name</label>
            <input type="text" id="name" name="name"
                   value="{{ old('name') }}" autocomplete="name" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <div class="field {{ $errors->has('student_number') ? 'has-error' : '' }}">
            <label for="student_number">Student number</label>
            <input type="text" id="student_number" name="student_number"
                   value="{{ old('student_number') }}"
                   placeholder="2024-00123-SR-0" required>
            @error('student_number')
                <div class="error">{{ $message }}</div>
            @else
                <div class="hint">Format: 2024-00123-SR-0</div>
            @enderror
        </div>


        <div class="field {{ $errors->has('organization') ? 'has-error' : '' }}">
            <label for="organization">Academic organization</label>
            <select id="organization" name="organization" required>
                <option value="" disabled @selected(!old('organization'))>
                    Choose your organization
                </option>
                @foreach ($organizations as $org)
                    <option value="{{ $org->value }}"
                        @selected(old('organization') === $org->value)>
                        {{ $org->value }}
                    </option>
                @endforeach
            </select>
            @error('organization')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <div class="field {{ $errors->has('cor') ? 'has-error' : '' }}">
            <label for="cor">Certificate of Registration (COR)</label>
            <input type="file" id="cor" name="cor"
                   accept=".pdf,.jpg,.jpeg,.png" required>
            @error('cor')
                <div class="error">{{ $message }}</div>
            @else
                <div class="hint">PDF, JPG, JPEG, or PNG. Maximum 5 MB.</div>
            @enderror
        </div>


        <!-- Password -->
        <div class="field {{ $errors->has('password') ? 'has-error' : '' }}">
            <label for="password">Password</label>


            <input type="password" id="password" name="password"
                   autocomplete="new-password" required>


            <!-- Strength label -->
            <div style="display: flex; justify-content: space-between;
                        align-items: center; margin-top: 8px;">
                <span class="hint">Password strength</span>
                <strong id="strength-label" style="font-size: 13px;">
                    Not entered
                </strong>
            </div>


            <!-- Strength progress bar -->
            <div style="display: flex; gap: 5px; margin-top: 8px;">
                <div class="strength-bar"
                     style="height: 6px; flex: 1; background: #ddd;
                            border-radius: 5px;"></div>
                <div class="strength-bar"
                     style="height: 6px; flex: 1; background: #ddd;
                            border-radius: 5px;"></div>
                <div class="strength-bar"
                     style="height: 6px; flex: 1; background: #ddd;
                            border-radius: 5px;"></div>
            </div>


            <!-- Password requirements -->
            <div style="margin-top: 12px; font-size: 13px;">
                <div id="length-check" class="password-check">
                    ○ At least 8 characters
                </div>


                <div id="uppercase-check" class="password-check">
                    ○ One uppercase letter
                </div>


                <div id="number-check" class="password-check">
                    ○ One number
                </div>
            </div>


            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>


        <!-- Confirm password -->
        <div class="field">
            <label for="password_confirmation">Confirm password</label>
            <input type="password" id="password_confirmation"
                   name="password_confirmation"
                   autocomplete="new-password" required>
        </div>


        <!-- Show password -->
        <label class="check">
            <input type="checkbox" id="showPassword">
            Show password
        </label>


        <button type="submit" class="btn">Create account</button>
    </form>


    <p class="switch">
        Already registered? <a href="{{ route('login') }}">Log in</a>
    </p>
@endsection


<script>
document.addEventListener('DOMContentLoaded', function () {


    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');
    const showPassword = document.getElementById('showPassword');


    const strengthLabel = document.getElementById('strength-label');
    const bars = document.querySelectorAll('.strength-bar');


    const lengthCheck = document.getElementById('length-check');
    const uppercaseCheck = document.getElementById('uppercase-check');
    const numberCheck = document.getElementById('number-check');


    // Show or hide password
    showPassword.addEventListener('change', function () {
        password.type = this.checked ? 'text' : 'password';
        confirmation.type = this.checked ? 'text' : 'password';
    });


    // Update password strength while typing
    password.addEventListener('input', function () {


        const value = password.value;


        const hasLength = value.length >= 8;
        const hasUppercase = /[A-Z]/.test(value);
        const hasNumber = /[0-9]/.test(value);


        let score = 0;


        if (hasLength) score++;
        if (hasUppercase) score++;
        if (hasNumber) score++;


        // Update requirement checkmarks
        lengthCheck.textContent =
            (hasLength ? '✓ ' : '○ ') + 'At least 8 characters';


        uppercaseCheck.textContent =
            (hasUppercase ? '✓ ' : '○ ') + 'One uppercase letter';


        numberCheck.textContent =
            (hasNumber ? '✓ ' : '○ ') + 'One number';


        // Update requirement colors
        lengthCheck.style.color = hasLength ? 'green' : '#888';
        uppercaseCheck.style.color = hasUppercase ? 'green' : '#888';
        numberCheck.style.color = hasNumber ? 'green' : '#888';


        // Reset progress bars
        bars.forEach(function (bar) {
            bar.style.background = '#ddd';
        });


        // Determine password strength
        let strength = 'Not entered';
        let color = '#888';


        if (value.length === 0) {
            strength = 'Not entered';
        } else if (score === 1) {
            strength = 'Weak';
            color = '#dc4545';
        } else if (score === 2) {
            strength = 'Medium';
            color = '#e99a24';
        } else {
            strength = 'Strong';
            color = '#16a34a';
        }


        strengthLabel.textContent = strength;
        strengthLabel.style.color = color;


        // Fill progress bars
        for (let i = 0; i < score; i++) {
            bars[i].style.background = color;
        }
    });


});
</script>



