<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"/>

  <title>Archive Report</title>

  <style>
    /* Hilangkan spinner input number */
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    html, body {
      overflow-x: hidden;
      height: 100%;
      margin: 0;
      padding: 0;
    }

    .login-dark {
      height: 100vh;
      background-size: cover;
      background: #000000;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-dark form {
      max-width: 400px;
      width: 90%;
      background-color: #0f0f0f;
      padding: 40px;
      border-radius: 4px;
      color: #fff;
      box-shadow: 3px 3px 4px rgba(0,0,0,0.2);
    }

    .login-dark .illustration {
      text-align: center;
      padding: 15px 0 20px;
      font-size: 100px;
      color: blue;
    }

    .login-dark form .form-control {
      background: none;
      border: none;
      border-bottom: 1px solid #434a52;
      border-radius: 0;
      box-shadow: none;
      outline: none;
      color: inherit;
    }

    .login-dark form .btn-primary {
      background: #214a80;
      border: none;
      border-radius: 4px;
      padding: 11px;
      box-shadow: none;
      margin-top: 26px;
    }

    .login-dark form .btn-primary:hover {
      background: #1a3b6e;
    }

    /* Custom dropdown */
    .custom-dropdown {
        position: relative;
        user-select: none;
    }

    .dropdown-selected {
        background-color: transparent;
        border-bottom: 1px solid #434a52;
        padding: 10px;
        color: #fff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dropdown-selected::after {
        font-size: 0.8rem;
        color: #fff;
        margin-left: 10px;
    }

    .dropdown-options {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: #1a1a1a;
        border: 1px solid #434a52;
        max-height: 200%;
        overflow-y: auto;
        z-index: 999;
        display: none;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .dropdown-options li {
        padding: 10px;
        cursor: pointer;
        color: white;
    }

    .dropdown-options li:hover {
        background-color: #333;
    }
  </style>
</head>
<body>

<div class="login-dark">
  <form action="{{ route('report.result') }}" method="POST">
    @csrf

    <div class="illustration"><i class="ion-clipboard"></i></div>

    @if ($errors->any())
      <div style="color: red; padding: 10px; border-radius: 5px;">
        @foreach ($errors->all() as $error)
          <p><i>{{" * $error "}}</i></p>
        @endforeach
      </div>
    @endif

    <div class="form-group custom-dropdown">
      <div class="dropdown-selected"><span class="selected-text">Choose Machine ID</span><span class="dropdown-arrow" style="">&#9660;</span></div>

      <ul class="dropdown-options">
        @foreach ($alats as $alat)
          <li data-value="{{ $alat->id_mesin }}">{{ $alat->id_mesin }}</li>
        @endforeach
      </ul>
      <input type="hidden" name="id_mesin" id="id_mesin">
    </div>

    <div class="form-group custom-dropdown">
        <div class="dropdown-selected"><span class="selected-text">Choose Month</span><span class="dropdown-arrow">&#9660;</span></div>

      {{-- <input class="form-control" type="number" name="month" placeholder="Month" required> --}}
      {{-- <select name="month" class="form-control" style="background:#0f0f0f ">
        <option value="1">January</option>
        <option value="2">February</option>
        <option value="3">March</option>
        <option value="4">April</option>
        <option value="5">May</option>
        <option value="6">June</option>
        <option value="7">July</option>
        <option value="8">August</option>
        <option value="9">September</option>
        <option value="10">October</option>
        <option value="11">November</option>
        <option value="12">December</option>
      </select> --}}
    </div>
    <div class="form-group">
      <input class="form-control" type="number" name="year" placeholder="Year" required>
    </div>

    <div class="form-group">
      <button class="btn btn-primary btn-block" style="background: blue">Submit</button>
    </div>
  </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.querySelector('.custom-dropdown');
        const selected = dropdown.querySelector('.dropdown-selected');
        const options = dropdown.querySelector('.dropdown-options');
        const hiddenInput = dropdown.querySelector('input[type="hidden"]');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        const selectedText = dropdown.querySelector('.selected-text');

        selected.addEventListener('click', function () {
            const isOpen = options.style.display === 'block';
            options.style.display = isOpen ? 'none' : 'block';
            arrow.innerHTML = isOpen ? '&#9660;' : '&#9650;'; // ▼ : ▲
        });

        options.querySelectorAll('li').forEach(function (option) {
            option.addEventListener('click', function () {
                selectedText.textContent = this.textContent;
                hiddenInput.value = this.getAttribute('data-value');
                options.style.display = 'none';
                arrow.innerHTML = '&#9660;';
            });
        });

        // Klik di luar dropdown untuk menutup dan reset panah
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                options.style.display = 'none';
                arrow.innerHTML = '&#9660;';
            }
        });
    });
    </script>


</body>
</html>
