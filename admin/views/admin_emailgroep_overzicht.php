<?php
// Add styling and bootstrap.
include_once PLEEGOUDERSUPPORT_PLUGIN_STYLE_DIR . '/bootstrap.php';
require_once 'emailgroep-class.php';

// Putting the post values in a variable
$input_array = $_POST;
$emailgroep = new Emailgroep();
?>

<div class="col-lg-12 col-md-12 col-sm=12">
    <h3>Emailgroep Overzicht</h3>
    <br>
<?php
    

    if (isset($_POST['update_emailgroep'])) {
        $editId = $_POST['id'];
        $emailgroepen = $emailgroep->getAllEmailgroepen();
        foreach ($emailgroepen as $value) { ?>
            <tr>
                <form action="" method="POST">
                    <td>
                        <input type="text" name="naam" placeholder="Naam" value="<?= $value->naam ?>"> &nbsp;
                    </td>
                    <!-- Update Button -->
                    <td>
                        <input type="text" name="id" value="<?= $_POST['id'] ?>" hidden>
                        <input name="update_emailgroep_naam" value="update" class="btn_custom_upd" type="submit">
                    </td>
                </form>
            </tr>
            <?php
        }
    } else{
            ?>
    <h5>Emailgroep Toevoegen</h5>
    <p>Maak een Emailgroep aan</p>
    <form method="post" class="space2">
            <input type="text" name="emailgroep">
            <input type="submit" name="submit-naam">
            <?php 
                //if filled in naam is submitted check if it is not empty, else return error message
                if (isset($input_array['submit-naam']) && !empty($input_array['emailgroep'])) {

                    //use a filter so no dangerous code can be inserted into the database
                    $naam = htmlspecialchars($input_array['emailgroep']);

                        $temp = $emailgroep->createEmailgroep($naam);
                        echo "<br><br>  <div class='alert alert-success alert-dismissible fade show' role='success' style='width:25%'>$temp!
                                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>";
                }
            ?>
    </form>

    <br>

    <h5>Emailgroepen Overzicht</h5>
    <p>Dit zijn op het moment alle aangemaakte email groepen</p>

    <table class="table table-hover table-striped" style="margin-top:20px;" id="myTable">
        <thead class="thead-dark">
            <tr>
              <th>Emailgroep Naam</th>  
              <th colspan="2">Acties</th>
            </tr>
        </thead>
        <tbody>
                <?php 
                
                $emailgroepen = $emailgroep->getAllEmailgroepen();

                foreach($emailgroepen as $value) {
                ?>
            <tr>
                <td>
                    <?= $value->naam ?>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="text" name="id" value="<?= $value->id ?>" hidden>
                        <input type="submit" name="update_emailgroep" class="btn_custom_upd" value="Update">
                    </form>
                </td>
                <td>
                    <?php

                        if (isset($_POST['delete'])) {
                            $id = $_POST['id'];
                            $emailgroep->deleteEmailgroep($id);
                            echo '<meta http-equiv="Refresh" content="0;">';
                        }
                        $idToDelete = $value->id;
                        
                    ?>
                    <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                        <a onclick="return confirm('Weet u zeker dat u dit agendpunt wilt verwijderen?');">
                        <input name="id" type="number" value="<?= $idToDelete ?>" hidden>
                        <input name="delete" type="submit" class="btn_custom_del" value="Delete">
                        </a>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
        if(isset($_POST['update_emailgroep_naam'])){

            $naam = htmlspecialchars(filter_var($_POST["naam"], FILTER_SANITIZE_STRING));
            $updatingID = $_POST['id'];
            $emailgroep->updateEmailgroepNaam($updatingID, $naam);
            echo '<meta http-equiv="Refresh" content="0;">';
            
        }
    }
    ?>

</div>