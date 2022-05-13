<?php
// Add styling and bootstrap.
include_once PLEEGOUDERSUPPORT_PLUGIN_STYLE_DIR . '/bootstrap.php';
require_once 'nieuwsbrief-class.php';
require_once 'email-class.php';
require_once 'emailgroep-class.php';
// Putting the post values in a variable
$input_array = $_POST;
$nieuwsbrief = new Nieuwsbrief();
$emailclass = new Emailclass();
$emailgroep = new Emailgroep();
?>

<!-- Content -->
<div class="col-lg-12 col-md-12 col-sm=12">
    <h3>Nieuwsbrief</h3>

    <br>
    <h5>Excel Upload</h5>
    <p>Kies een CSV bestand met e-mails om deze toe te voegen aan de verzendlijst voor de nieuwsbrief</p>
    <!-- <form class="js-upload" method="POST" action="http://localhost/POZ/wp-admin/admin.php?page=admin_nieuwsbrief"> -->
    <form method="post" enctype="multipart/form-data" class="space2">
    <select name="emailgroepen" id="emailgroepen">
                <option value='NULL'>Kies een Emailgroep</option>
            <?php
                $emailgroepen = $emailgroep->getAllEmailgroepen();
                foreach($emailgroepen as $value){
                    echo "<option value='$value->id'>$value->naam</option>";
                }
            ?>
    </select>
        <input type="file" name="csv_import" accept=".csv">
        <input class="btn_custom" type="submit" name="submit-file">
    </form>

<?php
if (isset($input_array['submit-file']) && !empty($_FILES['csv_import']['name'])) {
    $fk_emailgroep_id = $input_array['emailgroepen'];
    if ($fk_emailgroep_id === 'NULL'){
        echo "<br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>Kies een Emailgroep!
                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>";
    
    }else{
    // Refers to uploaded file name
    $fileName = $_FILES['csv_import']['name'];
    // Refers to extention of file
    $fileExtension = strtolower(end(explode('.', $fileName)));
    // Get the only useable file type
    $fileType = ['csv']; 

    if (!in_array($fileExtension, $fileType)) {
        echo ("Kies een CSV bestand");
    } else {

        //Execute the import
        $result = $emailclass->importCSV($_FILES['csv_import'], $fk_emailgroep_id);
        if (isset($result[0])) {
            echo "<br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>Bestand is leeg!
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
        } else {
            echo "<br><div class='alert alert-success alert-dismissible fade show' role='success' style='width:25%'>Bestand succesvol geimporteerd!
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
        }
    }
}
}


?>
<br>
    <h5>Handmatig Toevoegen</h5>
    <p>Vul een email in om handmatig in de lijst te zetten</p>
    <form method="post" class="space2">
            <select name="emailgroepen-manuel" id="emailgroepen-manuel">
                <option value='NULL'>Kies een Emailgroep</option>
            <?php
                $emailgroepen = $emailgroep->getAllEmailgroepen();
                foreach($emailgroepen as $value){
                    echo "<option value='$value->id'>$value->naam</option>";
                }
            ?>
            </select>
            <input type="text" name="email">
            <input class="btn_custom" type="submit" name="submit-manuel">
            <?php 
                //if filled in email is submitted check if it is not empty, else return error message
                if (isset($input_array['submit-manuel']) && !empty($input_array['email'])) {

                    $fk_emailgroep_id = $input_array['emailgroepen-manuel'];

                    //check if user has chosen a emailgroep 
                    if($fk_emailgroep_id === 'NULL'){
                        echo "<br><br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>Kies een Emailgroep!
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
                    }else{

                        $email = htmlspecialchars($input_array['email']);
                        //if email is valid execute the function, else return error message
                        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                        
                            $temp = $emailclass->setManually($email, $fk_emailgroep_id);
                            if($temp == "E-mail succesvul toegevoegd"){
                            echo "<br><br><div class='alert alert-success alert-dismissible fade show' role='success' style='width:25%'>$temp
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
                            }else{
                            echo "<br><br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>$temp
                                                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                                    <span aria-hidden='true'>&times;</span>
                                                </button>
                                            </div>";   
                            }
                        }else{
                            echo "<br><br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>Vul een geldige Email in!
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
                        }
                    }
                }
            ?>
    </form>

    <br>
    <h5>Nieuwsbrief sturen</h5>
    <p>Selecteer een word bestand om de email te verzenden</p>
    <form method="post" class="space2" enctype="multipart/form-data">

        <select name="emailgroepen-email" id="emailgroepen-email">
                    <option value='NULL'>Kies een Emailgroep</option>
                <?php
                    $emailgroepen = $emailgroep->getAllEmailgroepen();
                    foreach($emailgroepen as $value){
                        echo "<option value='$value->id'>$value->naam</option>";
                    }
                ?>
        </select>

        <input type="file" name="word-upload" id="fileToUpload" accept=".doc,.docx">
            <input class="btn_custom" type="submit" name="submit-test">
            <?php 
                
                if (isset($input_array['submit-test']) && !empty($_FILES['word-upload']['name'])) {

                    $fk_emailgroep_id = $input_array['emailgroepen-email'];

                    //check if user has chosen a emailgroep 
                    if($fk_emailgroep_id === 'NULL'){
                        echo "<br><br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>Kies een Emailgroep!
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
                    }else{

                    $emailslist = $emailclass->getAllEmails($fk_emailgroep_id);

                    $emails = array_column($emailslist, 'email');
                    
                    //print_r($emails);   


                    // Refers to uploaded file name
                    $fileName = $_FILES['word-upload']['name'];
                    // Refers to temp name
                    $tmp_name = $_FILES['word-upload']['tmp_name'];

                    $file_type = $_FILES['word-upload']['type'];
                    // Refers to extention of file
                    $fileExtension = strtolower(end(explode('.', $fileName)));
                    // Get the only useable file type
                    $fileType = ['docx'];

                    if (!in_array($fileExtension, $fileType)) {
                        echo ("Kies een CSV bestand");
                    } else {

                        $error = $_FILES['word-upload']['error'];

                        $overrides = array( 'test_form' => false);
                        wp_handle_upload($_FILES['word-upload'], $overrides);
                        $newFilename = sanitize_file_name($fileName);
                        
                        $to = $emails;
                        $subject = "test";
                        $message = "dit is een test";
                        $attachment = array( WP_CONTENT_DIR . '/uploads/' . $newFilename );

                        //$test = WP_CONTENT_DIR . '/uploads/' . $fileName . '.' . $fileExtension;
                        //echo $test;
                        
                        $mail = wp_mail( $to, $subject, $message, "test4", $attachment);
                        
                        unlink(WP_CONTENT_DIR . '/uploads/' . $newFilename);

                        if($mail == false){
                            echo "<br><div class='alert alert-danger alert-dismissible fade show' role='danger' style='width:25%'>Er is iets fout gegaan, Email is niet verzonden!
                                    <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>";
                        }else{
                            echo "<br><div class='alert alert-success alert-dismissible fade show' role='success' style='width:25%'>Email succesvol verzonden!
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                            </button>
                        </div>";
                        }
                }  
                }
            }
            ?>
    </form>

    <hr>
</div>
