<?php
class StudentController
{
    public function index()
    {
        $search = $_GET['search'] ?? '';
        $studentRepository = new StudentRepository();
        if ($search) {
            $students = $studentRepository->getByPattern($search);

        } else {
            $students = $studentRepository->getAll();
        }

        require 'view/student/index.php';
    }
    public function create()
    {
        require 'view/student/create.php';
    }
    public function store()
    {
        $studentRepository = new StudentRepository();
        if ($studentRepository->save($_POST)) {
            $_SESSION['success'] = 'đã tạo sinh viên thành công';
            header('location:/');
            exit;
        }
        $_SESSION['error'] = $studentRepository->error;
        header('location:/');
    }
    public function edit()
    {
        $id = $_GET['id'];
        $studentRepository = new StudentRepository();
        $student = $studentRepository->find($id);

        require 'view/student/edit.php';
    }
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $studentRepository = new StudentRepository();
        //dữ liệu cũ trong data
        $student = $studentRepository->find($id);
        //cập nhật đối tượng
        $student->name = $name;
        $student->$birthday = $birthday;
        $student->$gender = $gender;
        //lưu đối tượng xuống data
        if ($studentRepository->update($student)) {
            $_SESSION['success'] = 'đã cập nhật sinh viên thành công';
            header('location:/');
            exit;
        }
        $_SESSION['error'] = $studentRepository->error;
        header('location:/');

    }
    public function destroy()
    {
        $id = $_GET['id'];
        //sinh viên đã đăng kí môn học chưa
        $registerRepository = new RegisterRepository();
        $registers = $registerRepository->getByStudentId($id);
        if (count($registers)>0) {
             $_SESSION['success'] = 'sinh viên đã đăng kí môn học không thể xóa';
             header('location:/');
             exit;
}

        $studentRepository = new StudentRepository();
        if ($studentRepository->delete($id)) {
            $_SESSION['success'] = 'đã xóa sinh viên thành công';
            header('location:/');
            exit;
        }
        $_SESSION['error'] = $studentRepository->error;
        header('location:/');

    }

}
