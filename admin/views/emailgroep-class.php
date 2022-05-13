<?php
class Emailgroep{

    public $id;
    public $naam;

    public function setNaam($naam)
    {
        $this->naam = $naam;
    }

    public function getNaam()
    {
        return $this->naam;
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
     * createEmailgroep
     *
     * @param  mixed $naam
     * @return string
     */
    public function createEmailgroep($naam)
    {
        $this->setNaam($naam);

        //create wordpress database connection 
        global $wpdb;
        //check if naam already exists
        $naamexistanceCheck = $wpdb->get_var("SELECT COUNT(*) FROM wp_ps_emailgroep WHERE naam = '$this->naam'");

        //if naam doesn't exists continue, else return message 
        if ($naamexistanceCheck < 1) {
            
            //insert into database table
            $wpdb->insert('wp_ps_emailgroep',array('naam' => $this->naam),array('%s'));
            //return succes message
            return "Emailgroep succesvul toegevoegd";
        }else{
            return "Emailgroep bestaat al";
        }   
    }

    public function getAllEmailgroepen()
    {
        //get database
        global $wpdb;

        //get all emailgroepen
        $emailgroepen = $wpdb->get_results( "SELECT * FROM wp_ps_emailgroep");

        //return the emailgroepen
        return $emailgroepen;
    }
    
    /**
     * deleteEmailgroep
     * delete a emailgroep
     * @param  mixed $id
     * @return void
     */
    public function deleteEmailgroep($id)
    {
        //set id
        $this->setId($id);

        //get database
        global $wpdb;

        //delete the emailgroep where the id matches the id that is given in the params
        $wpdb->query("DELETE FROM wp_ps_emailgroep WHERE id = $this->id");
        
    }

    public function updateEmailgroepNaam($id, $naam)
    {
        //set id
        $this->setId($id);

        //set naae
        $this->setNaam($naam);

        //get databse
        global $wpdb;

        $wpdb->update('wp_ps_emailgroep', array('naam' => $this->naam), array('id' => $this->id));
    }

}
?>