<?php
function getPronouns($gender)
{
  switch ($gender) {
    case "male":
      return "him";
    case "female":
      return "her";
    default:
      return "them";
  }
}

function getOrdinalNumber($day)
{
  $suffix = 'th';
  if (!in_array(($day % 100), [11, 12, 13])) {
    switch ($day % 10) {
      case 1:
        $suffix = 'st';
        break;
      case 2:
        $suffix = 'nd';
        break;
      case 3:
        $suffix = 'rd';
        break;
    }
  }
  return $day . $suffix;
}

function checkAge($birthdate)
{
  date_default_timezone_set("Asia/Manila");
  $userBirthdate = new DateTime($birthdate);
  $currentDate = new DateTime();
  $userAge = $currentDate->diff($userBirthdate)->y;

  if ($userAge >= 18) {
    return "legal age";
  } else {
    return "a minor";
  }
}

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
    $gender = trim($_POST['gender']);
    $pronouns = htmlspecialchars(getPronouns($gender));
    $birthdate = trim($_POST['birthdate']);
    $checkAge = checkAge($birthdate);
    $homeAddress = htmlspecialchars(trim($_POST['homeAddress']));
    $requestPurpose = htmlspecialchars(strtoupper($_POST['purposeRequest']));
    $dateRelease = $_POST['releaseDate'];
    $date = new DateTime($dateRelease);
    $day = htmlspecialchars($date->format('d'));
    $ordinal = htmlspecialchars(getOrdinalNumber($day));
    $month = htmlspecialchars($date->format('F'));
    $year = htmlspecialchars($date->format('Y'));
    $document = htmlspecialchars(strtoupper($_POST['documentRequest']));

    class PDF extends FPDF
    {
      function Footer()
      {
        $this->AddFont('Garamond', 'BI', 'EBGaramond-BoldItalic.php');
        $this->SetY(-10);
        $this->SetFont('Garamond', 'BI', 10);
        $this->SetTextColor(0, 176, 240);
        $this->Cell(0, 0, 'A Drug free, Healthy and Peaceful Barangay', 0, 1, 'C');
      }
    }

    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();

    $pdf->AddFont('Colonna', '', 'colonna.php');
    $pdf->AddFont('Garamond', '', 'garamond.php');
    $pdf->AddFont('Garamond', 'B', 'EBGaramond-Bold.php');
    $pdf->AddFont('Garamond', 'I', 'EBGaramond-Italic.php');
    $pdf->AddFont('Garamond', 'BI', 'EBGaramond-BoldItalic.php');

    $pdf->SetLeftMargin(20);
    $pdf->SetRightMargin(20);
    $pdf->Image('./assets/brgylogo_9.png', 97.634, 20, 14.732, 12.192);
    $pdf->Ln(27);

    $pdf->SetFont('Garamond', 'B', 14);
    $pdf->SetTextColor(68, 114, 196);
    $pdf->Cell(0, 0, 'Barangay 9 Zone 2', 0, 1, 'C');

    $pdf->Ln(6);
    $pdf->SetFont('Garamond', '', 12);
    $pdf->Cell(0, 0, 'Pasay City', 0, 1, 'C');

    $pdf->Ln(6);
    $pdf->SetFont('Colonna', '', 14);
    $pdf->SetTextColor(0);
    $pdf->Cell(0, 0, 'Office of the Barangay Captain', 0, 1, 'C');

    $pdf->Ln(6);
    $pdf->SetDrawColor(68, 114, 196);
    $pdf->Line(20, $pdf->GetY(), 190, $pdf->GetY());

    $pdf->Ln(6);
    $pdf->SetFont('Garamond', 'B', 18);
    $pdf->Cell(0, 0, $document, 0, 1, 'C');

    $pdf->Ln(14);
    $pdf->SetFont('Garamond', 'B', 14);
    $pdf->Write(7, "TO WHOM IT MAY CONCERN:");

    $pdf->Ln(14);
    $pdf->SetFont('Garamond', '', 14);
    $pdf->Write(6, "          This is to certify that ");
    $pdf->SetFont('Garamond', 'BI', 14);
    $pdf->Write(6, $requesterName);
    $pdf->SetFont('Garamond', '', 14);
    $pdf->Write(6, " of $checkAge, $gender, a resident of $homeAddress.");

    $pdf->Ln(10);
    $pdf->Write(6, "          I personally know ");
    $pdf->SetFont('Garamond', 'I', 14);
    $pdf->Write(6, $pronouns);
    $pdf->SetFont('Garamond', '', 14);
    $pdf->Write(6, " to have good moral and no derogatory record or pending case file in this barangay against " . $pronouns . ".");

    $pdf->Ln(10);
    $pdf->Write(6, "          This certification is being issued upon request of ");
    $pdf->SetFont('Garamond', 'BI', 14);
    $pdf->Write(6, $requesterName);
    $pdf->SetFont('Garamond', '', 14);
    $pdf->Write(6, " for " . $requestPurpose . ".");

    $pdf->Ln(10);
    $pdf->Write(6, "         Issued this $ordinal");
    $pdf->SetFont('Garamond', 'I', 14);
    $pdf->Write(6, " day of $month ");
    $pdf->SetFont('Garamond', '', 14);
    $pdf->Write(6, $year . ".");

    $pdf->Ln(32);
    $pdf->SetFont('Garamond', 'B', 14);
    $pdf->Cell(0, 0, $signatory, 0, 1, 'R');

    $pdf->Ln(7);
    $pdf->SetFont('Garamond', 'B', 14);
    $pdf->Cell(162, 0, 'Barangay Captain', 0, 1, 'R');

    $pdf->Ln(32);
    $pdf->SetDrawColor(1, 1, 1);
    $pdf->Line(20, $pdf->GetY(), 77, $pdf->GetY());

    $pdf->Ln(3);
    $pdf->SetFont('Garamond', 'I', 10);
    $pdf->Cell(0, 0, "Signature over printed name of the bearer", 0, 1, 'L');

    $pdf->Ln(14);
    $pdf->Cell(0, 0, "Not valid without seal", 0, 1, 'L');

    $pdf->Output();
  }

  $signatoryQuery->close();
}
?>