<?php
tcpdf();
$obj_pdf = new TCPDF('P', PDF_UNIT, "A4", true, 'UTF-8', true);
$obj_pdf->SetCreator("Hendy Andrianto S.Kom (www.facebook.com/opchaky.it)");
$toko = "LEMBAGA PENDIDIKAN KETERAMPILAN";
$hal = "GITA PERTIWI";
$alamat = "PUSAT : JL. KEBON TIWU I NO. 10 TASIKMALAYA";
$tlp = "(0265) 323445 HP. 085295168608";
$cabang = "CABANG : JL. RAYA TIMUR BOROLONG CILAMPUNG HILIR SINGAPARNA"."\n"."HP. 085353292292";
$judul = $alamat . "\n" . "TELP. " . $tlp;
$foto = "profile.jpg";
$obj_pdf->SetTitle($toko);
$obj_pdf->SetDefaultMonospacedFont('helvetica','B','12');
$obj_pdf->SetHeaderData($foto, 10, $toko , $hal . "\n" . $judul . "\n" . $cabang);
$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$obj_pdf->SetDefaultMonospacedFont('helvetica');
$obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$obj_pdf->SetMargins(10, 34, 10);
$obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$obj_pdf->SetFont('helvetica', '', 10);
$obj_pdf->setFontSubsetting(FALSE);
$obj_pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
$obj_pdf->SetFillColor(255, 235, 235);
$obj_pdf->AddPage();
$obj_pdf->SetFont('helvetica', 'B', 9);
$txt = 'LAPORAN DATA SISWA';
$obj_pdf->MultiCell(200, 10, $txt, 0, 'C', 0, 0, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->Ln(2);
$obj_pdf->SetFont('helvetica', 'B', 8);
$obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
$obj_pdf->SetFont('helvetica', '', 8);
$i = 0;
$tipe = $this->db->get('tbl_tipe')->result();
foreach ($tipe as $row) {
    $i++;
    $tipe = $row->nama;
    $idna = $row->id;
    $txxt = $i . " " . $tipe;
    $obj_pdf->SetFont('helvetica', 'B', 8);
    $obj_pdf->MultiCell(100, 10, $txxt, 0, 'L', 0, 1, '', '', true, 0, false, true, 10, 'M');
    $obj_pdf->SetFont('helvetica', '', 8);
    $obj_pdf->MultiCell(8, 5, 'No.', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(50, 5, 'Nama', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(10, 5, 'L/P', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(30, 5, 'Agama', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(30, 5, 'Pendidikan', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(30, 5, 'Pekerjaan', 1, 'C', 1, 0, '', '', true, 0, false, true, 5, 'M');
    $obj_pdf->MultiCell(32, 5, 'No Hp', 1, 'C', 1, 1, '', '', true, 0, false, true, 5, 'M');
    $x=0;
    $ckdata = $this->db->query("SELECT view_member.nama,view_member.jns_kel,tbl_agama.agama as nama_agama,tbl_pendidikan.nama as nama_pendidikan,view_member.no_hp,tbl_pekerjaan.nama as nama_pekerjaan FROM view_member INNER JOIN tbl_agama ON view_member.id_agama = tbl_agama.id INNER JOIN tbl_pendidikan ON view_member.id_pendidikan = tbl_pendidikan.id INNER JOIN tbl_pekerjaan ON view_member.id_pekerjaan = tbl_pekerjaan.id WHERE view_member.id_tipe = '$idna'")->result();
    foreach ($ckdata as $row) {
        $x++;
        $obj_pdf->MultiCell(8, 5, $x . ".", 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(50, 5, $row->nama, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(10, 5, $row->jns_kel, 1, 'C', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(30, 5, $row->nama_agama, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(30, 5, $row->nama_pendidikan, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(30, 5, $row->nama_pekerjaan, 1, 'L', 0, 0, '', '', true, 0, false, true, 5, 'M');
        $obj_pdf->MultiCell(32, 5, $row->no_hp, 1, 'R', 0, 1, '', '', true, 0, false, true, 5, 'M');
    }
    $obj_pdf->Ln(2);
}
$obj_pdf->lastPage();
$obj_pdf->writeHTML($content, true, false, true, false, '');
$obj_pdf->Output('Surat Jalan ' . $no_surat .'.pdf', 'I');
?>