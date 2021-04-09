<!-- Distribution model -->

<?php
class Ticket {

    public $id_ticket;
    public $title;
    public $date;
    public $data;

    public function __construct($id_ticket = false,  $title = false, $date = false, $data = false) {
        if ($id_ticket === false) return;

        $this->id_ticket = $id_ticket;
        $this->title = $title;
        $this->date = $date;
        $this->data = $data;
    } //end construct

    public function submitTicket($id_ticket, $title, $data)
    {
        try {
            $con = DBConnect::getInstance();
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_ticket = htmlspecialchars($id_ticket);

            $title = htmlspecialchars($title);

            $data = htmlspecialchars($data);

            $query = $con->prepare("INSERT INTO information (id_ticket, title, date, data)
      VALUES (:id_ticket, :title, NOW(), :data)");

            $result = $query->execute(array('id_ticket' => $id_ticket, 'title' => $title, 'data' => $data));

            return $result;
        }
        catch(PDOException $e)
        {
            echo "<br>" . $e->getMessage();
            return false;
        }
    }

    public function deleteTicket($id_ticket)
    {
        try {
            $con = DBConnect::getInstance();
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $id_ticket = htmlspecialchars($id_ticket);

            $query = $con->prepare("DELETE FROM information WHERE id_ticket = :id_ticket");

            $result = $query->execute(array('id_ticket' => $id_ticket));

            return $result;
        }
        catch(PDOException $e)
        {
            echo "<br>" . $e->getMessage();
            return false;
        }
    }

    public function getTicket() {
        try {
            $con = DBConnect::getInstance();
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM information ORDER BY date desc";
            $reponse = $con->query($sql);

            foreach ($reponse as $soumis) {
                $list[] = new Ticket($soumis['id_ticket'], $soumis['title'], $soumis['date'], $soumis['data']);
            }

            if (isset($list)) {
                return $list;
            }

            return NULL;


        } catch (PDOException $e) {
            echo $sql . "</br>" . $e->getMessage();
        }
    }
}
