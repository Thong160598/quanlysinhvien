<?php
class StudentRepository
{
    // trả về danh sách student (dạng đối tượng)
    protected function fetch($cond = null)
    {
        global $conn; // global để bên trong hàm dùng được biến bên ngoài hàm (mặc định là không được)
        $sql = "SELECT * FROM student";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM student WHERE name LIKE '%ty%'
        }
        $result = $conn->query($sql);
        $students = []; //[] bên phải dấu bằng là tạo một arry rổng
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $birthday = $row['birthday'];
                $gender = $row['gender'];
                $student = new Student($id, $name, $birthday, $gender);
                $students[] = $student; // [] bên trái dấu bằng là thêm một phần tử cuối danh sách

            }
        }
        return $students;
    }
    // lấy tất cả sinh viên trong data
    public function getAll()
    {
        $students = $this->fetch();
        return $students;
    }
    public function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'";
        $students = $this->fetch($cond);
        return $students;
    }
    //lưu sinh viên mới vào data
    public function save($data)
    {
        global $conn;
        $name = $data['name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];

        $sql = "INSERT INTO student (name, birthday, gender) VALUES ('$name', '$birthday', '$gender')";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    public function find($id)
    {
        $cond = "id=$id";
        $students = $this->fetch($cond);
        // current lấy 1 phần tử đầu tiên trong danh sách
        $student = current($students);
        return $student;
    }
    public function update($student)
    {
        global $conn;
        $name = $student->name;
        $birthday = $student->birthday;
        $gender = $student->gender;
        $id = $student->id;
        $sql = "UPDATE student SET name='$name', birthday='$birthday', gender='$gender' WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;

    }
    public function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM student WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;

    }
}
