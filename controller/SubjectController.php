<?php
class SubjectController
{
    public function index()
    {
        $search = $_GET['search'] ?? '';
        $subjectRepository = new SubjectRepository();
        if ($search) {
            $subjects = $subjectRepository->getByPattern($search);

        } else {
            $subjects = $subjectRepository->getAll();
        }

        require 'view/subject/index.php';
    }
    public function create()
    {
        require 'view/subject/create.php';
    }
    public function store()
    {
        $subjectRepository = new SubjectRepository();
        if ($subjectRepository->save($_POST)) {
            $_SESSION['success'] = 'đã tạo môn học thành công';
            header('location:/?c=subject');
            exit;
        }
        $_SESSION['error'] = $subjectRepository->error;
        header('location:/?c=subject');
    }
    public function edit()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        $subject = $subjectRepository->find($id);

        require 'view/subject/edit.php';
    }
    public function update()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $number_of_credit = $_POST['number_of_credit'];

        $subjectRepository = new SubjectRepository();
        //dữ liệu cũ trong data
        $subject = $subjectRepository->find($id);
        //cập nhật đối tượng
        $subject->name = $name;
        $subject->number_of_credit = $number_of_credit;

        //lưu đối tượng xuống data
        if ($subjectRepository->update($subject)) {
            $_SESSION['success'] = 'đã cập nhật môn học thành công';
            header('location:/?c=subject');
            exit;
        }
        $_SESSION['error'] = $subjectRepository->error;
        header('location:/?c=subject');

    }
    public function destroy()
    {
        $id = $_GET['id'];
        $subjectRepository = new SubjectRepository();
        if ($subjectRepository->delete($id)) {
            $_SESSION['success'] = 'đã xóa môn học thành công';
            header('location:/?c=subject');
            exit;
        }
        $_SESSION['error'] = $subjectRepository->error;
        header('location:/?c=subject');

    }

}
