**API para gestión de proyectos con Symfony**

Este documento proporciona una descripción general de la API RESTful creada con Symfony para gestionar proyectos.

**Endpoints**

La API expone los siguientes puntos finales para interactuar con los recursos del proyecto:

-   **GET /api/projects** - Recupera una lista de todos los proyectos.
-   **POST /api/projects** - Crea un nuevo proyecto.
-   **GET /api/projects/{id}** - Recupera un proyecto específico por su identificador.
-   **PUT /api/projects/{id}** - Actualiza un proyecto existente.
-   **DELETE /api/projects/{id}** - Elimina un proyecto.

**Serializador**

El serializador desempeña un papel fundamental en la transformación de datos entre formatos JSON y objetos PHP. En esta API, se utiliza el componente Serializer de Symfony para:

1.  **Deserializar la entrada JSON** de las solicitudes POST y PUT en objetos Project. Esto permite a Symfony mapear los datos JSON entrantes a las propiedades del objeto Project, facilitando la validación y persistencia.
2.  **Serializar la salida** en formato JSON para las respuestas de la API. De este modo, se devuelve una representación JSON de los proyectos a la aplicación cliente, independientemente de su lenguaje de programación.

**Grupos de serialización**

Los grupos de serialización se emplean para controlar qué propiedades de un objeto Project se incluyen en la salida JSON. En el código, se observa el uso de `['groups' => 'project:read']` en los métodos `index`,  `show`,  `update`, y `create`. Esto indica que se debe aplicar el grupo de serialización denominado "project:read" al serializar los objetos Project en JSON.

**Validación**

La API aprovecha el componente Validator de Symfony para garantizar la integridad de los datos del proyecto. En los métodos `create` y `update`, se utiliza el método `validate` del validador para verificar si el objeto Project cumple con las restricciones definidas en la entidad Project. Si se detectan errores de validación, se devuelve una respuesta de error con el código de estado HTTP 400 (Solicitud incorrecta) y un mensaje que detalla los errores.

**EntityManager**

El EntityManager, proporcionado por Doctrine ORM, es un componente crucial para interactuar con la base de datos. Se emplea en los métodos `create`,  `update`, y `delete` para:

-   **Persistir** un nuevo proyecto en la base de datos (`em->persist($project)`).
-   **Ejecutar** la operación de persistencia (`em->flush()`).
-   **Eliminar** un proyecto existente de la base de datos (`em->remove($project)`).

**Respuestas de la API**

La API devuelve respuestas JSON con códigos de estado HTTP para indicar el resultado de la solicitud:

-   **200 OK** - Indica que la operación se realizó correctamente.
-   **201 Created** - Se devuelve para las solicitudes POST exitosas que crean un nuevo recurso.
-   **204 No Content** - Se utiliza en el método `delete` para indicar que la eliminación se realizó con éxito, pero no se devuelve ningún contenido en el cuerpo de la respuesta.
-   **400 Bad Request** - Se produce si la solicitud contiene datos no válidos o viola las restricciones de validación.
-   **404 Not Found** - Se devuelve si se intenta acceder a un recurso inexistente (por ejemplo, un proyecto con un identificador no válido).
