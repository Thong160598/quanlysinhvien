<?php
class SubjectRepository
{
    // trả về danh sách subject (dạng đối tượng)
    protected function fetch($cond = null)
    {
        global $conn; // global để bên trong hàm dùng được biến bên ngoài hàm (mặc định là không được)
        $sql = "SELECT * FROM subject";
        if ($cond) {
            $sql .= " WHERE $cond";
            //SELECT * FROM subject WHERE name LIKE '%ty%'
        }
        $result = $conn->query($sql);
        $subjects = []; //[] bên phải dấu bằng là tạo một arry rổng
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $name = $row['name'];
                $number_of_credit = $row['number_of_credit'];
                
                $subject = new Subject($id, $name, $number_of_credit);
                $subjects[] = $subject; // [] bên trái dấu bằng là thêm một phần tử cuối danh sách

            }
        }
        return $subjects;
    }
    // lấy tất cả sinh viên trong data
    public function getAll()
    {
        $subjects = $this->fetch();
        return $subjects;
    }
    public function getByPattern($search)
    {
        $cond = "name LIKE '%$search%'";
        $subjects = $this->fetch($cond);
        return $subjects;
    }
    //lưu sinh viên mới vào data
    public function save($data)
    {
        global $conn;
        $name = $data['name'];
        $number_of_credit = $data['number_of_credit'];
      

        $sql = "INSERT INTO subject (name, number_of_credit) VALUES ('$name', '$number_of_credit')";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;
    }

    public function find($id)
    {
        $cond = "id=$id";
        $subjects = $this->fetch($cond);
        // current lấy 1 phần tử đầu tiên trong danh sách
        $subject = current($subjects);
        return $subject;
    }
    public function update($subject)
    {
        global $conn;
        $name = $subject->name;
        $number_of_credit = $subject->number_of_credit;
       
        $id = $subject->id;
        $sql = "UPDATE subject SET name='$name', number_of_credit='$number_of_credit' WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;

    }
    public function delete($id)
    {
        global $conn;
        $sql = "DELETE FROM subject WHERE id=$id";
        if ($conn->query($sql)) {
            return true;
        }
        $this->error = $sql . '<br>' . $conn->error;
        return false;

    }
}
