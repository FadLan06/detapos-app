<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Auth_model');
    }

    public function index()
    {
        $data['judul'] = 'Selamat Datang';

        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('login/index', $data);
            $this->db->query("DELETE FROM tb_log WHERE DATEDIFF(CURDATE(), timestmp) >= 2");
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->Auth_model->cek_user($username);

        if ($user) {
            if ($user['is_active'] == 1) {
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'id' => $user['id'],
                        'produk' => $user['produk'],
                        'token' => $user['token'],
                        'date_created' => $user['date_created'],
                        'username' => $user['username'],
                        'password' => $user['password'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('Dashboard');
                    } elseif ($user['role_id'] == 2) {
                        $prof = $this->db->get_where('setting_app', ['token' => $user['token']])->row_array();
                        if ($prof['nama_toko'] == 'detapos.co.id') {
                            redirect('Profil');
                        } else {
                            redirect('Home');
                        }
                    } elseif ($user['role_id'] == 3) {
                        redirect('Beranda');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Kata Sandi Anda Salah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('Login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Nama Pengguna Ini Belum Aktif! Silahkan Hubingi CS (0811-4324-445)<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('Login');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Nama Pengguna Belum Terdaftar!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Login');
        }
    }

    // function api_login()
    // {
    //     if ($_POST) {
    //         $username = $this->input->post('username');
    //         $password = $this->input->post('password');

    //         $_key = 'ZWEQXaClwJcLP9hy5Dp5';

    //         $curl = curl_init();

    //         curl_setopt_array($curl, array(
    //             CURLOPT_URL => "https://member.gammaadvertisa.com/api/check-access/by-login-pass?_key=" . $_key . "&login=" . $username . "&pass=" . $password,
    //             CURLOPT_RETURNTRANSFER => true,
    //             CURLOPT_ENCODING => "",
    //             CURLOPT_MAXREDIRS => 10,
    //             CURLOPT_TIMEOUT => 30,
    //             CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //             CURLOPT_CUSTOMREQUEST => "GET",
    //         ));

    //         $response = curl_exec($curl);
    //         $err = curl_error($curl);

    //         curl_close($curl);

    //         if ($err) {
    //             echo "cURL Error #:" . $err;
    //         } else {
    //             echo $response;
    //         }
    //     }
    // }

    public function registrasi()
    {
        $this->form_validation->set_rules('token', 'Token', 'required|trim|is_unique[user.token]', [
            'is_unique' => 'Token ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No. Hp/WA', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Email ini sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[4]|matches[password1]', [
            'matches' => 'Kata sandi tidak cocok!',
            'min_length' => 'Kata sandi terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|matches[password]', [
            'matches' => 'Kata sandi tidak cocok!'
        ]);


        if ($this->form_validation->run() == false) {
            $data['judul'] = 'Registrasi';
            $this->load->view('login/registrasi', $data);
        } else {
            $email = $this->input->post('email', true);
            // $token = mt_rand(0, 9999999999);
            $token = htmlspecialchars($this->input->post('token', true));
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($email),
                'no_hp' => htmlspecialchars($this->input->post('no_hp')),
                'produk' => htmlspecialchars($this->input->post('produk')),
                'image' => 'default.png',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => '2',
                'is_active' => 1,
                'date_created' => time(),
                'license_expires' => htmlspecialchars($this->input->post('license_expires')),
                'coupon' => 'new',
                'token' => $token
            ];
            $this->db->insert('user', $data);
            $id = $this->db->insert_id();

            if ($this->input->post('usaha') == 'Butik') {
                $this->db->query("INSERT INTO user_access_menu VALUES ('','$token','2','2','$id','1','1','1'), ('','$token','19','2','$id','1','1','1'), ('','$token','20','2','$id','1','1','1'), ('','$token','21','2','$id','1','1','1'), ('','$token','22','2','$id','1','1','1'), ('','$token','23','2','$id','1','1','1'), ('','$token','24','2','$id','1','1','1'), ('','$token','25','2','$id','1','1','1'), ('','$token','26','2','$id','1','1','1'), ('','$token','29','2','$id','1','1','1'), ('','$token','28','2','$id','1','1','1'), ('','$token','34','2','$id','1','1','1'), ('','$token','35','2','$id','1','1','1'), ('','$token','36','2','$id','1','1','1'), ('','$token','37','2','$id','1','1','1'), ('','$token','41','2','$id','1','1','1'), ('','$token','45','2','$id','1','1','1'),('','$token','46','2','$id','1','1','1'),('','$token','47','2','$id','1','1','1'),('','$token','48','2','$id','1','1','1'),('','$token','49','2','$id','1','1','1'),('','$token','50','2','$id','1','1','1'),('','$token','51','2','$id','1','1','1'),('','$token','52','2','$id','1','1','1'),('','$token','57','2','$id','1','1','1'),('','$token','58','2','$id','1','1','1'),('','$token','59','2','$id','1','1','1'),('','$token','61','2','$id','1','1','1'),('','$token','62','2','$id','1','1','1') ");
            } else {
                $this->db->query("INSERT INTO user_access_menu VALUES ('','$token','2','2','$id','1','1','1'), ('','$token','19','2','$id','1','1','1'), ('','$token','20','2','$id','1','1','1'), ('','$token','21','2','$id','1','1','1'), ('','$token','22','2','$id','1','1','1'), ('','$token','23','2','$id','1','1','1'), ('','$token','24','2','$id','1','1','1'), ('','$token','25','2','$id','1','1','1'), ('','$token','26','2','$id','1','1','1'), ('','$token','39','2','$id','1','1','1'), ('','$token','28','2','$id','1','1','1'), ('','$token','34','2','$id','1','1','1'), ('','$token','35','2','$id','1','1','1'), ('','$token','36','2','$id','1','1','1'), ('','$token','37','2','$id','1','1','1'), ('','$token','41','2','$id','1','1','1'), ('','$token','45','2','$id','1','1','1'),('','$token','46','2','$id','1','1','1'),('','$token','47','2','$id','1','1','1'),('','$token','48','2','$id','1','1','1'),('','$token','49','2','$id','1','1','1'),('','$token','50','2','$id','1','1','1'),('','$token','51','2','$id','1','1','1'),('','$token','52','2','$id','1','1','1') ");
            }

            $dataa = [
                'nama_toko' => htmlspecialchars('detapos.co.id'),
                'alamat' => htmlspecialchars('detapos.co.id'),
                'provinsi' => htmlspecialchars('7'),
                'kota' => htmlspecialchars('130'),
                'no_telpon' => htmlspecialchars('088800008888'),
                'email_toko' => htmlspecialchars('admin@detapos.co.id'),
                'barcode' => htmlspecialchars('standart'),
                'struk' => htmlspecialchars('thermal'),
                'zona' => htmlspecialchars('Asia/Hong_Kong'),
                'kode_unik' => htmlspecialchars('Menambahkan'),
                'status' => htmlspecialchars('1'),
                'usaha' => htmlspecialchars($this->input->post('usaha')),
                'get_kategori' => htmlspecialchars('Aktif'),
                'token' => htmlspecialchars($token),
            ];

            $this->db->insert('setting_app', $dataa);

            $cod = [
                'biaya' => 0,
                'status' => 0,
                'token' => htmlspecialchars($token),
            ];
            $this->db->insert('tb_cod', $cod);

            $dt = [
                'kode_akun' => htmlspecialchars('111'),
                'nama_akun' => htmlspecialchars('Kas'),
                'kategori' => htmlspecialchars('HL'),
                'token' => htmlspecialchars($token),
            ];
            $this->db->insert('tb_akun', $dt);

            $dt1 = [
                'kode_akun' => htmlspecialchars('411'),
                'nama_akun' => htmlspecialchars('Pendapatan'),
                'kategori' => htmlspecialchars('HT'),
                'token' => htmlspecialchars($token),
            ];
            $this->db->insert('tb_akun', $dt1);

            $dt2 = [
                'kode_akun' => htmlspecialchars('112'),
                'nama_akun' => htmlspecialchars('Persediaan'),
                'kategori' => htmlspecialchars('HL'),
                'token' => htmlspecialchars($token),
            ];
            $this->db->insert('tb_akun', $dt2);

            $dt3 = [
                'kode_akun' => htmlspecialchars('511'),
                'nama_akun' => htmlspecialchars('Harga Pokok Penjualan'),
                'kategori' => htmlspecialchars('HT'),
                'token' => htmlspecialchars($token),
            ];
            $this->db->insert('tb_akun', $dt3);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Selamat! akun anda sudah dibuat. Silahkan login!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Login');
        }
    }

    function cek_token()
    {
        if ($_POST) {
            $token = $_POST['token'];
            $set = $this->db->get_where('setting_app', ['token' => $token])->row_array();
            if (empty($set['token'])) {
                $ch = curl_init();
                $url = "https://member.gammaadvertisa.com/softsale/api/check-license?key=" . $token;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
                $result = curl_exec($ch);

                curl_close($ch);

                // $array = json_decode($result, true);
                // echo $array['message'];
                // echo $array['license_expires'];
                echo $result;
            } else {
                $tok = '';
                $ch = curl_init();
                $url = "https://member.gammaadvertisa.com/softsale/api/check-license?key=" . $tok;
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/x-www-form-urlencoded"));
                $result = curl_exec($ch);

                curl_close($ch);

                // $array = json_decode($result, true);
                // echo $array['message'];
                // echo $array['license_expires'];
                echo $result;
            }
        }
    }

    function cek_produk()
    {
        $db2 = $this->load->database('db2', TRUE);
        if ($_POST['token']) {
            $token = $_POST['token'];
            $key = $db2->get_where('am_softsale_license', ['key' => $token])->row_array();
            $user_id = $db2->get_where('am_softsale_license', ['user_id' => $key['user_id']])->row_array();
            $invoice_item_id = $db2->get_where('am_invoice_item', ['invoice_item_id' => $user_id['invoice_item_id']])->row_array();
            $query = $db2->get_where('am_billing_plan', ['plan_id' => $invoice_item_id['billing_plan_id']]);
            $tokn = $query->row_array();
            if ($query->num_rows()) {
                echo $tokn['first_period'];
            } else {
                echo '0';
            }
        }
    }

    public function logout()
    {
        date_default_timezone_set('Asia/Hong_Kong');
        // $date = array('last_login' => date('Y-m-d H:i:s'));
        $id = $this->session->userdata('token');
        $kd = $this->session->userdata('id');
        $this->db->set('last_login', date('Y-m-d H:i:s'));
        $this->db->where('token', $id);
        $this->db->where('id', $kd);
        $this->db->update('user');

        $this->session->unset_userdata('username');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('produk');
        $this->session->unset_userdata('date_created');
        $this->session->unset_userdata('password');
        $this->session->unset_userdata('token');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-dark alert-dismissible fade show" role="alert">Anda Telah Keluar!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Login');
    }

    public function blocked()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $data['judul'] = 'Page Not Found';

        $this->load->view('templates/header', $data);
        $this->load->view('login/block', $data);
        $this->load->view('templates/footer');
    }
}
