// document.addEventListener('DOMContentLoaded', () => {

//     const formPencarian = document.getElementById('form-pencarian');
//     const inputKeyword = document.getElementById('input-keyword');
//     const hasilPencarian = document.getElementById('hasil-pencarian');
//     const loading = document.getElementById('loading');

//     formPencarian.addEventListener('submit', function(event) {
//         // Mencegah form dari reload halaman
//         event.preventDefault(); 
        
//         const keyword = inputKeyword.value.trim();

//         if (keyword === '') {
//             alert('Silakan masukkan kata kunci pencarian.');
//             return;
//         }

//         // Tampilkan loading, bersihkan hasil sebelumnya
//         loading.style.display = 'block';
//         hasilPencarian.innerHTML = '';

//         // Panggil API backend menggunakan Fetch
//         fetch(`api/search.php?keyword=${encodeURIComponent(keyword)}`)
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('Network response was not ok');
//                 }
//                 return response.json();
//             })
//             .then(data => {
//                 loading.style.display = 'none'; // Sembunyikan loading

//                 if (data.error) {
//                     hasilPencarian.innerHTML = `<p>Error: ${data.error}</p>`;
//                     return;
//                 }

//                 if (data.length === 0) {
//                     hasilPencarian.innerHTML = '<p>Tidak ada artikel yang ditemukan.</p>';
//                 } else {
//                     tampilkanHasil(data);
//                 }
//             })
//             .catch(error => {
//                 loading.style.display = 'none';
//                 hasilPencarian.innerHTML = '<p>Terjadi kesalahan saat mengambil data. Coba lagi nanti.</p>';
//                 console.error('Fetch error:', error);
//             });
//     });

//     function tampilkanHasil(data) {
//         data.forEach(artikel => {
//             const artikelDiv = document.createElement('div');
//             artikelDiv.className = 'artikel';

//             // Ambil penulis, prioritaskan creator1
//             const penulis = artikel.creator1 || artikel.creator2 || artikel.creator3 || 'Penulis tidak diketahui';
            
//             // Potong deskripsi jika terlalu panjang
//             const deskripsiSingkat = artikel.description ? (artikel.description.substring(0, 250) + '...') : 'Deskripsi tidak tersedia.';

//             artikelDiv.innerHTML = `
//                 <h3>${artikel.title || 'Judul tidak tersedia'}</h3>
//                 <p class="penulis">Oleh: ${penulis}</p>
//                 <p class="deskripsi">${deskripsiSingkat}</p>
//                 <p class="sumber">Sumber: ${artikel.source1 || 'Tidak diketahui'}</p>
//             `;

//             hasilPencarian.appendChild(artikelDiv);
//         });
//     }
// });