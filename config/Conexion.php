<?php
    class Conexion {
        private $oConexion;

        /***************************************************************************************
        *                        Realiza la conexión de la base de datos
        **************************************************************************************/
        public function conectar() {
            $bRet = false;
            try{
                $this->oConexion = new PDO(
                    "mysql:host=".HOST.";dbname=".DATABASE ,
                    USER,
                    PASSWORD,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8MB4'")
                );
                $bRet = true;
            } catch (PDOException $e){
                $bRet = $e->getMessage();
            }

            return $bRet;
        }

        /***************************************************************************************
        *                        Rompe la conexión de la base de datos
        **************************************************************************************/
        public function desconectar(){
            $bRet = true;
            if ($this->oConexion != null){
                $this->oConexion=null;
            }
            return $bRet;
        }

        /***************************************************************************************
        *                  Generar una consulta preparada con un solo resultado
        *                         devuelto en una variable de tipo objeto
        **************************************************************************************/
        public function consultaSimple($sComando = "", $aDatos = null) {

            $response = null;
            try {
                if($this->oConexion == null)
                    throw new Exception("Error en Conexion.php -> No se ha establecido conexión a la base de datos.");
                if(is_string($sComando) && $sComando == "")
                    throw new Exception("Error en Conexion.php -> No se ha indicado la consulta sql.");

                $stmt = $this->oConexion->prepare($sComando);
                
                $isExecuteSuccess = is_array( $aDatos ) ? $stmt->execute( $aDatos ) : $stmt->execute();

                if( $isExecuteSuccess ) {
                    
                    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $response = $row;
                    }

                } else {
                    $tmp = $stmt->errorInfo();
                    throw new Exception("Error en Conexion.php -> ".$tmp[2]);
                }

            } catch(Exception $e) {
                $response = $e->getMessage();
            }
            return $response;
        }

        /***************************************************************************************
        *       Generar una consulta preparada, la cual retorna un array con el numero
        *                    de filas y nombre de la columna
        **************************************************************************************/
        public function consultaCompuesta($sComando, $aDatos = null) {
            $response = null;
            try {
                if($this->oConexion == null)
                    throw new Exception("Error en Conexion.php -> No se ha establecido conexión a la base de datos.");
                if(is_string($sComando) && $sComando == "")
                    throw new Exception("Error en Conexion.php -> No se ha indicado la consulta sql.");
                $stmt = $this->oConexion->prepare($sComando);

                $successExecute = is_array( $aDatos ) ? $stmt->execute( $aDatos ) : $stmt->execute();

                if ( $successExecute ) {
                    $i = 0;
                    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                        $response[$i] = $row;
                        $i++;
                    }
                } else {
                    $tmp = $stmt->errorInfo();
                    throw new Exception("Error en Conexion.php -> ".$tmp[2]);
                }
            } catch(Exception $e) {
                $response = $e->getMessage();
            }
            return $response;
        }

        /***************************************************************************************
        *       Función que ejecuta una instrucción SQl,retornando
        *              el numero de filas afectadas
        **************************************************************************************/
        public function ejecutaComando($sComando, $aDatos = null) {
            $response = null;
            try {
                if($this->oConexion == null)
                    throw new Exception("Error en Conexion.php -> No se ha establecido conexión a la base de datos.");
                if(is_string($sComando) && $sComando == "")
                    throw new Exception("Error en Conexion.php -> No se ha especificado la instrucción a ejecutar.");

                $stmt = $this->oConexion->prepare($sComando);

                if(is_array($aDatos)) {
                    $bRet = $stmt->execute($aDatos);
                } else {
                    $bRet = $stmt->execute();
                }

                if ($bRet) {
                    //$stmt->debugDumpParams(); //Para debugear la sentencia preparada
                    $response = $stmt->rowCount();
                } else {
                    $tmp = $stmt->errorInfo();
                    throw new Exception("Error en Conexion.php -> ".$tmp[2]);
                }
            } catch(Exception $e) {
                $response = $e->getMessage();
            }
            return $response;
        }

        /***************************************************************************************
        *              Función para obtener el ultimo ID auto incrementable
        **************************************************************************************/
        public function getId() {
            $response = 0;
            try {
                if($this->oConexion == null)
                    throw new Exception("Error en Conexion.php -> No se ha establecido conexión a la base de datos.");

                $response = $this->oConexion->lastInsertId();
            } catch(Exception $e) {
                $response = $e->getMessage();
            }
            return $response;
        }
    }