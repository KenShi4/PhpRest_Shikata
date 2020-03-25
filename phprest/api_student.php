<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('./class/Student.php');
$student = new Student();
switch($requestMethod)
{
	case 'GET':
		$id = '';
		if($_GET['id']) {
			$id = $_GET['id'];
			$student->_id = $id;
			$data = $student->one();
		} else {
			$data = $student->list();
		}
		if(!empty($data)) {
          $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
        } else {
          $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
		echo $js_encode;
		break;
    
    case 'POST':
        $stud = json_decode(file_get_contents("php://input"),true);

        if(strcmp($stud['name'],"") != 0 && strcmp($stud['surname'],"") != 0 && strcmp($stud['sidi_code'],"") != 0 && strcmp($stud['tax_code'],"") != 0) //controlla che tutti i valori siano stati passati
        {
            $student->_name = $stud['name'];
            $student->_surname = $stud['surname'];
            $student->_sidiCode = $stud['sidi_code'];
            $student->_taxCode = $stud['tax_code'];

            $data = $student->insert();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
            }

            $data = $student->getLast();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true); //non dovrebbe mai arrivare qui
            }
            header('Content-Type: application/json');
            echo "<b>Aggiunto: </b>" . $js_encode;
        }
        else
        {
            echo "POST studente non valido";
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $student->_id = $id;
        $data = $student->delete();
        if(!empty($data))
        {
            $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
        }
        else
        {
            $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
        echo $js_encode;
        break;

    case 'PATCH':
        $stud = json_decode(file_get_contents("php://input"),true);

        if(strcmp($stud['id'], "")!=0) //controlla che l'id sia passato
        {
            $student->_id = $stud['id'];
            foreach($stud as $key => $value)
            {
                if(strcmp($value,"")!=0) //controlla che il valore sia passato
                {
                    $student->{"_$key"} = $value; //$student->_name = Pippo
                }
            }

            $data = $student->patch();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet or data is the same as previous.'), true);
            }

            $data = $student->one();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet or data is the same as previous.'), true);
            }
            header('Content-Type: application/json');
            echo "<b>Modificato: </b>" . $js_encode;
        }
        else //mancanza di id
        {
            echo "PATCH studente non valido";
        }
        break;

    case 'PUT':
        $stud = json_decode(file_get_contents("php://input"),true);

        if(strcmp($stud['id'],"") != 0 && strcmp($stud['name'],"") != 0 && strcmp($stud['surname'],"") != 0 && strcmp($stud['sidi_code'],"") != 0 && strcmp($stud['tax_code'],"") != 0) //controlla che tutti i valori siano stati passati
        {
            $student->_id = $stud['id'];
            $student->_name = $stud['name'];
            $student->_surname = $stud['surname'];
            $student->_sidiCode = $stud['sidi_code'];
            $student->_taxCode = $stud['tax_code'];

            $data = $student->put();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet or data is the same as previous.'), true);
            }

            $data = $student->one();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'studentInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet or data is the same as previous.'), true);
            }
            header('Content-Type: application/json');
            echo "<b>Modificato: </b>" . $js_encode;
        }
        else //mancanza di id
        {
            echo "PUT studente non valido";
        }
        break;

    default:
	    header("HTTP/1.0 405 Method Not Allowed");
	    break;
}
?>	