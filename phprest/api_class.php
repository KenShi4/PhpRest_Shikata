<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
include('./class/class.php');
$classes = new classes();
switch($requestMethod)
{
	case 'GET':
		$id = '';
		if($_GET['id']) {
			$id = $_GET['id'];
			$classes->_id = $id;
			$data = $classes->one();
		} else {
			$data = $classes->list();
		}
		if(!empty($data)) {
          $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
        } else {
          $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
		echo $js_encode;
		break;
    
    case 'POST':
        $cla = json_decode(file_get_contents("php://input"),true);

        if(strcmp($cla['year'],"") != 0 && strcmp($cla['section'],"") != 0)  //controlla che tutti i valori siano stati passati
        {
            $classes->_id = $cla['id'];
            $classes->_year = $cla['year'];
            $classes->_section = $cla['section'];

            $data = $classes->insert();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
            }

            $data = $classes->getLast();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
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
            echo "POST classe non valido";
        }
        break;

    case 'DELETE':
        $id = $_GET['id'];
        $classes->_id = $id;
        $data = $classes->delete();
        if(!empty($data))
        {
            $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
        }
        else
        {
            $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet.'), true);
        }
        header('Content-Type: application/json');
        echo $js_encode;
        break;

    case 'PATCH':
        $cla = json_decode(file_get_contents("php://input"),true);

        if(strcmp($cla['id'], "")!=0) //controlla che l'id sia passato
        {
            $classes->_id = $cl['id'];
            foreach($cla as $key => $value)
            {
                if(strcmp($value,"")!=0) //controlla che il valore sia passato
                {
                    $classes->{"_$key"} = $value; //$classes->_name = Pippo
                }
            }

            $data = $cla->patch();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet or data is the same as previous.'), true);
            }

            $data = $classes->one();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
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
        $cla = json_decode(file_get_contents("php://input"),true);
        if(strcmp($cla['id'],"") != 0 && strcmp($cla['year'],"") != 0 && strcmp($cla['section'],"") != 0) //controlla che tutti i valori siano stati passati
        {
            $classes->_id = $cla['id'];
            $classes->_year = $cla['year'];
            $classes->_section = $cla['section'];


            $data = $classes->put();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
            }
            else
            {
                $js_encode = json_encode(array('status'=>FALSE, 'message'=>'There is no record yet or data is the same as previous.'), true);
            }

            $data = $classes->one();
            if(!empty($data))
            {
                $js_encode = json_encode(array('status'=>TRUE, 'classInfo'=>$data), true);
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