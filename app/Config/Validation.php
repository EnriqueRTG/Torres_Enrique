<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public array $categorias = [
        'nombre' => [
            'rules'  => 'required|min_length[4]|max_length[125]|is_unique[categorias.nombre, id, {id}]',
            'errors' => [
                'required'        => 'Por favor, ingresa el nombre de una categoria.',
                'min_length[4]'   => 'La categoria debe tener al menos 4 caracteres.',
                'max_length[125]' => 'La categoria no debe superar los 125 caracteres.',
                'is_unique'       => 'Esta categoria ya está registrada.',
            ],
        ],
    ];

    public array $marcas = [
        'nombre' => [
            'rules' => 'required|alpha_numeric_space|min_length[3]|is_unique[marcas.nombre]',
            'errors' => [
                'required' => 'El nombre de la marca es obligatorio',
                'alpha_numeric_space' => 'El nombre de la marca solo puede contener caracteres alfanuméricos y espacios',
                'min_length' => 'El nombre de la marca debe tener al menos 3 caracteres',
                'is_unique' => 'El nombre de la marca ya existe'
            ],
        ],
    ];

    public array $usuarios = [
        'nombre' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'apellido' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'email' => [
            'rules' => 'required|valid_email|is_unique[usuarios.email]|max_length[125]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'valid_email' => 'El campo {field} debe contener una dirección de correo electrónico válida.',
                'is_unique'  => 'El correo electrónico ya está registrado.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'password' => [
            'rules' => 'required|min_length[8]|max_length[255]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'telefono' => [
            'rules' => 'permit_empty|max_length[20]',
            'errors' => [
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'rol_id' => [
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'El campo {field} es obligatorio.',
                'is_natural_no_zero' => 'El campo {field} debe ser un número entero positivo.',
            ],
        ],
    ];

    public array $registros = [
        'nombre' => [
            'label' => 'Nombre/s',
            'rules' => 'required|min_length[2]|max_length[125]|alpha_space',
            'errors' => [
                'required'        => 'Por favor, ingrese Nombre.',
                'min_length[2]'   => 'El Nombre debe tener al menos 2 caracteres.',
                'max_length[125]' => 'El Nombre no debe superar los 125 caracteres.',
                'alpha_space'     => 'El Nombre no debe contener otros caracteres que no sean los del alfabeto y/o espacios.',
            ],
        ],
        'apellido' => [
            'label' => 'Apellido/s',
            'rules' => 'required|min_length[2]|max_length[125]|alpha_space',
            'errors' => [
                'required'        => 'Por favor, ingrese Apellido.',
                'min_length[2]'   => 'El Apellido debe tener al menos 2 caracteres.',
                'max_length[125]' => 'El Apellido no debe superar los 125 caracteres.',
                'alpha_space'     => 'El Apellido no debe contener otros caracteres que no sean los del alfabeto y/o espacios.',
            ],
        ],
        'email' =>  [
            'label' => 'Correo electrónico',
            'rules' => 'required|min_length[12]|max_length[125]|valid_email|is_unique[usuarios.email, id, {id}]',
            'errors' => [
                'required'        => 'Por favor, ingresa un correo electrónico.',
                'min_length[12]'  => 'El correo electrónico debe tener al menos 12 caracteres.',
                'max_length[125]' => 'El correo electrónico no debe superar los 125 caracteres.',
                'valid_email'     => 'El correo electrónico ingresado debe ser válido.',
                'is_unique'       => 'Este correo electrónico ya está registrado.',
            ],
        ],
        'password' => [
            'label' => 'Contraseña',
            'rules' => 'required|min_length[8]|max_length[20]|alpha_dash',
            'errors' => [
                'required'        => 'Por favor, ingresa una contraseña.',
                'min_length[8]'   => 'La contraseña debe tener al menos 8 caracteres.',
                'max_length[20]'  => 'La contraseña no debe superar los 20 caracteres.',
                'alpha_dash'      => 'La contraseña solo admite caracteres alfanuméricos, guiones y/o guiones bajos.',
            ],
        ],
        'confirm_password' => [
            'label' => 'Confirmar Contraseña',
            'rules' => 'required|matches[password]',
            'errors' => [
                'required' => 'Por favor, repita la contraseña ingresada.',
                'matches'  => 'Las contraseñas no coinciden.',
            ],
        ],
        'terms' => [
            'label' => 'Términos y Condiciones',
            'rules' => 'required',
            'errors' => [
                'required' => 'Debe aceptar los términos y condiciones.',
            ],
        ],
    ];

    public array $usuarios_update = [
        'nombre' => [
            'rules' => 'required|min_length[4]|max_length[125]|alpha_space',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
                'alpha_space' => 'El campo {field} solo puede contener letras y espacios.',
            ],
        ],
        'apellido' => [
            'rules' => 'required|min_length[4]|max_length[125]|alpha_space',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
                'alpha_space' => 'El campo {field} solo puede contener letras y espacios.',
            ],
        ],
        'email' => [
            'rules' => 'permit_empty|min_length[4]|max_length[125]|valid_email|is_unique[usuarios.email,id,{id}]',
            'errors' => [
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
                'valid_email' => 'El campo {field} debe contener una dirección de correo electrónico válida.',
                'is_unique'  => 'El correo electrónico ya está registrado.',
            ],
        ],
        'password' => [
            'rules' => 'permit_empty|min_length[8]|max_length[20]|alpha_dash',
            'errors' => [
                'min_length' => 'La contraseña debe tener al menos {param} caracteres.',
                'max_length' => 'La contraseña no puede exceder los {param} caracteres.',
                'alpha_dash' => 'La contraseña solo admite caracteres alfanuméricos, guiones y/o guiones bajos.',
            ],
        ],
        'passwordConf' => [
            'rules' => 'permit_empty|min_length[8]|max_length[20]|alpha_dash|matches[password]',
            'errors' => [
                'min_length' => 'La confirmación de la contraseña debe tener al menos {param} caracteres.',
                'max_length' => 'La confirmación de la contraseña no puede exceder los {param} caracteres.',
                'alpha_dash' => 'La confirmación de la contraseña solo admite caracteres alfanuméricos, guiones y/o guiones bajos.',
                'matches'  => 'La confirmación de la contraseña no coincide con la contraseña.',
            ],
        ],
        'telefono' => [
            'rules' => 'permit_empty|max_length[15]|numeric',
            'errors' => [
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
                'numeric'    => 'El campo {field} debe contener solo caracteres numéricos.',
            ],
        ],
    ];

    public array $productos_create = [
        'nombre' => [
            'label'  => 'Nombre del producto',
            'rules'  => 'required|min_length[3]|max_length[255]|is_unique[productos.nombre,id,{id}]',
            'errors' => [
                'required' => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre del producto debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre del producto no puede exceder los 255 caracteres.',
                'is_unique' => 'El nombre del producto ya está registrado.',
            ],
        ],
        'descripcion' => [
            'label'  => 'Descripción',
            'rules'  => 'permit_empty|min_length[10]',
            'errors' => [
                'min_length' => 'La descripción debe tener al menos 10 caracteres.',
            ],
        ],
        'precio' => [
            'label'  => 'Precio',
            'rules'  => 'required|decimal|greater_than[0]',
            'errors' => [
                'required' => 'El precio del producto es obligatorio.',
                'decimal' => 'El precio debe ser un número decimal.',
                'greater_than' => 'El precio debe ser mayor a 0.',
            ],
        ],
        'stock' => [
            'label'  => 'Stock',
            'rules'  => 'required|is_natural|greater_than_equal_to[0]',
            'errors' => [
                'required' => 'El stock del producto es obligatorio.',
                'is_natural' => 'El stock debe ser un número entero positivo.',
                'greater_than_equal_to' => 'El stock debe ser mayor o igual a 0.',
            ],
        ],
        'marca_id' => [
            'label'  => 'Marca',
            'rules'  => 'required|is_natural_no_zero|is_not_unique[marcas.id]',
            'errors' => [
                'required' => 'Debe seleccionar una marca.',
                'is_natural_no_zero' => 'La marca seleccionada no es válida.',
                'is_not_unique' => 'La marca seleccionada no existe.',
            ],
        ],
        'modelo' => [
            'label'  => 'Modelo',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'El modelo no puede exceder los 255 caracteres.',
            ],
        ],
        'peso' => [
            'label'  => 'Peso',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'El peso no puede exceder los 255 caracteres.',
            ],
        ],
        'dimensiones' => [
            'label'  => 'Dimensiones',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'Las dimensiones no pueden exceder los 255 caracteres.',
            ],
        ],
        'material' => [
            'label'  => 'Material',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'El material no puede exceder los 255 caracteres.',
            ],
        ],
        'color' => [
            'label'  => 'Color',
            'rules'  => 'permit_empty|max_length[255]',
            'errors' => [
                'max_length' => 'El color no puede exceder los 255 caracteres.',
            ],
        ],
    ];

    public array $productos_update = [
        'nombre'          => 'required|min_length[4]|max_length[125]|alpha_numeric_space',
        'descripcion'     => 'required|string',
        'precio'          => 'required|decimal',
        'stock'           => 'required|is_natural_no_zero',
        'marca_id'        => 'required|is_natural',
        'subcategoria_id' => 'required|is_natural',
        'presentacion'    => 'required|min_length[4]|max_length[125]|alpha_numeric_space',
        //'imagen'          => 'required|min_length[4]|max_length[125]|alpha_space',
    ];

    public array $login = [
        'email' =>  [
            'label' => 'Correo electrónico',
            'rules' => 'required|valid_email',
            'errors' => [
                'required'        => 'Por favor, ingresa un correo electrónico.',
                'valid_email'     => 'El correo electrónico ingresado debe ser válido',
            ],
        ],
        'password' => [
            'label' => 'Contraseña',
            'rules' => 'required',
            'errors' => [
                'required'        => 'Por favor, ingresa la contraseña.',
            ],
        ],
    ];

    public array $contactos = [
        'nombre' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'email' => [
            'rules' => 'required|valid_email|max_length[125]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'valid_email' => 'El campo {field} debe contener una dirección de correo electrónico válida.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'asunto' => [
            'rules' => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'mensaje' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'El campo {field} es obligatorio.',
            ],
        ],
    ];

    public $consultas = [
        'usuario_id' => [
            'rules' => 'required|integer|is_not_unique[usuarios.id]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'integer'    => 'El campo {field} debe ser un número entero.',
                'is_not_unique' => 'El {field} seleccionado no existe en la tabla usuarios.',
            ],
        ],
        'asunto' => [
            'rules' => 'required|min_length[5]|max_length[255]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
                'max_length' => 'El campo {field} no puede exceder los {param} caracteres.',
            ],
        ],
        'mensaje' => [
            'rules' => 'required|min_length[10]',
            'errors' => [
                'required'   => 'El campo {field} es obligatorio.',
                'min_length' => 'El campo {field} debe tener al menos {param} caracteres.',
            ],
        ],
    ];

    public array $imagenes_create = [
        'nombre' => [
            'label'  => 'Nombre de la imagen',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El nombre de la imagen es obligatorio.',
                'min_length' => 'El nombre de la imagen debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de la imagen no puede exceder los 255 caracteres.',
            ],
        ],
        'imagen' => [
            'label' => 'Imagen',
            'rules' => 'uploaded[imagen]|max_size[imagen,1024]|is_image[imagen]|mime_in[imagen,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded' => 'Debe subir una imagen.',
                'max_size' => 'La imagen no debe exceder los 1024 KB.',
                'is_image' => 'El archivo debe ser una imagen válida.',
                'mime_in' => 'Las imágenes deben ser de tipo jpg, jpeg o png.',
            ],
        ],
        'url' => [
            'label'  => 'URL de la imagen',
            'rules'  => 'required|valid_url|max_length[255]',
            'errors' => [
                'required' => 'La URL de la imagen es obligatoria.',
                'valid_url' => 'La URL debe ser válida.',
                'max_length' => 'La URL no puede exceder los 255 caracteres.',
            ],
        ],
    ];

    public array $imagenes_update = [
        'nombre' => [
            'label'  => 'Nombre de la imagen',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El nombre de la imagen es obligatorio.',
                'min_length' => 'El nombre de la imagen debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de la imagen no puede exceder los 255 caracteres.',
            ],
        ],
        'url' => [
            'label'  => 'URL de la imagen',
            'rules'  => 'required|valid_url|max_length[255]',
            'errors' => [
                'required' => 'La URL de la imagen es obligatoria.',
                'valid_url' => 'La URL debe ser válida.',
                'max_length' => 'La URL no puede exceder los 255 caracteres.',
            ],
        ],
    ];

    public array $direcciones = [
        'calle' => [
            'label'  => 'Calle',
            'rules'  => 'required|max_length[255]',
            'errors' => [
                'required'   => 'La calle es obligatoria.',
                'max_length' => 'La calle no puede exceder los 255 caracteres.',
            ],
        ],
        'numero' => [
            'label'  => 'Número',
            'rules'  => 'required|max_length[10]',
            'errors' => [
                'required'   => 'El número es obligatorio.',
                'max_length' => 'El número no puede exceder los 10 caracteres.',
            ],
        ],
        'piso' => [
            'label'  => 'Piso',
            'rules'  => 'permit_empty|max_length[10]',
            'errors' => [
                'max_length' => 'El piso no puede exceder los 10 caracteres.',
            ],
        ],
        'departamento' => [
            'label'  => 'Departamento',
            'rules'  => 'permit_empty|max_length[10]',
            'errors' => [
                'max_length' => 'El departamento no puede exceder los 10 caracteres.',
            ],
        ],
        'ciudad' => [
            'label'  => 'Ciudad',
            'rules'  => 'required|max_length[100]',
            'errors' => [
                'required'   => 'La ciudad es obligatoria.',
                'max_length' => 'La ciudad no puede exceder los 100 caracteres.',
            ],
        ],
        'provincia' => [
            'label'  => 'Provincia',
            'rules'  => 'required|max_length[100]',
            'errors' => [
                'required'   => 'La provincia es obligatoria.',
                'max_length' => 'La provincia no puede exceder los 100 caracteres.',
            ],
        ],
        'codigo_postal' => [
            'label'  => 'Código Postal',
            'rules'  => 'required|max_length[10]',
            'errors' => [
                'required'   => 'El código postal es obligatorio.',
                'max_length' => 'El código postal no puede exceder los 10 caracteres.',
            ],
        ],
        'pais' => [
            'label'  => 'País',
            'rules'  => 'required|max_length[100]',
            'errors' => [
                'required'   => 'El país es obligatorio.',
                'max_length' => 'El país no puede exceder los 100 caracteres.',
            ],
        ],
    ];

    public array $usuarios_direcciones = [
        'usuario_id' => [
            'label'  => 'ID del Usuario',
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'El ID del usuario es obligatorio.',
                'integer'  => 'El ID del usuario debe ser un número entero.',
            ],
        ],
        'direccion_id' => [
            'label'  => 'ID de la Dirección',
            'rules'  => 'required|integer',
            'errors' => [
                'required' => 'El ID de la dirección es obligatorio.',
                'integer'  => 'El ID de la dirección debe ser un número entero.',
            ],
        ],
        'baja' => [
            'label'  => 'Baja',
            'rules'  => 'permit_empty|boolean',
            'errors' => [
                'boolean' => 'El campo baja debe ser verdadero o falso.',
            ],
        ],
    ];
}
