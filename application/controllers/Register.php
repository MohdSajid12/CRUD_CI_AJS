<?php

class Register extends CI_Controller
{

    public function front()
    {
        $this->load->view('front');
    }
    public function index()
    {
        $this->load->view('show');
    }

    public function create()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');

        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email')
        );

        $insert = $this->MyModel->insertRecord($data);

        if ($insert) {
            echo "data submitted";
        } else {
            echo "something went wrong";
        }
    }

    public function getData()
    {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');

        $data = $this->MyModel->getRecords();
        echo json_encode($data);
    }


    public function update()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');

        $data = array(
            'id'=>$this->input->post('id'),
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email')
        );

        $update = $this->MyModel->updateRecord($data);

        if ($update) {
            echo "record updated";
        } else {
            echo "something went wrong";
        }
    }

    public function delete()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type');

        $data = array(
            'id' => $this->input->post('id'),
            // 'name' => $this->input->post('name'),
            // 'email' => $this->input->post('email')
        );

        $delete = $this->MyModel->deleteRecord($data);

        if ($delete) {
            echo "record deleted";
        } else {
            echo "something went wrong";
        }
    }
}
