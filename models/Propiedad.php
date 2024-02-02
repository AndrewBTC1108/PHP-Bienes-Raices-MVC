<?php 
    namespace Model;
    class Propiedad extends ActiveRecord {
        //base de datos 
        protected static $tabla = 'propiedades';
        //para normalizar los datos
        protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento' , 'creado', 'vendedores_id'];

        //atributoss
        public $id;
        public $titulo;
        public $precio;
        public $imagen;
        public $descripcion;
        public $habitaciones;
        public $wc;
        public $estacionamiento;
        public $creado;
        public $vendedores_id;

        /*
        Este es el constructor de la clase Propiedad. Se ejecuta automáticamente cuando se crea una nueva instancia de la clase. 
        Acepta un argumento opcional $args, que es un array asociativo con las claves correspondientes a los atributos de la clase. 
        Si se proporciona un valor para un atributo en $args, se asigna ese valor al atributo correspondiente; de lo contrario, 
        se asigna una cadena vacía como valor predeterminado.
        */
        public function __construct($args = [])
        {
            $this->id = $args['id'] ?? '';
            $this->titulo = $args['titulo'] ?? '';
            $this->precio = $args['precio'] ?? '';
            $this->imagen = $args['imagen'] ?? '';
            $this->descripcion = $args['descripcion'] ?? '';
            $this->habitaciones = $args['habitaciones'] ?? '';
            $this->wc = $args['wc'] ?? '';
            $this->estacionamiento = $args['estacionamiento'] ?? '';
            $this->creado = date('Y/m/d');
            $this->vendedores_id = $args['vendedores_id'] ?? '';
        }

        public function validar() {
            if (!$this->titulo) {
                self::$errores[] = "Debes añadir un titulo";
            }
    
            if (!$this->precio) {
                self::$errores[] = "El precio es obligatorio";
            }
    
            if (strlen($this->descripcion) < 50) {
                self::$errores[] = 'La descripcion debe tener al menos 50 caracteres';
            }
    
            if (!$this->habitaciones) {
                self::$errores[] = 'El numero de habitaciones es obligatorio';
            }
    
            if (!$this->wc) {
                self::$errores[] = 'El numero de baños es obligatorio';
            }
    
            if (!$this->estacionamiento) {
                self::$errores[] = 'El numero de lugares estacionamiento es obligatorio';
            }
    
            if (!$this->vendedores_id) {
                self::$errores[] = 'Elige un vendedor';
            }

            //si no hay nombre asignado al _FILES ni 'error' se asume que no hay imagen
            if (!$this->imagen) {
                self::$errores[] = 'La imagen de la propiedad es obligatoria';
            }

            //es importante retornar estos errores en caso de que los haya
            return self::$errores;
        }

    }
?>