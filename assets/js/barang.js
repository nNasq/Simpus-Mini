const keysBarang = ["nama", "sku", "kategori", "harga", "stok"];
function muatDaftarBarang() {
    muatDataGenerik("../data/barang.json", keysBarang);
}
document.addEventListener("DOMContentLoaded", () => {
    muatDaftarBarang();
    const btnMuatUlang = document.getElementById("btn-muat-ulang");
    if (btnMuatUlang) {
        btnMuatUlang.addEventListener("click", muatDaftarBarang);
    }
});