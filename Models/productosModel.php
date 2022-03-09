<?php

	class productosModel extends Mysql
	{	public $intIdProducto;
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

		public function insertProducto(string $nombre, string $descripcion, int $codigo, int $precio, int $stock, int $categoria, int $estado){
			$this->intCodigo = $codigo;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intPrecio = $precio;
			$this->intStock = $stock;
			// $this->strPortada = $portada;
			$this->intStatus = $estado;
			$this->intCategoriaId = $categoria;

			$Sql = "SELECT * FROM producto WHERE codigo = {$this->intCodigo}";
			$Result = $this->select_All($Sql);

			if(empty($Result)){
				//echo "vacio";
				$Query_Insert = "INSERT INTO producto (codigo,nombre,descripcion,precio,stock,status,categoriaid) VALUES (?,?,?,?,?,?,?)";
				$Arr_Insert = array($this->intCodigo,$this->strNombre,$this->strDescripcion,$this->intPrecio,$this->intStock,$this->intStatus,$this->intCategoriaId);
				$Result = $this->insert($Query_Insert,$Arr_Insert);				
			}else{
				$Result = "Existe";
			}
			return $Result;

		}

		public function updateProducto(int $idproducto,string $nombre, string $descripcion, int $codigo, int $precio, int $stock, int $categoria, int $estado){
			// dep($_POST);die();
			$this->intIdProducto = $idproducto;
			$this->intCodigo = $codigo;
			$this->strNombre = $nombre;
			$this->strDescripcion = $descripcion;
			$this->intPrecio = $precio;
			$this->intStock = $stock;			
			$this->intStatus = $estado;
			$this->intCategoriaId = $categoria;
			$Sql = "SELECT * FROM producto WHERE codigo = '{$this->intCodigo}' AND id != '{$this->intIdProducto}'";
			// echo $Sql;die();
			$ResultSelect = $this->select_All($Sql);


			if (empty($ResultSelect)){				
				$Query="UPDATE producto 
						SET nombre = ?, 
						descripcion = ?, 
						codigo = ?, 
						precio = ?, 
						stock = ?, 
						categoriaid = ?, 
						status = ?
						WHERE id = ?";
				$ArrData  = array($this->strNombre, 
								$this->strDescripcion, 
								$this->intCodigo, 
								$this->intPrecio, 
								$this->intStock, 
								$this->intCategoriaId, 
								$this->intStatus, 
								$this->intIdProducto);
				$Result = $this->update($Query,$ArrData);
			}else{
				$Result="Existe";
			}

			return $Result;
		}

		public function deleteProducto(int $idProd)
		{
			$this->intIdProducto = $idProd;
			$sql = "UPDATE producto SET status = ? WHERE id = $this->intIdProducto ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);			
			return $request;
		}

		public function selectProducto(int $idprod){
			$this->intIdProducto = $idprod;
			$QuerySelect = "SELECT 	prod.id,
									prod.codigo,
									prod.nombre,
									prod.descripcion,
									prod.precio,
									prod.stock,
									prod.status,
									cat.nombre as nombrecategoria,
									cat.id as idcategoria				
								FROM producto prod
								INNER JOIN categoria cat ON cat.id = prod.categoriaid WHERE prod.id = {$this->intIdProducto}";
								// echo $QuerySelect;
								$Result = $this->select($QuerySelect);
								return $Result;
		}

		public function selectImage(int $idprod){
			$this->intIdProducto = $idprod;
			$QuerySelect = "SELECT idproducto,imagen FROM imagen WHERE idproducto = {$this->intIdProducto}";
			// echo $QuerySelect;
								$Result = $this->select_All($QuerySelect);
								return $Result;
		}

		public function insertImage(int $idprod, string $img){
			$this->intIdProducto = $idprod;
			$this->strPortada = $img;
			$insertQuery="INSERT INTO imagen (idproducto,imagen) values (?,?)";
			$arrQuery = array($this->intIdProducto, $this->strPortada);
			$Result = $this->insert($insertQuery, $arrQuery);
			return $Result;

		}

		public function deleteImage(int $id, string $img){
			$this->intIdProducto = $id;
			$this->strPortada = $img;
			$QueryDelete = "DELETE FROM imagen WHERE idproducto = $this->intIdProducto AND imagen = '{$this->strPortada}' ";
			$Request = $this->delete($QueryDelete);
			return $Request;
		}


	}
 ?>