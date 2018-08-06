<?php

class Base_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

    }

    function hash($password)
    {
        $salt = rand(111111, 999999);
        $password = hash("sha512", $salt . $password);

        $hash = array(
            "salt" => $salt,
            "password" => $password,
        );

        return $hash;
    }

    function debug($data)
    {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
        die();
    }

    function check_exists($username, $exclude_id = "")
    {

        $where = array(
            "username" => $username
        );

        if ($exclude_id == "") {

            $admin = $this->Admin_model->get_where($where);
            $user = $this->User_model->get_where($where);
            $client = $this->Client_model->get_where($where);

            if (empty($admin) and empty($user) and empty($client)) {
                return false;
            } else {
                return true;
            }
        } else if ($exclude_id != "") {
            $admin = $this->Admin_model->get_where_and_primary_is_not($where, $exclude_id);
            $user = $this->User_model->get_where_and_primary_is_not($where, $exclude_id);
            $client = $this->Client_model->get_where_and_primary_is_not($where, $exclude_id);

            if (empty($admin) and empty($user) and empty($client)) {
                return false;
            } else {
                return true;
            }
        }

    }

    function show_404_if_empty($array)
    {
        if (empty($array)) show_404();
    }

    function multi_image_upload($files, $field_name, $path)
    {

        $files_count = count($files[$field_name]['name']);

        $urls = array();

        $error = false;
        for ($i = 0; $i < $files_count; $i++) {

            if ($error) die($error_message);

            $_FILES["image"]['name'] = $files[$field_name]['name'][$i];
            $_FILES["image"]['type'] = $files[$field_name]['type'][$i];
            $_FILES["image"]['tmp_name'] = $files[$field_name]['tmp_name'][$i];
            $_FILES["image"]['error'] = $files[$field_name]['error'][$i];
            $_FILES["image"]['size'] = $files[$field_name]['size'][$i];

            $config = array(
                "allowed_types" => "gif|png|jpg|jpeg",
                "upload_path" => "./images/" . $path . "/",
                "path" => "/images/" . $path . "/"
            );

            $this->load->library("upload", $config);

            if ($this->upload->do_upload("image")) {
                $url = $config['path'] . $this->upload->data()['file_name'];

                array_push($urls, $url);
            } else {
                $error = true;
                $error_message = $this->upload->display_errors();
            }
        }

        return $urls;
    }
}

?>
