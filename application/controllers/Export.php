<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Export to Excel multiple sheets with CI and Spout
 *
 * @author budy k
 *
 */

//load Spout Library
require_once APPPATH . '/third_party/spout/src/Spout/Autoloader/autoload.php';
//lets Use the Spout Namespaces
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Common\Type;
use Box\Spout\Writer\Style\StyleBuilder;

class Export extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }

    // Melakukan export data rancangan kegiatan
    public function exportRancanganKegiatan()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");

        $data['title'] = 'Validasi';
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');
        $this->load->model('Model_kegiatan', 'kegiatan');

        if ($this->input->get('tahun') != null || $this->input->get('lembaga') != null || $this->input->get('status') != null) {
            $tahun = $this->input->get('tahun');
            $lembaga = $this->input->get('lembaga');
            $status =  $this->input->get('status');
            $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan($tahun, $lembaga, $status);
        } else {
            $data['rancangan'] = $this->kemahasiswaan->getRekapRancangan();
        }

        $rancangan = [];
        foreach ($data['rancangan'] as $dr) {
            $rancangan[$dr['id_lembaga']] = $this->kemahasiswaan->detailRancangan($dr['id_lembaga'], $dr['tahun_pengajuan']);
        }
        $jumlah_data = 1;
        foreach ($rancangan as $rancangan_lembaga) {
            foreach ($rancangan_lembaga as $rl) {
                $jumlah_data++;
            }
        }
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $objPHPExcel->setActiveSheetIndex()->setTitle("Daftar Rancangan Kegiatan");
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Nama Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ID Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Tahun Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Nama Proker');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Tanggal Mulai Pelaksanaan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Tanggal Selesai Pelaksanaan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Anggaran Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Status Rancangan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Catatan Revisi');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle('A1:J' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;
        foreach ($rancangan as $rancangan_lembaga) {
            foreach ($rancangan_lembaga as $rl) {
                $status = '';
                $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $rl['nama_lembaga']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $rl['id_lembaga']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $baris, '' . $rl['tahun_kegiatan']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $baris, '' . $rl['nama_proker']);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $baris, '' . date("d/m/Y", strtotime($rl['tanggal_mulai_pelaksanaan'])));
                $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $baris, '' . date("d/m/Y", strtotime($rl['tanggal_selesai_pelaksanaan'])));
                $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $baris, '' . $rl['anggaran_kegiatan']);
                if ($rl['status_rancangan'] == 2) {
                    $status = 'Proses';
                } elseif ($rl['status_rancangan'] == 3) {
                    $status = 'Revisi';
                } elseif ($rl['status_rancangan'] == 0) {
                    $status = 'Baru Mengajukan';
                } elseif ($rl['status_rancangan'] == 1) {
                    $status = 'Telah Disetujui';
                } elseif ($rl['status_rancangan'] == 4) {
                    $status = 'Sedang Berlangsung';
                } elseif ($rl['status_rancangan'] == 5) {
                    $status = 'Telah Terlaksana';
                }
                $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $baris, '' . $status);
                $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $baris, '' . $rl['catatan_revisi']);
                $baris++;
                $no++;
            }
        }

        $filename = 'daftar-rancangan-kegiatan' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    public function exportProposalKegiatan()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");

        $periode = $this->input->get('tahun');
        $kategroi = $this->input->get('kategori');


        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');

        if ($periode != "kosong") {
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            if ($kategroi == "mhs") {
                $this->db->where('acc_rancangan', 0);
            } elseif ($kategroi == "lbg") {
                $this->db->where_not_in('acc_rancangan', 0);
            }
            $this->db->where('periode', $periode);
            $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
            $data['kegiatan'] = $this->db->get()->result_array();
        } else {
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
            $data['kegiatan'] = $this->db->get()->result_array();
        }

        // var_dump($data);
        // die;
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $jumlah_data = count($data['kegiatan']) + 1;

        $objPHPExcel->setActiveSheetIndex()->setTitle("Daftar Proposal Kegiatan");
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Nama Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ID Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Tahun Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Nama Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Tingkat Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Deskripsi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Tanggal Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Tanggal Pengajuan Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Status Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Penanggung Jawab');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Nomor Whatsup');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Anggaran Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Dana Penerimaan Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Lokasi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Laporan Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Berita Proposal');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle('A1:Q' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;

        foreach ($data['kegiatan'] as $r) {
            $status = '';
            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $r['nama_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $r['id_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $baris, '' . $r['periode']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $baris, '' . $r['nama_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $baris, '' . $r['nama_tingkatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $baris, '' . $r['deskripsi_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $baris, '' . date("d/m/Y", strtotime($r['tanggal_kegiatan'])));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $baris, '' . date("d/m/Y", strtotime($r['tgl_pengajuan_proposal'])));
            if ($r['status_selesai_proposal'] == 0) {
                $status = 'Belum diproses';
            } elseif ($r['status_selesai_proposal'] == 1) {
                $status = 'Sedang berlangsung';
            } elseif ($r['status_selesai_proposal'] == 2) {
                $status = 'Revisi';
            } elseif ($r['status_selesai_proposal'] == 3) {
                $status = 'Selesai';
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $baris, '' . $status);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $baris, '' . $r['nama_penanggung_jawab']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $baris, '' . $r['no_whatsup']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $baris, '' . $r['dana_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $baris, '' . $r['dana_proposal']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $baris, '' . $r['lokasi_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $baris, '' . base_url('file_bukti/proposal/' .  $r['proposal_kegiatan']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $baris, '' . base_url('file_bukti/berita_proposal/' .  $r['berita_proposal']));
            $baris++;
            $no++;
        }


        $filename = 'daftar-proposal-kegiatan' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportLpjKegiatan()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");

        $periode = $this->input->get('tahun');
        $kategroi = $this->input->get('kategori');

        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');

        if ($periode != "kosong") {
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            if ($kategroi == "mhs") {
                $this->db->where('acc_rancangan', 0);
            } elseif ($kategroi == "lbg") {
                $this->db->where_not_in('acc_rancangan', 0);
            }
            $this->db->where('periode', $periode);
            $this->db->where('status_selesai_proposal', 3);
            $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
            $data['kegiatan'] = $this->db->get()->result_array();
        } else {
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            $this->db->where('status_selesai_proposal', 3);
            $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
            $data['kegiatan'] = $this->db->get()->result_array();
        }


        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $jumlah_data = count($data['kegiatan']) + 1;

        $objPHPExcel->setActiveSheetIndex()->setTitle("Daftar LPJ Kegiatan");
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Nama Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ID Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Tahun Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Nama Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Tingkat Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Deskripsi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Tanggal Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Tanggal Pengajuan LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Status LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Penanggung Jawab');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Nomor Whatsup');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Anggaran Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Dana Penerimaan LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Lokasi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Laporan LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Berita LPJ');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);

        $objPHPExcel->getActiveSheet()->getStyle('A1:Q' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;

        foreach ($data['kegiatan'] as $r) {
            $status = '';
            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $r['nama_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $r['id_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $baris, '' . $r['periode']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $baris, '' . $r['nama_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $baris, '' . $r['nama_tingkatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $baris, '' . $r['deskripsi_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $baris, '' . date("d/m/Y", strtotime($r['tanggal_kegiatan'])));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $baris, '' . date("d/m/Y", strtotime($r['tgl_pengajuan_lpj'])));
            if ($r['status_selesai_lpj'] == 0) {
                $status = 'Belum proses';
            } elseif ($r['status_selesai_lpj'] == 1) {
                $status = 'Sedang berlangsung';
            } elseif ($r['status_selesai_lpj'] == 2) {
                $status = 'Revisi';
            } elseif ($r['status_selesai_lpj'] == 3) {
                $status = 'Selesai';
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $baris, '' . $status);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $baris, '' . $r['nama_penanggung_jawab']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $baris, '' . $r['no_whatsup']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $baris, '' . $r['dana_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $baris, '' . $r['dana_lpj']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $baris, '' . $r['lokasi_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $baris, '' . base_url('file_bukti/lpj/' .  $r['lpj_kegiatan']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $baris, '' . base_url('file_bukti/berita_lpj/' .  $r['berita_pelaporan']));
            $baris++;
            $no++;
        }


        $filename = 'daftar-lpj-kegiatan' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportPoinSkp()
    {

        $this->load->model('Model_mahasiswa', 'mhs');
        $start_date = $this->input->get('tgl_pengajuan_start');
        $end_date = $this->input->get('tgl_pengajuan_end');
        $this->db->select('poin_skp.*,mahasiswa.*,prodi.nama_prodi,jurusan.nama_jurusan,bobot, nama_prestasi, nama_tingkatan, jenis_kegiatan, nama_bidang, nama_dasar_penilaian');
        $this->db->from('poin_skp');
        $this->db->where('poin_skp.validasi_prestasi', 1);
        $this->db->join('semua_prestasi', 'poin_skp.prestasiid_prestasi = semua_prestasi.id_semua_prestasi');
        $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        $this->db->join('dasar_penilaian', 'semua_prestasi.id_dasar_penilaian = dasar_penilaian.id_dasar_penilaian');
        $this->db->join('semua_tingkatan', 'semua_prestasi.id_semua_tingkatan = semua_tingkatan.id_semua_tingkatan');
        $this->db->join('tingkatan', 'semua_tingkatan.id_tingkatan = tingkatan.id_tingkatan');
        $this->db->join('jenis_kegiatan', 'semua_tingkatan.id_jenis_kegiatan = jenis_kegiatan.id_jenis_kegiatan');
        $this->db->join('bidang_kegiatan', 'jenis_kegiatan.id_bidang = bidang_kegiatan.id_bidang');
        $this->db->join('mahasiswa', 'mahasiswa.nim = poin_skp.nim', 'left');
        $this->db->join('prodi', 'prodi.kode_prodi = mahasiswa.kode_prodi', 'left');
        $this->db->join('jurusan', 'jurusan.kode_jurusan = prodi.kode_jurusan', 'left');
        if ($start_date != null || $end_date != null) {
            $this->db->where('tgl_pelaksanaan >=', $start_date);
            $this->db->where('tgl_pelaksanaan <=', $end_date);
        }
        $this->db->order_by('mahasiswa.nim', 'ASC');
        $detail_skp = $this->db->get()->result_array();
        $mahasiswa = $this->mhs->getDataMahasiswa();

        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");
        $work_sheet_count = 2; //number of sheets you want to create

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $jumlah_data = count($detail_skp) + 1;

        for ($work_sheet = 0; $work_sheet < $work_sheet_count; $work_sheet++) {

            if ($work_sheet == 0) {
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setTitle("Daftar skp Mahasiswa");
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('A1', 'No');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('B1', 'Nim');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('C1', 'Nama Mahasiswa');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('D1', 'Jurusan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('E1', 'Prodi');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('F1', 'Nama Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('G1', 'Tanggal Pengajuan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('H1', 'Tanggal Pelaksanaan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('I1', 'Tempat Pelaksanaan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('J1', 'Bidang Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('K1', 'Jenis Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('L1', 'Tingkatan Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('M1', 'Prestasi Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('N1', 'Bobot');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('O1', 'Bukti');

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);


                $objPHPExcel->getActiveSheet()->getStyle('A1:O' . $jumlah_data)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:O1")->getFont()->setBold(true);
                $no = 1;
                $baris = 2;

                foreach ($detail_skp as $r) {
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('A' . $baris, '' . $no);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('B' . $baris, '' . $r['nim']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('C' . $baris, '' . $r['nama']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('D' . $baris, '' . $r['nama_jurusan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('E' . $baris, '' . $r['nama_prodi']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('F' . $baris, '' . $r['nama_kegiatan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('G' . $baris, '' . date("d/m/Y", strtotime($r['tgl_pengajuan'])));
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('H' . $baris, '' . date("d/m/Y", strtotime($r['tgl_pelaksanaan'])));
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('I' . $baris, '' . $r['tempat_pelaksanaan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('J' . $baris, '' . $r['nama_bidang']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('K' . $baris, '' . $r['jenis_kegiatan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('L' . $baris, '' . $r['nama_tingkatan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('M' . $baris, '' . $r['nama_prestasi']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('N' . $baris, '' . $r['bobot']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('O' . $baris, '' . base_url($r['file_bukti']));
                    $baris++;
                    $no++;
                }
            } else {
                $objWorkSheet = $objPHPExcel->createSheet($work_sheet_count);
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setTitle("Rekap Poin skp Mahasiswa");
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('A1', 'No');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('B1', 'Nim');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('C1', 'Nama Mahasiswa');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('D1', 'Jurusan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('E1', 'Prodi');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('F1', 'Poin skp');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('G1', 'Kategori');


                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);


                $objPHPExcel->getActiveSheet()->getStyle('A1:G' . $jumlah_data)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:G1")->getFont()->setBold(true);
                $no = 1;
                $baris = 2;

                foreach ($mahasiswa as $r) {
                    $kategori = '';
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('A' . $baris, '' . $no);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('B' . $baris, '' . $r['nim']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('C' . $baris, '' . $r['nama']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('D' . $baris, '' . $r['nama_jurusan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('E' . $baris, '' . $r['nama_prodi']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('F' . $baris, '' . $r['total_poin_skp']);

                    if ($r['total_poin_skp'] > 300) {
                        $kategori = "Dengan Pujian";
                    } elseif ($r['total_poin_skp'] <= 300 && $r['total_poin_skp'] >= 201) {
                        $kategori = 'Sangat Baik';
                    } elseif ($r['total_poin_skp'] <= 200 && $r['total_poin_skp'] >= 151) {
                        $kategori = 'Baik';
                    } elseif ($r['total_poin_skp'] <= 150 && $r['total_poin_skp'] >= 100) {
                        $kategori = 'Cukup';
                    } else {
                        $kategori = 'kurang';
                    }
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('G' . $baris, '' . $kategori);
                    $baris++;
                    $no++;
                }
            }
        }


        $filename = 'daftar-poin-skp' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportDaftarKuliahTamu()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");

        $start_date = $this->input->get('tgl_pengajuan_start');
        $end_date = $this->input->get('tgl_pengajuan_end');

        $this->load->model('Model_kegiatan', 'kegiatan');
        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');

        $this->db->select('*');
        $this->db->from('kuliah_tamu');
        if ($start_date != null || $end_date != null) {
            $this->db->where('tanggal_event >=', $start_date);
            $this->db->where('tanggal_event <=', $end_date);
        }
        $this->db->order_by('id_kuliah_tamu', 'ASC');
        $kuliah_tamu = $this->db->get()->result_array();

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $jumlah_data = count($kuliah_tamu) + 1;

        $objPHPExcel->setActiveSheetIndex()->setTitle("Daftar Kuliah Tamu");
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Tanggal Event');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Nama Event');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Deskripsi');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Lokasi');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Waktu Mulai');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Waktu Selesai');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Pemateri');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'Status');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Kode QR');


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);


        $objPHPExcel->getActiveSheet()->getStyle('A1:J' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;

        foreach ($kuliah_tamu as $r) {
            $kategori = '';
            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $r['tanggal_event']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $r['nama_event']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $baris, '' . $r['deskripsi']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $baris, '' . $r['lokasi']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $baris, '' . $r['waktu_mulai']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $baris, '' . $r['waktu_selesai']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $baris, '' . $r['pemateri']);

            if ($r['status_terlaksana'] == 0) {
                $kategori = "Dengan Pujian";
            } elseif ($r['status_terlaksana'] == 1) {
                $kategori = 'Telah Terlaksana';
            } else {
                $kategori = 'Sedang Berlangsung';
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $baris, '' . $kategori);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $baris, '' . base_url('assets/qrcode/kuliah_tamu_' . $r['kode_qr'] . '.png'));
            $baris++;
            $no++;
        }
        $filename = 'daftar-kuliah-tamu' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportRekapitulasiSKP()
    {

        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");


        $data['prestasi'] = $this->db->get('prestasi')->result_array();

        $this->load->model('Model_kemahasiswaan', 'kemahasiswaan');

        $tahun = "";
        if ($this->input->get('tahun')) {
            $tahun = $this->input->get('tahun');
        }
        $data['tahun'] = $tahun;
        for ($i = 0; $i < count($data['prestasi']); $i++) {
            $id_prestasi = intval($data['prestasi'][$i]['id_prestasi']);
            $count = 0;
            $semua_prestasi = $this->db->get_where('semua_prestasi', ['id_prestasi' => $id_prestasi])->result_array();
            for ($j = 0; $j < count($semua_prestasi); $j++) {
                $id_semua_prestasi = intval($semua_prestasi[$j]['id_semua_prestasi']);
                $this->db->select('id_poin_skp, YEAR(tgl_pelaksanaan) as tahun');
                $this->db->where('prestasiid_prestasi', $id_semua_prestasi);
                $this->db->where('validasi_prestasi', 1);
                $mahasiswa = $this->db->get('poin_skp')->result_array();

                // $count += count($mahasiswa);

                // Hitung sesuai tahun
                $count_temp = count($mahasiswa);
                if ($count_temp != 0) {
                    if ($tahun != "") {
                        for ($k = 0; $k < $count_temp; $k++) {
                            if (intval($mahasiswa[$k]['tahun']) == $tahun) {
                                $count += 1;
                            }
                        }
                    } else {
                        $count += $count_temp;
                    }
                }
            }
            $data['prestasi'][$i]['jumlah'] = $count;
        }


        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $jumlah_data = count($data['prestasi']) + 1;


        $objPHPExcel->setActiveSheetIndex()->setTitle("Rekapitulasi SKP");
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Prestasi');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'Jumlah');



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);



        $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;

        foreach ($data['prestasi'] as $r) {

            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $r['nama_prestasi']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $r['jumlah']);

            $baris++;
            $no++;
        }
        $filename = 'reakpitulasi-skp' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    public function exportDaftarAnggota()
    {

        // $this->db->select('');

        // $lembaga = $this->db->get;
        // $this->db->where('id_pengajuan_anggota_lembaga', intval($id));
        // $this->db->from('daftar_anggota_lembaga');
        // $this->db->join('mahasiswa', 'daftar_anggota_lembaga.nim = mahasiswa.nim');
        // $this->db->join('semua_prestasi', 'daftar_anggota_lembaga.id_sm_prestasi = semua_prestasi.id_semua_prestasi');
        // $this->db->join('prestasi', 'semua_prestasi.id_prestasi = prestasi.id_prestasi');
        // $anggota_lembaga = $this->db->get()->result_array();
        // echo json_encode($anggota_lembaga);
    }
}
