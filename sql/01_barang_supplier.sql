CREATE TABLE barang (
    id SERIAL PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    sku VARCHAR(50),
    kategori VARCHAR(50),
    harga INTEGER NOT NULL DEFAULT 0,
    stok INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE supplier (
    id SERIAL PRIMARY KEY,
    kode_supplier VARCHAR(30) NOT NULL,
    nama VARCHAR(150) NOT NULL,
    alamat TEXT,
    no_hp VARCHAR(20)
);