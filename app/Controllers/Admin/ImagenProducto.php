<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ImagenProductoModel;

/**
 * Controlador para gestionar imágenes de productos.
 *
 * Este controlador se encarga de eliminar imágenes asociadas a productos.
 * La eliminación incluye borrar el archivo físico del servidor y eliminar el registro
 * correspondiente en la base de datos.
 *
 * @package App\Controllers\Admin
 */
class ImagenProducto extends BaseController
{
    /**
     * Instancia del modelo de imágenes de productos.
     *
     * @var ImagenProductoModel
     */
    protected $imagenProductoModel;

    /**
     * Constructor.
     *
     * Inicializa el modelo de imágenes para poder utilizarlo en los métodos del controlador.
     */
    public function __construct()
    {
        $this->imagenProductoModel = new ImagenProductoModel();
    }

    /**
     * Elimina una imagen asociada a un producto.
     *
     * Busca la imagen en la base de datos utilizando su ID. Si se encuentra, construye la
     * ruta absoluta al archivo (usando FCPATH y la ruta almacenada, que debe ser relativa a
     * la carpeta pública, por ejemplo, "uploads/productos/imagen.jpg"). Se verifica que el archivo exista:
     * si es así, se intenta eliminar el archivo físico; posteriormente, se elimina el registro en la base de datos.
     *
     * @param int $imagenId ID de la imagen a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirige a la página anterior con un mensaje de éxito o error.
     */
    public function eliminarImagen($imagenId)
    {
        // Buscar la imagen mediante el modelo instanciado en el constructor.
        $imagen = $this->imagenProductoModel->find($imagenId);
        if (!$imagen) {
            return redirect()->back()->with('error', 'Imagen no encontrada.');
        }

        // Construir la ruta completa al archivo (se asume que la ruta almacenada es relativa a FCPATH).
        $rutaArchivo = FCPATH . $imagen->ruta_imagen;

        // Verificar si el archivo existe.
        if (file_exists($rutaArchivo)) {
            // Intentar eliminar el archivo físico.
            if (!unlink($rutaArchivo)) {
                log_message('error', 'No se pudo eliminar el archivo: ' . $rutaArchivo);
                return redirect()->back()->with('error', 'No se pudo eliminar la imagen física.');
            }
        } else {
            log_message('error', 'Archivo no encontrado: ' . $rutaArchivo);
        }

        // Eliminar el registro de la base de datos.
        if ($this->imagenProductoModel->delete($imagenId)) {
            return redirect()->back()->with('mensaje', 'Imagen eliminada correctamente.');
        } else {
            log_message('error', 'Error al eliminar el registro de la imagen con ID ' . $imagenId);
            return redirect()->back()->with('error', 'Error al eliminar el registro de la imagen.');
        }
    }
}
