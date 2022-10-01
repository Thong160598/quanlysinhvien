<?php
class RegisterController
{
    public function index()
    {
        $search = $_GET['search'] ?? '';
        $registerRepository = new RegisterRepository();
        if ($search) {
            $registers = $registerRepository->getByPattern($search);

        } else {
            $registers = $registerRepository->getAll();
        }

        require 'view/register/index.php';
    }
    public function create()
    {
       $studentRepository = new StudentRepository();
       $students = $studentRepository->getAll();

       $subjectRepository = new SubjectRepository();
       $subjects = $subjectRepository->getAll();
       require 'view/register/create.php';
    }
    public function store()
    {
        $registerRepository = new RegisterRepository();
        if ($registerRepository->save($_POST)) {
            $_SESSION['success'] = 'đã tạo môn học thành công';
            header('location:/?c=register');
            exit;
        }
        $_SESSION['error'] = $registerRepository->error;
        header('location:/?c=register');
    }
    public function edit()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        $register = $registerRepository->find($id);

        require 'view/register/edit.php';
    }
    public function update()
    {
        $id = $_POST['id'];
        $score = $_POST['score'];
        $registerRepository = new RegisterRepository();
        //dữ liệu cũ trong data
        $register = $registerRepository->find($id);
        //cập nhật đối tượng
        $register->score=$score;

        //lưu đối tượng xuống data
        if ($registerRepository->update($register)) {
            $_SESSION['success'] = 'đã cập nhật môn học thành công';
            header('location:/?c=register');
            exit;
        }
        $_SESSION['error'] = $registerRepository->error;
        header('location:/?c=register');

    }
    public function destroy()
    {
        $id = $_GET['id'];
        $registerRepository = new RegisterRepository();
        if ($registerRepository->delete($id)) {
            $_SESSION['success'] = 'đã xóa môn học thành công';
            header('location:/?c=register');
            exit;
        }
        $_SESSION['error'] = $registerRepository->error;
        header('location:/?c=register');

    }

}
