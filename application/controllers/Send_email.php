<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Send_email extends CI_Controller
{

    /**
     * Kirim email dengan SMTP Gmail.
     *
     */
    function  __construct()
    {
        parent::__construct();
    }

    function send()
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mohfadlanzainudin@gmail.com';
        $mail->Password = 'fadlanzainudin';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('fadlan642@gmail.com', 'Fadhlan');
        $mail->addReplyTo('fadlan642@gmail.com', 'Fadhlan');

        // Add a recipient
        $mail->addAddress('mohfadlanzainudin@gmail.com');

        // Email subject
        $mail->Subject = 'Send Email via SMTP using PHPMailer in CodeIgniter';

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "<h1>Send HTML Email using SMTP in CodeIgniter</h1>
            <p>This is a test email sending using SMTP mail server with PHPMailer.</p>";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    public function index()
    {
        if ($this->input->post('file_submit') && !empty($_FILES['file_upload']['name'])) {
            $number = sizeof($_FILES['file_upload']['tmp_name']);
            $files = $_FILES['file_upload'];

            for ($i = 0; $i < $number; $i++) {
                if ($_FILES['file_upload']['error'][$i] != 0) {
                    $this->form_validation->set_message('file_upload', 'Couldn\'t upload the files');
                    return false;
                }
            }

            $config['upload_path'] = 'assets/upload/barang/';
            $config['allowed_types'] = 'jpg|jpeg|jpe|png|gif|bmp';
            $config['encrypt_name'] = true;

            for ($i = 0; $i < $number; $i++) {
                $_FILES['file_upload']['name'] = $files['name'][$i];
                $_FILES['file_upload']['type'] = $files['type'][$i];
                $_FILES['file_upload']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['file_upload']['error'] = $files['error'][$i];
                $_FILES['file_upload']['size'] = $files['size'][$i];

                $this->upload->initialize($config);
                if ($this->upload->do_upload('file_upload')) {
                    $data = $this->upload->data();
                    chmod($data['full_path'], 0777);

                    $insert[$i]['kode_barang'] = '12332ww22';
                    $insert[$i]['gambar'] = $data['file_name'];
                    $insert[$i]['file_size'] = $data['file_size'];
                    $insert[$i]['token'] = '12332ww22';
                }
            }
            $this->db->insert_batch('tb_barang_tmp', $insert);
        }
        $this->load->view('welcome_message');
    }

    function email()
    {
        $this->load->view('email');
    }
}
