<?php 
defined('BASEPATH') or exit('No Direct script access allowed'); 

class Laporan extends CI_Controller { 
    function __construct() { 
        parent::__construct(); 
    } 
    
    public function laporan_buku() { 
        $data['judul'] = 'Laporan Data Buku'; 
        $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array(); 
        $data['buku'] = $this->ModelBuku->getBuku()->result_array(); 
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array(); 
        $this->load->view('admin/header', $data); 
        $this->load->view('admin/sidebar', $data); 
        $this->load->view('admin/topbar', $data); 
        $this->load->view('buku/laporan_buku', $data); 
        $this->load->view('admin/footer'); 
    }
    public function cetak_laporan_buku(){
        $data['buku'] = $this->ModelBuku->getBuku()->result_array();
        $data['kategori'] = $this->ModelBuku->getKategori()->result_array();
        $this->load->view('buku/laporan_print_buku',$data);
    }
    public function laporan_buku_pdf()
    {
        $id_user = $this->session->userdata('id_user');  
        $data['buku'] = $this->ModelBuku->getBuku()->result_array(); 
        
        $this->load->view('buku/laporan_pdf_buku', $data); 
        $paper_size = 'A4'; 
        // ukuran kertas 
        $orientation = 'landscape';
        //tipe format kertas potrait atau landscape 
        $html = $this->output->get_output(); 

        $this->load->library('pdf');
        $this->pdf->generate($html, "Laporan Data Buku.pdf", $paper_size, $orientation);


/*
        $pdf = new DOMPDF();

        $pdf->setPaper($paper_size, $orientation);
        $pdf->loadHtml($html);
        $pdf->render();
        
        $pdf->stream("laporanbuku.pdf", [
            'Attachment' => 0
        ]);
        */
    }
     public function export_excel()
    {
        $data = array( 'title' => 'Laporan Buku','buku' => $this->ModelBuku->getBuku()->result_array());
        $this->load->view('buku/export_excel_buku', $data);
    }
    public function laporan_pinjam()
    { 
    $data['judul'] = 'Laporan Data Peminjaman'; 
    $data['user'] = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array(); 
    $data['laporan'] = $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array(); 
    $this->load->view('admin/header', $data); 
    $this->load->view('admin/sidebar', $data); 
    $this->load->view('admin/topbar', $data); 
    $this->load->view('pinjam/laporan-pinjam', $data);
    $this->load->view('admin/footer'); 
    }
    public function cetak_laporan_pinjam() 
    {
        $data['laporan'] = $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array();
        $this->load->view('pinjam/laporan-print-pinjam', $data); 
    }
    public function laporan_pinjam_pdf()
    { 
        
        $data['laporan'] = $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array();
        $this->load->view('pinjam/laporan-print-pinjam', $data);
        $paper_size = 'A4';
        $orientation = 'landscape'; 
        $html = $this->output->get_output();

        $this->load->library('pdf');
        $this->pdf->generate($html, "Laporan Data Peminjam.pdf", $paper_size, $orientation);
/*
        $pdf = new DOMPDF();

        $pdf->setPaper($set_paper, $orientation);
        $pdf->loadHtml($html);
        $pdf->render();

        $pdf->stream("laporan data peminjaman.pdf", [
            'Attachment' => 0
        ]);
        */
    } 
    public function export_excel_pinjam() 
    { 
        $data = array( 'title' => 'Laporan Data Peminjaman Buku', 'laporan' => $this->db->query("select * from pinjam p,detail_pinjam d, buku b,user u where d.id_buku=b.id and p.id_user=u.id and p.no_pinjam=d.no_pinjam")->result_array()); 
        $this->load->view('pinjam/export-excel-pinjam', $data); 
    }
    public function cetak_laporan_anggota()
    {
        $data['buku'] = $this->ModelUser->cekData()->result_array();
        $this->db->where('role_id', 2);
        $data['anggota'] = $this->db->get('user')->result_array();
        $this->load->view('user/laporan_print_anggota', $data);
    }
    public function laporan_anggota_pdf()
    {
        
        $data['buku'] = $this->ModelUser->cekData()->result_array();
        $this->db->where('role_id', 2);
        $data['anggota'] = $this->db->get('user')->result_array();
        $this->load->view('user/laporan_pdf_anggota', $data);
        $paper_size = 'A4'; // ukuran kertas 
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape 
        $html = $this->output->get_output();

        $this->load->library('pdf');
        $this->pdf->generate($html, "Laporan Data Anggota.pdf", $paper_size, $orientation);

        /*
        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF 
        $this->dompdf->load_html($html);
        $this->dompdf->render();
        $this->dompdf->stream("laporan data anggota.pdf", array('Attachment' => 0));
        // nama file pdf yang di hasilkan 
        */
    }
     public function export_excel_anggota()
    {
        $data = array(
            'title' => 'Laporan Data Anggota', 'anggota' => $data['anggota'] = $this->db->get('user')->result_array()
        );
        $this->db->where('role_id', 2);
        $this->load->view('user/export_excel_anggota', $data);
    }
}