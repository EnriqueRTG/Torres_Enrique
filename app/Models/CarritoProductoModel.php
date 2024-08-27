<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoProductoModel extends Model
{
    protected $table            = 'carritos_productos';
    protected $primaryKey       = ['carrito_id', 'producto_id']; // Clave primaria compuesta
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['carrito_id', 'producto_id', 'cantidad', 'baja', 'fecha_creacion', 'fecha_actualizacion'];
    protected $useTimestamps    = false;
    protected $createdField     = 'fecha_creacion';
    protected $updatedField     = 'fecha_actualizacion';
    protected $skipValidation   = false;

    // Agregar un producto al carrito
    public function agregarProducto($carritoId, $productoId, $cantidad)
    {
        $existingItem = $this->where('carrito_id', $carritoId)
            ->where('producto_id', $productoId)
            ->first();

        if ($existingItem) {
            $nuevaCantidad = $existingItem->cantidad + $cantidad;
            return $this->where('carrito_id', $carritoId)
                ->where('producto_id', $productoId)
                ->set('cantidad', $nuevaCantidad)
                ->update();
        } else {
            // Si no existe, insertar un nuevo registro
            $data = [
                'carrito_id' => $carritoId,
                'producto_id' => $productoId,
                'cantidad' => $cantidad,
                'fecha_creacion' => date('Y-m-d H:i:s')
            ];

            try {
                $this->insert($data);
                return true; // Indicar que la inserción fue exitosa
            } catch (\Exception $e) {
                log_message('error', 'Error al agregar producto al carrito: ' . $e->getMessage());
                return false; // Indicar que hubo un error
            }
        }
    }

    // Actualizar la cantidad de un producto en el carrito
    public function actualizarCantidad($carritoId, $productoId, $cantidad)
    {
        return $this->where('carrito_id', $carritoId)
            ->where('producto_id', $productoId)
            ->set('cantidad', $cantidad)
            ->update();
    }

    // Eliminar un producto del carrito
    public function eliminarProducto($carritoId, $productoId)
    {
        return $this->where('carrito_id', $carritoId)
            ->where('producto_id', $productoId)
            ->delete();
    }

    // Obtener los productos de un carrito
    public function obtenerProductosCarrito($carritoId)
    {
        return $this->where('carrito_id', $carritoId)->findAll();
    }
}
