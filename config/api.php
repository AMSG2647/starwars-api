<?php

return [

    /*
     * Turn to string the status code in the json response's body.
     */
    'stringify' => true,

    /*
     * Set the status code from the json response to be the same as the status code
     * in the json response's body.
     */
    'match_status' => true,

    /*
     * Include the count of the "data" in the JSON response
     */
    'include_data_count' => false,

    /*
     * Json response's body labels.
     */
    'keys'      => [
        'status'     => 'status',
        'message'    => 'message',
        'data'       => 'data',
        'data_count' => 'data_count',
    ],

    /*
     * Response default messages.
     */
    'messages' => [
        'success'    => 'El proceso se completó con éxito',
        'notfound'   => 'Lo sentimos, no hay resultados para su consulta.',
        'validation' => 'Error de validación, compruebe los campos de la solicitud y vuelva a intentarlo.',
        'forbidden'  => 'No tienes permiso para acceder a este contenido.',
        'error'      => 'Error del servidor. Vuelve a intentarlo más tarde.',
    ],

];
