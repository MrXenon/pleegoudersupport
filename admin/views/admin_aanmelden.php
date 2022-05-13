<?php
// Add styling and bootstrap.
include_once PLEEGOUDERSUPPORT_PLUGIN_STYLE_DIR . '/bootstrap.php';
// Database tabbelen oproepen
global $wpdb;
?>
<h3>Agendapunt aanmaken</h3>
<?php
        // Voeg in de database toe
        if (!empty($_POST['add']) && isset($_POST['add'])) {
            global $wpdb;
            $titel = filter_var($_POST["titel"], FILTER_SANITIZE_STRING);
            $datum = filter_var($_POST["datum"], FILTER_SANITIZE_STRING);
            $tijd = filter_var($_POST["tijd"], FILTER_SANITIZE_STRING);
            $omschrijving = filter_var($_POST["omschrijving"], FILTER_SANITIZE_STRING);
            $categorie = filter_var($_POST["categorie"], FILTER_SANITIZE_STRING);
            
            $wpdb->insert('wp_ps_agenda', array('titel' => $titel, 'datum' => $datum, 'tijd' => $tijd, 'omschrijving' => $omschrijving, 'categorie' => $categorie));
            echo'<div class="alert alert-success alert-dismissible fade show" role="success" style="width:25%">Succesvol aangemaakt!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
        ?>

<!-- Aanmeld Formulier -->
<div class="col-md-12">
    <form action="" method="post">
        <div class="col-md-3 float-left">
            <div class="form-group">
                <label>Titel:</label>
                <input type="text" class="form-control" name="titel" required>
            </div>
            <div class="form-group">
                <label>Datum:</label>
                <input type="date" class="form-control" name="datum">
            </div>
            <div class="form-group">
                <label>Tijd:</label>
                <input type="time" class="form-control" name="tijd" required>
            </div>
            <div class="form-group">
                <label>Omschrijving:</label>
                <textarea type="text" class="form-control" name="omschrijving" required></textarea>
            </div>
            <div class="form-group">
                <label>Categorie:</label>
                <select name="categorie" class="form-control" id="usr" required>
                    <option value="Belangenbehartiging">Belangenbehartiging</option>
                    <option value="Kennis verwerven">Kennis verwerven</option>
                    <option value="KiP">KiP</option>
                    <option value="Koffiecontacten">Koffiecontacten</option>
                    <option value="Onderzoek">Onderzoek</option>
                </select>
            </div>
            <div>
                <input type="submit" class="btn_custom" name="add" value="Aanmaken" />
            </div>
        </div>
    </form>
</div>
</div>