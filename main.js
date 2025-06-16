document.querySelectorAll('btnDetail').forEach(item => {
    item.addEventListener('click', (e) => {
        let parent = e.target.parentNode.parentNode;
        let gambar = parent.querySelector('.circle-img').src;
        console.log(`gambar: ${gambar}`);
    });
});