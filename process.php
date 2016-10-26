<?php
if( isset($_POST) ){
     
    //form validation vars
    $formok = true;
    $errors = array();
     
    //submission data
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $date = date('d/m/Y');
    $time = date('H:i:s');
     
    //form data
    $name = $_POST['name'];    
    $email = $_POST['email'];
    // $telephone = $_POST['telephone'];
    // $enquiry = $_POST['enquiry'];
    // $message = $_POST['message'];
     
    //validate form data
     
    //validate name is not empty
    if(empty($name)){
        $formok = false;
        $errors[] = "Debes introducir tu nombre";
    }
     
    //validate email address is not empty
    if(empty($email)){
        $formok = false;
        $errors[] = "Debes introducir una dirección de correo electrónico";
    //validate email address is valid
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $formok = false;
        $errors[] = "La dirección de correo electrónico que has introducido no es válida";
    }
     
    // //validate message is not empty
    // if(empty($message)){
    //     $formok = false;
    //     $errors[] = "You have not entered a message";
    // }
    // //validate message is greater than 20 characters
    // elseif(strlen($message) < 20){
    //     $formok = false;
    //     $errors[] = "Your message must be greater than 20 characters";
    // }
     
    //send email if all is ok
    if($formok){
        $headers = "From: info@example.com" . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
         
        $emailbody = "<p>Querido Papirriqui,</p>
                      <p>Has recibido un nuevo contacto desde http://www.muxe.com.co/.</p>
                      <p><strong>Nombre: </strong> {$name} </p>
                      <p><strong>Email: </strong> {$email} </p>
                      <p>Este mensaje ha sido enviado desde la dirección IP: {$ipaddress} on {$date} at {$time}</p>";
         
        mail("diego.bocanegra@gmail.com","Nuevo Contacto en la web de MUXE",$emailbody,$headers);
         
    }
     
    //what we need to return back to our form
    $returndata = array(
        'posted_form_data' => array(
            'name' => $name,
            'email' => $email
        ),
        'form_ok' => $formok,
        'errors' => $errors
    );
         
     
    //if this is not an ajax request
    if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest'){
        //set session variables
        session_start();
        $_SESSION['cf_returndata'] = $returndata;
         
        //redirect back to form
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
}