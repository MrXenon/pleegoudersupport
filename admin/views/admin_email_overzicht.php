<?php
// Add styling and bootstrap.
include_once PLEEGOUDERSUPPORT_PLUGIN_STYLE_DIR . '/bootstrap.php';
require_once 'emailgroep-class.php';
require_once 'email-class.php';

// Putting the post values in a variable
$input_array = $_POST;
$emailgroep = new Emailgroep();
$emailclass = new Emailclass();
?>

<div class="col-lg-12 col-md-12 col-sm=12">
    <h3>Email Overzicht</h3>
    <br>

    <form method="post" class="space2">
            <select name="emailgroepen" id="emailgroepen">
                        <option value='NULL'>Kies een Emailgroep</option>
                    <?php
                        $emailgroepen = $emailgroep->getAllEmailgroepen();
                        foreach($emailgroepen as $value){
                            echo "<option value='$value->id'>$value->naam</option>";
                            
                        }
                    ?>
            </select>

            <input type="submit" name="submit-emailgroep">
            
        </form>
<?php
    if (isset($input_array['submit-emailgroep'])){

        $fk_emailgroep_id = $input_array['emailgroepen'];

            ?>
        

    <table class="table table-hover table-striped" style="margin-top:20px;" id="myTable">
        <thead class="thead-dark">
            <tr>
              <th>Email</th>  
              <th colspan="2">Acties</th>
            </tr>
        </thead>
        <tbody>
                <?php 
                
                
                $emails = $emailclass->getAllEmails($fk_emailgroep_id);

                foreach($emails as $value) {
                ?>
            <tr>
                <td>
                    <?= $value->email ?>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="text" name="id" value="<?= $value->id ?>" hidden>
                        <input type="submit" name="update_email" class="btn_custom_upd" value="Update">
                    </form>
                </td>
                <td>
                    <?php
                        if (isset($_POST['delete'])) {
                            $id = $_POST['id'];
                            $emailclass->DeleteEmail($id);
                            
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
            
    
}else{
    ?>
    
    <br><p>Kies een Emailgroep waarvan je de emails wilt bekijken</p>
    <b><p>Let op! De actie knoppen werken nog niet.</p></b>

    <?php
}
    ?>

</div>