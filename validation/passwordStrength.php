<?php
 if (isset($_POST['getData'])) {
     $password = $_POST['getData'];
     $meter = ['meterValue' => 0,'meterMess'=>''];
     session_start();
     if (preg_match('/[a-z]/',$password)){
         $meter['meterValue'] += 20;
     }
     if (preg_match('/[A-ZA-Z]/',$password)){
         $meter['meterValue'] += 20;
     }
     if (preg_match('/[!#$%^&*(),.?":{}|<>]+/',$password)){
        $meter['meterValue'] += 20;
     }
     if (preg_match('/[0-9]/',$password)){
        $meter['meterValue'] += 20;
     }
     if (strlen($password) >= 8) {
        $meter['meterValue'] += 20;
     }
     switch ($meter['meterValue']) {
         case 20:
             $meter['meterMess'] = 'Very weak. Try adding uppercase letter,'
                                   .'special characters, '
                                   . 'numbers or increasing the length';
             break;
         case 40:
             $meter['meterMess'] = 'Weak. Try adding uppercase letter,'
                                   .'special characters, '
                                   . 'numbers or increasing the length';
             break;
         case 60:
             $meter['meterMess'] = 'Decent';
             break;
         case 80:
              $meter['meterMess'] = 'Good';
             break;
         case 100:
              $meter['meterMess'] = 'Secure';
             break;
     }
    $_SESSION['passStrength'] = $meter['meterValue'];
    echo json_encode($meter);
 } else {
     header("Location: ../signup.php");
     exit();
 }
