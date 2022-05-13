<?php
class Emailclass{

    public $id;
    public $email;

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }


    /**
     * setManually
     * function for manually inserting a email into the database
     * @param  mixed $email
     * @return string
     */
    public function setManually($email, $fk_emailgroep_id)
    {
        $this->setEmail($email);

        //filter incoming variable if it's a valid email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL)){

            //create wordpress database connection 
            global $wpdb;
            //check if email already exists
            $emailexistanceCheck = $wpdb->get_var("SELECT COUNT(*) FROM wp_ps_email WHERE email = '$this->email' AND fk_emailgroep_id = $fk_emailgroep_id");

            //if email doesn't exists continue, else return message 
            if ($emailexistanceCheck < 1) {
                
                //insert into database table
                $wpdb->insert('wp_ps_email',array('email' => $this->email, 'fk_emailgroep_id' => $fk_emailgroep_id),array('%s'));
                //return succes message
                return "E-mail succesvul toegevoegd";
            }else{
                return "E-mail bestaat al";
            }   

        }else{
            return 'Email niet geldig';
        }
    }

    /**
     * getEmails
     * Get all the emails stored in the database
     * @return Mixed
     */
    public function getAllEmails($fk_emailgroep_id)
    {
        global $wpdb;
        $emails = $wpdb->get_results( "SELECT * FROM wp_ps_email WHERE fk_emailgroep_id = $fk_emailgroep_id");
        return $emails;
    }

    public function updateEmail($id, $email)
    {
        //set id
        $this->setId($id);

        //set naae
        $this->setEmail($email);

        //get databse
        global $wpdb;

        $wpdb->update('wp_ps_email', array('email' => $this->$email), array('id' => $this->id));
    }

    public function DeleteEmail($id)
    {
        //set id
        $this->setId($id);

        //get database
        global $wpdb;

        //delete the email where the id matches the id that is given in the params
        $wpdb->query("DELETE FROM wp_ps_email WHERE id = $this->id");
    }

    //Function to import a CSV file
    public function importCSV($file, $fk_emailgroep_id)
    {
        //Open the file so it can read what's in it
        if (($handle = fopen($file['tmp_name'], "r")) !== false) {
            //Gets line from file pointer and parse for CSV fields
            while (($data = fgetcsv($handle, 0, ";")) !== false) {
                $email = $data[0];
                //Call $wpdb
                //database connectie word hier gemaakt
                global $wpdb;
                //hier word gechecked of de email al bestaat, als dit het geval is word deze lijn overgeslagen.
                $emailexistanceCheck = $wpdb->get_var("SELECT COUNT(*) FROM wp_ps_emailgroep WHERE email = '$email'");
                if ($emailexistanceCheck > 0) {
                    continue;
                }
                //Insert query
                //hieronder worden de gegevens ingevoegd in de database
                try{
                $wpdb->insert('wp_ps_email',array('email' => $email, 'fk_emailgroep_id' => $fk_emailgroep_id));
            }
            catch (Exception $e) {
               echo $e->getMessage; 
            }
            }
        } else {
            $success = false;
        }
    }
}


?>