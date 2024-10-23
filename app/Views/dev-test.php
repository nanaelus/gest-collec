<div id="toggle" style="cursor: pointer;">
    <i class="fa-toggle-on text-success fa-solid fa-xl" id="icon"></i>
</div>

<script>
document.getElementById('toggle').addEventListener('click', function() {
const icon = document.getElementById('icon');

if (icon.classList.contains('fa-toggle-on')) {
// Changer en "off"
icon.classList.remove('fa-toggle-on', 'text-success');
icon.classList.add('fa-toggle-off', 'text-danger');
} else {
// Changer en "on"
icon.classList.remove('fa-toggle-off', 'text-danger');
icon.classList.add('fa-toggle-on', 'text-success');
}
});
</script>
