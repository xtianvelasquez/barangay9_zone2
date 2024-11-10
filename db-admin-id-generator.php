<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";
  require_once __DIR__ . "/fpdf186/fpdf.php";

  $adminRole = "Barangay Captain";
  $signatoryQuery = $dbConnect->prepare("SELECT admin_name FROM admin_credentials WHERE admin_role = ?");
  $signatoryQuery->bind_param("s", $adminRole);

  if (!$signatoryQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $signatoryQuery->error);
    $signatoryQuery->close();
    exit;
  }

  $signatoryResult = $signatoryQuery->get_result();
  if ($signatoryResult->num_rows == 1) {
    $displaySignatory = $signatoryResult->fetch_assoc();

    $signatory = htmlspecialchars(strtoupper($displaySignatory['admin_name']));
    $requesterName = htmlspecialchars(strtoupper($_POST['requesterName']));
    $homeAddress = htmlspecialchars(strtoupper($_POST['homeAddress']));
    $contactPersonFullName  = htmlspecialchars($_POST['contactName']);
    $contactPersonPhoneNumber = htmlspecialchars($_POST['contactPhone']);

    class PDF extends FPDF
    {

      function NbLines($w, $txt)
      {

        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
          $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
          $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
          $c = $s[$i];
          if ($c == "\n") {
            $i++;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
            continue;
          }
          if ($c == ' ')
            $sep = $i;
          $l += $cw[$c];
          if ($l > $wmax) {
            if ($sep == -1) {
              if ($i == $j)
                $i++;
            } else
              $i = $sep + 1;
            $sep = -1;
            $j = $i;
            $l = 0;
            $nl++;
          } else
            $i++;
        }
        return $nl;
      }

      function MultiCellHeight($w, $h, $txt, $border = 0, $align = 'J')
      {

        $lines = $this->NbLines($w, $txt);
        $height = $lines * $h;

        $this->MultiCell($w, $h, $txt, $border, $align);
        return $height;
      }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->Rect(73.74, 20, 62.52, 88.9); // Front

    $pdf->Image('./assets/brgylogo_9.png', 100, 23, 12, 10);
    $pdf->Ln(22);
    $pdf->SetFont('Arial', 'B', 6);
    $pdf->Ln(3);
    $pdf->MultiCell(0, 0, 'Barangay 9 Zone 2', 0, 'C');
    $pdf->Ln(3);
    $pdf->MultiCell(0, 0, 'Pasay City', 0, 'C');
    $pdf->Ln(3);
    $pdf->MultiCell(0, 0, 'Office of the Barangay Captain', 0, 'C');

    $pdf->Rect(92.5, 44, 25.4, 25.4);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 72);
    $height1 = $pdf->MultiCellHeight(62.52, 4, $requesterName, 0, 'C');

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY(73.74, 71 + $height1);
    $height2 = $pdf->MultiCellHeight(62.52, 5, 'NAME', 0, 'C');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 72 + $height1 + $height2);
    $height3 = $pdf->MultiCellHeight(62.52, 4, $homeAddress, 0, 'C');

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY(73.74, 71 + $height1 + $height2 + $height3);
    $height4 = $pdf->MultiCellHeight(62.52, 5, 'ADDRESS', 0, 'C');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 72 + $height1 + $height2 + $height3 + $height4);
    $height5 = $pdf->MultiCellHeight(62.52, 4, $signatory, 0, 'C');

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY(73.74, 71 + $height1 + $height2 + $height3 + $height4 + $height5);
    $height6 = $pdf->MultiCellHeight(62.52, 5, 'BARANGAY CAPTAIN', 0, 'C');

    $frontHeights = $height1 + $height2 + $height3 + $height4 + $height5 + $height6;

    $pdf->Rect(73.74, 118.9, 62.52, 88.9); // Back

    $pdf->Image('./assets/brgylogo_9.png', 100, 122, 12, 10);

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY(73.74, 105 + $frontHeights);
    $height7 = $pdf->MultiCellHeight(62.52, 4, 'CONTACT NUMBER IF IN CASE OF EMERGENCY', 0, 'L');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 105 + $frontHeights + $height7);
    $height8 = $pdf->MultiCellHeight(62.52, 4, 'NAME: ' . $contactPersonFullName, 0, 'L');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 105 + $frontHeights + $height7 + $height8);
    $height9 = $pdf->MultiCellHeight(62.52, 5, 'CONTACT: ' . $contactPersonPhoneNumber, 0, 'L');

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 145 + $frontHeights + $height7 + $height8 + $height9);
    $height10 = $pdf->MultiCellHeight(62.52, 4, $signatory, 0, 'C');

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY(73.74, 143 + $frontHeights + $height7 + $height8 + $height9 + $height10);
    $height11 = $pdf->MultiCellHeight(62.52, 5, 'BARANGAY CAPTAIN', 0, 'C');

    $pdf->Output();
  }

  $signatoryQuery->close();
}
?>