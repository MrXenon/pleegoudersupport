<?php
// Add styling and bootstrap.
include_once PLEEGOUDERSUPPORT_PLUGIN_STYLE_DIR . '/bootstrap.php';
global $wpdb;
//Verwijderen
if (isset($_POST['delete'])) {
    $ID = $_POST['id'];
    $wpdb->query("DELETE FROM wp_ps_agenda WHERE id = $ID");
}
// Update
if (isset($_POST['update_agenda'])) {
    $titel = filter_var($_POST["titel"], FILTER_SANITIZE_STRING);
    $datum = filter_var($_POST["datum"], FILTER_SANITIZE_STRING);
    $tijd = filter_var($_POST["tijd"], FILTER_SANITIZE_STRING);
    $omschrijving = filter_var($_POST["omschrijving"], FILTER_SANITIZE_STRING);
    $categorie = filter_var($_POST["categorie"], FILTER_SANITIZE_STRING);
    $updatingID = $_POST['id'];
    $wpdb->update('wp_ps_agenda', array('titel' => $titel, 'datum' => $datum, 'tijd' => $tijd, 'omschrijving' => $omschrijving, 'categorie' => $categorie), array('id' => $updatingID));
    // header("Refresh:0");
    echo '<meta http-equiv="Refresh" content="0;">';
}
?>

<!-- Overzicht lijst -->
<div class="col-lg-12 col-md-12 col-sm=12">
    <h3>Studenten overzicht</h3>
    <a style="float:right !important;">Zoeken: <input type="search" id="myInput" onkeyup="searchFunction()"></a><br>
    <div id="table-wrapper">
        <div id="table-scroll">
            <!-- begin tabel -->
            <table class="table table-hover table-striped" style="margin-top:20px;" id="myTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Titel</th>
                        <th>Datum</th>
                        <th>Tijd</th>
                        <th>Omschrijving</th>
                        <th>Categorie</th>
                        <th width="20" colspan="2">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Tabel Inhoud
                    global $wpdb;
                    $query = "SELECT * FROM wp_ps_agenda";

                    if (isset($_POST['update'])) {
                        $editId = $_POST['id'];
                        $result1 = $wpdb->get_results("SELECT * FROM wp_ps_agenda WHERE id = $editId");
                        foreach ($result1 as $print) { ?>
                            <tr>
                                <form action="" method="POST">
                                    <td>
                                        <input type="text" name="titel" placeholder="Titel" value="<?= $print->titel ?>"> &nbsp;
                                    </td>
                                    <td>
                                        <input type="date" name="datum" placeholder="Datum" value="<?= $print->datum ?>">
                                    </td>
                                    <td>
                                        <input type="time" name="tijd" placeholder="Tijd" value="<?= $print->tijd ?>">
                                    </td>
                                    <td>
                                        <textarea type="text " name="omschrijving" placeholder="Omschijving" value="<?= $print->omschrijving ?>"><?= $print->omschrijving ?></textarea>
                                    </td>
                                    <td>
                                        <select name="categorie" class="form-control" id="usr" required>
                                            <option value="<?= $print->categorie ?>">- <?= $print->categorie ?> -</option>
                                            <option value="Belangenbehartiging">Belangenbehartiging</option>
                                            <option value="Kennis verwerven">Kennis verwerven</option>
                                            <option value="KiP">KiP</option>
                                            <option value="Koffiecontacten">Koffiecontacten</option>
                                            <option value="Onderzoek">Onderzoek</option>
                                        </select>
                                    </td>
                                    <!-- Update Button -->
                                    <td>
                                        <input type="text" name="id" value="<?= $_POST['id'] ?>" hidden>
                                        <input name="update_agenda" value="update" class="btn_custom_upd" type="submit">
                                    </td>
                                </form>
                            </tr>
                            <?php
                        }
                    } else {
                        $result = $wpdb->get_results($query);
                        foreach ($result as $print) {
                            ?>
                                <tr>
                                    <td><?= $print->titel ?></td>
                                    <td><?= $print->datum ?></td>
                                    <td><?= $print->tijd ?></td>
                                    <td><?= $print->omschrijving ?></td>
                                    <td><?= $print->categorie ?></td>
                                    <!-- Update Button -->
                                    <td>
                                        <form action="" method="POST">
                                            <input type="text" name="id" value="<?= $print->id ?>" hidden>
                                            <input type="submit" name="update" class="btn_custom_upd" value="Update">
                                        </form>
                                    </td>
                                    <!-- Delete Button-->
                                    <td>
                                        <?php
                                        $idToDelete = $print->id;
                                        ?>
                                        <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                                            <a onclick="return confirm('Weet u zeker dat u dit agendpunt wilt verwijderen?');">
                                                <input name="id" type="number" value="<?= $idToDelete ?>" hidden>
                                                <input name="delete" type="submit" class="btn_custom_del" value="Delete">
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                    <?php
                            
                        }
                    }
                    ?>
                </tbody>
            </table>
            <!-- einde tabel -->
        </div>
    </div>
</div>