<?php
// memanggil library FPDF
require('fpdf/fpdf.php');
// require_once "?page=fpdf/fpdf";
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

    function tbl()

    {
        $this->Cell(10, 15, '', 0, 1);
        $this->SetFont('Times', 'B', 9);
        $this->Cell(10, 7, 'NO', 1, 0, 'C');
        $this->Cell(20, 7, 'NIM', 1, 0, 'C');
        $this->Cell(45, 7, 'NAMA', 1, 0, 'C');
        $this->Cell(45, 7, 'ALAMAT', 1, 0, 'C');
        $this->Cell(40, 7, 'GENDER', 1, 0, 'C');
        $this->Cell(25, 7, 'TAHUN', 1, 0, 'C');
        $this->Cell(10, 1, '', 0, 1);

        $this->SetFont('Times', '', 10);
        $no = 1;
        $connection = new Mysqli("localhost", "root", "", "bsw_fix");
        $data = mysqli_query($connection, "SELECT * FROM mahasiswa WHERE nim IN(SELECT nim FROM nilai)");
        while ($d = mysqli_fetch_array($data)) {
            $this->Cell(10, 6, '', 0, 1);
            $this->Cell(10, 6, $no++, 1, 0, 'C');
            $this->Cell(20, 6, $d['nim'], 1, 0);
            $this->Cell(45, 6, $d['nama'], 1, 0);
            $this->Cell(45, 6, $d['alamat'], 1, 0);
            $this->Cell(40, 6, $d['jenis_kelamin'], 1, 0);
            $this->Cell(25, 6, $d['tahun_mengajukan'], 1, 0);
        }

        $this->SetFont('Times', 'B', 13);
        $this->Cell(200, 10, 'DATA PENDAFTAR', 0, 0, 'C');
    }

    
    function tbl2($teks3, $teks4)

    {
        $this->Cell(10, 15, '', 0, 1);
        $this->SetFont('Times','', '12');
        $this->Cell(190,10, $teks3, 0, 0,'R');
        $this->Cell(10, 15, '', 0, 1);
        $this->Cell(190,10, $teks4,0, 0, 'R');

    }

    function tbl1($teks0)

    {
        $this->SetFont('Times','', '12');
        $this->MultiCell(200,5, $teks0);

    }
}

//instantisasi objek

$pdf = new Pdf();

//Mulai dokumen

$pdf->AddPage('P', 'A4');

//meletakkan gambar

$pdf->letak('logo.png');

//meletakkan judul disamping logo diatas

$pdf->judul('PEMERINTAH KOTA KEDIRI', 'PSDKU', 'POLITEKNIK NEGERI MALANG', 'jalan lingkar maskumambang Telp. (8839)77388', 'Website: http://polinema.sch.id | E-Mail: psdkupolinema@schoool.ac.id');

//membuat garis ganda tebal dan tipis

$pdf->garis();
$pdf->jdl('Daftar Mahasiswa');
$pdf->tbl();
$teks_a ='';
$teks_c ='Wakil Rektor Bidang Kemahasiswaan';
$teks_d ='Dr. Ir. Nama';
$pdf->tbl1($teks_a);
$pdf->tbl2($teks_c, $teks_d);

$pdf->Output('mhs.pdf', 'I');
