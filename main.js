document.querySelectorAll('btnDetail').forEach(item => {
    item.addEventListener('click', (e) => {
        let parent = e.target.parentNode.parentNode;
        let gambar = parent.querySelector('.circle-img').src;
        let harga = parent.querySelector('.bottom-row').innerHTML;
        console.log(`harga: ${harga}`);
    });
});