<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .login-dark {
            height: 100vh;
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
    <div class="login-dark">
        @if($step == 1)
        <form id="EmailForm" method="POST" action="{{ route('report.processStep1') }}">
            @csrf
            <div class="illustration"><i class="icon ion-ios-email"></i></div>
            @if ($errors->any())
                <div style="color: red; padding: 10px; border-radius: 5px;">
                    @foreach ($errors->all() as $error)
                        <p><i>* {{ $error }}</i></p>
                    @endforeach
                </div>
            @endif
            <div class="form-group">
                <input class="form-control" type="email" name="email" placeholder="Send To Email" required>
            </div>
            <div class="form-group">
                <button class="btn btn-primary btn-block" style="background: blue">Send Email</button>
            </div>
        </form>
        @endif

        @if($step == 2)
        <form id="ReportForm" method="POST" action="{{ route('report.processStep2') }}">
            @csrf
            <div class="illustration"><i class="ion-clipboard"></i></div>
            @if ($errors->any())
                <div style="color: red; padding: 10px; border-radius: 5px;">
                    @foreach ($errors->all() as $error)
                        <p><i>* {{ $error }}</i></p>
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
                <input class="form-control flatpickr-input" type="text" id="startDateInput" name="start_date" placeholder="Select Start Date" readonly>
            </div>

            <div class="form-group">
                <input class="form-control flatpickr-input" type="text" id="endDateInput" name="end_date" placeholder="Select End Date" readonly>
            </div>

            <div class="form-group">
                <button class="btn btn-primary btn-block" style="background: blue">Submit</button>
            </div>
        </form>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Inisialisasi flatpickr untuk dua input
        flatpickr("#startDateInput", {
            dateFormat: "Y-m-d"
        });
        flatpickr("#endDateInput", {
            dateFormat: "Y-m-d"
        });

        // Dropdown Custom
        document.addEventListener('DOMContentLoaded', function () {
            const dropdowns = document.querySelectorAll('.custom-dropdown');

            dropdowns.forEach(function (dropdown) {
                const selected = dropdown.querySelector('.dropdown-selected');
                const options = dropdown.querySelector('.dropdown-options');
                const hiddenInput = dropdown.querySelector('input[type="hidden"]');
                const arrow = dropdown.querySelector('.dropdown-arrow');
                const selectedText = dropdown.querySelector('.selected-text');

                selected.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const isOpen = options.style.display === 'block';

                    document.querySelectorAll('.dropdown-options').forEach(opt => opt.style.display = 'none');
                    document.querySelectorAll('.dropdown-arrow').forEach(arw => arw.innerHTML = '&#9660;');

                    if (!isOpen) {
                        options.style.display = 'block';
                        arrow.innerHTML = '&#9650;';
                    }
                });

                options.querySelectorAll('li').forEach(function (item) {
                    item.addEventListener('click', function (e) {
                        const value = this.getAttribute('data-value');
                        const text = this.innerText;
                        hiddenInput.value = value;
                        selectedText.innerText = text;
                        options.style.display = 'none';
                        arrow.innerHTML = '&#9660;';
                    });
                });

                document.addEventListener('click', function () {
                    options.style.display = 'none';
                    arrow.innerHTML = '&#9660;';
                });
            });
        });
    </script>
</body>
</html>
