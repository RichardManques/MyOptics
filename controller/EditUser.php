<?php
    namespace controller;

    use model\ModelUser;
    require_once("../model/ModelUser.php");

    class EditUser {
        public $rut, $name, $state;
        public $error = "";

        public function __construct() {
            $this -> rut = $_POST["rut"];
            $this -> name = $_POST["name"];
            $this -> state = $_POST["state"];
        }

        public function validate() {
            if($this -> rut == "" && $this -> name == "" && $this -> state == "") {
                $this -> error = "Verifica los Campos";
            } else {
                if($this -> rut == "") {
                    $this -> error = "Verifica el Rut del Usuario". "<br>";
                }

                if($this -> name == "") {
                    $this -> error .= "Verifica el Nombre del Usuario". "<br>";
                }

                if($this -> state == "") {
                    $this -> error .= "Selecciona un Estado al Usuario";
                }
            }
        }

        public function edit() {
            $this -> validate();
            
            if($this -> error == "") {
                $modelUser = new ModelUser();
                $result = $modelUser -> read($this -> rut);

                if(count($result) > 0) {
                    $result = $modelUser -> update($this -> state, $this -> rut);
                    
                    if($result) {
                        echo json_encode("El Usuario Se Actualizo");
                    } else {
                        echo json_encode("El Usuario No Se Actualizo");
                    }
                } else {
                    echo json_encode("El Rut No Está Registrado");
                }
            } else {
                echo json_encode($this -> error);
            }    
        }
    }

    $object = new EditUser();
    $object -> edit();
?>