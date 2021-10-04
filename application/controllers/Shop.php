<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Shop extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('Shop_model');
    }

    public function olshop($id)
    {
        $data['judul'] = 'Selamat Datang';
        $toko = ucwords(str_replace('-', ' ', $id));
        $set = $this->db->get_where('setting_app', ['nama_toko' => $toko])->row_array();

        $this->db->limit(12);
        $this->db->offset($this->uri->segment(3));
        $this->db->where('gambar !=', null);
        $barang = $this->db->get_where('tb_barang', ['token' => $set['token']]);

        $this->db->where('gambar !=', null);
        $this->db->where('token', $set['token']);
        $total_rows = $this->db->count_all_results('tb_barang');

        $this->load->helper('app');
        $pagination_links = pagination($total_rows, 12);

        if (!$this->input->is_ajax_request()) $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/index', compact('barang', 'pagination_links'));
        if (!$this->input->is_ajax_request()) $this->load->view('templates/footer-front');
    }

    public function toko($id)
    {
        // is_logged_in_pel();

        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $toko = ucwords(str_replace('-', ' ', $id));
        $data['set'] = $this->db->get_where('setting_app', ['nama_toko' => $toko])->row_array();
        $data['judul'] = $data['set']['nama_toko'];

        $this->db->where('gambar !=', null);
        $data['barang'] = $this->db->get_where('tb_barang', ['token' => $id]);

        $data['ket'] = $this->db->query("SELECT * FROM tb_kategori_barang WHERE token = '$id'");

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/toko', $data);
        $this->load->view('templates/footer-front');
    }

    function detail_ket()
    {
        $data['cek'] = $this->db->get_where('tb_barang', ['id_kategori' => $_GET['kode']])->row_array();
        $this->load->view('front-end/detail_ket', $data);
    }

    public function detail()
    {
        // is_logged_in_pel();
        $id = $this->uri->segment(4);

        $data['judul'] = 'Detail Produk';
        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $data['barang'] = $this->db->get_where('tb_barang', ['gambar !=' => null, 'id' => $id])->row_array();

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/detail', $data);
        $this->load->view('templates/footer-front');
    }

    public function masuk()
    {
        $use = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $kr = $this->db->query("SELECT * FROM tb_keranjang_tmp WHERE id_pel='$use[id_pel_shop]'")->row_array();

        if (empty($kr['id_barang'])) {
            $data = array(
                'id_barang'      => $this->input->post('id_barang'),
                'qty'     => $this->input->post('qty'),
                'harga'   => $this->input->post('harga'),
                'nama_barang'    => $this->input->post('nama_barang'),
                'token'    => $this->input->post('token'),
                'id_pel'    => $this->input->post('id_pel'),
            );

            $hasil = $this->db->insert('tb_keranjang_tmp', $data);
            echo json_encode($hasil);
        } elseif ($kr['id_barang'] != $this->input->post('id_barang')) {
            $data = array(
                'id_barang'      => $this->input->post('id_barang'),
                'qty'     => $this->input->post('qty'),
                'harga'   => $this->input->post('harga'),
                'nama_barang'    => $this->input->post('nama_barang'),
                'token'    => $this->input->post('token'),
                'id_pel'    => $this->input->post('id_pel'),
            );

            $hasil = $this->db->insert('tb_keranjang_tmp', $data);
            echo json_encode($hasil);
        } else {
            $qty = $this->input->post('qty') + $kr['qty'];
            $data = array(
                'qty'     => $qty,
            );

            $this->db->where('id_barang', $this->input->post('id_barang'));
            $hasil = $this->db->update('tb_keranjang_tmp', $data);
            echo json_encode($hasil);
        }
    }

    function m_keranjang()
    {
        $data = array(
            'id'      => $this->input->post('id'),
            'qty'     => $this->input->post('qty'),
            'price'   => $this->input->post('price'),
            'name'    => $this->input->post('name')
        );

        $this->cart->insert($data);
        redirect($this->input->post('link'));
    }

    public function masuk_check()
    {
        $use = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $kr = $this->db->query("SELECT * FROM tb_keranjang_tmp WHERE id_pel='$use[id_pel_shop]'")->row_array();

        if (empty($kr['id_barang'])) {
            $data = array(
                'id_barang'      => $this->input->post('id_barang'),
                'qty'     => $this->input->post('qty'),
                'harga'   => $this->input->post('harga'),
                'nama_barang'    => $this->input->post('nama_barang'),
                'token'    => $this->input->post('token'),
                'id_pel'    => $this->input->post('id_pel'),
            );

            $hasil = $this->db->insert('tb_keranjang_tmp', $data);
            echo json_encode($hasil);
        } elseif ($kr['id_barang'] != $this->input->post('id_barang')) {
            $data = array(
                'id_barang'      => $this->input->post('id_barang'),
                'qty'     => $this->input->post('qty'),
                'harga'   => $this->input->post('harga'),
                'nama_barang'    => $this->input->post('nama_barang'),
                'token'    => $this->input->post('token'),
                'id_pel'    => $this->input->post('id_pel'),
            );

            $hasil = $this->db->insert('tb_keranjang_tmp', $data);
            echo json_encode($hasil);
        } else {
            $qty = $this->input->post('qty') + $kr['qty'];
            $data = array(
                'qty'     => $qty,
            );

            $this->db->where('id_barang', $this->input->post('id_barang'));
            $hasil = $this->db->update('tb_keranjang_tmp', $data);
            echo json_encode($hasil);
        }
    }

    public function keranjang()
    {
        if (empty($this->cart->contents())) {
            redirect('Olshop/' . $this->uri->segment(2));
        }

        // is_logged_in_pel();

        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Keranjang Belanjaan';

        // $this->db->group_by('token');
        // $data['data'] = $this->db->get_where('tb_keranjang_tmp', ['id_pel' => $data['use']['id_pel_shop']])->result_array();

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/keranjang', $data);
        $this->load->view('templates/footer-front');
    }

    public function hapus()
    {
        $id = $this->uri->segment(3);
        $lk = $this->uri->segment(4);
        $this->cart->remove($id);
        redirect('Olshop/' . $lk . '/cart');
    }

    public function ubah()
    {

        // $id = $this->input->post('id');
        // $id_barang = $this->input->post('id_barang');
        // $qty = $this->input->post('qty');

        // for ($i = 0; $i < count($id_barang); $i++) {
        //     $dataa = array(
        //         'qty'   => $qty[$i]
        //     );

        //     $this->db->where('id_keranjang_tmp', $id[$i]);
        //     $this->db->update('tb_keranjang_tmp', $dataa);
        // }
        // redirect('Shop/Keranjang');

        $i = 1;
        $lk = $this->input->post('link');
        foreach ($this->cart->contents() as $items) {
            $data = array(
                'rowid' => $items['rowid'],
                'qty'   => $this->input->post($i++ . '[qty]')
            );

            $this->cart->update($data);
        }

        redirect('Olshop/' . $lk . '/cart');
    }

    public function clear($id)
    {
        $this->cart->destroy();
        redirect('Olshop/' . $id);
    }

    public function login()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['user'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
            $data['judul'] = 'Login';

            $this->load->view('templates/header-front', $data);
            $this->load->view('front-end/login', $data);
            $this->load->view('templates/footer-front');
        } else {
            $this->load->model('Auth_model');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->Auth_model->cek_user_pel($email);

            if ($user) {
                if ($user['is_active'] == 1) {
                    if (password_verify($password, $user['password'])) {
                        $data = [
                            'nama_pel' => $user['nama_pel'],
                            'email' => $user['email'],
                            'image' => $user['image'],
                        ];
                        $this->session->set_userdata($data);
                        // redirect('Shop');
                        echo '<script>window.location=history.go(-1);</script>';
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Kata Sandi Anda Salah!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                        redirect('Shop/Login');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Nama Pengguna Ini Belum Aktif! Silahkan Hubingi CS (0811-4324-445)<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                    redirect('Shop/Login');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Nama Pengguna Belum Terdaftar!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                redirect('Shop/Login');
            }
        }
    }

    public function registrasi()
    {
        $this->form_validation->set_rules('nama_pel', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('no_hp', 'No. Hp/WA', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[tb_pel_shop.email]', [
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

            $this->load->view('templates/header-front', $data);
            $this->load->view('front-end/registrasi', $data);
            $this->load->view('templates/footer-front');
        } else {
            $data = [
                'nama_pel' => htmlspecialchars($this->input->post('nama_pel', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'no_hp' => htmlspecialchars($this->input->post('no_hp')),
                'image' => 'default_pel.png',
                'provinsi' => htmlspecialchars($this->input->post('provinsi', true)),
                'kota' => htmlspecialchars($this->input->post('kota', true)),
                'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('tb_pel_shop', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success text-dark alert-dismissible fade show" role="alert">Selamat! akun anda sudah dibuat. Silahkan login!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            redirect('Shop/Login');
        }
    }

    public function keluar()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('nama_pel');
        $this->session->unset_userdata('image');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-dark alert-dismissible fade show" role="alert">Anda Telah Keluar!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect('Shop/Login');
    }

    public function profil()
    {
        is_logged_in_pel();
        $data['judul'] = 'Profil';

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/profil', $data);
        $this->load->view('templates/footer-front');
    }

    public function checkout()
    {
        // if (empty($this->cart->contents())) {
        //     redirect('Shop');
        // }

        // is_logged_in_pel();
        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Checkout Belanjaan';

        // $this->db->group_by('token');
        // $data['data'] = $this->db->get_where('tb_keranjang_tmp', ['id_pel' => $data['use']['id_pel_shop']])->result_array();
        // $data['order_id'] = $this->Shop_model->order_id();

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/checkout', $data);
        $this->load->view('templates/footer-front');
    }

    function proses_checkout()
    {
        if (isset($_POST['proses'])) {

            $i = 1;
            $use = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
            $kr = $this->db->query("SELECT *, sum(qty) as qty, sum(qty * harga) as subtotal FROM tb_keranjang_tmp WHERE id_pel='$use[id_pel_shop]' GROUP BY id_barang")->result_array();
            foreach ($kr as $items) {
                $token = $items['token'];
                $dataa = array(
                    'order_id' => htmlspecialchars($this->input->post('order_id')),
                    'id_barang' => htmlspecialchars($items['id_barang']),
                    'qty'   => htmlspecialchars($this->input->post('qty' . $token)),
                    'expedisi'  =>  htmlspecialchars($this->input->post('expedisi' . $token)),
                    'paket'  =>  htmlspecialchars($this->input->post('paket' . $token)),
                    'ongkir'  =>  htmlspecialchars($this->input->post('ong' . $token)),
                    'estimasi'  =>  htmlspecialchars($this->input->post('estimasi' . $token)),
                    'berat'  =>  htmlspecialchars($this->input->post('berat' . $token)),
                    'total'  =>  htmlspecialchars($this->input->post('totaal' . $token)),
                    'total_bayar'  =>  htmlspecialchars($this->input->post('total_bayarr' . $token)),
                    'token' => htmlspecialchars($items['token'])
                );
                $this->db->insert('tb_shop_detail', $dataa);
            }

            $data = [
                'order_id'  =>  htmlspecialchars($this->input->post('order_id')),
                'tgl_order'  =>  htmlspecialchars($this->input->post('tgl_order')),
                'id_pel_shop'  =>  htmlspecialchars($this->input->post('id_pel_shop')),
                'nama_penerima'  =>  htmlspecialchars($this->input->post('nama_penerima')),
                'no_hp'  =>  htmlspecialchars($this->input->post('no_hp')),
                'provinsi'  =>  htmlspecialchars($this->input->post('provinsi')),
                'kota'  =>  htmlspecialchars($this->input->post('kota')),
                'alamat'  =>  htmlspecialchars($this->input->post('alamat')),
                'total'  =>  htmlspecialchars($this->input->post('total')),
                'total_bayar'  =>  htmlspecialchars($this->input->post('total_bayar')),
                'status'  =>  1,
                'status_bayar'  =>  0
            ];

            $this->db->insert('tb_shop', $data);

            $this->db->where('id_pel', $use['id_pel_shop']);
            $this->db->delete('tb_keranjang_tmp');

            redirect('Shop/Pesanan');
        }
    }

    private function _send($type, $token)
    {
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'email-smtp.us-east-1.amazonaws.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AKIA5K3LOZDQ6NLOVIVI';
        $mail->Password = 'BFEN2KI7nEhIffG1Qxt0E1MS4XxPDQKw4Fwl3TcyIvbf';
        $mail->SMTPSecure = 'ssl';
        $mail->Port     = 465;

        $mail->setFrom('admin@detapos.co.id', 'Admin Detapos');

        // Add a recipient
        $mail->addAddress($this->input->post('email'), $this->input->post('nama_lengkap'));

        // Email subject
        $mail->Subject = 'Pesanan anda kami telah terima - #' . $this->input->post('order_id') . '';

        // Set email format to HTML
        $mail->isHTML(true);

        $rek = $this->db->get_where('tb_rekening', ['token' => $token]);
        $dt = $rek->num_rows();

        if ($dt == '1') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '2') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '3') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js3') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr3') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an3') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        } else if ($dt == '4') {
            $data = "
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js1') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr1') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an1') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js2') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr2') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an2') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js3') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr3') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an3') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <tr>
                    <td align='center'>
                        <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                            <tr>
                                <td align='center'>
                                    <img src='https://app.detapos.co/assets/img/" . $this->input->post('js4') . ".png' width='50%'>
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>No. Rek : </b> " . $this->input->post('nr4') . "
                                </td>
                            </tr>
                            <tr>
                                <td align='center'>
                                    <b>Atas Nama : </b> " . $this->input->post('an4') . "
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ";
        }

        // Email body content
        $mailContent = "
            <!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
            <html xmlns='http://www.w3.org/1999/xhtml'>
            
            <head>
                <meta name='viewport' content='width=device-width, initial-scale=1.0' />
                <meta name='x-apple-disable-message-reformatting' />
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                <meta name='color-scheme' content='light dark' />
                <meta name='supported-color-schemes' content='light dark' />
                <title></title>
                <style type='text/css' rel='stylesheet' media='all'>
                    /* Base ------------------------------ */
            
                    @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:400,700&display=swap');
            
                    body {
                        width: 100% !important;
                        height: 100%;
                        margin: 0;
                        -webkit-text-size-adjust: none;
                    }
            
                    a {
                        color: #3869D4;
                    }
            
                    a img {
                        border: none;
                    }
            
                    td {
                        word-break: break-word;
                    }
            
                    .preheader {
                        display: none !important;
                        visibility: hidden;
                        /* mso-hide: all; */
                        font-size: 1px;
                        line-height: 1px;
                        max-height: 0;
                        max-width: 0;
                        opacity: 0;
                        overflow: hidden;
                    }
            
                    /* Type ------------------------------ */
            
                    body,
                    td,
                    th {
                        font-family: 'Nunito Sans', Helvetica, Arial, sans-serif;
                    }
            
                    h1 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 18px;
                        font-weight: bold;
                        text-align: center;
                    }
            
                    h2 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 12px;
                        font-weight: bold;
                        text-align: left;
                    }
            
                    h3 {
                        margin-top: 0;
                        color: #333333;
                        font-size: 10px;
                        font-weight: bold;
                        text-align: left;
                    }
            
                    td,
                    th {
                        font-size: 12px;
                    }
            
                    p,
                    ul,
                    ol,
                    blockquote {
                        margin: .4em 0 1.1875em;
                        font-size: 12px;
                        line-height: 1.625;
                    }
            
                    p.sub {
                        font-size: 10px;
                    }
            
                    /* Utilities ------------------------------ */
            
                    .align-right {
                        text-align: right;
                    }
            
                    .align-left {
                        text-align: left;
                    }
            
                    .align-center {
                        text-align: center;
                    }
            
                    /* Buttons ------------------------------ */
            
                    .button {
                        background-color: #3869D4;
                        border-top: 10px solid #3869D4;
                        border-right: 18px solid #3869D4;
                        border-bottom: 10px solid #3869D4;
                        border-left: 18px solid #3869D4;
                        display: inline-block;
                        color: #FFF;
                        text-decoration: none;
                        border-radius: 3px;
                        box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                        -webkit-text-size-adjust: none;
                        box-sizing: border-box;
                    }
            
                    .button--green {
                        background-color: #22BC66;
                        border-top: 10px solid #22BC66;
                        border-right: 18px solid #22BC66;
                        border-bottom: 10px solid #22BC66;
                        border-left: 18px solid #22BC66;
                    }
            
                    .button--red {
                        background-color: #ea323c;
                        border-top: 10px solid #ea323c;
                        border-right: 18px solid #ea323c;
                        border-bottom: 10px solid #ea323c;
                        border-left: 18px solid #ea323c;
                    }
            
                    @media only screen and (max-width: 400px) {
                        .button {
                            width: 100% !important;
                            text-align: center !important;
                        }
                    }
            
                    /* Attribute list ------------------------------ */
            
                    .attributes {
                        margin: 0 0 0px;
                    }
            
                    .attributes_content {
                        background-color: #F4F4F7;
                        padding: 16px;
                    }
            
                    .attributes_item {
                        padding: 0;
                    }
            
                    /* Related Items ------------------------------ */
            
                    .related {
                        width: 100%;
                        margin: 0;
                        padding: 25px 0 0 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .related_item {
                        padding: 10px 0;
                        color: #CBCCCF;
                        font-size: 12px;
                        line-height: 18px;
                    }
            
                    .related_item-title {
                        display: block;
                        margin: .5em 0 0;
                    }
            
                    .related_item-thumb {
                        display: block;
                        padding-bottom: 10px;
                    }
            
                    .related_heading {
                        border-top: 1px solid #CBCCCF;
                        text-align: center;
                        padding: 25px 0 10px;
                    }
            
                    /* Discount Code ------------------------------ */
            
                    .discount {
                        width: 100%;
                        margin: 0;
                        padding: 24px;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #F4F4F7;
                        border: 2px dashed #CBCCCF;
                    }
            
                    .discount_heading {
                        text-align: center;
                    }
            
                    .discount_body {
                        text-align: center;
                        font-size: 12px;
                    }
            
                    /* Social Icons ------------------------------ */
            
                    .social {
                        width: auto;
                    }
            
                    .social td {
                        padding: 0;
                        width: auto;
                    }
            
                    .social_icon {
                        height: 20px;
                        margin: 0 8px 10px 8px;
                        padding: 0;
                    }
            
                    /* Data table ------------------------------ */
            
                    .purchase {
                        width: 100%;
                        margin: 0;
                        padding: 35px 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .purchase_content {
                        width: 100%;
                        margin: 0;
                        padding: 5px 0 0 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    .purchase_item {
                        padding: 10px 0;
                        color: #51545E;
                        font-size: 12px;
                        line-height: 18px;
                    }
            
                    .purchase_heading {
                        padding-bottom: 8px;
                        border-bottom: 1px solid #EAEAEC;
                    }
            
                    .purchase_heading p {
                        margin: 0;
                        color: #85878E;
                        font-size: 12px;
                    }
            
                    .purchase_footer {
                        padding-top: 15px;
                        border-top: 1px solid #EAEAEC;
                    }
            
                    .purchase_total {
                        margin: 0;
                        text-align: right;
                        font-weight: bold;
                        color: #333333;
                    }
            
                    .purchase_total--label {
                        padding: 0 15px 0 0;
                    }
            
                    body {
                        background-color: #F4F4F7;
                        color: #51545E;
                    }
            
                    p {
                        color: #51545E;
                    }
            
                    p.sub {
                        color: #6B6E76;
                    }
            
                    .email-wrapper {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #F4F4F7;
                    }
            
                    .email-content {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                    }
            
                    /* Body ------------------------------ */
            
                    .email-body {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #FFFFFF;
                    }
            
                    .email-body_inner {
                        width: 570px;
                        margin: 0 auto;
                        padding: 0;
                        -premailer-width: 570px;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        background-color: #FFFFFF;
                    }
            
                    .body-action {
                        width: 100%;
                        margin: 30px auto;
                        padding: 0;
                        -premailer-width: 100%;
                        -premailer-cellpadding: 0;
                        -premailer-cellspacing: 0;
                        text-align: center;
                    }
            
                    .body-sub {
                        margin-top: 25px;
                        padding-top: 25px;
                        border-top: 1px solid #EAEAEC;
                    }
            
                    .content-cell {
                        padding: 0px;
                    }
            
                    /*Media Queries ------------------------------ */
            
                    @media (prefers-color-scheme: dark) {
            
                        body,
                        .email-body,
                        .email-body_inner,
                        .email-content,
                        .email-wrapper,
            
                        p,
                        ul,
                        ol,
                        blockquote,
                        h1,
                        h2,
                        h3 {
                            color: #FFF !important;
                        }
            
                        .attributes_content,
                        .discount {
                            background-color: #222 !important;
                        }
            
                    }
            
                    /* :root {
                        color-scheme: light dark;
                        supported-color-schemes: light dark;
                    } */
                </style>
            </head>
            
            <body>
                <table class='email-wrapper' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                    <tr>
                        <td align='center'>
                            <table class='email-content' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                <!-- Email Body -->
                                <tr>
                                    <td class='email-body' width='100%' cellpadding='0' cellspacing='0'>
                                        <table class='email-body_inner' align='center' width='570' cellpadding='0' cellspacing='0' role='presentation'>
                                            <!-- Body content -->
                                            <tr>
                                                <td class='content-cell'>
                                                    <div class='f-fallback'>
                                                        <h1 align='center'>Terima Kasih Atas Pesanan Anda</h1>
                                                        <table class='attributes' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td class='attributes_content'>
                                                                    <table width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Order ID </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('order_id') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Nama </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('nama_lengkap') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Nomor Hp/WA </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('no_wa') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%' valign='top'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Alamat </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%' valign='top'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('alamat') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Provinsi </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('provinsi') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class='attributes_item' width='30%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong>Kota/Kab </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item' width='5%'>
                                                                                <span class='f-fallback'>
                                                                                    <strong> : </strong>
                                                                                </span>
                                                                            </td>
                                                                            <td class='attributes_item'>
                                                                                <span class='f-fallback'>
                                                                                " . $this->input->post('kota') . "
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <!-- Action -->
                                                        <table class='purchase' width='100%' cellpadding='0' cellspacing='0'>
                                                            <tr>
                                                                <td colspan='2'>
                                                                    <table class='purchase_content' width='100%' cellpadding='0' cellspacing='0'>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>" . $this->input->post('nama_barang') . "</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>Rp.  " . number_format($this->input->post('harga_jual')) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback'>QTY</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback'>" . $this->input->post('qty') . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_item'><span class='f-fallback purchase_total'>Kode Unik</span></td>
                                                                            <td class='align-right' width='35%' class='purchase_item'><span class='f-fallback purchase_total'>- Rp. " . number_format($this->input->post('kode_unik')) . "</span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('total')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Ongkir</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('ongkir')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width='65%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total purchase_total--label'>Total Bayar</p>
                                                                            </td>
                                                                            <td width='35%' class='purchase_footer' valign='middle'>
                                                                                <p class='f-fallback purchase_total'>Rp. " . number_format($this->input->post('total_bayar')) . "</p>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <p align='center'>Untuk menyelesaikan proses pembayaran, silahkan transfer sejumlah </p>
                                                        <table class='body-action' align='center' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td align='center'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' role='presentation'>
                                                                        <tr>
                                                                            <td align='center'>
                                                                                <a href='' class='f-fallback button button--red'>Rp. " . number_format($this->input->post('total_bayar')) . "</a>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table> 
                                                        <p align='center'>Ke daftar rekening dibawah ini : </p>
                                                        " . $data . "
                                                        <p align='center'>Konfirmasi pembayaran anda ke : <a href='" . base_url() . "konfirmasi/" . $this->input->post('token') . "/" . $this->input->post('order_id') . "'> Form Konfirmasi Pembayaran </a></p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
            
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            
            </html>
        ";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo $mail->ErrorInfo;
            die;
        } else {
            return true;
        }
    }

    public function pesanan()
    {
        is_logged_in_pel();
        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Pesanan Saya';

        $id = $data['use']['id_pel_shop'];
        $data['shop'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='1' AND s.id_pel_shop='$id' GROUP BY d.token, d.order_id ORDER BY id_shop_detail ASC")->result();
        $data['shopp'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='2' AND s.id_pel_shop='$id' GROUP BY d.token, d.order_id ORDER BY id_shop_detail ASC")->result();
        $data['shoppi'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='3' AND s.id_pel_shop='$id' GROUP BY d.token, d.order_id ORDER BY id_shop_detail ASC")->result();
        $data['shopping'] = $this->db->query("SELECT *, s.order_id as id_order, d.total_bayar as totbar, d.status_bayar as tusbar FROM tb_shop s LEFT JOIN tb_shop_detail d ON s.order_id = d.order_id WHERE s.status='4' AND s.id_pel_shop='$id' GROUP BY d.token, d.order_id ORDER BY id_shop_detail ASC")->result();

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/pesanan', $data);
        $this->load->view('templates/footer-front');
    }

    public function bayar($or, $id)
    {
        $this->load->model('Akuntansi_model');

        is_logged_in_pel();
        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Konfirmasi Pembayaran';

        $data['id'] = $this->db->get_where('tb_shop_detail', ['id_shop_detail' => $id])->row_array();
        $data['rek'] = $this->db->get_where('tb_rekening', ['token' => $data['id']['token']])->result_array();
        $data['no_jurnal'] = $this->Akuntansi_model->no_jurnalll();

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/bayar', $data);
        $this->load->view('templates/footer-front');
    }

    function konfirmasi()
    {
        if (isset($_POST['konfirmasi'])) {
            if ($_FILES['bukti_transfer']['error'] <> 4) {

                $config['upload_path'] = 'assets/upload/konfirmasi';
                $config['allowed_types'] = 'jpg|png|gif|bmp|jpeg|jpe';
                $config['encrypt_name'] = true;
                $config['max_size'] = 1000;
                $config['quality'] = '50%';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti_transfer')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $hasil  = $this->upload->data();
                    $totval = $this->input->post('jml_transfer');
                    $no_transaksi = $this->input->post('order_id');
                    $totpok = $this->input->post('totpok');

                    $data = array(
                        'id_shop'           => htmlspecialchars($this->input->post('id_shop')),
                        'order_id'          => htmlspecialchars($this->input->post('order_id')),
                        'nama'              => htmlspecialchars($this->input->post('nama')),
                        'transfer_ke'       => htmlspecialchars($this->input->post('transfer_ke')),
                        'tgl_transfer'      => htmlspecialchars($this->input->post('tgl_transfer')),
                        'jml_transfer'      => htmlspecialchars($this->input->post('jml_transfer')),
                        'bukti_transfer'    => $hasil['file_name'],
                        'timee'             => date('Y-m-d H:i:s'),
                        'token'             => htmlspecialchars($this->input->post('token'))
                    );
                    $this->db->insert('tb_shop_tmp', $data);

                    $this->db->set('status_bayar', '1');
                    $this->db->where('token', $this->input->post('token'));
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_shop_detail');

                    $this->db->set('status_bayar', '1');
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_shop');

                    //AKUNTANSI
                    $user = $this->db->get_where('user', ['token' => $this->input->post('token')])->row_array();
                    if ($user['coupon'] == 'new') {
                        $datta = [
                            'no_jurnal' => $this->input->post('no_jurnal'),
                            'tgl_jurnal' => date('Y-m-d'),
                            'keterangan' => 'Pendapatan Penjualan Online dengan Nomor Transaksi ' . $no_transaksi,
                            'token' => $this->input->post('token'),
                            'no_transaksi' => '',
                            'order_id' => $this->input->post('id_shop')
                        ];

                        $this->db->insert('tb_jurnal_tmp', $datta);

                        $tok = $this->input->post('token');
                        $ak = $this->db->query("SELECT * FROM tb_akun WHERE token='$tok' AND kode_akun IN (111,112,411,511)")->result_array();

                        foreach ($ak as $ro) {
                            if ($ro['kode_akun'] == '111') {
                                // $ka = 'D';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totval,
                                    'tipe' => 'D',
                                    'token' => $this->input->post('token'),
                                    'no_transaksi' => '',
                                    'order_id' => $this->input->post('id_shop')
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            } else if ($ro['kode_akun'] == '411') {
                                // $ka = 'K';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totval,
                                    'tipe' => 'K',
                                    'token' => $this->input->post('token'),
                                    'no_transaksi' => '',
                                    'order_id' => $this->input->post('id_shop')
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            } else if ($ro['kode_akun'] == '112') {
                                // $ka = 'K';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totpok,
                                    'tipe' => 'D',
                                    'token' => $this->input->post('token'),
                                    'no_transaksi' => '',
                                    'order_id' => $this->input->post('id_shop')
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            } else if ($ro['kode_akun'] == '511') {
                                // $ka = 'K';
                                $dt1 = [
                                    'no_jurnal' => $this->input->post('no_jurnal'),
                                    'id_akun' => $ro['id_akun'],
                                    'nominal' => $totpok,
                                    'tipe' => 'K',
                                    'token' => $this->input->post('token'),
                                    'no_transaksi' => '',
                                    'order_id' => $this->input->post('id_shop')
                                ];

                                $this->db->insert('tb_jurnal', $dt1);
                            }
                        }
                    }

                    redirect('Shop/Selesai/' . $this->input->post('order_id') . '/' . $this->input->post('id_shop'));
                }
            }
        }
    }

    function selesai($or, $id)
    {
        is_logged_in_pel();
        $data['use'] = $this->db->get_where('tb_pel_shop', ['email' => $this->session->userdata('email')])->row_array();
        $data['judul'] = 'Selesai Pembayaran';

        $this->load->view('templates/header-front', $data);
        $this->load->view('front-end/selesai', $data);
        $this->load->view('templates/footer-front');
    }

    function terima()
    {
        if (isset($_POST['terima'])) {
            if ($_FILES['bukti_terima']['error'] <> 4) {

                $config['upload_path'] = 'assets/upload/terima';
                $config['allowed_types'] = 'jpg|png|gif|bmp|jpeg|jpe';
                $config['max_size'] = 1000;
                $config['quality'] = '50%';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if (!$this->upload->do_upload('bukti_terima')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $hasil  = $this->upload->data();
                    $data = array(
                        'order_id'          => htmlspecialchars($this->input->post('order_id')),
                        'no_resi'           => htmlspecialchars($this->input->post('no_resi')),
                        'ulasan'            => htmlspecialchars($this->input->post('ulasan')),
                        'bukti_terima'      => $hasil['file_name'],
                        'timee'             => date('Y-m-d H:i:s'),
                        'token'             => htmlspecialchars($this->input->post('token'))
                    );
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_shop_terima', $data);

                    $this->db->set('status', '4');
                    $this->db->set('waktu_selesai', date('Y-m-d H:i:s'));
                    $this->db->where('order_id', $this->input->post('order_id'));
                    $this->db->update('tb_shop');

                    redirect('Shop/Pesanan');
                }
            } else {
                $data = array(
                    'order_id'          => htmlspecialchars($this->input->post('order_id')),
                    'no_resi'           => htmlspecialchars($this->input->post('no_resi')),
                    'ulasan'            => htmlspecialchars($this->input->post('ulasan')),
                    'timee'             => date('Y-m-d H:i:s'),
                    'token'             => htmlspecialchars($this->input->post('token'))
                );
                $this->db->where('order_id', $this->input->post('order_id'));
                $this->db->update('tb_shop_terima', $data);

                $this->db->set('status', '4');
                $this->db->set('waktu_selesai', date('Y-m-d H:i:s'));
                $this->db->where('order_id', $this->input->post('order_id'));
                $this->db->update('tb_shop');

                redirect('Shop/Pesanan');
            }
        }
    }
}
