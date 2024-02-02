<?php 
    namespace Model;
    class vendedor extends ActiveRecord {
        protected static $tabla = 'vendedores';
        protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'imagen'];

        public $id;
        public $nombre;
        public $apellido;
        public $telefono;
        public $imagen;

        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? '';
            $this->nombre = $args['nombre'] ?? '';
            $this->apellido = $args['apellido'] ?? '';
            $this->imagen = $args['imagen'] ?? '';
            $this->telefono = $args['telefono'] ?? '';
        }

        public function validar() {
            if (!$this->nombre) {
                self::$errores[] = "Debes añadir un nombre";
            }
    
            if (!$this->apellido) {
                self::$errores[] = "El apellido es obligatorio";
            }

            if (!$this->imagen) {
                self::$errores[] = 'La imagen del vendedor es obligatoria';
            }
    
            if (!$this->telefono) {
                self::$errores[] = 'El telefono es obligatorio';
            }

            //validar que sea un numero el que se coloca en campo numero
            //expresion regular es buscar un patron dentro de un texto
            //esto siginifica que es una extencion fija de 0-9 que solo va atener 10 digitos
            if(!preg_match('/[0-9]{10}/', $this->telefono)) {
                self::$errores[] = 'Formatio no valido';
            }
            //es importante retornar estos errores en caso de que los haya
            return self::$errores;
        }

    }

?>