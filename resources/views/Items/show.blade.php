<!DOCTYPE html>
<html>
<head>
    <title>Item List</title> <!-- Judul halaman -->
</head>
<body>
    <h1>Items</h1> <!-- Judul utama halaman -->

    <!-- Menampilkan pesan sukses jika ada -->
    @if(session('success'))
        <p>{{ session('success') }}</p> <!-- Menampilkan pesan sukses dari session -->
    @endif

    <!-- Tombol untuk menambah item baru -->
    <a href="{{ route('items.create') }}">Add Item</a>

    <ul>
        <!-- Melakukan iterasi melalui daftar item -->
        @foreach ($items as $item)
            <li>
                {{ $item->name }} -  <!-- Menampilkan nama item -->

                <!-- Link untuk mengedit item -->
                <a href="{{ route('items.edit', $item) }}">Edit</a>

                <!-- Form untuk menghapus item -->
                <form action="{{ route('items.destroy', $item) }}" method="POST" style="display:inline;">
                    @csrf <!-- Token CSRF untuk keamanan -->
                    @method('DELETE') <!-- Metode DELETE untuk menghapus item -->
                    <button type="submit">Delete</button> <!-- Tombol untuk menghapus item -->
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
