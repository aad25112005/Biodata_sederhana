const hobiForm = document.getElementById('hobiForm');
const hasilHobi = document.getElementById('hasilHobi');

hobiForm.addEventListener('change', function () {
  const selectedHobbies = Array.from(hobiForm.querySelectorAll('input[type="checkbox"]:checked'))
    .map(checkbox => checkbox.value);

  if (selectedHobbies.length > 0) {
    hasilHobi.textContent = 'Hobi yang dipilih: ' + selectedHobbies.join(', ');
  } else {
    hasilHobi.textContent = 'Tidak ada hobi yang dipilih.';
  }
});
