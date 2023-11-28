<?php
// memanggil library FPDF
require('fpdf/fpdf.php');
$connection = new Mysqli("localhost", "root", "", "bsw_backup");

// intance object dan memberikan pengaturan halaman PDF



class Pdf extends FPDF

{

    function letak($gambar)

    {

        //memasukkan gambar untuk header

        $this->Image($gambar, 10, 10, 25, 25);


        //menggeser posisi sekarang

    }

    function judul($teks1, $teks2, $teks3, $teks4, $teks5)

    {

        $this->Cell(25);

        $this->SetFont('Times', 'B', '12');

        $this->Cell(0, 5, $teks1, 0, 1, 'C');

        $this->Cell(25);

        $this->Cell(0, 5, $teks2, 0, 1, 'C');

        $this->Cell(25);

        $this->SetFont('Times', 'B', '12');

        $this->Cell(0, 5, $teks3, 0, 1, 'C');

        $this->Cell(25);

        $this->SetFont('Times', 'I', '8');

        $this->Cell(0, 5, $teks4, 0, 1, 'C');

        $this->Cell(25);

        $this->Cell(0, 2, $teks5, 0, 1, 'C');
    }

    function garis()

    {

        $this->SetLineWidth(1);

        $this->Line(10, 36, 195, 36);

        $this->SetLineWidth(0);

        $this->Line(10, 37, 195, 37);
    }

    function jdl($teks1)

    {
        $this->Cell(10, 15, '', 0, 1);
        $this->SetFont('Times', 'B', '12');

        $this->Cell(200, 10, $teks1, 0, 0, 'C');

        $this->Cell(25);
    }
    function tbl1($teks0)

    {
        $this->SetFont('Times','', '12');
        $this->MultiCell(200,5, $teks0);

    }

    function tbl($teks2)

    {
        $this->SetFont('Times','', '12');
        $this->MultiCell(250,10, $teks2);
        $this->Ln(20);

    }

    function tbl3($teks9)

    {
        $this->SetFont('Times','', '12');
        $this->Cell(190,10, $teks9, 0, 0,'R');

    }

    function tbl2($teks3, $teks4)

    {
        $this->SetFont('Times','', '12');
        $this->Cell(190,10, $teks3, 0, 0,'R');
        $this->Cell(10, 15, '', 0, 1);
        $this->Cell(190,10, $teks4,0, 0, 'R');

    }

 
}

//instantisasi objek

$pdf = new Pdf();

//Mulai dokumen

$pdf->AddPage('P', 'A4');

//meletakkan gambar
$dt = date("Y/m/d");
$dt2 = date('d F Y', strtotime($dt));
$pdf->letak('logo.png');

$teks_tgl = 'Kediri, '.$dt2.'';
$teks_c ='Wakil Rektor Bidang Kemahasiswaan';
$teks_d ='Dr. Ir. Nama';
$teks_b = '
Kepada Yth. Mahasiswa Penerima Beasiswa (terlampir)
Perguruan Tinggi
di Kediri

Bersama ini kami mengundang Saudara yang namanya tercantum dalam lampiran undangan
ini untuk hadir pada :

Hari/Tanggal: Selasa, 20 Juni 2023
Pukul       : 10.00 s/d selesai
Tempat      : Ruang Rapat III Lantai 1 Rektorat
Acara       : 1. Pengarahan Beasiswa

Demikian, atas perhatiannya disampaikan terima kasih.';

$pdf->judul('PEMERINTAH KOTA KEDIRI', 'PSDKU', 'POLITEKNIK NEGERI MALANG', 'jalan lingkar maskumambang Telp. (8839)77388', 'Website: http://polinema.sch.id | E-Mail: psdkupolinema@schoool.ac.id');

//membuat garis ganda tebal dan tipis

$pdf->garis();
$pdf->jdl('Surat Panggilan');
$teks_a ='';
$pdf->tbl1($teks_a);
$pdf->tbl3($teks_tgl);
$pdf->tbl1($teks_a);
$pdf->tbl($teks_b);

$pdf->tbl2($teks_c, $teks_d);

$pdf->Output('mhs.pdf', 'I');
