<footer class="footer mt-auto py-3">
  <div class="container">
  <a href="ketetapan.php" class="btn btn-sm btn-outline-dark">Ketetapan</a>
   &copy; Hak Cipta Terpelihara.
  </div>
</footer>

</div>

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">

// Skrip untuk tambah pilihan jawapan undian
function tambah_jawapan() {
    var original = document.getElementById("input-jawapan");
    var clone = original.cloneNode(true);  
    var inputs = clone.getElementsByTagName('input'); 
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].value = ''; 
    }
    original.parentNode.insertBefore(clone, original.nextSibling);
}

// Skrip untuk paparkan popup pengesahan Buang 
function deletethis(val) {
if (confirm("Anda pasti untuk buang?") == true) {
    let currentUrl = window.location.href;
    // semak jika url dah ada parameter
    if (currentUrl.indexOf('?') === -1) {
        // jika belum ada, kita guna ?
        window.location.replace(currentUrl + '?delete=' + val);
    } else {
        // jika dah ada, kita guna &
        window.location.replace(currentUrl + '&delete=' + val);
    }
  }
}

// Skrip untuk paparan Tooltip lebih cantik
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
});
</script>
<?php 
// Skrip untuk munculkan efek Cursor
if(!empty($cursor)){
  echo "<script src='js/cursor_multis.js'></script><script>new cursoreffects.".$cursor."Cursor({ element: document.body })</script>";
}
?>

<script type="text/javascript">
  
$("#imej").change(function() {
    if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imej_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    }
});

const path = window.location.pathname;
const filename = path.substring(path.lastIndexOf('/') + 1);
const anchor = document.querySelector('a[href="'+filename+'"]');
if (anchor) { anchor.classList.add('activepage'); }
</script>

</body>
</html>