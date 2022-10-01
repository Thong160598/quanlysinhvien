<?php
class RegisterRepository
{
    // trả về danh sách register (dạng đối tượng)
    protected function fetch($cond = null)
    {
        global $conn; // global để bên trong hàm dùng được biến bên ngoài hàm (mặc định là không được)
        $sql = "
        SELECT register.*, student.name AS student_name, subject.name AS subject_name FROM register
        JOIN student ON student.id=register.student_id
        JOIN subject ON subject.id=register.subject_id";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM register WHERE student_id LIKE '%ty%'
        }
        $result = $conn->query($sql);
        $registers = []; //[] bên phải dấu bằng là tạo một arry rổng
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $student_id = $row['student_id'];
                $subject_id = $row['subject_id'];
                $score = $row['score'];
                $student_name = $row['student_name'];
                $subject_name = $row['subject_name'];

                $register = new Register($id, $student_id, $subject_id, $score, $student_name,$subject_name);
                $registers[] = $register; // [] bên trái dấu bằng là thêm một phần tử cuối danh sách

            }
        }

        return $registers;
    }
    // lấy tất cả sinh viên trong data
    public function getAll()
    {
        $registers = $this->fetch();
        return $registers;
    }
    public function getByPattern($search)
    {
        $cond = "student.name LIKE '%$search%' OR subject.name LIKE '%$search%'";
        $registers = $this->fetch($cond);
        return $registers;
    }
    //lưu sinh viên mới vào data
    public function save($data)
    {
        global $conn;
        $student_id = $data['student_id'];
        $subject_id = $data['subject_id'];
      

        $sql = "INSERT INTO register (student_id, subject_id) VALUES ('$student_id', '$subject_id')";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    public function find($id)
    {
        $cond = "register.id=$id";
        $registers = $this->fetch($cond);
        // current lấy 1 phần tử đầu tiên trong danh sách
        $register = current($registers);
        return $register;
    }
    public function update($register)
    {
        global $conn;
        $score = $register->score;
        $id = $register->id;
        $sql = "UPDATE register SET score=$score WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;

    }
    public function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM register WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;

    }
    public function getByStudentId($id){
        $cond = "student_id = $id";
        $registers = $this->fetch($cond);
        return $registers;
    }
}
