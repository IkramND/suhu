<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate PDF</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        form { width: 50%; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button { margin-top: 15px; padding: 10px 20px; background: blue; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: darkblue; }
    </style>
</head>
<body>

    <h2>Generate PDF dari Input User</h2>

    <form action="{{ route('generate.pdf') }}" method="POST">
        @csrf
        <label>Machine ID</label>
        <input type="text" name="id_mesin" required>

        <label>IP address </label>
        <input type="text" name="ip_address" required>

        <label>Location </label>
        <input type="text" name="lokasi" required>

        <button type="submit">Submit</button>
    </form>

</body>
</html>



