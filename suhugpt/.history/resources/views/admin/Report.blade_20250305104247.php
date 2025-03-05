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
        <label>Judul:</label>
        <input type="text" name="title" required>

        <label>Isi Konten:</label>
        <textarea name="content" rows="5" required></textarea>

        <button type="submit">Download PDF</button>
    </form>

</body>
</html>


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Output</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 20px; }
        h1 { color: #333; }
        p { font-size: 16px; }
        .footer { margin-top: 50px; font-size: 12px; color: gray; }
    </style>
</head>
<body>
    <h1>{{ $id_mesin }}</h1>
    <p>{{ $ip_address }}</p>
    <p>{{ $lokasi }}</p>

    <div class="footer">Generated on: {{ $date }}</div>
</body>
</html> --}}
