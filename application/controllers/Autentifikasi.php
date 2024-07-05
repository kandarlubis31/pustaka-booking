<?php

class Autentifikasi extends CI_Controller
{
    public function index()
    {
        //jika statusnya sudah login, maka tidak bisa mengakses
        //halaman login alias dikembalikan ke tampilan user
        if($this->session->userdata('email')) { redirect('user'); }


        // Set method Validation untuk form
        $this->form_validation->set_rules('email', 'Alamat Email',
            'required|trim|valid_email', [
                'required' => 'Email Harus diisi!!',
                'valid_email' => 'Email Tidak Benar!!'
            ]);
        $this->form_validation->set_rules('password', 'Password',
            'required|trim', [
                'required' => 'Password Harus diisi'
            ]);
        // eksekusi form validasi
        if ($this->form_validation->run() == false) 
        {
            $data['judul'] = 'Login';
            $data['user'] = '';

            //kata 'login' merupakan nilai dari variabel judul dalam
            //array $data dikirimkan ke view aute_header
            $this->load->view('templates/aute_header', $data);
            $this->load->view('autentifikasi/login');
            $this->load->view('templates/aute_footer');
        } else { $this->_login(); }
    }

        //  Menambahkan Fungsi Logout
    public function logout()
    {
        $item = array('email','role_id');
        $this->session->unset_userdata($item);
        $this->session->set_flashdata('pesan','<div class="alert alert-info alert-message" role="alert">Anda telah berhasil logout !</div>');
        redirect('autentifikasi');
    }
    
    private function _login()
    {
        $email = htmlspecialchars($this->input->post('email', true));
        $password = $this->input->post('password', true);
        $user = $this->ModelUser->cekData(['email' => $email])->row_array();
        
        //jika usernya ada (exist)
        if ($user) 
        {
            //jika user sudah aktif
            if ($user['is_active'] == 1) {

                //cek password
                if (md5($password) === $user['password']) 
                {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    
                    if ($user['role_id'] == 1){
                        $this->session->set_flashdata('pesan',
                                '<div class="alert alert-info alert-message" role="alert">Selamat Datang Admin</div>');
                        redirect('admin');
                    }
                    else {
                        if ($user['image'] == 'default.jpg')
                        {
                            $this->session->set_flashdata('pesan',
                                '<div class="alert alert-info alert-message" role="alert">Silahkan Ubah Profile Anda untuk Ubah Photo Profil</div>');
                        }
                        $this->session->set_flashdata('pesan',
                                '<div class="alert alert-info alert-message" role="alert">Selamat Datang User !</div>');
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Password salah!!</div>');
                    redirect('autentifikasi');
                }

            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">User belum diaktifasi!!</div>');
                redirect('autentifikasi');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Email tidak terdaftar!!</div>');
            redirect('autentifikasi');
        }
    }

    public function blok() { $this->load->view('autentifikasi/blok'); }
    public function gagal() { $this->load->view('autentifikasi/gagal'); }


    public function registrasi()
    {
        if ($this->session->userdata('email')) { redirect('user'); }

       
        $this->form_validation->set_rules(
            'nama', 
            'Nama Lengkap',
            'required', [
                'required' => 'Nama Belum diisi!!'
            ]);
       
        $this->form_validation->set_rules(
            'email', 
            'Alamat Email',
            'required|trim|valid_email|is_unique[user.email]', [
                'valid_email' => 'Email Tidak Benar!!',
                'required' => 'Email Belum diisi!!',
                'is_unique' => 'Email Sudah Terdaftar!'
            ]);
        
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|matches[password2]', [
                'matches' => 'Password Tidak Sama!!',
                'required' => 'Password Harus diisi',
                'min_length' => 'Password Terlalu Pendek'
            ]);
        $this->form_validation->set_rules(
            'password2', 
            'RepeatPassword',
            'required|trim|matches[password1]',[
                'matches' => 'Password Tidak Sama!!',
                'required' => 'Password Harus diisi',
                'min_length' => 'Password Terlalu Pendek'
            ]
        );
       
        if ($this->form_validation->run() == false) 
        {
            $data['judul'] = 'Registrasi Member';
            $this->load->view('templates/aute_header', $data);
            $this->load->view('autentifikasi/registrasi');
            $this->load->view('templates/aute_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'tanggal_input' => time()
            ];
            $member = $this->db->count_all_results('user');;
            if($member==0){
                $admin = [
                    'nama' => 'Admin Pustaka Booking',
                    'email' => 'admin@pustaka-booking.com',
                    'image' => 'default.jpg',
                    'password' => password_hash('12345678', PASSWORD_DEFAULT),
                    'role_id' => 1,
                    'is_active' => 1,
                    'tanggal_input' => time()
                ];
                $this->ModelUser->simpanData($admin);
                $this->ModelUser->simpanData($data); //menggunakan model
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Selamat!! akun member anda sudah dibuat. Silahkan Aktivasi Akun anda</div>');
                redirect('autentifikasi');
            } else{
                $this->ModelUser->simpanData($data); //menggunakan model
                $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Selamat!! akun member anda sudah dibuat. Silahkan Aktivasi Akun anda</div>');
                redirect('autentifikasi');
            }
            
        }
    }
}


