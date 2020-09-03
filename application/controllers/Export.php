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
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan,d.*');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            $this->db->join('dokumentasi_kegiatan as d', 'd.id_kegiatan=k.id_kegiatan', 'left');
            if ($kategroi == "mhs") {
                $this->db->where('l.id_lembaga', 0);
            } elseif ($kategroi == "lbg") {
                $this->db->where_not_in('l.id_lembaga', 0);
            }
            $this->db->where('periode', $periode);
            $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
            $data['kegiatan'] = $this->db->get()->result_array();
        } else {
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan,d.*');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            $this->db->join('dokumentasi_kegiatan as d', 'd.id_kegiatan=k.id_kegiatan', 'left');
            if ($kategroi == "mhs") {
                $this->db->where('l.id_lembaga', 0);
            } elseif ($kategroi == "lbg") {
                $this->db->where_not_in('l.id_lembaga', 0);
            }
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
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Penanggung Jawab');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Nomor Whatsapp');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Tahun Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Nama Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Nama Penyelenggara');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'URL Penyelenggara');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Tingkat Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Deskripsi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Tanggal Pengajuan Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Tanggal Mulai Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Tanggal Selesai Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Status Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Anggaran Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Dana Penerimaan Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Lokasi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Laporan Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Berita Proposal');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Gambar Kegiatan 1 / Acara Pendukung');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'Gambar Kegiatan 2 / Acara Pendukung');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(40);

        $objPHPExcel->getActiveSheet()->getStyle('A1:V' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:V1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;

        foreach ($data['kegiatan'] as $r) {
            $status = '';
            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $r['nama_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $r['id_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $baris, '' . $r['nama_penanggung_jawab']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $baris, '' . $r['no_whatsup']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $baris, '' . $r['periode']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $baris, '' . $r['nama_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $baris, '' . $r['nama_penyelenggara']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $baris, '' . $r['url_penyelenggara']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $baris, '' . $r['nama_tingkatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $baris, '' . $r['deskripsi_kegiatan']);

            $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $baris, '' . date("d/m/Y", strtotime($r['tgl_pengajuan_proposal'])));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $baris, '' . date("d/m/Y", strtotime($r['tanggal_kegiatan'])));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $baris, '' . date("d/m/Y", strtotime($r['tanggal_selesai_kegiatan'])));

            if ($r['status_selesai_proposal'] == 0) {
                $status = 'Belum diproses';
            } elseif ($r['status_selesai_proposal'] == 1) {
                $status = 'Sedang berlangsung';
            } elseif ($r['status_selesai_proposal'] == 2) {
                $status = 'Revisi';
            } elseif ($r['status_selesai_proposal'] == 3) {
                $status = 'Selesai';
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $baris, '' . $status);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $baris, '' . $r['dana_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $baris, '' . $r['dana_proposal']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . $baris, '' . $r['lokasi_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $baris, '' . base_url('file_bukti/proposal/' .  $r['proposal_kegiatan']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $baris, '' . base_url('file_bukti/berita_proposal/' .  $r['berita_proposal']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('U' . $baris, '' . base_url('file_bukti/foto_proposal/' .  $r['d_proposal_1']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('V' . $baris, '' . base_url('file_bukti/foto_proposal/' .  $r['d_proposal_2']));
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
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan,d.*');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            $this->db->join('dokumentasi_kegiatan as d', 'd.id_kegiatan=k.id_kegiatan', 'left');
            if ($kategroi == "mhs") {
                $this->db->where('l.id_lembaga', 0);
            } elseif ($kategroi == "lbg") {
                $this->db->where_not_in('l.id_lembaga', 0);
            }
            $this->db->where('periode', $periode);
            $this->db->where('status_selesai_proposal', 3);
            $this->db->order_by('k.status_selesai_proposal ASC, k.status_selesai_lpj ASC');
            $data['kegiatan'] = $this->db->get()->result_array();
        } else {
            $this->db->select('k.*,l.nama_lembaga,t.nama_tingkatan,d.*');
            $this->db->from('kegiatan as k');
            $this->db->join('lembaga as l', 'l.id_lembaga=k.id_lembaga', 'left');
            $this->db->join('tingkatan as t', 't.id_tingkatan=k.id_tingkatan', 'left');
            $this->db->join('dokumentasi_kegiatan as d', 'd.id_kegiatan=k.id_kegiatan', 'left');
            $this->db->where('status_selesai_proposal', 3);
            if ($kategroi == "mhs") {
                $this->db->where('l.id_lembaga', 0);
            } elseif ($kategroi == "lbg") {
                $this->db->where_not_in('l.id_lembaga', 0);
            }
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

        $objPHPExcel->setActiveSheetIndex()->setTitle("Daftar Proposal Kegiatan");
        $objPHPExcel->setActiveSheetIndex()->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('B1', 'Nama Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('C1', 'ID Lembaga');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('D1', 'Penanggung Jawab');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('E1', 'Nomor Whatsapp');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('F1', 'Tahun Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('G1', 'Nama Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('H1', 'Nama Penyelenggara');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('I1', 'URL Penyelenggara');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('J1', 'Tingkat Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('K1', 'Deskripsi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('L1', 'Tanggal Pengajuan LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('M1', 'Tanggal Mulai Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('N1', 'Tanggal Selesai Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('O1', 'Status LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('P1', 'Anggaran Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('Q1', 'Dana Penerimaan LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('R1', 'Lokasi Kegiatan');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('S1', 'Laporan LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('T1', 'Berita LPJ');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('U1', 'Gambar Kegiatan 1 LPJ / Acara Pendukung');
        $objPHPExcel->setActiveSheetIndex()->setCellValue('V1', 'Gambar Kegiatan 2 LPJ / Acara Pendukung');

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(40);

        $objPHPExcel->getActiveSheet()->getStyle('A1:V' . $jumlah_data)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:V1")->getFont()->setBold(true);
        $no = 1;
        $baris = 2;

        foreach ($data['kegiatan'] as $r) {
            $status = '';
            $objPHPExcel->setActiveSheetIndex()->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('B' . $baris, '' . $r['nama_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('C' . $baris, '' . $r['id_lembaga']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('D' . $baris, '' . $r['nama_penanggung_jawab']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('E' . $baris, '' . $r['no_whatsup']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('F' . $baris, '' . $r['periode']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('G' . $baris, '' . $r['nama_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('H' . $baris, '' . $r['nama_penyelenggara']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('I' . $baris, '' . $r['url_penyelenggara']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('J' . $baris, '' . $r['nama_tingkatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('K' . $baris, '' . $r['deskripsi_kegiatan']);

            $objPHPExcel->setActiveSheetIndex()->setCellValue('L' . $baris, '' . date("d/m/Y", strtotime($r['tgl_pengajuan_lpj'])));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('M' . $baris, '' . date("d/m/Y", strtotime($r['tanggal_kegiatan'])));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('N' . $baris, '' . date("d/m/Y", strtotime($r['tanggal_selesai_kegiatan'])));

            if ($r['status_selesai_lpj'] == 0) {
                $status = 'Belum diproses';
            } elseif ($r['status_selesai_lpj'] == 1) {
                $status = 'Sedang berlangsung';
            } elseif ($r['status_selesai_lpj'] == 2) {
                $status = 'Revisi';
            } elseif ($r['status_selesai_lpj'] == 3) {
                $status = 'Selesai';
            }
            $objPHPExcel->setActiveSheetIndex()->setCellValue('O' . $baris, '' . $status);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('P' . $baris, '' . $r['dana_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('Q' . $baris, '' . $r['dana_lpj']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('R' . $baris, '' . $r['lokasi_kegiatan']);
            $objPHPExcel->setActiveSheetIndex()->setCellValue('S' . $baris, '' . base_url('file_bukti/lpj/' .  $r['lpj_kegiatan']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('T' . $baris, '' . base_url('file_bukti/berita_lpj/' .  $r['berita_pelaporan']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('U' . $baris, '' . base_url('file_bukti/foto_lpj/' .  $r['d_lpj_1']));
            $objPHPExcel->setActiveSheetIndex()->setCellValue('V' . $baris, '' . base_url('file_bukti/foto_lpj/' .  $r['d_lpj_2']));
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
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('H1', 'Tanggal Mulai Pelaksanaan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('I1', 'Tanggal Selesai Pelaksanaan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('J1', 'Tempat Pelaksanaan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('K1', 'Bidang Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('L1', 'Jenis Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('M1', 'Tingkatan Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('N1', 'Prestasi Kegiatan');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('O1', 'Bobot');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('P1', 'Nilai Bobot');
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('Q1', 'Bukti');

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(32);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
                $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(30);


                $objPHPExcel->getActiveSheet()->getStyle('A1:Q' . $jumlah_data)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->getFont()->setBold(true);
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
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('I' . $baris, '' . date("d/m/Y", strtotime($r['tgl_selesai_pelaksanaan'])));
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('J' . $baris, '' . $r['tempat_pelaksanaan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('K' . $baris, '' . $r['nama_bidang']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('L' . $baris, '' . $r['jenis_kegiatan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('M' . $baris, '' . $r['nama_tingkatan']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('N' . $baris, '' . $r['nama_prestasi']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('O' . $baris, '' . $r['bobot'] . ' x ' . $r['nilai_bobot']);
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('P' . $baris, '' . ($r['nilai_bobot'] * $r['bobot']));
                    $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('Q' . $baris, '' . base_url($r['file_bukti']));
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
                $objPHPExcel->setActiveSheetIndex($work_sheet)->setCellValue('F1', 'Total Poin skp');
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
        $this->load->model('Model_poinskp', 'poinskp');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        $data['prestasi'] = [];
        $prestasi = $this->db->get('prestasi')->result_array();
        for ($i = 0; $i < count($prestasi); $i++) {
            $data['prestasi'][$i] = [
                'id_prestasi' => $prestasi[$i]['id_prestasi'],
                'nama_prestasi' => $prestasi[$i]['nama_prestasi'],
                'jumlah' => 0
            ];
        }
        if ($start_date != "" && $end_date != "") {
            $data['start_date'] = $start_date;
            $data['end_date'] = $end_date;
        } else {
            $data['start_date'] = "";
            $data['end_date'] = "";
        }

        $gPrestasi = $this->poinskp->getSemuaPrestasByRange($start_date, $end_date);

        foreach ($gPrestasi as $p) {
            for ($i = 0; $i < count($data['prestasi']); $i++) {
                if ($data['prestasi'][$i]['id_prestasi'] == $p['id_prestasi']) {
                    $data['prestasi'][$i] = [
                        'id_prestasi' => $p['id_prestasi'],
                        'nama_prestasi' => $p['nama_prestasi'],
                        'jumlah' => intval($p['jumlah'])

                    ];
                }
            }
        }

        $jumlah_data = count($data['prestasi']) + 1;

        $prestasi = [];
        $i  = 0;
        foreach ($data['prestasi'] as $p) {
            $temp = 0;
            $temp =  $this->_getRekapitulasiSKP($p['id_prestasi'], $start_date, $end_date);
            if ($temp != null) {
                $prestasi[$i++] = $temp;
            }
        }

        $jumlah_prestasi = 0;
        foreach ($prestasi as $pew) {
            $temp = 0;
            foreach ($pew as $re) {
                $temp++;
            }
            $jumlah_prestasi += $temp;
        }



        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),

        );

        $indek = 0;

        while ($indek < 2) {
            if ($indek == 0) {
                $objPHPExcel->setActiveSheetIndex($indek)->setTitle("Rekapitulasi Prestasi SKP");
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A1', 'No');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B1', 'Prestasi');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C1', 'Jumlah');



                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);



                $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $jumlah_data)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
                $no = 1;
                $baris = 2;

                foreach ($data['prestasi'] as $r) {

                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . $baris, '' . $no);
                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B' . $baris, '' . $r['nama_prestasi']);
                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C' . $baris, '' . $r['jumlah']);

                    $baris++;
                    $no++;
                }
                $indek++;
                $objPHPExcel->createSheet($indek);
            } else {
                $objPHPExcel->setActiveSheetIndex($indek)->setTitle("Detail Prestasi SKP");
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A1', 'No');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B1', 'Nim');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C1', 'Nama');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('D1', 'Prodi');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('E1', 'Jurusan');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('F1', 'Prestasi');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('G1', 'Kegiatan');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('H1', 'Link Bukti');

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(72);

                $objPHPExcel->getActiveSheet()->getStyle('A1:H' . ($jumlah_prestasi + 1))->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setBold(true);
                $no = 1;
                $baris = 2;

                foreach ($prestasi as $p) {
                    foreach ($p as $r) {
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . $baris, '' . $no);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B' . $baris, '' . $r['nim']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C' . $baris, '' . $r['nama']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('D' . $baris, '' . $r['nama_prodi']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('E' . $baris, '' . $r['nama_jurusan']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('F' . $baris, '' . $r['nama_prestasi']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('G' . $baris, '' . $r['nama_kegiatan']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('H' . $baris, '' . base_url($r['file_bukti']));
                        $baris++;
                        $no++;
                    }
                }
                $indek++;
                $objPHPExcel->createSheet($indek);
            }
        }

        $filename = 'reakpitulasi-skp' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    public function exportRekapitulasiTingkatan()
    {
        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");


        $this->load->model('Model_poinskp', 'poinskp');
        // mengambil data tingkatan
        $tahun = "";
        if ($this->input->get('tahun')) {
            $tahun = $this->input->get('tahun');
        }

        $tingkatan = $this->poinskp->getDataTingkatan($tahun);

        $data = [];
        foreach ($tingkatan as $t) {
            $temp = [];
            $temp = $this->_getRekapTingkatanSKP($t['id_tingkatan'], $tahun);
            if ($temp) {
                $data[$t['id_tingkatan']] = $temp;
            }
        }

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),

        );



        $jumlah_tingkatan = count($tingkatan) + 1;

        $jum = 0;
        foreach ($data as $d) {
            $jtemp = 0;
            foreach ($d as $r) {
                $jtemp++;
            }
            $jum += $jtemp;
        }

        $indek = 0;

        while ($indek < 2) {
            if ($indek == 0) {
                $objPHPExcel->setActiveSheetIndex($indek)->setTitle("Rekapitulasi Tingkatan SKP");
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A1', 'No');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B1', 'Tingkatan');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C1', 'Jumlah');



                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);



                $objPHPExcel->getActiveSheet()->getStyle('A1:C' . $jumlah_tingkatan)->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
                $no = 1;
                $baris = 2;

                foreach ($tingkatan as $r) {

                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . $baris, '' . $no);
                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B' . $baris, '' . $r['nama_tingkatan']);
                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C' . $baris, '' . $r['jumlah']);

                    $baris++;
                    $no++;
                }
                $indek++;
                $objPHPExcel->createSheet($indek);
            } else {
                $objPHPExcel->setActiveSheetIndex($indek)->setTitle("Detail Tingkatan SKP");
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A1', 'No');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B1', 'Nim');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C1', 'Nama');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('D1', 'Prodi');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('E1', 'Jurusan');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('F1', 'Tingkatan');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('G1', 'Kegiatan');
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('H1', 'Link Bukti');

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(72);

                $objPHPExcel->getActiveSheet()->getStyle('A1:H' . ($jum + 1))->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->getFont()->setBold(true);
                $no = 1;
                $baris = 2;

                foreach ($data as $t) {
                    foreach ($t as $r) {
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . $baris, '' . $no);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B' . $baris, '' . $r['nim']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C' . $baris, '' . $r['nama']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('D' . $baris, '' . $r['nama_prodi']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('E' . $baris, '' . $r['nama_jurusan']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('F' . $baris, '' . $r['nama_tingkatan']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('G' . $baris, '' . $r['nama_kegiatan']);
                        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('H' . $baris, '' . base_url($r['file_bukti']));
                        $baris++;
                        $no++;
                    }
                }
                $indek++;
                $objPHPExcel->createSheet($indek);
            }
        }

        $filename = 'reakpitulasi-tingkatan-skp' . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    public function exportSerapanKegiatan()
    {
        $lembaga = $this->db->get('lembaga')->result_array();
        $kegiatan = $this->db->get('kegiatan')->result_array();
        $non_delegasi = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();
        $tahun = $this->input->get_post('tahun');
        $json = file_get_contents(base_url('API_skp/laporanSerapan/' . $tahun));
        $data = json_decode($json, true);
        $total = $this->_totalDana($data);
        $temp = [];
        foreach ($lembaga as $l) {
            $detail = [];
            $json2 = file_get_contents(base_url('API_skp/detaillaporanSerapan?tahun=' . $tahun . '&&id_lembaga=' . $l['id_lembaga']));
            $detail = json_decode($json2, true);

            $temp[$l['id_lembaga']]['kegiatan'] = $detail['kegiatan'];
            $temp[$l['id_lembaga']]['laporan'] = $detail['laporan'];
            $temp[$l['id_lembaga']]['total'] = $detail['total']['total'];
        }

        // var_dump($non_delegasi);
        // var_dump($data);
        // echo 'cekkk';
        // var_dump($temp[0]);
        // echo 'cekkk';
        // var_dump($total);
        // die;

        include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("creater");
        $objPHPExcel->getProperties()->setLastModifiedBy("Middle field");
        $objPHPExcel->getProperties()->setSubject("Subject");

        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),

        );

        $styleCenter = array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $bulan = ['C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N'];

        $indek = 0;

        $jumlah_data2 = count($non_delegasi) + 2;
        $objPHPExcel->setActiveSheetIndex($indek)->setTitle('Rekapitulasi Serapan Lembaga');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A1', 'No');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B1', 'Nama Lembaga');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C1', 'Bulan');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C2', 'Januari');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('D2', 'Febuari');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('E2', 'Maret');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('F2', 'April');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('G2', 'Mei');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('H2', 'Juni');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('I2', 'Juli');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('J2', 'Agustus');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('K2', 'September');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('L2', 'Oktober');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('M2', 'November');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('N2', 'Desember');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('O1', 'Dana Pagu');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P1', 'Jumlah Terserap');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('R1', 'Sisa');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P2', 'Rp');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('Q2', '%');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('R2', 'Rp');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('S2', '%');
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . ($jumlah_data2 + 1), 'Total');

        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('A1:A2');
        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('B1:B2');
        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('C1:N1');
        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('O1:O2');
        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('P1:Q1');
        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('R1:S1');
        $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('A' . ($jumlah_data2 + 1) . ':N' . ($jumlah_data2 + 1));


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);

        $objPHPExcel->getActiveSheet()->getStyle('A1:S' . ($jumlah_data2 + 1))->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle("A1:S2")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:S2")->applyFromArray($styleCenter);
        $objPHPExcel->getActiveSheet()->getStyle("A" . ($jumlah_data2 + 1))->applyFromArray($styleCenter);
        $objPHPExcel->getActiveSheet()->getStyle("A" . ($jumlah_data2 + 1))->getFont()->setBold(true);
        $no = 1;
        $baris = 3;


        foreach ($non_delegasi as $lbg) {
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . $baris, '' . $no);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B' . $baris, '' . $data[$lbg['id_lembaga']]['nama_lembaga']);

            for ($i = 1; $i < 13; $i++) {
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue($bulan[$i - 1] . $baris, '' . $data[$lbg['id_lembaga']][$i]);
            }
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('O' . $baris, '' . $data[$lbg['id_lembaga']]['dana_pagu']);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P' . $baris, '' . $data[$lbg['id_lembaga']]['dana_terserap']);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('Q' . $baris, '' . $data[$lbg['id_lembaga']]['terserap_persen']);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('R' . $baris, '' . $data[$lbg['id_lembaga']]['dana_sisa']);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('S' . $baris, '' . $data[$lbg['id_lembaga']]['sisa_terserap']);
            $baris++;
            $no++;
        }

        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('O' . ($jumlah_data2 + 1), '' . $total['total']['dana_pagu']);
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P' . ($jumlah_data2 + 1), '' . $total['total']['dana_terserap']);
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('Q' . ($jumlah_data2 + 1), '' . $total['total']['persen_terserap']);
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('R' . ($jumlah_data2 + 1), '' . $total['total']['dana_sisa']);
        $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('S' . ($jumlah_data2 + 1), '' . $total['total']['persen_sisa']);

        $indek++;
        $objPHPExcel->createSheet($indek);

        foreach ($lembaga as $l) {
            $jumlah_data = count($temp[$l['id_lembaga']]['kegiatan']) + 2;
            $objPHPExcel->setActiveSheetIndex($indek)->setTitle($l['nama_lembaga']);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A1', 'No');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B1', 'Nama Kegiatan');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C1', 'Bulan');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('C2', 'Januari');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('D2', 'Febuari');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('E2', 'Maret');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('F2', 'April');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('G2', 'Mei');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('H2', 'Juni');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('I2', 'Juli');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('J2', 'Agustus');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('K2', 'September');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('L2', 'Oktober');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('M2', 'November');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('N2', 'Desember');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('O1', 'Dana Pagu');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P1', 'Anggaran Terserap');
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . ($jumlah_data + 1), 'Total');

            $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('A1:A2');
            $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('B1:B2');
            $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('C1:N1');
            $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('O1:O2');
            $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('P1:P2');
            $objPHPExcel->setActiveSheetIndex($indek)->mergeCells('A' . ($jumlah_data + 1) . ':N' . ($jumlah_data + 1));


            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);


            $objPHPExcel->getActiveSheet()->getStyle('A1:P' . ($jumlah_data + 1))->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("A1:P2")->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:P2")->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle("A" . ($jumlah_data + 1))->applyFromArray($styleCenter);
            $objPHPExcel->getActiveSheet()->getStyle("A" . ($jumlah_data + 1))->getFont()->setBold(true);
            $no = 1;
            $baris = 3;

            foreach ($temp[$l['id_lembaga']]['kegiatan'] as $k) {
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('A' . $baris, '' . $no);
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('B' . $baris, '' . $k['nama_kegiatan']);

                for ($i = 1; $i < 13; $i++) {
                    $objPHPExcel->setActiveSheetIndex($indek)->setCellValue($bulan[$i - 1] . $baris, '' . $temp[$l['id_lembaga']]['laporan'][$k['id_kegiatan']][$i]);
                }
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('O' . $baris, '' . $temp[$l['id_lembaga']]['laporan'][$k['id_kegiatan']]['anggaran_kegiatan']);
                $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P' . $baris, '' . $temp[$l['id_lembaga']]['laporan'][$k['id_kegiatan']]['dana_terserap']);
                $baris++;
                $no++;
            }
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('O' . ($jumlah_data + 1), '' . $temp[$l['id_lembaga']]['total']['anggaran_kegiatan']);
            $objPHPExcel->setActiveSheetIndex($indek)->setCellValue('P' . ($jumlah_data + 1), '' . $temp[$l['id_lembaga']]['total']['dana_terserap']);
            $indek++;
            $objPHPExcel->createSheet($indek);
        }

        $filename = 'daftar-laporan-serapan-' . $tahun . '.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cach

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    private function _totalDana($laporan)
    {

        $lembaga = $this->db->get_where('lembaga', ['id_lembaga !=' => 0])->result_array();
        $data['total']['dana_sisa'] = 0;
        $data['total']['dana_terserap'] = 0;
        $data['total']['dana_pagu'] = 0;
        $data['total']['persen_terserap'] = 0;
        $data['total']['persen_sisa'] = 0;
        foreach ($lembaga as $l) {
            $data['total']['dana_sisa'] += $laporan[$l['id_lembaga']]['dana_sisa'];
            $data['total']['dana_terserap'] += $laporan[$l['id_lembaga']]['dana_terserap'];
            $data['total']['dana_pagu'] += $laporan[$l['id_lembaga']]['dana_pagu'];
        }
        if ($data['total']['dana_pagu'] == 0) {
            $data['total']['persen_terserap'] = 0;
            $data['total']['persen_sisa'] = 0;
        } else {
            $data['total']['persen_terserap'] = $data['total']['dana_terserap'] / $data['total']['dana_pagu'] * 100;
            $data['total']['persen_sisa'] = $data['total']['dana_sisa'] / $data['total']['dana_pagu'] * 100;
        }

        return $data;
    }

    private function _getRekapitulasiSKP($id_prestasi, $start_date = null, $end_date = null)
    {

        $this->db->select('ps.*,sp.id_prestasi,p.nama_prestasi,m.nama,prodi.nama_prodi,jurusan.nama_jurusan');
        $this->db->from('poin_skp as ps');
        $this->db->join('semua_prestasi as sp', 'ps.prestasiid_prestasi=sp.id_semua_prestasi', 'left');
        $this->db->join('prestasi as p', 'p.id_prestasi=sp.id_prestasi', 'left');
        $this->db->join('mahasiswa as m', 'm.nim=ps.nim', 'left');
        $this->db->join('prodi', 'm.kode_prodi = prodi.kode_prodi', 'left');
        $this->db->join('jurusan', 'prodi.kode_jurusan = jurusan.kode_jurusan', 'left');
        if ($start_date != null && $end_date != null) {
            $this->db->where('ps.tgl_pelaksanaan >=', $start_date);
            $this->db->where('ps.tgl_pelaksanaan <=', $end_date);
        }
        $this->db->where('p.id_prestasi', $id_prestasi);
        $this->db->where('ps.validasi_prestasi', 1);
        $data['semua_tingkatan'] = $this->db->get()->result_array();
        return $data['semua_tingkatan'];
    }

    private function _getRekapTingkatanSKP($id, $tahun)
    {
        $this->load->model('Model_poinskp', 'poinskp');
        $tahun = $tahun;
        $id_tingkat = $id;
        $data = $this->poinskp->rekapTingkatan($id_tingkat, $tahun);
        return $data;
    }

    public function exportBeasiswa()
    {
    }
}
