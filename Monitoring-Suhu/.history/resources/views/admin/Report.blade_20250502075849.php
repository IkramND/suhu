<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <title>Generate Real Time Report</title>
    <style>
        html, body {
            overflow: hidden;
            height: 100%;
            margin: 0;
            padding: 0;
        }
        .login-dark form select.form-control option {
    color: black;  /* Warna teks di dalam dropdown */
    background-color: white; /* Warna latar belakang opsi */
}
        .login-dark {
            height: 100vh;
            background-size: cover;
            position: relative;
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
            text-shadow: none;
            outline: none;
        }

        .login-dark form .btn-primary:hover {
            background: #1a3b6e;
        }

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

.dropdown-options {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background-color: #1a1a1a;
    border: 1px solid #434a52;
    max-height: 200px;
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




    <div class="login-dark" style="height: 100vh;">

        <form action="{{ route('generate.pdf') }}" method="POST">

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
        <div class="dropdown-selected">
          <span class="selected-text">Choose Machine ID</span>
          <span class="dropdown-arrow">&#9660;</span>
        </div>

        <ul class="dropdown-options">
          @foreach ($alats as $alat)
            <li data-value="{{ $alat->id_mesin }}">{{ $alat->id_mesin }}</li>
          @endforeach
        </ul>

        <input type="hidden" name="id_mesin" id="id_mesin">
      </div>

            <div class="form-group">
                <input class="form-control flatpickr-input" type="text" id="customDateInput" placeholder="Select Start Date" name="start_date">
            </div>

            <div class="form-group">
                <input class="form-control flatpickr-input" type="text" id="customDateInput" placeholder="Select End Date" name="end_date">
            </div>

            <div class="form-group custom-dropdown">
                <div class="dropdown-selected">
                <span class="selected-text">Choose File Output</span>
                <span class="dropdown-arrow">&#9660;</span>
            </div>

                <ul class="dropdown-options">
                    <li data-value="PDF">PDF</li>
                    <li data-value="CSV">CSV</li>
                </ul>
                <input type="hidden" name="file" id="file">
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" style="background-color:blue">Submit</button>
            </div>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>

        flatpickr("#customDateInput", {
        dateFormat: "Y-m-d",
            });


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
                arrow.innerHTML = isOpen ? '&#9660;' : '&#9650;';
            });

            options.querySelectorAll('li').forEach(function (option) {
                option.addEventListener('click', function () {
                    selectedText.textContent = this.textContent;
                    hiddenInput.value = this.getAttribute('data-value');
                    options.style.display = 'none';
                    arrow.innerHTML = '&#9660;';
                });
            });

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
