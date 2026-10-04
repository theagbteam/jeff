
<form method="post" action="index.php?action=submit">
    <label>State:</label>
    <select id="state" name="state_id" required>
        <option value="">-- Select State --</option>
        <?php foreach ($states as $s): ?>
            <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
        <?php endforeach; ?>
    </select>

    <label>LGA:</label>
    <select id="lga" name="lga_id" required>
        <option value="">-- Select State First --</option>
    </select>

    <button type="submit">Submit</button>
</form>


<script>
document.getElementById('state').addEventListener('change', function () {
    const stateId = this.value;
    const lgaSelect = document.getElementById('lga');
    lgaSelect.innerHTML = '<option value="">Loading...</option>';

    if (!stateId) {
        lgaSelect.innerHTML = '<option value="">-- Select State First --</option>';
        return;
    }

    fetch('index.php?action=lgas&state_id=' + encodeURIComponent(stateId))
        .then(res => res.json())
        .then(data => {
            lgaSelect.innerHTML = '<option value="">-- Select LGA --</option>';
            data.forEach(lga => {
                const opt = document.createElement('option');
                opt.value = lga.id;
                opt.textContent = lga.name;
                lgaSelect.appendChild(opt);
            });
        })
        .catch(() => {
            lgaSelect.innerHTML = '<option value="">Error loading LGAs</option>';
        });
});
</script>