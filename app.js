document.getElementById('absenForm').addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('absensi.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('response').textContent = data
        document.getElementById('rfid').value = ''
    })
    .catch(error => console.error('Error:', error))
})