
class Salt {
    public $id_salt;
    public $salt;
    public $id_team;

    public __construct($id_salt=false, $salt=false, $id_team=false) {
    /**
      * Constructeur du sel associé à une team.
      * @param id_salt : identifiant du sel
      * @param salt : la valeur du sel
      * @param id_team : l'identifiant de la team associée au sel
      */

        if ($id_salt && $salt && $id_team) {
            $this->id_salt = $id_salt;
            $this->salt = $salt;
            $this->id_team = $id_team;
        }
    }

    public function generateSalt() {
        /**
         * Permet de générer un sel associé à une team et de l'enregistrer dans la base de données.
         */

        
    }



}