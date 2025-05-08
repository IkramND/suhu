<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap & Ionicons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">



    <title></title>
</head>
<body>
    <div class="login-dark">
        <form method="POST" action="{{ route('acess.submit') }}">
            @csrf
            <div class="illustration"><i class="ion-unlocked"></i></div>

            @if(session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div>
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li style="background: #0f0f0f; color:red "><i>{{"* $error "}}</i></li>
                        @endforeach
                    </ul>
                </div>
            @endif
        <div>
            <p>Choose Acess Machine for <span style="font-weight: bold">{{session('user.name')}}</span></p>
        </div>
        <div>
            @foreach ($alats as $alat)
                <input type="checkbox" name="acess[]" value="{{$alat->id_mesin}}">
                {{$alat->id_mesin}}
                <br>
            @endforeach
        </div>
        <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
        </form>
    </div>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Styling -->
    <style>
        .login-dark {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: black  ;
        }

        .login-dark form {
            width: 100%;
            max-width: 350px;
            background-color: #0f0f0f;
            padding: 40px;
            border-radius: 5px;
            text-align: center;
            color: #fff;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .login-dark .illustration {
            font-size: 80px;
            color: blue;
            margin-bottom: 20px;
        }

        .login-dark .form-control {
            background: none;
            border: none;
            border-bottom: 1px solid #434a52;
            border-radius: 0;
            box-shadow: none;
            outline: none;
            color: inherit;
            padding: 10px;
        }

        .login-dark .form-control::placeholder {
            color: #ccc;
        }

        .login-dark .btn-primary {
            background: blue;
            border: none;
            padding: 10px;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-dark .btn-primary:hover {
            background: darkblue;
        }

        .alert {
            font-size: 14px;
            border-radius: 4px;
            padding: 10px;
        }

        body {
            overflow: hidden;
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
        text-align: left;
    }

    .dropdown-options li:hover {
        background-color: #333;
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const dropdown = document.querySelectorAll('.custom-dropdown');

        dropdown.forEach(function(dropdown){
            const selected = dropdown.querySelector('.dropdown-selected');
            const options = dropdown.querySelector('.dropdown-options');
            const hiddenInput = dropdown.querySelector('input[type="hidden"]');
            const arrow = dropdown.querySelector('.dropdown-arrow');
            const selectedText = dropdown.querySelector('.selected-text');

            selected.addEventListener('click', function (e){
                e.stopPropagation();
                const isOpen = options.style.display === 'block';

                document.querySelectorAll('.dropdown-options').forEach(opt => opt.style.display = 'none');
                document.querySelectorAll('.dropdown-arrow').forEach(arw => arw.innerHTML = '&#9660;');

                options.style.display = isOpen ? 'none' : 'block';
                arrow.innerHTML = isOpen ? '&#9660;' : '&#9650;' ;
            });

            options.querySelectorAll('li').forEach(function (option){
                option.addEventListener('click',function (e){
                    e.stopPropagation();
                    selectedText.textContent = this.textContent;
                    hiddenInput.value = this.getAttribute('data-value');
                    options.style.display = 'none';
                    arrow.innerHTML = '&#9660;';
                });
            });
        });

        document.addEventListener('click', function(){
            document.querySelectorAll('.dropdown-options').forEach(opt => opt.style.display = 'none');
            document.querySelectorAll('.dropdown-arrow').forEach(arw => arw.innerHTML = '&#9660;')
        })
    });
    </script>
</body>
</html>
