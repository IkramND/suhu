.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 220px;
    height: 100vh; /* Tinggi penuh */
    background-color: #252d37;
    color: white;
    padding: 16px;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease-in-out;

    /* Tambahkan scrolling */
    overflow-y: auto;
    scrollbar-width: thin; /* Agar scrollbar lebih kecil */
    scrollbar-color: #888 #252d37; /* Warna scrollbar */
}

/* Tambahkan tampilan scrollbar khusus untuk browser berbasis WebKit (Chrome, Edge, Safari) */
.sidebar::-webkit-scrollbar {
    width: 8px; /* Lebar scrollbar */
}

.sidebar::-webkit-scrollbar-thumb {
    background-color: #888; /* Warna bagian scroll */
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background-color: #555; /* Warna scroll saat hover */
}

.sidebar::-webkit-scrollbar-track {
    background: #252d37; /* Warna latar belakang scrollbar */
}
