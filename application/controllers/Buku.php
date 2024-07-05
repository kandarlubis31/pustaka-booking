<?php


class Buku extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();
        // cek_admin();
    }
    
    // Fungsi Tambah Kategori
    public function kategori()
    {
        $data['judul'] = 'Kategori Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();
        $this->form_validation->set_rules(
            'kategori', 
            'Kategori',
            'required', [
                'required' => 'Judul Buku harus diisi'
            ]);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = ['kategori' => $this->input->post('kategori')];
            $this->ModelBuku->simpanKategori($data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Berhasil Menambah Kategori</div>');
            redirect('buku/kategori');
        }
    }
    // Fungsi Update Kategori
    public function ubahkategori()
    {
        $data['judul'] = 'Ubah Kategori Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();

        $where = ['id' =>  $this->uri->segment(3)];
        $data['kategori'] = $this->ModelBuku->kategoriWhere($where)->row_array();
        
        
        $this->form_validation->set_rules(
            'kategori', 
            'Kategori',
            'required', [
                'required' => 'Judul Buku harus diisi'
            ]);

        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/ubah_kategori', $data);
            $this->load->view('templates/footer');
        } else {
            $data = ['kategori' => $this->input->post('kategori')];
            $this->ModelBuku->updateKategori(['id' => $this->input->post('id')], $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Berhasil Update Kategori</div>');
            redirect('buku/kategori');
        }
    }
    // Fungsi Hapus Kategori
    public function hapusKategori()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelBuku->hapusKategori($where);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Kategori Telah dihapus !</div>');
        redirect('buku/kategori');
    }


    // // Fungsi Index dan Menambah Buku Baru
    public function index()
    {
        $data['judul'] = 'Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();

        $this->form_validation->set_rules(
            'judul_buku', 
            'Judul Buku', 
            'required|min_length[3]', [
                'required' => 'Judul Buku harus diisi',
                'min_length' => 'Judul buku terlalu pendek'
            ]);
        $this->form_validation->set_rules(
            'id_kategori', 
            'Kategori',
            'required', [
                'required' => 'Nama pengarang harus diisi',
            ]);
        $this->form_validation->set_rules(
            'pengarang', 
            'Nama Pengarang', 
            'required|min_length[3]', [
                'required' => 'Nama pengarang harus diisi', 
                'min_length' => 'Nama pengarang terlalu pendek'
            ]);
        $this->form_validation->set_rules(
            'penerbit', 
            'Nama Penerbit', 
            'required|min_length[3]', [
                'required' => 'Nama penerbit harus diisi',
                'min_length' => 'Nama penerbit terlalu pendek'
            ]);
        $this->form_validation->set_rules(
            'tahun', 
            'Tahun Terbit',
            'required|min_length[3]|max_length[4]|numeric', [
                'required' => 'Tahun terbit harus diisi',
                'min_length' => 'Tahun terbit terlalu pendek',
                'max_length' => 'Tahun terbit terlalu panjang',
                'numeric' => 'Hanya boleh diisi angka'
            ]);
        $this->form_validation->set_rules(
            'isbn',
            'Nomor ISBN',
            'required|min_length[3]|numeric', [
                'required' => 'Nama ISBN harus diisi',
                'min_length' => 'Nama ISBN terlalu pendek',
                'numeric' => 'Yang anda masukan bukan angka'
            ]);
        $this->form_validation->set_rules(
            'stok', 
            'Stok',
            'required|numeric', [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]);

        //konfigurasi sebelum gambar diupload
        $config['upload_path'] = './assets/img/upload/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = '3000';
        $config['max_width'] = '3000';
        $config['max_height'] = '3000';
        $config['file_name'] = 'img' . time();
        $this->load->library('upload', $config);
        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/index', $data);
            $this->load->view('templates/footer');
        } else {
            if ($this->upload->do_upload('image')) 
            {
                $image = $this->upload->data();
                $gambar = $image['file_name'];
            } else { $gambar = ''; }


            $data = [
                'judul_buku' => $this->input->post('judul_buku',true),
                'id_kategori' => $this->input->post('id_kategori',true),
                'pengarang' => $this->input->post('pengarang',true),
                'penerbit' => $this->input->post('penerbit', true),
                'tahun_terbit' => $this->input->post('tahun', true),
                'isbn' => $this->input->post('isbn', true),
                'stok' => $this->input->post('stok', true),
                'dipinjam' => 0,
                'dibooking' => 0,
                'image' => $gambar
            ];
            $this->ModelBuku->simpanBuku($data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Berhasil Menambahkan Buku Baru</div>');
            redirect('buku');
        }
    }

    // Fungsi Update Buku


    public function ubahBuku()
    {
        $data['judul'] = 'Ubah Data Buku';
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array();
        $data['buku'] = $this->ModelBuku->bukuWhere(['id' => $this->uri->segment(3)])->row_array();
        $kategori = $this->ModelBuku->joinKategoriBuku(['buku.id' => $this->uri->segment(3)])->result_array();
        
        foreach ($kategori as $k) 
        {
            $data['id'] = $k['id_kategori'];
            $data['k'] = $k['kategori'];
        }
        
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();


        $this->form_validation->set_rules(
            'judul_buku', 
            'Judul Buku', 
            'required|min_length[13]', [
                'required' => 'Judul Buku Harus diisi',
                'min_length' => 'Judul buku terlalu pendek'
            ]);

        $this->form_validation->set_rules(
            'pengarang', 
            'Pengarang', 
            'required|min_length[5]', [
                'required' => 'Nama Pengarang Harus diisi',
                'min_length' => 'Nama Pengarang terlalu pendek'
            ]);

        $this->form_validation->set_rules(
            'penerbit', 
            'Penerbit', 
            'required|min_length[5]', [
                'required' => 'Nama Penerbit Harus diisi',
                'min_length' => 'Nama Penerbit terlalu pendek'
            ]);

        $this->form_validation->set_rules(
            'tahun_terbit', 
            'Tahun Terbit',
            'required|min_length[3]|max_length[4]|numeric', [
                'required' => 'Tahun terbit harus diisi',
                'min_length' => 'Tahun terbit terlalu pendek',
                'max_length' => 'Tahun terbit terlalu panjang',
                'numeric' => 'Hanya boleh diisi angka'
            ]);
        $this->form_validation->set_rules(
            'isbn',
            'Nomor ISBN',
            'required|min_length[3]|numeric', [
                'required' => 'Nama ISBN harus diisi',
                'min_length' => 'Nama ISBN terlalu pendek',
                'numeric' => 'Yang anda masukan bukan angka'
            ]);
        $this->form_validation->set_rules(
            'stok', 
            'Stok',
            'required|numeric', [
                'required' => 'Stok harus diisi',
                'numeric' => 'Yang anda masukan bukan angka'
            ]);

        if ($this->form_validation->run() == false) 
        {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('buku/ubah_buku', $data);
            $this->load->view('templates/footer');
        } else {
            $judulbuku = $this->input->post('judul_buku', true);
            $id_buku = $this->input->post('no_buku', true);
            $pengarang = $this->input->post('pengarang', true);
            $penerbit = $this->input->post('penerbit', true);
            $tahun = $this->input->post('tahun_terbit', true);
            $isbn = $this->input->post('isbn', true);
            $stok = $this->input->post('stok', true);

            //jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            //Cek kalau image exist
            if ($upload_image) 
            {
                //Eksekusi script
                $config['upload_path'] = './assets/img/upload/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '3000';
                $config['max_width'] = '3000';
                $config['max_height'] = '3000';
                $config['file_name'] = 'pro' . time();
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) 
                {
                    $gambar_lama = $data['buku']['image'];

                    if ($gambar_lama != 'default.jpg') { unlink(FCPATH . 'assets/img/upload/' .$gambar_lama); }

                    $gambar_baru = $this->upload->data('file_name');
                    $this->db->set('image', $gambar_baru);
                } else { }
            }

            $this->db->set('judul_buku', $judulbuku);
            $this->db->set('pengarang', $pengarang);
            $this->db->set('penerbit', $penerbit);
            $this->db->set('tahun_terbit', $tahun);
            $this->db->set('isbn', $isbn);
            $this->db->set('stok', $stok);
            $this->db->where('id', $id_buku);
            $this->db->update('buku');
            $this->session->set_flashdata('pesan', '<div class="alert alert-success alert-message" role="alert">Berhasil Merubah Data Buku !</div>');
            redirect('buku');

        }


    }

    // Fungsi Hapus Buku
    public function hapusBuku()
    {
        $where = ['id' => $this->uri->segment(3)];
        $this->ModelBuku->hapusBuku($where);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-message" role="alert">Buku Telah dihapus !</div>');
        redirect('buku');
    }

}


