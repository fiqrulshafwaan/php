<select name="tahun" id="tahun">
    <?php
    $tahun = date("Y");
    $th = $tahun - 30;

    while ($th < $tahun) {
        $th++;
        echo "<option value=$th>$th</option>";
    }
    ?>
</select>