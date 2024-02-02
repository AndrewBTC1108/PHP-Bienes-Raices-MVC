<?php
    /*
     -Todo lo que este public va hacer referencia como $this->
     -Todo lo que sea statico va hacer referencia como self::$
     -herencia para heredar y poder llamar metodos a la clase padre static::$
    */
    namespace Model;
    class ActiveRecord {
        
        //Base de datos
        protected static $db;
        protected static $columnasDB = [];
        protected static $tabla = '';
        //errores arreglo con mensajes de errores
        protected static $errores = [];

        //Definir conexion la BD 
        public static function setDB($database) {
            self::$db = $database;
        }

        public function guardar() {
            /*
              verificamos, si no esta vacio con id, significa que si hay un id el cual coincide con el id  que vamos a actualizar
              de lo contrario si la variable !empty($this->id) si esta vacia significa que esatmos en la seccion de crear y se pasara a crear enves de actualizar
            */
            if(!empty($this->id)) {
                //llamando metodo de actualizar
                $this->actualizar();
            } else {
                //llamando metodo de crear
                $this->crear();
            }
        }

        public function crear() {
            //sanitizar los datos 
            $atributos = $this->sanitizarAtributos();
            /*
            -función join() se utiliza para unir elementos de un array en una única cadena se compone de un separador.
            -array_keys()  en PHP se utiliza para obtener todas las claves (índices) de un array y devolverlas en un nuevo array.
            -array_values() se utiliza para devolver un nuevo array que contiene todos los valores del array original
            */
            //insertar en la base de datos 
            $query = " INSERT INTO " . static::$tabla . " ( ";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES (' ";
            $query .= join("', '", array_values($atributos));
            $query .= " ') ";
            // debuguear($query);
            //lo insertamos a la base de datos 
            $resultado = self::$db->query($query);

            if($resultado) {
                //redireccionar al usuario
                header('Location: /admin?resultado=1'); //query sting
            }
        }

        public function actualizar() {
            //sanitizar los datos 
            $atributos = $this->sanitizarAtributos();
            $valores = [];

            foreach($atributos as $key => $value) {
                $valores[] = "{$key}='{$value}'";
            }
            
            $query = "UPDATE ". static::$tabla . " SET ";
            $query .= join(', ', $valores);
            $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
            $query .= " LIMIT 1 ";
            
            //lo actualizamos en la Base de Datos
            $resultado = self::$db->query($query);
            
            if ($resultado) {
                //redireccionar al usuario
                header('Location: /admin?resultado=2'); //query string
            }
            
        }
        //eliminar un registro
        public function eliminar() {
            //Elimina el registro
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            //insertar en la base de datos
            $resultado = self::$db->query($query);

            if($resultado) {
                //llamamos el metodo ára borrar la imagen
                $this->borrarImagen();
                header('Location: /admin?resultado=3');
            }
        }

        //este metodo se encargara de iterar sobre columnasDB
        //identificar y unir a los atributos de la base de datos
        public function atributos() {
            $atributos = [];
            foreach(static::$columnasDB as $columna) {
                //va a verificar cuando $colmuna este en id y lo ignorara y seguira por el otro atributo, id no es necesario sanitizar
                if($columna == 'id') continue;
                $atributos[$columna] = $this->$columna;
            }
            return $atributos;
        }

        //este metodo se encargara de sanitizar cada una de las columnas
        public function sanitizarAtributos() {
            $atributos = $this->atributos();
            $sanitizado = [];

            foreach($atributos as $key => $value) {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
            return $sanitizado;
        }
        //subida de archivos
        public function setImage($imagen) {
            //si estamos editando o si hay un id
            if(isset($this->id)) {
                $this->borrarImagen();
            }
            //asignar al atributo de imagen el nombre de la imagen
            if($imagen) {
                $this->imagen = $imagen;
            }
        }

        //Eliminar el archivo
        public function borrarImagen() {
            //comprobar si existe el archivo para eliminarlo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo) {
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }
        //validacion
        public static function getErrores() {
            return static::$errores;
        }

        public function validar() {
            static::$errores = [];
            //es importante retornar estos errores en caso de que los haya
            return static::$errores;
        }
     /****************************************************************************/
        //lista todas los registros
        public static function all() {
            $query = "SELECT * FROM " . static::$tabla;
            //lo insertamos a la base de datos
            $resultado = self::consultarSQL($query);

            return $resultado;
        }

        //obtiene determinados numeros de registros para mostrar en el front
        public static function get($cantidad) {
            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
            //lo insertamos a la base de datos
            $resultado = self::consultarSQL($query);

            return $resultado;
        }

        //busca un registro por su id
        public static function find($id) {
            $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";
            //consultar la base de datos insertamos query a la DB
            $resultado = self::consultarSQL($query);
            return array_shift($resultado);
        }

        public static function consultarSQL($query) {
            //consultar la base de datos insertamos query a la DB
            $resultado = self::$db->query($query);
            //iterar los resultados
            $array = [];
            while($registro = $resultado->fetch_assoc()) {
                $array[] = static::crearObjeto($registro);
            }
            //liberar memoria 
            $resultado->free();
            //retornar los resultados
            return $array;
        }

        protected static function crearObjeto($registro) {
            //crear nuevos objetos de la clase actual
            $objeto = new static;
            foreach($registro as $key => $value) {
                if(property_exists($objeto, $key)) {
                    $objeto->$key = $value;
                }
            }
            return $objeto;
        }

        //sincroniza el objeto en memoria con los cambios realizados por el usuario
        //va a leer todo el post y va a ir iterando en memoria todo lo que este guadado por POST e ira mapeando
        public function sincronizar($args=[]) { 
            foreach($args as $key => $value) {
              if(property_exists($this, $key) && !is_null($value)) {
                //va a sobrescribir el nuevo valor escrito desde $_POST
                $this->$key = $value;
              }
            }
        }
    }

?>