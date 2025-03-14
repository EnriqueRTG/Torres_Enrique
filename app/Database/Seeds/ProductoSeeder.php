<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder para la tabla "productos".
 *
 * Inserta un conjunto de productos de ejemplo en la base de datos.
 */
class ProductoSeeder extends Seeder
{
    public function run()
    {
        $productosModel = new \App\Models\ProductoModel();

        // Definir un array con productos de ejemplo
        $productos = [
            [
                'nombre' => 'Caja Agujas Tattoo Premium X 50 1203RL',
                'descripcion' => 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 3. Tipo de configuración: Round Liner.',
                'precio' => 12500,
                'stock' => 10,
                'categoria_id' => 3,
                'marca_id' => 10,
                'modelo' => '1203 RL',
                'peso' => '200 gramos',
                'dimensiones' => '12 x 7 x 4 cm',
                'material' => 'Acero inoxidable de grado médico',
                'color' => 'Plateado',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Agujas Para Tatuar Caja X 50u Hurricane 1207RL',
                'descripcion' => 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 7. Tipo de configuración: Round Liner.',
                'precio' => 15024,
                'stock' => 10,
                'categoria_id' => 3,
                'marca_id' => 2,
                'modelo' => '1207 RL',
                'peso' => '200 gramos',
                'dimensiones' => '12 x 7 x 4 cm',
                'material' => 'Acero inoxidable de grado médico',
                'color' => 'Plateado',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Caja Cerrada Agujas Tattoo Lineas x50 Unidades 1213RL',
                'descripcion' => 'Caja que contiene 50 unidades de agujas de tatuaje, cada una con las siguientes características: Diámetro de la aguja: 0.35 mm. Número de agujas en el haz: 13. Tipo de configuración: Round Liner.',
                'precio' => 18426,
                'stock' => 10,
                'categoria_id' => 3,
                'marca_id' => 10,
                'modelo' => '1213 RL',
                'peso' => '200 gramos',
                'dimensiones' => '12 x 7 x 4 cm',
                'material' => 'Acero inoxidable de grado médico',
                'color' => 'Plateado',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Cartuchos Tattoo Spark Greywash 1203 RL Caja x 20 u.',
                'descripcion' => 'Cartuchos de alta calidad con membrana mejorada. Su sistema de aguja brinda un trabajo más estable y preciso. Todos los cartuchos están fabricados con plásticos de ingeniería médica y acero inoxidable médico 316L. Esterilizado por gas EO. Cajas x 20 unidades.',
                'precio' => 14379,
                'stock' => 15,
                'categoria_id' => 3,
                'marca_id' => 3,
                'modelo' => '1203 RL',
                'peso' => '200 gramos',
                'dimensiones' => '15 x 10 x 5 cm',
                'material' => 'Plásticos de ingeniería médica y acero inoxidable médico',
                'color' => 'Transparente o translúcido',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Cartuchos Tattoo Spark Greywash 1209 RL Caja x 20 u.',
                'descripcion' => 'Cartuchos de alta calidad con membrana mejorada. Su sistema de aguja brinda un trabajo más estable y preciso. Todos los cartuchos están fabricados con plásticos de ingeniería médica y acero inoxidable médico 316L. Esterilizado por gas EO. Cajas x 20 unidades.',
                'precio' => 16780,
                'stock' => 20,
                'categoria_id' => 3,
                'marca_id' => 3,
                'modelo' => '1209 RL',
                'peso' => '200 gramos',
                'dimensiones' => '15 x 10 x 5 cm',
                'material' => 'Plásticos de ingeniería médica y acero inoxidable médico',
                'color' => 'Transparente o translúcido',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Cartuchos Tattoo Mast Pro 0805 RL caja de 20',
                'descripcion' => 'Agujas hechas por 304 L, pulidas por máquina automática que trabajan más suavemente. Desinfección completa de óxido de etileno, uso único desechable. Control estricto de calidad y consistencia, suave y libre de impurezas.  4 barras engrosadas aseguraron la alta resistencia de la durabilidad, cerca de 200 fuerza de rebote con dureza.',
                'precio' => 16783.35,
                'stock' => 8,
                'categoria_id' => 3,
                'marca_id' => 11,
                'modelo' => '0805 RL',
                'peso' => '200 gramos',
                'dimensiones' => '15 x 10 x 5 cm',
                'material' => 'Plásticos de ingeniería médica y acero inoxidable médico',
                'color' => 'Transparente o translúcido',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Descartador De Agujas Y Cortopunzantes 2.2 Lts.',
                'descripcion' => 'Contenedor diseñado específicamente para la eliminación segura de agujas, jeringas y otros objetos cortopunzantes usados. Este tipo de contenedor es esencial en entornos médicos, de tatuajes, y otros lugares donde se manipulan objetos afilados que pueden ser peligrosos si no se desechan adecuadamente.',
                'precio' => 4897.20,
                'stock' => 25,
                'categoria_id' => 10,
                'marca_id' => 12,
                'modelo' => 'SIMIL E2',
                'peso' => '190 gramos',
                'dimensiones' => '12,5 x 14 x 19,5 cm',
                'material' => 'Polipropileno rígido virgen, resistente a caídas y perforaciones.',
                'color' => 'Rojo',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Fuente De Alimentación Tattoo Bronc Tpn-035',
                'descripcion' => 'La fuente de alimentación Bronc para tatuajes es un dispositivo versátil y fácil de usar, diseñado para tatuadores profesionales. Voltaje y Potencia: Funciona en un rango de voltaje de 0-18V. Capacidad de alta salida de 3A. Pantalla y Controles: Equipado con una pantalla LCD a color de alta resolución. Panel de control sensible al tacto que permite ajustes incluso con guantes. Muestra en tiempo real la frecuencia, el voltaje, el porcentaje de carga y la corriente de amperaje. Funcionalidades: 12 configuraciones de voltaje preestablecidas. Función de inicio con un solo botón. Función de registro de tiempo para rastrear la duración de las sesiones. NO INCLUYE CABLE DE CONEXIÓN A 220V.',
                'precio' => 193200,
                'stock' => 5,
                'categoria_id' => 4,
                'marca_id' => 13,
                'modelo' => 'Tpn-035',
                'peso' => '625 gramos',
                'dimensiones' => '13 x 8 cm',
                'material' => 'Carcasa de plástico de alta resistencia',
                'color' => 'Negro',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Llave Allen Cruz Maquina Tattoo 2 Medidas Ajuste',
                'descripcion' => 'Herramienta para ajustar, calibrar y puesta a punto de máquinas tattoo. Tiene 2 medidas diferentes y una punta con destornillador de plástico para regular y ajustar el tornillo de contacto de las máquinas.',
                'precio' => 52782.54,
                'stock' => 35,
                'categoria_id' => 10,
                'marca_id' => 10,
                'modelo' => 'Allen Cruz',
                'peso' => '50 gramos',
                'dimensiones' => '20 oz.',
                'material' => 'Metal y plastico',
                'color' => 'Negro',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Máquina Tattoo Cheyenne Hawk Pen',
                'descripcion' => 'Con el control absoluto y la precisión en mente, Cheyenne ha introducido la mayor innovación en la industria del tatuaje: el bolígrafo Cheyenne Hawk. Esta revolucionaria máquina está especialmente diseñada para parecerse mucho a un bolígrafo real, lo que facilitará procedimientos de tatuaje aún más precisos que antes. El Cheyenne Hawk Pen es compatible con su propio agarre de 0.827 in y 0.984 in, el sistema de cartuchos Cheyenne y las fuentes de alimentación PU I y PU II y los cables de alimentación Cheyenne Thunder y Spirit. Otras marcas de fuentes de alimentación se pueden utilizar con el Hawk Pen, pero necesitarán un cable adaptador dependiendo de su fuente de alimentación particular (enchufes rojos/negros). Esta máquina no necesita una instalación de arranque.',
                'precio' => 2659751,
                'stock' => 3,
                'categoria_id' => 1,
                'marca_id' => 1,
                'modelo' => 'Hawk Pen - MACH-418',
                'peso' => '130 gramos',
                'dimensiones' => '25,4 x 123 mm',
                'material' => 'Aluminio',
                'color' => 'Negro, bronce, naranja, morado, rojo y plateado.',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Máquina Tattoo Cheyenne Hawk 10th Anniversary Edition',
                'descripcion' => 'HAWK EDICIÓN 10.º ANIVERSARIO. HAWK fue la primera máquina para tatuar de Cheyenne; se lanzó en el 2007 y ganó inmediatamente muchos fans por todo el mundo. Incluso hoy en día es una de las herramientas para tatuar de mayor calidad, de las más valoradas. Con motivo del décimo aniversario, se ha lanzado una nueva edición limitada del clásico, en dos nuevos colores; un producto único, como suele serlo.',
                'precio' => 2318745,
                'stock' => 1,
                'categoria_id' => 1,
                'marca_id' => 1,
                'modelo' => 'Hawk 10th Anniv. Ed.',
                'peso' => '130 gramos',
                'dimensiones' => '13 x 3 cm',
                'material' => 'Aluminio',
                'color' => 'Negro',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Maquina Rotativa Para Tattoo Tipo Dragonfly Híbrida',
                'descripcion' => 'Máquina para tatuar rotativa tipo DragonFly X2, super livianas con un motor de excelentes prestaciones. Con conexión para cable clip y cable ficha RCA, funcionan indistintamente.',
                'precio' => 38855,
                'stock' => 8,
                'categoria_id' => 1,
                'marca_id' => 10,
                'modelo' => 'Dragonfly',
                'peso' => '99 gramos',
                'dimensiones' => '100 x 22 x 75 mm',
                'material' => 'Aleación de aluminio',
                'color' => 'Blanco, dorado, negro, rojo, verde.',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Máquina Tattoo Custom Mk97-4 Alloy 10w. Pro Liner Shader',
                'descripcion' => 'Máquina para tatuar con bobinas de 10w. para uso profesional.',
                'precio' => 45489,
                'stock' => 7,
                'categoria_id' => 1,
                'marca_id' => 4,
                'modelo' => 'Custom MK97 Alloy',
                'peso' => '250 gramos',
                'dimensiones' => '10 x 8 x 5 cm',
                'material' => 'Acero de fundición',
                'color' => 'Negro',
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Punteras Descartables 25mm X25u - 9 RL',
                'descripcion' => '25 Punteras Descartables STRONG 25mm',
                'precio' => 22990,
                'stock' => 20,
                'categoria_id' => 3,
                'marca_id' => 10,
                'modelo' => null,
                'peso' => null,
                'dimensiones' => '25 mm',
                'material' => 'Plástico',
                'color' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Caja Punteras Descartables 30mm. Línea x15 Unidades 11 RT',
                'descripcion' => 'Estas punteras descartables están diseñadas específicamente para su uso con agujas de tatuaje. Cada grip tiene un diámetro de 30mm, ideal para trabajos precisos y definidos, asegurando un resultado limpio y profesional.',
                'precio' => 10487,
                'stock' => 25,
                'categoria_id' => 3,
                'marca_id' => 10,
                'modelo' => null,
                'peso' => null,
                'dimensiones' => '30 mm',
                'material' => 'Plástico',
                'color' => null,
                'estado' => 'activo',
            ]
        ];

        // Insertar todos los productos de forma masiva
        $productosModel->insertBatch($productos);
    }
}
