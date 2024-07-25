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

    public $subcategorias_create = [
        'nombre' => [
            'rules'  => 'required|min_length[4]|max_length[125]|is_unique[subcategorias.nombre, id, {id}]',
            'errors' => [
                'required'        => 'Por favor, ingresa el nombre de una subcategoria.',
                'min_length[4]'   => 'La subcategoria debe tener al menos 4 caracteres.',
                'max_length[125]' => 'La subcategoria no debe superar los 125 caracteres.',
                'is_unique'       => 'Esta subcategoria ya está registrada.',
            ],
        ],
    ];

    public $subcategorias_update = [
        'nombre' => [
            'rules'  => 'required|min_length[4]|max_length[125]',
            'errors' => [
                'required'        => 'Por favor, ingresa el nombre de una subcategoria.',
                'min_length[4]'   => 'La subcategoria debe tener al menos 4 caracteres.',
                'max_length[125]' => 'La subcategoria no debe superar los 125 caracteres.',
            ],
        ],
    ];

    public $marcas = [
        'nombre' => [
            'rules'  => 'required|min_length[2]|max_length[125]|is_unique[marcas.nombre, id, {id}]',
            'errors' => [
                'required'        => 'Por favor, ingresa el nombre de una marca.',
                'min_length[4]'   => 'La marca debe tener al menos 2 caracteres.',
                'max_length[125]' => 'La marca no debe superar los 125 caracteres.',
                'is_unique'       => 'Esta marca ya está registrada.',
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
                'valid_email'     => 'El correo electrónico ingresado debe ser válido',
                'is_unique'       => 'Este correo electrónico ya está registrado.',
            ],
        ],
        'password' => [
            'label' => 'Contraseña',
            'rules' => 'required|min_length[6]|max_length[20]|alpha_dash',
            'errors' => [
                'required'        => 'Por favor, ingresa una contraseña.',
                'min_length[6]'   => 'La contraseña debe tener al menos 6 caracteres.',
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
        'direccion' => [
            'label' => 'Dirección',
            'rules' => 'required|min_length[6]|max_length[125]|alpha_numeric_space',
            'errors' => [
                'required'            => 'Por favor, ingresa la dirección de domicilio.',
                'min_length[6]'       => 'La dirección debe tener al menos 6 caracteres.',
                'max_length[125]'     => 'La dirección no debe superar los 125 caracteres.',
                'alpha_numeric_space' => 'La dirección solo debe contener caracteres alfanuméricos y/o espacios',
            ],
        ],
        'telefono' => [
            'label' => 'Teléfono',
            'rules' => 'required|min_length[8]|max_length[16]|',
            'errors' => [
                'required'        => 'Por favor, ingresa un número de teléfono o celular.',
                'min_length[8]'   => 'El teléfono debe tener al menos 8 caracteres.',
                'max_length[16]'  => 'El teléfono no debe superar los 16 caracteres.',
                'numeric'         => 'El teléfono solo debe contener caracteres numéricos',
            ],
        ],
        'terms' => [
            'label' => 'Términos y Condiciones',
            'rules' => 'required',
            'errors' => [
                'required' => 'Debe aceptar los términos y condiciones.'
            ],
        ],
    ];

    public $usuarios_update = [
        'nombre'       => 'required|min_length[4]|max_length[125]|alpha_space',
        'apellido'     => 'required|min_length[4]|max_length[125]|alpha_space',
        'email'        => 'required_with[password,passwordConf]|min_length[4]|max_length[125]|valid_email|is_unique[usuarios.email, id, {id}]',
        'password'     => 'required_with[email,passwordConf]|min_length[8]|max_length[20]|alpha_dash',
        'passwordConf' => 'required_with[password,email]|min_length[8]|max_length[20]|alpha_dash|matches[password]',
        'direccion'    => 'required|max_length[125]|alpha_numeric_space',
        'telefono'     => 'required|max_length[15]|numeric',
    ];

    public  $productos_create = [
        'nombre' => [
            'label'  => 'Nombre del producto',
            'rules'  => 'required|min_length[3]|max_length[255]',
            'errors' => [
                'required' => 'El nombre del producto es obligatorio.',
                'min_length' => 'El nombre del producto debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre del producto no puede exceder los 255 caracteres.',
            ],
        ],
        'descripcion' => [
            'label'  => 'Descripción',
            'rules'  => 'required|min_length[10]',
            'errors' => [
                'required' => 'La descripción del producto es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 10 caracteres.',
            ],
        ],
        'precio' => [
            'label'  => 'Precio',
            'rules'  => 'required|numeric|greater_than[0]',
            'errors' => [
                'required' => 'El precio del producto es obligatorio.',
                'numeric' => 'El precio debe ser un número.',
                'greater_than' => 'El precio debe ser mayor a 0.',
            ],
        ],
        'stock' => [
            'label'  => 'Stock',
            'rules'  => 'required|is_natural', 
            'errors' => [
                'required' => 'El stock del producto es obligatorio.',
                'is_natural' => 'El stock debe ser un número entero positivo.',
            ],
        ],
        'marca_id' => [
            'label'  => 'Marca',
            'rules'  => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'Debe seleccionar una marca.',
                'is_natural_no_zero' => 'La marca seleccionada no es válida.',
            ],
        ],
        'subcategoria_id' => [
            'label'  => 'Subcategoría',
            'rules'  => 'required|is_natural_no_zero',
            'errors' => [
                'required' => 'Debe seleccionar una subcategoría.',
                'is_natural_no_zero' => 'La subcategoría seleccionada no es válida.',
            ],
        ],
        'presentacion' => [
            'label'  => 'Presentación',
            'rules'  => 'permit_empty|max_length[100]', // Opcional, pero con límite de caracteres
            'errors' => [
                'max_length' => 'La presentación no puede exceder los 100 caracteres.',
            ],
        ],
        'imagenes' => [
            'label' => 'Imágenes',
            'rules' => 'uploaded[imagenes.*]|max_size[imagenes,1024]|is_image[imagenes.*]|mime_in[imagenes,image/jpg,image/jpeg,image/png]',
        ],
    ];

    public  $productos_update = [
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
        'email' =>  [
            'label' => 'Correo electrónico',
            'rules' => 'required|valid_email',
            'errors' => [
                'required'        => 'Por favor, ingresa un correo electrónico.',
                'valid_email'     => 'El correo electrónico ingresado debe ser válido',
            ],
        ],
        'nombre' => [
            'label' => 'Nombre',
            'rules' => 'required|min_length[2]|max_length[125]|alpha_space',
            'errors' => [
                'required'        => 'Por favor, ingrese Nombre.',
                'min_length[2]'   => 'El Nombre debe tener al menos 2 caracteres.',
                'max_length[125]' => 'El Nombre no debe superar los 125 caracteres.',
                'alpha_space'     => 'El Nombre no debe contener otros caracteres que no sean los del alfabeto y/o espacios.',
            ],
        ],
        'asunto' => [
            'label' => 'Asunto',
            'rules' => 'required|min_length[10]|max_length[70]|alpha_space',
            'errors' => [
                'required'        => 'Por favor, ingrese el asunto.',
                'min_length[2]'   => 'El asunto debe tener al menos 10 caracteres.',
                'max_length[125]' => 'El asunto no debe superar los 70 caracteres.',
                'alpha_space'     => 'El asunto no debe contener otros caracteres que no sean los del alfabeto y/o espacios.',
            ],
        ],
        'mensaje' => [
            'label' => 'Mensaje',
            'rules' => 'required|min_length[25]|max_length[1000]',
            'errors' => [
                'required'        => 'Por favor, ingrese el mensaje.',
                'min_length[2]'   => 'El mensaje debe tener al menos 25 caracteres.',
                'max_length[125]' => 'El mensaje no debe superar los 1000 caracteres.'
            ],
        ],
    ];
}
