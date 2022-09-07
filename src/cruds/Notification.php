<!-- sql文 -->

class 

public function before_attendance_user() {
        $stmt = $this->db ->prepare("SELECT email FROM users");
        $stmt -> execute();
        return $stmt -> fetchAll();
    }