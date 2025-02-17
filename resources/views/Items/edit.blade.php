<!DOCTYPE html>
<html>
<head>
    <title>Edit Item</title> <!-- Judul halaman -->
</head>
<body>
    <h1>Edit Item</h1> <!-- Judul utama halaman -->

    <!-- Form untuk mengupdate item -->
    <form action="{{ route('items.update', $item) }}" method="POST">
        @csrf <!-- Token CSRF untuk keamanan -->
        @method('PUT') <!-- Menggunakan metode PUT untuk memperbarui item -->

        <label for="name">Name:</label>
        <input type="text" name="name" value="{{ $item->name }}" required> <!-- Input nama dengan nilai awal dari item -->
        <br>

        <label for="description">Description:</label>
        <textarea name="description" required>{{ $item->description }}</textarea> <!-- Textarea dengan nilai awal dari item -->
        <br>

        <button type="submit">Update Item</button> <!-- Tombol submit untuk menyimpan perubahan -->
    </form>

    <!-- Link kembali ke daftar item -->
    <a href="{{ route('items.index') }}">Back to List</a>
</body>
</html>
