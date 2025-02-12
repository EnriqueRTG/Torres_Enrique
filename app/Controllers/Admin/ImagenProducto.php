<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ImagenProductoModel;

/**
 * Controlador para gestionar imágenes de productos.
 *
 * Este controlador se encarga de eliminar imágenes asociadas a productos.  
 * La eliminación incluye borrar el archivo físico del servidor y eliminar el registro de la base de datos.
 *
 * @package App\Controllers\Admin
 */
class ImagenProducto extends BaseController
{
    /**
     * Elimina una imagen asociada a un producto.
     *
     * Este método busca la imagen en la base de datos utilizando su ID.  
     * Si se encuentra, se construye la ruta absoluta al archivo (asumiendo que la ruta almacenada es relativa a la carpeta pública, por ejemplo, "uploads/productos/").  
     * Se verifica que el archivo exista y, si es así, se elimina del sistema de archivos; luego se elimina el registro de la base de datos.
     *
     * @param int $imagenId ID de la imagen a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirige de vuelta a la página anterior con un mensaje de éxito o error.
     */
    public function eliminarImagen($imagenId)
    {
        $imagenModel = new ImagenProductoModel();
        $imagen = $imagenModel->find($imagenId);

        if ($imagen) {
            // Construir la ruta completa al archivo.
            // Se asume que la ruta almacenada en la base de datos es relativa (ej.: 'uploads/productos/imagen.jpg')
            $rutaArchivo = FCPATH . $imagen->ruta_imagen;

            // Verificar que el archivo exista
            if (file_exists($rutaArchivo)) {
                // Intentar eliminar el archivo físico
                if (!unlink($rutaArchivo)) {
                    log_message('error', 'No se pudo eliminar el archivo: ' . $rutaArchivo);
                    return redirect()->back()->with('error', 'No se pudo eliminar la imagen física.');
                }
            } else {
                log_message('error', 'Archivo no encontrado: ' . $rutaArchivo);
            }

            // Eliminar el registro de la base de datos
            if ($imagenModel->delete($imagenId)) {
                return redirect()->back()->with('mensaje', 'Imagen eliminada correctamente.');
            } else {
                return redirect()->back()->with('error', 'Error al eliminar el registro de la imagen.');
            }
        } else {
            return redirect()->back()->with('error', 'Imagen no encontrada.');
        }
    }
}
