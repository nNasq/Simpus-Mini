document.addEventListener("DOMContentLoaded", function () {
    initHapusConfirm();
    initValidasiForm();
});

// ===== Konfirmasi hapus =====
// Tombol Hapus berada di dalam <form class="form-hapus" method="post">
// yang mengirim request ke server (barang/hapus.php, supplier/hapus.php).
// Konfirmasi dilakukan pada event "submit" agar bisa dibatalkan
// (preventDefault) sebelum request terkirim.
function initHapusConfirm() {
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (!form.classList.contains("form-hapus")) return;

        const row = form.closest("tr");
        const nama = row ? row.querySelector("td")?.textContent.trim() : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
        if (!yakin) {
            e.preventDefault();
        }
    });
}

// ===== Validasi form (client-side, memakai style Bootstrap) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    input.classList.add("is-invalid");
    const div = document.createElement("div");
    div.className = "error invalid-feedback";
    div.textContent = pesan;
    input.insertAdjacentElement("afterend", div);
}

function hapusError(input) {
    input.classList.remove("is-invalid");
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        const nama = form.querySelector("[name='nama']");
        if (nama && nama.value.trim() === "") {
            tampilkanError(nama, "Field ini wajib diisi.");
            valid = false;
        } else if (nama) {
            hapusError(nama);
        }

        const harga = form.querySelector("[name='harga']");
        if (harga) {
            const nilai = parseInt(harga.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(harga, "Harga tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(harga);
            }
        }

        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        const kodeSupplier = form.querySelector("[name='kode_supplier']");
        if (kodeSupplier && kodeSupplier.value.trim() === "") {
            tampilkanError(kodeSupplier, "Kode supplier wajib diisi.");
            valid = false;
        } else if (kodeSupplier) {
            hapusError(kodeSupplier);
        }

        const sku = form.querySelector("[name='sku']");
        if (sku && sku.value.trim() !== "") {
            const regexSku = /^[A-Za-z0-9\-]+$/;
            if (!regexSku.test(sku.value.trim())) {
                tampilkanError(sku, "Format tidak valid. SKU hanya boleh berisi huruf, angka, dan tanda hubung (-).");
                valid = false;
            } else {
                hapusError(sku);
            }
        }

        if (!valid) {
            e.preventDefault();
        }
    });
}