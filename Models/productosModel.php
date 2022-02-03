<?php

	class productosModel extends Mysql
	{	
		public $intCodigo;
		public $strNombre;
        public $strDescripcion;        
		public $intPrecio;
        public $intStock;
		public $strPortada;
        public $intStatus;
        public $intCategoriaId;
        

		public function __construct()
		{
			parent::__construct();
		}
        

		public function selectProductos()
		{
			$sql = "SELECT prod.id,
                            prod.codigo, 
                            prod.nombre, 
                            prod.descripcion, 
                            prod.precio, 
                            prod.stock,
                            prod.imagen,
                            prod.datecreated,
                            prod.status,
                            cat.nombre as nombreCategoria,
                            cat.descripcion FROM producto prod
                    INNER JOIN categoria cat ON cat.id = prod.categoriaid WHERE prod.status != 0 ";
                    // echo $sql;
			$request = $this->select_All($sql);
			return $request;
		}



	}
 ?>