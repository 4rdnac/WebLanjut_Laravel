<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title> <!-- Judul halaman -->
</head>
<body>
    <h1>Add Item</h1> <!-- Judul utama halaman -->

    <!-- Form untuk menambahkan item baru -->
    <form action="{{ route('items.store') }}" method="POST">
        @csrf <!-- Token CSRF untuk keamanan dari serangan CSRF -->
        
        <label for="name">Name:</label>
        <input type="text" name="name" required> <!-- Input untuk nama item -->
        <br>

        <label for="description">Description:</label>
        <textarea name="description" required></textarea> <!-- Input textarea untuk deskripsi item -->
        <br>

        <button type="submit">Add Item</button> <!-- Tombol submit untuk menambahkan item -->
    </form>

    <!-- Link kembali ke daftar item -->
    <a href="{{ route('items.index') }}">Back to List</a>
</body>
</html>
