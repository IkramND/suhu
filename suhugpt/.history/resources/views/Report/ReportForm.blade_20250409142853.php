<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css"/>

  <title>Generate PDF</title>

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
        content: '\25BC'; /* Unicode panah ▼ */
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
        max-height: 150px;
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
      <div class="dropdown-selected">Pilih ID Mesin</div>
      <span class="dropdown-arrow">&#9660;</span> <!-- ▼ -->
      <ul class="dropdown-options">
        @foreach ($alats as $alat)
          <li data-value="{{ $alat->id_mesin }}">{{ $alat->id_mesin }}</li>
        @endforeach
      </ul>
      <input name="id_mesin" id="id_mesin">
    </div>

    <div class="form-group">
      <input class="form-control" type="number" name="month" placeholder="Month" required>
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

  selected.addEventListener('click', function (e) {
    e.stopPropagation();
    options.style.display = options.style.display === 'block' ? 'none' : 'block';
  });

  options.querySelectorAll('li').forEach(function (option) {
    option.addEventListener('click', function (e) {
      e.stopPropagation();
      selected.textContent = this.textContent;
      hiddenInput.value = this.getAttribute('data-value');
      options.style.display = 'none';
    });
  });

  document.addEventListener('click', function (e) {
    if (!dropdown.contains(e.target)) {
      options.style.display = 'none';
    }
  });
});
</script>

</body>
</html>
