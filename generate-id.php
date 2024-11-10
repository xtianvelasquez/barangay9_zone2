<?php

if (isset($_GET['requestReference'])) {
  require('dbconnection.php');
  require_once __DIR__ . "/fpdf186/fpdf.php";

  $requestReference = $_GET['requestReference'];
  $adminRole = "Barangay Captain";

  $query = "SELECT
  table1.first_name,
  table1.middle_name,
  table1.last_name,
  table2.home_address,
  table3.formal_picture,
  table4.request_reference,
  table5.contact_name,
  table5.contact_phone,
  table6.admin_name
  FROM masterlist AS table1
  LEFT JOIN user_contact_details AS table2 ON table1.user_id = table2.user_id
  LEFT JOIN user_attachments AS table3 ON table2.user_id = table3.user_id
  LEFT JOIN document_requests AS table4 ON table3.user_id = table4.user_id
  LEFT JOIN user_contact_person AS table5 ON table4.user_id = table5.user_id
  LEFT JOIN admin_credentials AS table6 ON table5.user_id <> table6.admin_id
  WHERE table4.request_reference = ? AND table6.admin_role = ?";

  $stmt = $dbConnect->prepare($query);
  $stmt->bind_param("ss", $requestReference, $adminRole);

  if (!$stmt->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $stmt->error);
    $stmt->close();
    exit;
  }

  $result = $stmt->get_result();
  if ($result->num_rows >= 1) {
    $details = $result->fetch_assoc();

    $firstName = htmlspecialchars(strtoupper($details['first_name']));
    $middleName = htmlspecialchars(strtoupper($details['middle_name']));
    $middleInitial = htmlspecialchars($middleName[0]);
    $lastName = htmlspecialchars(strtoupper($details['last_name']));
    $fullName = htmlspecialchars($firstName . " " . $middleInitial . ". " . $lastName);
    $homeAddress = htmlspecialchars(strtoupper($details['home_address']));
    $formalPicture = htmlspecialchars($details['formal_picture']);
    $contactPersonFullName  = htmlspecialchars($details['contact_name']);
    $contactPersonPhoneNumber = htmlspecialchars($details['contact_phone']);
    $barangayCaptain = htmlspecialchars(strtoupper($details['admin_name']));

    class PDF extends FPDF
    {
      // Calculate the number of lines a MultiCell will take
      function NbLines($w, $txt)
      {
        // Compute the number of lines a MultiCell of width w will take
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

      // Create a MultiCell and return the height
      function MultiCellHeight($w, $h, $txt, $border = 0, $align = 'J')
      {
        // Calculate the height of the MultiCell
        $lines = $this->NbLines($w, $txt);
        $height = $lines * $h;
        // Output the MultiCell
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
    $pdf->Image($formalPicture, 92.5, 44, 25.4, 25.4);

    $pdf->SetFont('Arial', 'B', 8);
    $pdf->SetXY(73.74, 72);
    $height1 = $pdf->MultiCellHeight(62.52, 4, $fullName, 0, 'C');

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
    $height5 = $pdf->MultiCellHeight(62.52, 4, $barangayCaptain, 0, 'C');

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
    $height10 = $pdf->MultiCellHeight(62.52, 4, $barangayCaptain, 0, 'C');

    $pdf->SetFont('Arial', '', 6);
    $pdf->SetXY(73.74, 143 + $frontHeights + $height7 + $height8 + $height9 + $height10);
    $height11 = $pdf->MultiCellHeight(62.52, 5, 'BARANGAY CAPTAIN', 0, 'C');

    $pdf->Output();
  }

  $stmt->close();
}
